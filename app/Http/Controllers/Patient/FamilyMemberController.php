<?php

namespace App\Http\Controllers\Patient;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use App\Models\FamilyMember;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FamilyMemberController extends Controller
{
    /**
     * Display a listing of the resource.
     */


    public function __construct(public FamilyMember $familyMember)
    {

    }

    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('users.patient.family.member.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

       $request->validate([
            'last_name' => 'required',
            'first_name' => 'required',
            'sex' => 'required',
            'email' => 'required',
            'relationship' => 'required',
            'contact_no' => 'required'
       ]);

       $imageName = 'famIMG-' . uniqid() . '.' . $request->image->extension();
       $dir = $request->image->storeAs('/profile/Family', $imageName, 'public');


       $user = Auth::user();


       FamilyMember::create([
        'image' =>  asset('/storage/' . $dir),
        'full_name' => $request->last_name . ', ' . $request->first_name,
        'last_name' => $request->last_name,
        'first_name' => $request->first_name,
        'middle_name' => $request->middle_name === null ? 'N\A' : $request->middle,
        'sex' => $request->sex,
        'relationship' => $request->relationship,
        'contact_no' => $request->contact_no,
        'email' => $request->email,
        'family_id' => $user->family->id
       ]);


       return back()->with(['message' => 'New Family Member Added Successfully']);

    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $profile = $this->familyMember->where('id', $id)->first();

        $medicalHistory = Appointment::where('is_family', true)->where('family_member_id', $id)->get();


        return view('users.patient.family.member.show', compact(['profile', 'medicalHistory']));
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
