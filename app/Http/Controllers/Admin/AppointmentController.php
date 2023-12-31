<?php

namespace App\Http\Controllers\Admin;

use App\Enums\AppointmentStatus;
use App\Http\Controllers\Controller;
use App\Models\Appointment;
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
        $total = $this->appointment->total();
        $calendarAppointment  = json_encode($this->appointment->get());
        return view('users.admin.Appointment.index-new', compact(['appointments', 'total', 'calendarAppointment']));
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
        $appointment = Appointment::find($id);
        $appointment->update([
            'patient' => $request->patient ?? $appointment->patient,
            'time' => $request->start_time . ' - ' . $request->end_time ?? $appointment->time,
            'date' => $request->date ?? $appointment->date
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

        $appointment->update(['status' => 'approved']);

        return back()->with(['approved' => 'Appointment Approved']);
    }
    public function reject($id){
        $appointment = Appointment::find($id);

        $appointment->update(['status' => 'reject']);

        return back()->with(['rejected' => 'Appointment reject']);
    }
    public function filter($filter){
       $appointments = Appointment::filter($filter);
       $total = $this->appointment->total();

      return view('users.admin.Appointment.filter', compact(['appointments', 'filter', 'total']));
    }
    public function reschedule(Request $request, String $id) {

        $appointment = Appointment::find($id);

        $appointment->update([
            'date' => $request->date,
            'status' => 'RESCHEDULE'
        ]);

        return back()->with(['message' => 'Appointment Date Updated']);
    }

}
