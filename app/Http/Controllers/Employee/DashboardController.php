<?php

namespace App\Http\Controllers\Employee;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class DashboardController extends Controller
{
    public function __construct(public Appointment $appointment)
    {
    }
    public function dashboard()
    {
        $appointments = Appointment::paginate(20);
        $appointmentsTodayTotal = $this->appointment->today()->count();

        $appointmentByMonthTotal = $this->appointment->currentMonth()->count();


        return view('users.employee.dashboard', compact(['appointments', 'appointmentsTodayTotal', 'appointmentByMonthTotal']));
    }
    public function filter(Request $request)
    {
        $search = $request->search;
        $appointments = Appointment::where(function ($query) use ($search) {
            $columns = Schema::getColumnListing('appointments');
            foreach ($columns as $column) {
                $query->orWhere(DB::raw("LOWER($column)"), 'LIKE', '%' . strtolower($search) . '%');
            }
        })->paginate(20);

        $appointmentsTodayTotal = $this->appointment->today()->count();

        $appointmentByMonthTotal = $this->appointment->currentMonth()->count();

        return view('users.employee.appointment.filter',  compact(['appointments', 'appointmentsTodayTotal', 'appointmentByMonthTotal']));
    }
}
