<?php

namespace App\Http\Controllers\Patient;

use App\Enums\AppointmentStatus;
use App\Http\Controllers\Controller;
use App\Models\Appointment;
use App\Models\AppointmentReschedule;
use Illuminate\Http\Request;

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
            'appointment_id' => $appointment->id
         ]);


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
        //
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
}
