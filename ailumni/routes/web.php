<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\IndexController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Alumni\UpdateAlumniProfileInformation;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Alumni\AlumniController;
use App\Http\Controllers\ThreadController;
use App\Http\Controllers\NewsPostController;
use App\Http\Controllers\ChatbotController;

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

    Route::group(['middleware' => 'admin'], function () {
        Route::get('/news', [NewsPostController::class, 'index'])->name('news.index');
        Route::get('/news/create', [NewsPostController::class, 'create'])->name('news.create');
        Route::post('/news', [NewsPostController::class, 'store'])->name('news.store');
        Route::delete('/news/{post}', [NewsPostController::class, 'destroy'])->name('news.destroy');
    });
});

route::get('/home', [IndexController::class,'index']);

Route::group(['middleware' => ['auth', 'admin'], 'prefix' => 'admin', 'as' => 'admin.'], function() {
    Route::resource('users', UserController::class);
});


Route::middleware(['auth', 'alumni'])->group(function () {
    Route::get('/alumni/profile', [UpdateAlumniProfileInformation::class, 'index'])->name('alumni.profile.show');
});

Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

Route::middleware(['auth'])->group(function () {
    Route::get('/threads', [ThreadController::class, 'index'])->name('threads.index');
    Route::get('/threads/{thread}', [ThreadController::class, 'show'])->name('threads.show');
    Route::get('/threads/{thread}/reaction-status', [ThreadController::class, 'getReactionStatus']);
    Route::post('/threads', [ThreadController::class, 'store'])->name('threads.store');
    Route::post('/threads/{thread}/comments', [ThreadController::class, 'storeComment'])->name('threads.comments.store');
    Route::post('/threads/{thread}/react', [ThreadController::class, 'react'])->name('threads.react');
});

Route::middleware(['auth'])->group(function () {
    Route::post('/chatbot', [ChatbotController::class, 'chat']);
});

Route::get('/contact-directory', function () {
    return view('contact-directory');
})->name('contact-directory');

Route::get('/about-us', function () {
    return view('about-us');
})->name('about-us');

Route::get('/alumni', [AlumniController::class, 'index'])->name('alumni.index');
Route::get('/alumni/{alumnus}', [AlumniController::class, 'show'])->name('alumni.show');
Route::get('/alumni/{alumnus}/edit', [AlumniController::class, 'edit'])->name('alumni.edit');
Route::put('/alumni/{alumnus}', [AlumniController::class, 'update'])->name('alumni.update');
Route::delete('/alumni/{alumnus}', [AlumniController::class, 'destroy'])->name('alumni.destroy');