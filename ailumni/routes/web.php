<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\IndexController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Alumni\UpdateAlumniProfileInformation;
use App\Http\Controllers\Admin\DashboardController;
use App\Actions\Fortify\UpdateUserProfileInformation;
use App\Http\Controllers\Alumni\AlumniController;


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

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
});

route::get('/home', [IndexController::class,'index']);

Route::group(['middleware' => ['auth', 'admin'], 'prefix' => 'admin', 'as' => 'admin.'], function() {
    Route::resource('users', UserController::class);
});


Route::middleware(['auth', 'alumni'])->group(function () {
    Route::get('/alumni/profile', [UpdateAlumniProfileInformation::class, 'index'])->name('alumni.profile.show');
});

Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

Route::get('/alumni', [AlumniController::class, 'index'])->name('alumni.profile.index');
Route::get('/alumni/{user}', [AlumniController::class, 'show'])->name('alumni.profile.index');
Route::get('/alumni/create', [AlumniController::class, 'create'])->name('alumni.profile.index');
Route::post('/alumni', [AlumniController::class, 'store'])->name('alumni.profile.index');