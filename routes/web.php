<?php

use App\Models\Service;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Admin\ResultController;
use App\Http\Controllers\Admin\ServiceController;
use App\Http\Controllers\Admin\EmployeeController;
use App\Http\Controllers\Patient\FamilyController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Patient\AppointmentController;
use App\Http\Controllers\Patient\FamilyMemberController;
use App\Http\Controllers\Admin\AppointmentController as AdminAppointmentController;
use App\Http\Controllers\Admin\FamilyMemberController as AdminFamilyMemberController;
use App\Http\Controllers\Admin\PatientController;
use App\Http\Controllers\Admin\PaymentAccountController;
use App\Http\Controllers\Admin\PaymentController;
use App\Http\Controllers\Admin\SalesReportController;
use App\Http\Controllers\Patient\DashboardController as PatientDashboardController;
use App\Http\Controllers\Employee\DashboardController as EmployeeDashboardController;
use App\Http\Controllers\Employee\AppointmentController as EmployeeAppointmentController;
use App\Http\Controllers\ImageCarouselController;
use App\Http\Controllers\Patient\FeedbackController;
use App\Http\Controllers\Patient\ProfileController as PatientProfileController;
use App\Http\Controllers\Patient\RescheduleController;
use App\Http\Controllers\PaypalController;
use App\Models\appointmentReschedule;
use App\Models\FeedBack;
use App\Models\ImageCarousel;

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

    $services = Service::get();

    $carousels = ImageCarousel::whereActive(true)->get();

    $feedbacks = FeedBack::latest()->limit(4)->get();

    return view('welcome', compact(['services', 'carousels', 'feedbacks']));
});

Route::get('/home', [HomeController::class, 'home'])->name('home');


Route::prefix('service')->as('service.')->group(function () {

    Route::get('/', function(){
        $services = Service::latest()->get();
        return view('services.index', compact(['services']));
    })->name('index');

    Route::get('/service/{service}', function (string $id) {
        $service = Service::with(['days'])->whereId($id)->first();
        return view('services.show', compact(['service']));
    })->name('show');
});




Route::get('/feedbacks', function () {

    $feedbacks = FeedBack::latest()->get();

    return view('feedback.index', compact(['feedbacks']));
})->name('feedbacks.index');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::middleware('role:admin')->prefix('admin')->as('admin.')->group(function () {
        Route::get('/dashboard', [DashboardController::class, 'dashboard'])->name('dashboard');
        Route::prefix('appointment')->as('appointment.')->group(function () {
            Route::post('/approved/{id}', [AdminAppointmentController::class, 'approved'])->name('approved');
            Route::post('/reject/{id}', [AdminAppointmentController::class, 'reject'])->name('reject');
            Route::get('/date={date}', [AdminAppointmentController::class, 'byDate'])->name('byDate');
            Route::put('/reschedule/approve', [AdminAppointmentController::class, 'approvedReschedule'])->name('reschedule.approve');
            Route::put('/reschedule/reject', [AdminAppointmentController::class, 'rejectReschedule'])->name('reschedule.reject');
            Route::get('/reschedule/id={appointment}', [AdminAppointmentController::class, 'reschedule'])->name('reschedule');
            Route::resource('result', ResultController::class)->except('create');
            Route::resource('payment', PaymentController::class);
        });

        Route::prefix('patient')->as('patient.')->group(function () {
            Route::resource('family', AdminFamilyMemberController::class);
        });


        Route::prefix('/services')->as('service.')->group(function () {
            Route::patch('/availability/{Service}', [ServiceController::class, 'availability'])->name('availability');
        });

        Route::prefix('/sales/report')->as('report.')->group(function () {
            Route::get('/', [SalesReportController::class, 'index'])->name('index');
        });
        Route::resource('paymentAccount', PaymentAccountController::class);
        Route::resource('services', ServiceController::class);
        Route::resource('appointment', AdminAppointmentController::class);
        Route::resource('employee', EmployeeController::class);
        Route::resource('imageCarousel', ImageCarouselController::class);
        Route::resource('patient', PatientController::class);
    });
    Route::middleware(['role:patient', 'verified'])->prefix('patient')->as('patient.')->group(function () {
        Route::get('/dashboard', [PatientDashboardController::class, 'dashboard'])->name('dashboard');
        Route::prefix('appointment/reschedule')->as('appointment.reschedule.')->group(function () {
            Route::get('/create/{appointment}/', [RescheduleController::class, 'create'])->name('create');
            Route::post('/', [RescheduleController::class, 'store'])->name('store');
            Route::get('/show/{appointment}/', [RescheduleController::class, 'show'])->name('show');
            Route::put('/approved', [RescheduleController::class, 'approved'])->name('approved');
            Route::put('/reject', [RescheduleController::class, 'reject'])->name('reject');
        });
        Route::prefix('appointment')->as('appointment.')->group(function () {
            Route::get('/date={date}', [AppointmentController::class, 'byDate'])->name('byDate');
        });

        Route::resource('appointment', AppointmentController::class);
        Route::prefix('family')->as('family.')->group(function () {
            Route::resource('members', FamilyMemberController::class);
        });
        Route::resource('family', FamilyController::class)->except('edit', 'destroy' . 'create');

        Route::prefix('profile')->as('profile.')->group(function () {
            Route::get('/create', [ProfileController::class, 'create'])->name('create');
            Route::get('/show/id={profile}', [ProfileController::class, 'show'])->name('show');
            Route::post('/', [ProfileController::class, 'store'])->name('store');
        });
        Route::resource('feedbacks', FeedbackController::class)->only(['store', 'create']);

        Route::resource('profile', PatientProfileController::class)->except('create', 'show', 'store');

        Route::prefix('paypal')->as('paypal.')->group(function () {
            Route::post('/paypal', [PaypalController::class, 'paypal'])->name('paypal');
            Route::get('/success', [PaypalController::class, 'success'])->name('success');
            Route::get('/cancel', [PaypalController::class, 'cancel'])->name('cancel');
        });
    });
    Route::middleware('role:employee')->prefix('employee')->as('employee.')->group(function () {
        Route::get('/dashboard', [EmployeeDashboardController::class, 'dashboard'])->name('dashboard');
        Route::get('/dashboard/filter', [EmployeeDashboardController::class, 'filter'])->name('filter');
        Route::prefix('/appointment')->as('appointment.')->group(function () {
            Route::post('/approved/{appointment}', [EmployeeAppointmentController::class, 'approved'])->name('approved');
            Route::get('/show/{Appointment}', [EmployeeAppointmentController::class, 'show'])->name('show');
            Route::post('/reject/{appointment}', [EmployeeAppointmentController::class, 'reject'])->name('reject');
            Route::get('/date={date}', [EmployeeAppointmentController::class, 'byDate'])->name('byDate');
        });
    });
});

require __DIR__ . '/auth.php';
