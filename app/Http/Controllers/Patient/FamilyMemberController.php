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
            'contact_no' => 'required',
            'birthdate' => 'required',
            'valid_id_image' => 'required',
            'valid_id_type' => 'required',
            'valid_id_number' => 'required'
        ]);


        $imageName = 'famIMG-' . uniqid() . '.' . $request->image->extension();
        $dir = $request->image->storeAs('/profile/Family', $imageName, 'public');



        $validID = 'vld-' . $request->last_name . '-' . uniqid() . '.' . $request->valid_id_image->extension();
        $validID_dir = $request->valid_id_image->storeAs('/profile/Family/ID', $validID, 'public');


        $user = Auth::user();


        FamilyMember::create([
            'image' =>  asset('/storage/' . $dir),
            'full_name' => $request->last_name . ', ' . $request->first_name,
            'last_name' => $request->last_name,
            'first_name' => $request->first_name,
            'middle_name' => $request->middle_name,
            'sex' => $request->sex,
            'relationship' => $request->relationship,
            'contact_no' => $request->contact_no,
            'email' => $request->email,
            'family_id' => $user->family->id,
            'birthdate' => $request->birthdate,
            'valid_id_image' => asset('/storage/' . $validID_dir),
            'valid_id_type' => $request->valid_id_type,
            'valid_id_number' => $request->valid_id_number
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
        $family = FamilyMember::find($id);

        return view('users.patient.family.member.edit', compact(['family']));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {


        $familyMember = FamilyMember::find($id);


        if ($request->hasFile('image')) {
            $imageName = 'famIMG-' . uniqid() . '.' . $request->image->extension();
            $dir = $request->image->storeAs('/profile/Family', $imageName, 'public');
        }



        if ($request->hasFile('valid_id_image')) {
            $validID = 'vld-' . $request->last_name . '-' . uniqid() . '.' . $request->valid_id_image->extension();
            $validID_dir = $request->valid_id_image->storeAs('/profile/Family/ID', $validID, 'public');
        }


        $fullName = $request->last_name . ', ' . $request->first_name;

        if ($request->last_name !== null) {
            $fullName = $request->last_name . ', ' . $familyMember->first_name;
        } else {
            $fullName = $familyMember->last_name . ', ' . $request->first_name;

        }

        if ($request->last_name === null && $request->first_name === null) {
            $fullName = $familyMember->full_name;
        }



        $familyMember->update([
            'image' =>  $request->image !== null ? asset('/storage/' . $dir) : $familyMember->image,
            'full_name' => $fullName,
            'last_name' => $request->last_name ?? $familyMember->last_name,
            'first_name' => $request->first_name ?? $familyMember->first_name,
            'middle_name' => $request->middle_name ?? $familyMember->middle_name,
            'sex' => $request->sex ?? $familyMember->sex,
            'relationship' => $request->relationship ?? $familyMember->relationship,
            'contact_no' => $request->contact_no ?? $familyMember->contact_no,
            'email' => $request->email ?? $familyMember->email,
            'birthdate' => $request->birthdate ?? $familyMember->birthdate,
            'valid_id_image' => $request->valid_id_image !== null ? asset('/storage/' . $validID_dir) : $familyMember->valid_id_image,
            'valid_id_type' => $request->valid_id_type ?? $familyMember->valid_id_type,
            'valid_id_number' => $request->valid_id_number ?? $familyMember->valid_id_number
        ]);


        return to_route('patient.family.members.show', ['member' => $familyMember->id]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
