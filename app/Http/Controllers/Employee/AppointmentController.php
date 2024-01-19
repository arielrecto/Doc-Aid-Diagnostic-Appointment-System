<?php

namespace App\Http\Controllers\Employee;

use App\Models\User;
use App\Models\Appointment;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Notifications\AppointmentStatusNotification;

class AppointmentController extends Controller
{

    public function __construct(Public Appointment $appointment)
    {

    }

    public function show (string $id) {


        $appointment = $this->appointment->where('id', $id)->with('subscribeServices.service')->first();


        return view('users.employee.appointment.show', compact(['appointment']));

    }
    public function approved (Request $request, String $id){
        $appointment = appointment::find($id);

        $user = User::find($appointment->user_id);

        $message  = [
            'content' => "Your Appointment is Approved",
            'date' =>  'Date: ' . now()->format('F-d-Y')
        ];

        $user->notify(new AppointmentStatusNotification($message));


        $appointment->update([
            'status' => 'approved'
        ]);

        return back()->with(['message' => 'Appointment is approved']);
    }
    public function reject (Request $request, String $id){

       $appointment = appointment::find($id);

       $user = User::find($appointment->user_id);

       $message  = [
           'content' => "Your Appointment is rejected",
           'date' =>  'Date: ' . now()->format('F-d-Y')
       ];

       $user->notify(new AppointmentStatusNotification($message));

        $appointment->update([
            'status' => 'reject'
        ]);

        return back()->with(['reject' => 'Appointment is rejected']);
    }
    public function byDate(string $date){


        $appointments = Appointment::with('subscribeServices.service')->where('date' , $date)->get();

        return response([
            'appointments' => $appointments,
        ], 200);
    }
}
