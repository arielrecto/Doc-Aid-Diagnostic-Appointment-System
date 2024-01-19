<?php

namespace App\Http\Controllers\Admin;

use App\Models\Appointment;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Enums\AppointmentStatus;
use App\Http\Controllers\Controller;

class SalesReportController extends Controller
{
    public function index(Request $request)
    {


        $filter = $request->filter;

        $sales = collect($this->weeklySales());

        $tagline = "weekly";

        if ($filter !== null) {
            if ($filter === 'monthly') {

                $sales = collect($this->monthlySales());

                $tagline = "Month" . ' - ' . now()->format('F');
            }
            if ($filter === 'year') {

                $sales = collect($this->annualSales());

                $tagline = "year" . ' - ' . now()->format('Y');
            }
            if($filter === 'custom'){

                $tagline = "{$request->start_date} - {$request->end_date}";

                $sales = collect($this->dateRangeSales($request->start_date, $request->end_date));
            }
        }


        return view('users.admin.Report.index', compact(['sales', 'tagline']));
    }
    private function weeklySales()
    {
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
    private function monthlySales()
    {
        $startDate = now()->startOfMonth();
        $endDate = now()->endOfMonth();

        $monthlySalesData = [];

        for ($date = $startDate; $date->lte($endDate); $date->addDay()) {
            $dayOfMonth = $date->format('j'); // Get the day of the month

            $monthlyAppointments = Appointment::whereStatus(AppointmentStatus::DONE->value)
                ->whereRaw('MONTH(date) = ?', [$date->month])
                ->count();

            $monthlySales = Appointment::whereStatus(AppointmentStatus::DONE->value)
                ->whereRaw('MONTH(date) = ?', [$date->month])
                ->sum('total');

            $monthlySalesData[] = [
                'name' => $dayOfMonth,
                'total_appointments' => $monthlyAppointments,
                'total_sales' => $monthlySales,
            ];
        }

        return $monthlySalesData;
    }
    private function annualSales(){
        $startDate = now()->startOfYear();
        $endDate = now()->endOfYear();

        $annualSalesData = [];

        for ($date = $startDate; $date->lte($endDate); $date->addMonth()) {
            $monthOfYear = $date->format('F'); // Get the month name

            $annualAppointments = Appointment::whereStatus(AppointmentStatus::DONE->value)
                ->whereRaw('YEAR(date) = ?', [$date->year])
                ->whereRaw('MONTH(date) = ?', [$date->month])
                ->count();

            $annualSales = Appointment::whereStatus(AppointmentStatus::DONE->value)
                ->whereRaw('YEAR(date) = ?', [$date->year])
                ->whereRaw('MONTH(date) = ?', [$date->month])
                ->sum('total');

            $annualSalesData[] = [
                'name' => $monthOfYear,
                'total_appointments' => $annualAppointments,
                'total_sales' => $annualSales,
            ];
        }

        return $annualSalesData;
    }
    private function dateRangeSales($startDate, $endDate){
        $startDate = Carbon::parse($startDate)->startOfDay();
        $endDate = Carbon::parse($endDate)->endOfDay();

        $salesData = [];

        for ($date = $startDate; $date->lte($endDate); $date->addDay()) {
            $formattedDate = $date->format('F d, Y');

            $dailyAppointments = Appointment::whereStatus(AppointmentStatus::DONE->value)
                ->whereDate('date', $formattedDate)
                ->count();

            $dailySales = Appointment::whereStatus(AppointmentStatus::DONE->value)
                ->whereDate('date', $formattedDate)
                ->sum('total');

            $salesData[] = [
                'name' => $formattedDate,
                'total_appointments' => $dailyAppointments,
                'total_sales' => $dailySales,
            ];
        }

        return $salesData;
    }
}
