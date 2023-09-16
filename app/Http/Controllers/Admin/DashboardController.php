<?php

namespace App\Http\Controllers\Admin;

use App\Enums\Availability;
use App\Http\Controllers\Controller;
use App\Models\Appointment;
use App\Models\Service;
use Illuminate\Http\Request;


class DashboardController extends Controller
{

    public function __construct(
        public Service $service,
        public Appointment $appointment,
    ) {
    }
    public function dashboard()
    {
        dd($this->service->isAvailable(Availability::INACTIVE));
        $appointments = $this->appointment->paginate(30);
        return view('users.admin.dashboard-new', compact(['appointments']));
    }
}
