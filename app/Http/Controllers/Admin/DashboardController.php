<?php

namespace App\Http\Controllers\Admin;

use App\Models\Service;
use App\Models\Appointment;
use Illuminate\Http\Request;
use App\Enums\AppointmentStatus;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Mockery\Undefined;

class DashboardController extends Controller
{

    public function __construct(
        public Appointment $appointment,
        public Service $service
    ) {
    }
    public function dashboard()
    {

        $year = now()->format('Y');

        $sales = $this->appointment->totalSaleInYear($year);
        $totalPendingAppointment = $this->appointment->whereStatus(AppointmentStatus::PENDING->value)->count();
        $appointments = $this->appointment->paginate(30);
        $calendarAppointment  = json_encode($this->appointment->get());
        $totalServices = $this->service->count();
        $monthlyTotal =  json_encode($this->getMonthlySalesInYear($year));

        return view('users.admin.dashboard-new', compact([
            'appointments',
            'sales',
            'totalPendingAppointment',
            'year',
            'totalServices',
            'monthlyTotal',
            'calendarAppointment'
        ]));
    }
    private function getMonthlySalesInYear(string $year)
    {

        $months = [];

        for ($m = 1; $m <= 12; $m++) {
            $monthName = date('F', mktime(0, 0, 0, $m, 1, date('Y')));
            $months[$monthName] = 0;
        }

        $appointments = $this->appointment->whereStatus(AppointmentStatus::DONE->value)
            ->whereYear('date', $year)->get();




        foreach ($appointments as $appointment) {
            $month = date('F', strtotime($appointment->date));
            $months[$month] += $appointment->total;
        };

        return $months;
    }
}
