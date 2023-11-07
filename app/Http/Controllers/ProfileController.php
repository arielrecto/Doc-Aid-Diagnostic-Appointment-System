<?php

namespace App\Http\Controllers;

use App\Enums\AppointmentStatus;
use App\Models\Profile;
use Illuminate\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Redirect;
use App\Http\Requests\ProfileUpdateRequest;
use App\Models\Appointment;
use App\Models\Result;
use App\Utilities\ImageUploader;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        return view('profile.edit', [
            'user' => $request->user(),
        ]);
    }
    public function create()
    {
        return view('users.patient.profile.create');
    }

    /**
     * Update the user's profile information.
     */

    public function show(String $id)
    {
        if (Auth::user()->profile == null) {
            return to_route('patient.profile.create');
        }

        $user = Auth::user();


        $medicalHistory = $user->appointments()
                        ->whereIsFamily(false)
                        ->whereStatus(AppointmentStatus::DONE->value)
                        ->get();


        $profile = Profile::find($id);

        return view('users.patient.profile.show', compact(['profile', 'medicalHistory']));
    }

    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'avatar' => 'required',
            'last_name' => 'required',
            'first_name' => 'required',
            'gender' => 'required',
            'birthdate' => 'required',
            'age' => 'required',
            'street' => 'required',
            'barangay' => 'required',
            'municipality' => 'required',
            'region' => 'required',
            'contact_no' => 'required',
            'zip_code' => 'required'
        ]);

        $imageName = 'avatar-' . uniqid() . '.' . $request->avatar->extension();
        $dir = $request->avatar->storeAs('/profile/avatar', $imageName, 'public');


        $profile = Profile::create([
            'avatar' => asset('/storage/' . $dir),
            'full_name' => $request->last_name . ', ' . $request->first_name . ' ' . $request->middle_name ?? ' ',
            'last_name' => $request->last_name,
            'first_name' => $request->first_name,
            'middle_name' => $request->middle_name ?? 'N/A',
            'birthdate' => $request->birthdate,
            'age' => $request->age,
            'gender' => $request->gender,
            'street' => $request->street,
            'barangay' => $request->barangay,
            'municipality' => $request->municipality,
            'region' => $request->region,
            'contact_no' => $request->contact_no,
            'zip_code' => $request->zip_code,
            'user_id' => Auth::user()->id
        ]);

        return redirect(route('patient.profile.show', ['profile' => $profile->id]))->with(['message', 'Profile Created !']);
    }


    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $request->user()->fill($request->validated());

        if ($request->user()->isDirty('email')) {
            $request->user()->email_verified_at = null;
        }

        $request->user()->save();

        return Redirect::route('profile.edit')->with('status', 'profile-updated');
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
}
