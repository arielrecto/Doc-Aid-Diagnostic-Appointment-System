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
}
