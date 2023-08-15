<?php

namespace App\Http\Controllers\Patient;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use App\Models\Service;
use App\Utilities\ImageUploader;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AppointmentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $appointments = Appointment::get();
        return view('users.patient.appointment.index', compact(['appointments']));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {

        $services = Service::get()->toJSON();
        $timeSlot = $this->timeIntervalByHour('8:00', '4:00');

        return view('users.patient.appointment.create', compact(['services', 'timeSlot']));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $service = Service::find($request->service);
        $imageUploader = new ImageUploader();
        $imageUploader->handler($request->receipt, '/image/receipt/', 'RCPT');

        $user = Auth::user();
        $appointment = Appointment::create([
            'date' => $request->date,
            'patient' => $user->name,
            'time' => $request->timeSlot,
            'type' => 'sample',
            'user_id' => $user->id,
            'service_id' => $service->id,
            'receipt_image' => $imageUploader->getURL(),
            'status' => 'pending'
        ]);


        // $appointment->services()->attach($service->id);

        return back()->with(['message' => 'Appointment Request Sent!']);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
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
