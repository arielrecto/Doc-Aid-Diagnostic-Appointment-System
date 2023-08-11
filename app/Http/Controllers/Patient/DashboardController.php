<?php

namespace App\Http\Controllers\Patient;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use App\Models\Service;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function dashboard() {
        $services = Service::get();
        $appointments = Appointment::where('is_approved' , true)->with('services')->get()->toJson();
        return view('users.patient.dashboard', compact(['services', 'appointments']));
    }
}
