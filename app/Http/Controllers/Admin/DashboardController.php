<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use Illuminate\Http\Request;


class DashboardController extends Controller
{

    public function __construct(
        public Appointment $appointment,
    ) {
    }
    public function dashboard()
    {
        $appointments = $this->appointment->paginate(30);
        return view('users.admin.dashboard-new', compact(['appointments']));
    }
}
