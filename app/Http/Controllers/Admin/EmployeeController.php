<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;

class EmployeeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('users.admin.Employee.index');
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
        'name' => 'required',
        'email' => 'required',
        'password' => 'required|confirmed'
       ]);

       $user = User::create($data);

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
