<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use Illuminate\Http\Request;

class AppointmentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $appointments = Appointment::get();
        $total = Appointment::total();
        return view('users.admin.Appointment.index-new', compact(['appointments', 'total']));
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

        $appointment = Appointment::find($id);

        return view('users.admin.Appointment.show', compact(['appointment']));
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
        $appointment = Appointment::find($id);

        $appointment->delete();


        return back()->with(['rejected' => 'Appointment Rejected ! ']);
    }
    public function approved($id){
        $appointment = Appointment::find($id);

        $appointment->update(['status' => 'approved']);

        return back()->with(['approved' => 'Appointment Approved']);
    }
    public function reject($id){
        $appointment = Appointment::find($id);

        $appointment->update(['status' => 'reject']);

        return back()->with(['reject' => 'Appointment reject']);
    }
    public function filter($filter){
       $appointments = Appointment::filter($filter);
       $total = Appointment::total();

      return view('users.admin.Appointment.filter', compact(['appointments', 'filter', 'total']));
    }
}
