<?php

namespace App\Http\Controllers\Patient;

use App\Enums\AppointmentStatus;
use App\Http\Controllers\Controller;
use App\Models\Appointment;
use App\Models\AppointmentReschedule;
use App\Models\Day;
use App\Models\Family;
use App\Models\FamilyMember;
use App\Models\Payment;
use App\Models\PaymentAccount;
use App\Models\Service;
use App\Models\ServiceAssignment;
use App\Models\SubscribeService;
use App\Models\TimeSlot;
use App\Utilities\ImageUploader;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AppointmentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        $user = Auth::user();

        $appointments = Appointment::with('subscribeServices.service')
            ->where('status', '!=', AppointmentStatus::DONE->value)
            ->whereUserId($user->id)->get();

        $appointmentsData = Appointment::with('subscribeServices.service')->whereUserId($user->id)->get()->toJson();

        return view('users.patient.appointment.index', compact(['appointments', 'appointmentsData']));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {

        // $services = Service::with('timeSlot')->get()->toJSON();

        if (Auth::user()->profile === null) {
            return to_route('patient.profile.create')->with(['message' => 'Setup the Profile First']);
        }

        $today = Carbon::now()->timezone('GMT+8')->format('l');

        $accounts = PaymentAccount::get();



        $day = Day::where('name', $today)->first();


        $services = Service::with('days')->with(['timeSlot' => function($q){
            $q->latest();
        }])->get();


        // $timeSlot = $this->timeIntervalByHour('8:00', '4:00');
        $familyMembers = Family::authUserFamilyMember();

        return view('users.patient.appointment.create', compact(['services', 'familyMembers', 'accounts']));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $user = Auth::user();



        $services = json_decode($request->services);




        $request->validate([
            'patient' => 'required',
            'date' => 'required',
            'patient' => 'required'
        ]);


        $otherDate = Carbon::createFromFormat('Y-m-d', $request->date);


        if ($otherDate->lt(now())) {
            return back()->with(['reject' => 'Appointment cannot be made since the selected date has passed.']);
        }

        $hasAppointment = Appointment::where('date', $request->date)
            ->where('user_id', $user->id)
            ->where('status', '!=',  AppointmentStatus::DONE->value)
            ->where('patient', $request->patient)
            ->latest()->first();

        if ($hasAppointment !== null) {

            $subscribeServices = $hasAppointment->subscribeServices;
            foreach ($subscribeServices as $s_service) {
                foreach ($services as $a_service) {
                    if ($s_service->service_id === $a_service->id) {
                        return back()->with(['reject' => 'You have Already Appointment with same service and date']);
                    }
                }
            }

            // if ($service->id === $subscribeService->service_id) {
            //     return back()->with(['reject' => 'You have Already Appointment with service and date']);
            // }
        }






        // $service = Service::find($request->service);
        $imageUploader = new ImageUploader();
        $imageUploader->handler($request->receipt, '/image/receipt/', 'RCPT');


        $appointment = Appointment::create([
            'date' => $request->date,
            'patient' => $request->patient,
            'time' => $request->timeSlot,
            'type' => 'sample',
            'user_id' => $user->id,
            'receipt_number' => $request->receipt_number,
            'receipt_image' => $imageUploader->getURL(),
            'receipt_amount' => $request->receipt_amount,
            'balance' => $request->balance,
            'total' => $request->total,
            'payment_type' => $request->payment_type,
            'status' => 'pending',
            'is_extended' => $request?->is_extended === "on" ? true : false
        ]);


        Payment::create([
            'ref_number' => $request->receipt_number,
            'image' => $imageUploader->getURL(),
            'amount' => $request->receipt_amount,
            'type' => 'downpayment',
            'appointment_id' => $appointment->id
        ]);

        collect($services)->map(function ($service) {
            $slot = $service->time_slot;
            $t_slot = TimeSlot::where('date', $slot->date)->first();
            if ($t_slot) {
                $t_slot->update([
                    'slots' => json_encode($slot->slots),
                ]);
            }
            TimeSlot::create([
                'service_id' => $service->id,
                'slots' => json_encode($slot->slots),
                'date' => $slot->date
            ]);
        });




        $familyMember = FamilyMember::where('full_name', $request->patient)->first();

        if ($familyMember !== null) {

            $appointment->update([
                'is_family' => true,
                'family_member_id' => $familyMember->id
            ]);
        }


        $this->processServices($services, $appointment);
        return back()->with(['message' => 'Appointment Request Sent!']);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {

        $user = Auth::user();

        $appointment = Appointment::find($id);

        $reschedule = AppointmentReschedule::where('appointment_id', $id)->where('user_id', '!=', $user->id)->first();


        return view('users.patient.appointment.show', compact(['appointment', 'reschedule']));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $appointment = Appointment::find($id);
        return view('users.patient.appointment.edit', compact(['appointment']));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $appointment = Appointment::find($id);

        $appointment->update([
            'date' => $request->date ?? $appointment->date,
            'patient' => $request->patient ?? $appointment->patient
        ]);


        return to_route('patient.appointment.show', ['appointment' => $appointment->id])->with(['message' => 'Appointment Updated Success']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
    public function timeIntervalByHour($start, $end)
    {
        $startTime = strtotime($start . 'AM');
        $endTime = strtotime($end . 'PM');

        $timeInterval = [];
        while ($startTime <= $endTime) {
            $endTimeSlot = strtotime('+1 hour', $startTime);
            $timeInterval[] = date('h:i A', $startTime) . ' - ' . date('h:i A', $endTimeSlot);
            $startTime = $endTimeSlot;
        }

        // Now $timeInterval contains an array of time intervals in the desired format
        return $timeInterval;
    }
    private function processServices($services, $appointment)
    {
        collect($services)->map(function ($service) use ($appointment) {
            list($startTime, $endTime) = explode(" - ", $service->selectedSlot->duration);
            $startTime = Carbon::parse($startTime);
            $endTime = Carbon::parse($endTime);

            Service::find($service->id)->update(['time_slot' => json_encode($service->time_slot)]);


            SubscribeService::create([
                'start_time' => $startTime,
                'end_time' => $endTime,
                'service_id' => $service->id,
                'appointment_id' => $appointment->id
            ]);
        });
    }
    public function byDate(string $date)
    {

        $user = Auth::user();

        $appointments = Appointment::with('subscribeServices.service')->where('date', $date)->where('user_id', $user->id)->get();

        return response([
            'appointments' => $appointments,
        ], 200);
    }
}
