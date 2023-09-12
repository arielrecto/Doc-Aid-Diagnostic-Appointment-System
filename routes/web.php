<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Admin\ServiceController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Patient\AppointmentController;
use App\Http\Controllers\Admin\AppointmentController as AdminAppointmentController;
use App\Http\Controllers\Admin\EmployeeController;
use App\Http\Controllers\Admin\ResultController;
use App\Http\Controllers\Patient\DashboardController as PatientDashboardController;
use App\Http\Controllers\Employee\DashboardController as EmployeeDashboardController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Patient\FamilyController;
use App\Http\Controllers\Patient\FamilyMemberController;
use App\Models\Service;

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
    Route::middleware('role:admin')->prefix('admin')->as('admin.')->group(function(){
        Route::get('/dashboard', [DashboardController::class, 'dashboard'])->name('dashboard');
        Route::prefix('appointment')->as('appointment.')->group(function(){
            Route::post('/approved/{id}', [AdminAppointmentController::class, 'approved'])->name('approved');
            Route::post('/reject/{id}', [AdminAppointmentController::class, 'reject'])->name('reject');
            Route::get('/filter={filter}', [AdminAppointmentController::class, 'filter'])->name('filter');
            Route::put('/reschedule/id={appointment}', [AdminAppointmentController::class, 'reschedule'])->name('reschedule');
            Route::resource('result', ResultController::class)->except('create');
        });
        Route::prefix('/services')->as('service.')->group(function (){
            Route::patch('/availability/{Service}', [ServiceController::class, 'availability'])->name('availability');
        });
        Route::resource('services', ServiceController::class);
        Route::resource('appointment', AdminAppointmentController::class);
        Route::resource('employee', EmployeeController::class);
    });
    Route::middleware('role:patient')->prefix('patient')->as('patient.')->group(function(){
        Route::get('/dashboard', [PatientDashboardController::class, 'dashboard'])->name('dashboard');
        Route::resource('appointment', AppointmentController::class);
        Route::prefix('family')->as('family.')->group(function(){
            Route::resource('members', FamilyMemberController::class);
        });
        Route::resource('family', FamilyController::class)->except('edit', 'destroy'.'create');

        Route::prefix('profile')->as('profile.')->group(function(){
            Route::get('/create', [ProfileController::class, 'create'])->name('create');
            Route::get('/show/id={profile}', [ProfileController::class, 'show'])->name('show');
            Route::post('/', [ProfileController::class, 'store'])->name('store');
        });

    });
    Route::middleware('role:employee')->prefix('employee')->as('employee.')->group(function() {
        Route::get('/dashboard', [EmployeeDashboardController::class, 'dashboard'])->name('dashboard');
        Route::get('/dashboard/filter', [EmployeeDashboardController::class, 'filter'])->name('filter');
    });


});

require __DIR__.'/auth.php';
