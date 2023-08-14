<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Admin\ServiceController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Patient\AppointmentController;
use App\Http\Controllers\Admin\AppointmentController as AdminAppointmentController;
use App\Http\Controllers\Patient\DashboardController as PatientDashboardController;
use App\Http\Controllers\Employee\DashboardController as EmployeeDashboardController;
use App\Http\Controllers\HomeController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/home', [HomeController::class, 'home'])->name('home');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::middleware('role:admin')->prefix('admin')->as('admin.')->group(function(){
        Route::get('/dashboard', [DashboardController::class, 'dashboard'])->name('dashboard');
        Route::prefix('appointment')->as('appointment.')->group(function(){
            Route::post('/approved/{id}', [AdminAppointmentController::class, 'approved'])->name('approved');
        });
        Route::resource('services', ServiceController::class);
        Route::resource('appointment', AdminAppointmentController::class);
    });
    Route::middleware('role:patient')->prefix('patient')->as('patient.')->group(function(){
        Route::get('/dashboard', [PatientDashboardController::class, 'dashboard'])->name('dashboard');
        Route::resource('appointment', AppointmentController::class)->only('store', 'index', 'create');
    });
    Route::middleware('role:employee')->prefix('employee')->as('employee.')->group(function() {
        Route::get('/dashboard', [EmployeeDashboardController::class, 'dashboard'])->name('dashboard');
    });


});

require __DIR__.'/auth.php';
