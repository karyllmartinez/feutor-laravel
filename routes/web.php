<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TutorAuthController;
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

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');



/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/
Route::get('tdashboard', [TutorAuthController::class, 'tdashboard'])->name('tdashboard');
Route::get('tlogin', [TutorAuthController::class, 'tindex'])->name('tlogin');
Route::post('tcustom-login', [TutorAuthController::class, 'tcustomLogin'])->name('tlogin.custom');
Route::get('tregister', [TutorAuthController::class, 'tregistration'])->name('tregister');
Route::post('tcustom-registration', [TutorAuthController::class, 'tcustomRegistration'])->name('tregister.custom');

if (Auth::guard('tutors')->attempt([
    'temail' => request('temail'),
    'password' => request('password'),
])) {
    // Get the authenticated tutor
    $tutor = Auth::guard('tutors')->user();

    // Redirect the tutor to a protected page
    return redirect('/tutors/dashboard');
} else {
    // Authentication failed
    return back()->withErrors(['temail' => 'Invalid email or password']);
}
