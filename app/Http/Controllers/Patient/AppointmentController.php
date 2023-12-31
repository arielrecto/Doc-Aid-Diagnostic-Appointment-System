<?php

namespace App\Http\Controllers\Patient;

use App\Enums\AppointmentStatus;
use App\Http\Controllers\Controller;
use App\Models\Appointment;
use App\Models\Day;
use App\Models\Family;
use App\Models\Payment;
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
        ->whereId($user->id)->get();

        $appointmentsData = Appointment::with('subscribeServices.service')->whereId($user->id)->get()->toJson();

        return view('users.patient.appointment.index', compact(['appointments', 'appointmentsData']));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {

        // $services = Service::with('timeSlot')->get()->toJSON();

        $today = Carbon::now()->timezone('GMT+8')->format('l');


        $day = Day::where('name', $today)->first();

        $services = $day->services()->with(['timeSlot'])->get();

        // $timeSlot = $this->timeIntervalByHour('8:00', '4:00');
        $familyMembers = Family::authUserFamilyMember();

        return view('users.patient.appointment.create', compact(['services', 'familyMembers']));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {


        $request->validate([
            'patient' => 'required',
            'date' => 'required',
            'receipt_number' => 'required',
            'receipt' => 'required',
            'receipt_amount' => 'required',
            'patient' => 'required'
        ]);


        $services = json_decode($request->services);


        // $service = Service::find($request->service);
        $imageUploader = new ImageUploader();
        $imageUploader->handler($request->receipt, '/image/receipt/', 'RCPT');

        $user = Auth::user();
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

        collect($services)->map(function ($item) {
            $slot = $item->time_slot;
            $t_slot = TimeSlot::where('date', $slot->date)->first();
            if ($t_slot) {
                $t_slot->update([
                    'slots' => json_encode($slot->slots),
                ]);
            }
            TimeSlot::create([
                'service_id' => $item->id,
                'slots' => json_encode($slot->slots),
                'date' => $slot->date
            ]);
        });

        $this->processServices($services, $appointment);
        return back()->with(['message' => 'Appointment Request Sent!']);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $appointment = Appointment::find($id);

        return view('users.patient.appointment.show', compact(['appointment']));
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
        foreach ($services as $_service) {
            list($startTime, $endTime) = explode(" - ", $_service->selectedSlot->duration);
            $startTime = Carbon::parse($startTime);
            $endTime = Carbon::parse($endTime);

            Service::find($_service->id)->update(['time_slot' => json_encode($_service->time_slot)]);


            SubscribeService::create([
                'start_time' => $startTime,
                'end_time' => $endTime,
                'service_id' => $_service->id,
                'appointment_id' => $appointment->id
            ]);
        }
    }
}
