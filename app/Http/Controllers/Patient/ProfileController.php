<?php

namespace App\Http\Controllers\Patient;

use App\Http\Controllers\Controller;
use App\Models\Profile;
use Illuminate\Http\Request;

class ProfileController extends Controller
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
        //
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
        $profile = Profile::find($id);


        return view('users.patient.profile.edit', compact(['profile']));
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
        //
    }
}
