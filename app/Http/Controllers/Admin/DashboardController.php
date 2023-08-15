<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function dashboard() {
        $appointments = Appointment::paginate(30);
        return view('users.admin.dashboard-new', compact(['appointments']));
    }
}
