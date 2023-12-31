<?php

namespace App\Http\Controllers\Patient;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function __construct(public Appointment $appointment)
    {

    }
    public function dashboard()
    {

        $user = Auth::user();

        // $services = Service::get();
        $appointments = Appointment::with('subscribeServices.service')->whereId($user->id)->get()->toJson();
        $timeInterval = $this->timeIntervalByHour('8:00', '4:00');
        $todayAppointments = $this->appointment->today();
        $totalAppointments = $this->appointment->whereId($user->id)->count();

        return view('users.patient.dashboard', compact(['timeInterval', 'todayAppointments', 'appointments', 'totalAppointments']));
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
