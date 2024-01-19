<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use Illuminate\Http\Request;
use App\Enums\AppointmentStatus;
use App\Http\Controllers\Controller;
use App\Models\Profile;

class PatientController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        $patients = User::role('patient')->get();


        return view('users.admin.patient.index', compact('patients'));
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

    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $patient = User::find($id);

        $profile = $patient->profile;



        $medicalHistory = $patient->appointments()
                        ->whereIsFamily(false)
                        ->whereStatus(AppointmentStatus::DONE->value)
                        ->get();



        return view('users.admin.patient.show', compact(['patient', 'profile', 'medicalHistory']));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {

        $profile = Profile::find($id);

        return view('users.admin.patient.edit', compact(['profile']));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {

        $profile = Profile::find($id);

        if($request->hasFile('avatar')){
            $imageName = 'avatar-' . uniqid() . '.' . $request->avatar->extension();
            $dir = $request->avatar->storeAs('/profile/avatar', $imageName, 'public');
        }


        if ($request->hasFile('valid_id_image')) {
            $validID = 'vld-' . $request->last_name . '-' . uniqid() . '.' . $request->valid_id_image->extension();
            $validID_dir = $request->valid_id_image->storeAs('/profile/Family/ID', $validID, 'public');
        }

        $fullName = $request->last_name . ', ' . $request->first_name;

        if ($request->last_name !== null) {
            $fullName = $request->last_name . ', ' . $profile->first_name;
        } else {
            $fullName = $profile->last_name . ', ' . $request->first_name;

        }

        if ($request->last_name === null && $request->first_name === null) {
            $fullName = $profile->full_name;
        }


        $profile->update([
            'avatar' => $request->hasFile('avatar') ? asset('/storage/' . $dir) : $profile->avatar,
            'last_name' => $request->last_name ?? $profile->last_name,
            'first_name' => $request->first_name ?? $profile->first_name,
            'middle_name' => $request->middle_name ?? $profile->middle_name,
            'birthdate' => $request->birthdate ?? $profile->birthdate,
            'age' => $request->age ?? $profile->age,
            'gender' => $request->gender ?? $profile->gender,
            'street' => $request->street ?? $profile->street,
            'barangay' => $request->barangay ?? $profile->barangay,
            'municipality' => $request->municipality ?? $profile->municipality,
            'region' => $request->region ?? $profile->region,
            'contact_no' => $request->contact_no ?? $profile->contact_no,
            'zip_code' => $request->zip_code ?? $profile->zip_code,
            'valid_id_image' => $request->valid_id_image !== null ? asset('/storage/' . $validID_dir) : $profile->valid_id_image,
            'valid_id_type' => $request->valid_id_type ?? $profile->valid_id_type,
            'valid_id_number' => $request->valid_id_number ?? $profile->valid_id_number
        ]);

        $profile->update([
            'full_name' => $profile->last_name . ', ' . $profile->first_name . ' ' . $request->middle_name
        ]);

        return back()->with(['message' => 'Profile is Updated']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $patient = User::find($id);

        $patient->delete();


        return back()->with(['message' => 'patient Deleted']);
    }
}
