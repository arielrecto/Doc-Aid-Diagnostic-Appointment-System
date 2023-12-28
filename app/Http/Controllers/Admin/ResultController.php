<?php

namespace App\Http\Controllers\Admin;

use App\Enums\AppointmentStatus;
use App\Models\Result;
use Illuminate\Http\Request;
use App\Utilities\FileUploader;
use App\Http\Controllers\Controller;
use App\Mail\AppointmentResult;
use App\Models\Appointment;
use App\Models\FamilyMember;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Validation\Rules\Unique;

class ResultController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        $appointment = Appointment::find($request->appointment_id);


        // $appointment->user->family->members()->get()


        if($appointment->balance != 0){
            return back()->with(['rejected' => 'appointment has remaining balance: ₱ ' . $appointment->balance]);
        }


        $patient = $appointment->user
                    ->family
                    ->members()
                    ->whereFullName($appointment->patient)
                    ->first();

        if($patient !== null) {
            $appointment->update([
                'is_family' => true,
                'family_member_id' => $patient->id
            ]);
        }

        $appointment->update([
            'status' => AppointmentStatus::DONE->value
        ]);

        $fileUploader = new FileUploader();
        $fileUploader->handler($request->file, '/file/result', str_replace(' ' , '', $appointment->patient));

       $result =  Result::create([
            'name' => $request->name,
            'user_id' => $appointment->user->id,
            'description' => $request->description,
            'appointment_id' => $appointment->id,
            'path' => $fileUploader->getPath()
        ]);





        Mail::to($appointment->user->email)->send(new AppointmentResult($result, asset($result->path)));

        return back()->with(['message' => 'Result Uploaded !']);
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
}
