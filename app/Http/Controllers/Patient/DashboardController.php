<?php

namespace App\Http\Controllers\Patient;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use App\Models\Service;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function __construct(public Appointment $appointment)
    {

    }
    public function dashboard()
    {
        $services = Service::get();
        $appointments = Appointment::with('subscribeServices.service')->get()->toJson();
        $timeInterval = $this->timeIntervalByHour('8:00', '4:00');
        $todayAppointments = $this->appointment->today();

        return view('users.patient.dashboard', compact(['services', 'timeInterval', 'todayAppointments', 'appointments']));
    }
    public function timeIntervalByHour($start, $end)
    {
        $startTime = strtotime($start .'AM');
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
}
