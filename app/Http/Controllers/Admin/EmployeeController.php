<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Profile;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class EmployeeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        $employees = User::role('employee')->get();
        return view('users.admin.Employee.index', compact(['employees']));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('users.admin.Employee.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            // 'name' => 'required',
            'email' => 'required',
            'password' => 'required|confirmed',
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

        $user = User::create([
            'name' => $request->last_name . ' ,' . $request->first_name,
            'email' => $request->email,
            'password' => Hash::make($request->password)
        ]);

        Profile::create([
            'avatar' => asset('image/logo.jpg'),
            'full_name' => $request->last_name . ' ,' . $request->first_name,
            'last_name' => $request->last_name,
            'first_name' => $request->first_name,
            'gender' => $request->gender,
            'birthdate' => $request->birthdate,
            'age' => $request->age,
            'street' => $request->street,
            'barangay' => $request->barangay,
            'municipality' => $request->municipality,
            'region' => $request->region,
            'contact_no' => $request->contact_no,
            'zip_code' => $request->zip_code,
            'user_id' => $user->id
        ]);

        $role = Role::where('name', 'employee')->first();

        $user->assignRole($role);


        return back()->with(['message' => 'Employee Account Created !']);
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
