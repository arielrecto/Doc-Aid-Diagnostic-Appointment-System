<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    public function home(){
        $role = Auth::user()->roles()->first()->name;

        switch($role) {
            case 'admin' : return redirect(route('admin.dashboard'));
            break;
            case 'patient' : return redirect(route('patient.dashboard'));
            break;
            case 'employee' : return redirect(route('employee.dashboard'));
            break;
            default : return redirect(route('/'));
        }
    }
}
