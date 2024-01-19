<?php

namespace App\Http\Controllers\Admin;

use App\Enums\AppointmentStatus;
use App\Http\Controllers\Controller;
use App\Models\Appointment;
use App\Models\AppointmentReschedule;
use App\Models\Service;
use App\Models\User;
use App\Notifications\AppointmentStatusNotification;
use App\Notifications\AppoitmentStatusNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AppointmentController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    public function __construct(public Appointment $appointment)
    {

    }

    public function index(Request $request)
    {
        $query = $request->query('filter');
        $appointments = Appointment::get();

        if($query !== null) {
            if($query === 'today'){
                $appointments = Appointment::where('date', now('GMT+8')->format('Y-m-d'))->get();
            }else{
                $appointments = Appointment::where('status', $query)->get();
            }
        }

        $total = $this->appointment->total();
        $totalPending = $this->appointment->pending()->count();
        $totalApproved = $this->appointment->where('status', AppointmentStatus::APPROVED->value)->get()->count();
        $totalDone = $this->appointment->where('status', AppointmentStatus::DONE->value)->get()->count();
        $calendarAppointment  = json_encode($this->appointment->get());
        return view('users.admin.Appointment.index-new', compact([
            'appointments',
            'total',
            'calendarAppointment',
            'totalPending',
            'totalApproved',
            'totalDone'
        ]));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {

        $appointment = Appointment::with(['subscribeServices.service', 'results'])->where('id', $id)->first();


        return view('users.admin.Appointment.show', compact(['appointment']));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $appointment = Appointment::find($id);
        return view('users.admin.Appointment.edit', compact(['appointment']));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {

        if(!now()->lt($request->date)){
            return back()->with(['rejected' => 'Date is in the past!']);
        };

        $appointment = Appointment::find($id);
        $appointment->update([
            'patient' => $request->patient ?? $appointment->patient,
            'time' => $request->start_time . ' - ' . $request->end_time ?? $appointment->time,
            'date' => $request->date ?? $appointment->date
        ]);

        $subscribeService = $appointment->subscribeServices->first();


        $subscribeService->update([
            'start_time' => $request->start_time,
            'end_time' => $request->end_time
        ]);

        return redirect(route('admin.appointment.show', ['appointment' => $appointment->id]))->with(['message', 'Appointment is Updated']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $appointment = Appointment::find($id);

        $appointment->delete();


        return back()->with(['rejected' => 'Appointment Deleted ! ']);
    }
    public function approved($id){
        $appointment = Appointment::find($id);

        $user = User::find($appointment->user_id);


        $message  = [
            'content' => "Your Appointment is Approved",
            'date' =>  'Date: ' . now()->format('F-d-Y')
        ];

        $user->notify(new AppointmentStatusNotification($message));

        $appointment->update(['status' => 'approved']);

        return back()->with(['approved' => 'Appointment Approved']);
    }
    public function reject($id){
        $appointment = Appointment::find($id);


        $user = User::find($appointment->user_id);


        $message  = [
            'content' => "Your Appointment is Rejected",
            'date' =>  'Date: ' . now()->format('F-d-Y')
        ];

        $user->notify(new AppointmentStatusNotification($message));

        $appointment->update(['status' => 'reject']);

        return back()->with(['rejected' => 'Appointment reject']);
    }
    public function filter($filter){
       $appointments = Appointment::filter($filter);
       $total = $this->appointment->total();

      return view('users.admin.Appointment.filter', compact(['appointments', 'filter', 'total']));
    }
    public function reschedule(Request $request, String $id) {

        $reschedule = AppointmentReschedule::find($id);


        $appointment = $reschedule->appointment;

        $appointments = Appointment::get()->toJson();


        return view('users.admin.Appointment.reschedule', compact(['reschedule', 'appointment', 'appointments']));
    }
    public function approvedReschedule(Request $request){


        $reschedule = AppointmentReschedule::find($request->reschedule_id);


        $reschedule->update([
            'status' => AppointmentStatus::APPROVED->value
        ]);


        $appointment = $reschedule->appointment;

        $user = User::find($appointment->id);

        $message  = [
            'content' => "Your Appointment Reschedule is Approved",
            'date' =>  'Date: ' . now()->format('F-d-Y')
        ];

        $user->notify(new AppointmentStatusNotification($message));


        $appointment->update([
            'status' => AppointmentStatus::APPROVED->value,
            'date' => $reschedule->date
        ]);

        $subscribeService = $appointment->subscribeServices->first();


        $subscribeService->update([
            'start_time' => $reschedule->start_time,
            'end_time' => $reschedule->end_time
        ]);

        $reschedule->delete();

        return to_route('admin.appointment.show', ['appointment' => $appointment->id])->with(['message' => 'Appointment Reschedule Approved']);
    }
    public function rejectReschedule(Request $request){


        $reschedule = AppointmentReschedule::find($request->reschedule_id);


        $appointment = $reschedule->appointment;

        $user = User::find($appointment->user_id);

        $message  = [
            'content' => "Your Appointment Reschedule is rejected",
            'date' =>  'Date: ' . now()->format('F-d-Y')
        ];

        $user->notify(new AppointmentStatusNotification($message));


        $appointment->update([
            'status' => AppointmentStatus::APPROVED->value,
        ]);


        $reschedule->delete();

        return to_route('admin.appointment.show', ['appointment' => $appointment->id])->with(['rejected' => 'Appointment Reschedule reject']);
    }
    public function byDate(string $date){


        $appointments = Appointment::with('subscribeServices.service')->where('date' , $date)->get();

        return response([
            'appointments' => $appointments,
        ], 200);
    }
}
