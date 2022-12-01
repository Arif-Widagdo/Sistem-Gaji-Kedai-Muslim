<?php

use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Session;
use App\Http\Controllers\RouterController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Owner\OwnerController;
use App\Http\Controllers\Employee\EmployeeController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

if (!App::isLocale('id') && !App::isLocale('en')) {
    App::setLocale('en');
}
Route::get('/locale/{locales}', function ($locale) {
    Session::put('locale', $locale);
    return redirect()->back();
});

Route::get('/', function () {
    return view('welcome');
});

// Route::get('/dashboard', function () {
//     return view('dashboard');
// })->middleware(['auth', 'verified'])->name('dashboard');

// Route::middleware('auth')->group(function () {
//     Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
//     Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
//     Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
// });


Route::group(['middleware' => ['auth', 'verified']], function () {
    Route::get('/dashboard', [RouterController::class, 'dashboard'])->name('dashboard');
    Route::get('/profile', [RouterController::class, 'profile'])->name('profile.edit');

    Route::group(['prefix' => 'owner', 'middleware' => 'isOwner'], function () {
        Route::get('/dashboard', [OwnerController::class, 'index'])->name('owner.dashboard');
        Route::get('/profile', [ProfileController::class, 'edit'])->name('owner.profile.edit');
    });


    Route::group(['prefix' => 'employee', 'middleware' => 'isEmployee'], function () {
        Route::get('/dashboard', [EmployeeController::class, 'index'])->name('employee.dashboard');
        Route::get('/profile', [ProfileController::class, 'edit'])->name('employee.profile.edit');
    });

    Route::post('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::post('/change-password', [ProfileController::class, 'changePassword'])->name('profile.changePassword');
    Route::post('/change-profile-picture', [ProfileController::class, 'updatePicture'])->name('profile.pictureUpdate');
    Route::post('/profile-delete-picture', [ProfileController::class, 'deletePicture'])->name('profile.deletePicture');
});

require __DIR__ . '/auth.php';