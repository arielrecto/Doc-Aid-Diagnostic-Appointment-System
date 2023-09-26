<?php

namespace App\Http\Controllers\Employee;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use Illuminate\Http\Request;

class AppointmentController extends Controller
{

    public function __construct(Public Appointment $appointment)
    {

    }

    public function show (string $id) {


        $appointment = $this->appointment->where('id', $id)->with('subscribeServices.service')->first();


        return view('users.employee.appointment.show', compact(['appointment']));

    }
    public function approved (Request $request, String $id){
        $appointment = appointment::find($id);

        $appointment->update([
            'status' => 'approved'
        ]);

        return back()->with(['message' => 'Appointment is approved']);
    }
    public function reject (Request $request, String $id){

       $appointment = appointment::find($id);

        $appointment->update([
            'status' => 'reject'
        ]);

        return back()->with(['message' => 'Appointment is approved']);
    }
}
