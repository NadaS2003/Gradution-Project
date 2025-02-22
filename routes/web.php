<?php

use App\Http\Controllers\Auth\NewPasswordController;
use App\Http\Controllers\Auth\PasswordResetLinkController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\Auth\LoginController;

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
    return view('splash');
});

###############################################################################################################
Route::get('/loginAll', function () {
    return view('Login.login');
})->name('loginAll');

Route::get('/superLogin', function () {
    return view('Login.supervisorLogin');
});

Route::get('/studentLogin', function () {
    return view('Login.studentLogin');
});
Route::get('/companyLogin', function () {
    return view('Login.companyLogin');
});

Route::get('/adminLogin', function () {
    return view('Login.adminLogin');
});


Route::post('/logout', function () {
    Auth::logout();
    return redirect('/login');
})->name('logout');

Route::get('/forgot-password', [PasswordResetLinkController::class, 'create'])
    ->name('password.request');

Route::post('/forgot-password', [PasswordResetLinkController::class, 'store'])
    ->name('password.email');

Route::get('/reset-password/{token}', [NewPasswordController::class, 'create'])
    ->name('password.reset');

Route::post('/reset-password', [NewPasswordController::class, 'store'])
    ->name('password.update');

###############################################################################################################3
Route::get('/registerAll', function () {
    return view('register.register');
})->name('registerAll');

Route::get('/superReg', function () {
    return view('register.superReg');
});

Route::get('/studentReg', function () {
    return view('register.studentReg');
});
Route::get('/companyReg', function () {
    return view('register.companyReg');
});
//
//Route::get('/adminReg', function () {
//    return view('register.adminReg');
//});

Route::get('/register/supervisor', [RegisteredUserController::class, 'createSupervisor'])->name('register.supervisor');
Route::post('/register/supervisor', [RegisteredUserController::class, 'storeSupervisor']);

Route::get('/register/company', [RegisteredUserController::class, 'createCompany'])->name('register.company');
Route::post('/register/company', [RegisteredUserController::class, 'storeCompany']);

Route::get('/register/student', [RegisteredUserController::class, 'createStudent'])->name('register.student');
Route::post('/register/student', [RegisteredUserController::class, 'storeStudent']);



###############################################################################################################3

Route::get('/studentDash',function (){
    return view('student.dashboard');
})->name('student.dashboard')->middleware('role:student');

Route::get('/showTraining',function (){
    return view('student.showTrainingOpportunities');
})->name('student.showTraining');

Route::get('/OpportunityDetails',function (){
    return view('student.opportunityDetails');
})->name('student.opportunityDetails');

Route::get('/myRequests',function (){
    return view('student.myRequests');
})->name('student.myRequests');

Route::get('/myProfile',function (){
    return view('student.myProfile');
})->name('student.myProfile');

Route::get('/myProfile',function (){
    return view('student.myProfile');
})->name('student.myProfile');

Route::get('/applyRequest',function (){
    return view('student.applyRequest');
})->name('student.applyRequest');

Route::get('/companyRate',function (){
    return view('student.companyRate');
})->name('student.companyRate');

###############################################################################################################3

Route::get('/supervisorDash',function (){
    return view('supervisor.dashboard');
})->name('supervisor.dashboard')->middleware('role:supervisor');

Route::get('/studentsList',function (){
    return view('supervisor.studentsList');
})->name('supervisor.studentsList');

Route::get('/studentDetails',function (){
    return view('supervisor.studentDetails');
})->name('supervisor.studentDetails');

Route::get('/companiesList',function (){
    return view('supervisor.companiesList');
})->name('supervisor.companiesList');

Route::get('/rates',function (){
    return view('supervisor.rates');
})->name('supervisor.rates');

###############################################################################################################3

Route::get('/companyDash',function (){
    return view('company.dashboard');
})->name('company.dashboard')->middleware('role:company');
###############################################################################################################3

Route::get('/adminDash',function (){
    return view('admin.dashboard');
})->name('admin.dashboard')->middleware('role:admin');

Route::get('/studentsManagement',function (){
    return view('admin.studentsManagement');
})->name('admin.studentsManagement')->middleware('role:admin');

Route::get('/supervisorsManagement',function (){
    return view('admin.supervisorsManagement');
})->name('admin.supervisorsManagement')->middleware('role:admin');

Route::get('/companiesManagement',function (){
    return view('admin.companiesManagement');
})->name('admin.companiesManagement')->middleware('role:admin');

Route::get('/opportunitiesManagement',function (){
    return view('admin.opportunitiesManagement');
})->name('admin.opportunitiesManagement')->middleware('role:admin');

Route::get('/audienceManagement',function (){
    return view('admin.audienceManagement');
})->name('admin.audienceManagement')->middleware('role:admin');

Route::get('/studentsRate',function (){
    return view('admin.studentsRate');
})->name('admin.studentsRate')->middleware('role:admin');

Route::get('/trainingRequests',function (){
    return view('admin.trainingRequests');
})->name('admin.trainingRequests')->middleware('role:admin');

Route::get('/trainingBooks',function (){
    return view('admin.trainingBooks');
})->name('admin.trainingBooks')->middleware('role:admin');

Route::get('/studentsData',function (){
    return view('admin.studentsData');
})->name('admin.studentsData')->middleware('role:admin');

###############################################################################################################3

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
