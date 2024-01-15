<?php

namespace App\Http\Controllers\Patient;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Family;
use App\Models\FamilyMember;
use Illuminate\Support\Facades\Auth;

class FamilyController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        $members = Family::authUserFamilyMember();

        return view('users.patient.family.index', compact(['members']));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
       $user = Auth::user();
       $request->validate([
        'name' => 'required'
       ]);

       Family::create([
        'name' => $request->name,
        'user_id' => $user->id
       ]);

       return back()->with(['message' => 'Family Added Success']);
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

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $family = Family::find($id);

        $family->update([
            'name' => $request->name
        ]);

        return back();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
