<?php

namespace App\Http\Controllers\Patient;

use App\Models\User;
use App\Models\Appointment;
use Illuminate\Http\Request;
use App\Enums\AppointmentStatus;
use App\Http\Controllers\Controller;
use App\Models\AppointmentReschedule;
use App\Notifications\AppointmentStatusNotification;
use Illuminate\Support\Facades\Auth;

class RescheduleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(string $id)
    {

        $appointment = Appointment::find($id);

        return view('users.patient.appointment.reschedule', compact(['appointment']));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {


        $user = Auth::user();

        if(!now()->lt($request->date)){
            return back()->with(['rejected' => 'Date is in the past!']);
        };
        $appointment = Appointment::find($request->appointment_id);

        $request->validate([
            'remark' => 'required',
            'start_time' => 'required',
            'end_time' => 'required',
            'date' => 'required'
        ]);

         AppointmentReschedule::create([
            'remark' => $request->remark,
            'start_time' => $request->start_time,
            'end_time' => $request->end_time,
            'date' => $request->date,
            'appointment_id' => $appointment->id,
            'user_id' => $user->id
         ]);


         $user = User::role('admin')->first();


        $message  = [
            'content' => "Patient: {$appointment->patient} is Request for Reschedule",
            'date' =>  'Date: ' . now()->format('F-d-Y')
        ];

        $user->notify(new AppointmentStatusNotification($message));


         $appointment->update([
            'status' => AppointmentStatus::RESCHEDULE->value
         ]);


         return back()->with([
            'message' => 'Your Request is Send waiting for the Admin Approval'
         ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {

        $user = Auth::user();
        $reschedule = AppointmentReschedule::find($id);

        $appointment = $reschedule->appointment;


        $appointments  = Appointment::where('user_id', $user->id)->get()->toJson();


        return view('users.patient.appointment.reschedule.show', compact(['reschedule', 'appointment', 'appointments']));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function approved(Request $request){

        $reschedule = AppointmentReschedule::find($request->reschedule_id);

        $user = User::role('admin')->first();


        $reschedule->update([
            'status' => AppointmentStatus::APPROVED->value
        ]);


        $appointment = $reschedule->appointment;



        $message  = [
            'content' => "Patient Approved in Appointment Reschedule",
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

        return to_route('patient.appointment.show', ['appointment' => $appointment->id])->with(['message' => 'Appointment Reschedule Approved']);

    }
    public function reject(Request $request){
        $reschedule = AppointmentReschedule::find($request->reschedule_id);


        $appointment = $reschedule->appointment;

        $user = User::find($appointment->user_id);

        $message  = [
            'content' => "Patient Rejected the Appointment Reschedule Remark: {$request->remark}",
            'date' =>  'Date: ' . now()->format('F-d-Y')
        ];

        $user->notify(new AppointmentStatusNotification($message));


        $appointment->update([
            'status' => AppointmentStatus::APPROVED->value,
        ]);


        $reschedule->delete();

        return to_route('patient.appointment.show', ['appointment' => $appointment->id])->with(['rejected' => 'Appointment Reschedule reject']);
    }

}
