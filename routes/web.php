<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\EmployeesController;
use App\Http\Controllers\LeaveRequestController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SalarySlipsController;
use Illuminate\Support\Facades\Route;
use SebastianBergmann\CodeCoverage\Report\Html\Dashboard;

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
    return redirect('register');
});

// employee profile for users
Route::get('/employeedetails', [ProfileController::class, 'index'])->name('profile.index');
Route::get('/employeedetails/create-leave-request', [ProfileController::class,'leave_request'])->name('profile.leave_request');
Route::post('/employeedetails/create-leave-request/create', [ProfileController::class, 'leave_request_create'])->name('profile.leave_request.create');
Route::get('employeedetails/leave-requests', [ProfileController::class, 'leave_request_show'])->name('profile.leave_requests.show');

Route::middleware([
    'auth:sanctum','is_admin',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard.index');

    // Staffs
    Route::get('/employees', [EmployeesController::class,'index'])->name('employees.index');
    Route::get('/employees/create', [EmployeesController::class, 'create'])->name('employees.create');
    Route::post('/employees', [EmployeesController::class, 'store']);
    Route::get('/employee/details/{id}', [EmployeesController::class, 'show'])->name('employee.detail');
    Route::get('/employee/edit/{id}', [EmployeesController::class, 'edit'])->name('employee.edit');
    Route::patch('/employee/update/{id}', [EmployeesController::class, 'update'])->name('employee.update');
    Route::delete('/employee/{id}', [EmployeesController::class, 'destroy'])->name('employee.destroy');

    //Salary Slip Route
    Route::get('/salary-slips', [SalarySlipsController::class, 'index'])->name('salary-slips.index');
    Route::get('/salary-slips/create', [SalarySlipsController::class, 'create'])->name('salary-slips.create');
    Route::get('/salary-slips/create/{id}', [SalarySlipsController::class, 'create_form'])->name('salary-slips.create_form');
    Route::post('/salary-slips', [SalarySlipsController::class, 'store'])->name('salary-slips.store');
    Route::get('/salary-slips/{id}', [SalarySlipsController::class, 'show'])->name('salary-slips.show');

    // leave requests
    Route::get('/leaverequests', [LeaveRequestController::class,'index'])->name('leaverequest.index');
    Route::patch('/leaverequests/check/{id}', [LeaveRequestController::class,'check'])->name('leaverequest.check');
    Route::patch('/leaverequests/reject/{id}', [LeaveRequestController::class,'reject'])->name('leaverequest.reject');
    Route::patch('/leaverequests/reset', [LeaveRequestController::class, 'reset'])->name('leaverequest.reset');
    Route::delete('/leaverequests/delete', [LeaveRequestController::class, 'delete'])->name('leaverequest.delete');
});