<?php

namespace App\Http\Controllers\Admin;

use App\Enums\AppointmentStatus;
use App\Models\Appointment;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SalesReportController extends Controller
{
    public function index(){

        $weeklySales = collect($this->weeklySales());

        return view('users.admin.Report.index', compact(['weeklySales']));
    }
    private function weeklySales(){
        $startDate = now()->startOfWeek();
        $endDate = now()->endOfWeek();

        $weeklySalesData = [];

        for ($date = $startDate; $date->lte($endDate); $date->addDay()) {
            $dayOfWeek = $date->format('l'); // Get the day name (e.g., Monday)

            $dailyAppointments = Appointment::whereStatus(AppointmentStatus::DONE->value)
            ->whereRaw('DAYOFWEEK(date) = ?', [$date->dayOfWeek + 1])
                ->count();
            //  $dailyAppointments = Appointment::where(function($q){

            //  })->whereStatus(AppointmentStatus::DONE->value)->count();

            $dailySales = Appointment::whereStatus(AppointmentStatus::DONE->value)->whereRaw('DAYOFWEEK(date) = ?', [$date->dayOfWeek + 1])
                ->sum('total');

            $weeklySalesData[] = [
                'name' => $dayOfWeek,
                'total_appointments' => $dailyAppointments,
                'total_sales' => $dailySales,
            ];
        }

      return $weeklySalesData;
    }
}
