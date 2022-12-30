<?php

use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Session;
use App\Http\Controllers\RouterController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Owner\OwnerController;
use App\Http\Controllers\Owner\ProductController;
use App\Http\Controllers\Owner\SallaryController;
use App\Http\Controllers\Owner\ServiceController;
use App\Http\Controllers\Owner\CategoryController;
use App\Http\Controllers\Owner\PositionController;
use App\Http\Controllers\Employee\EmployeeController;
use App\Http\Controllers\Owner\UserManagementController;

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
    // return view('welcome');
    return redirect()->route('login');
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

        // Route Users Position
        Route::get('/check-positions/slug', [PositionController::class, 'checkSlug'])->name('owner.check.positions');
        Route::delete('/positionst-deleteAll', [PositionController::class, 'deleteAll'])->name('owner.position.deleteAll');
        Route::resource('/positions', PositionController::class)->except(['create', 'edit']);

        // Route Users Management
        Route::resource('/users', UserManagementController::class)->except(['create', 'edit']);
        Route::delete('/users-management-deleteAll', [UserManagementController::class, 'deleteAll'])->name('owner.users.deleteAll');

        // Route Category Product
        Route::get('/check-category/slug', [CategoryController::class, 'checkSlug'])->name('owner.check.category');
        Route::delete('/check-category-deleteAll', [CategoryController::class, 'deleteAll'])->name('owner.category.deleteAll');
        Route::resource('/categories', CategoryController::class)->except(['show', 'create', 'edit']);

        // Route Service Management
        Route::resource('/services', ServiceController::class)->except(['create', 'edit']);
        Route::delete('/services-management-deleteAll', [ServiceController::class, 'deleteAll'])->name('owner.service.deleteAll');

        // Route Product Management
        Route::resource('/products', ProductController::class)->except(['create', 'edit']);
        Route::delete('/products-management-deleteAll', [ProductController::class, 'deleteAll'])->name('owner.product.deleteAll');

        // Route Sallary
        Route::resource('/sallaries', SallaryController::class)->names([
            'index' => 'owner.sallary.index',
            'create' => 'owner.sallary.create',
            'store' => 'owner.sallary.store',
            'destroy' => 'owner.sallary.destroy',
            'show' => 'owner.sallary.show',
        ])->except(['edit', 'update']);
        Route::get('/sallary-print', [SallaryController::class, 'print'])->name('owner.sallary.print');
        Route::delete('/sallary-management-deleteAll', [SallaryController::class, 'deleteAll'])->name('owner.sallary.deleteAll');
        // Route::get('/sallaries/create/{id_user}/{periode}', [SallaryController::class, 'create'])->name('owner.sallary.create');
    });


    Route::group(['prefix' => 'employee', 'middleware' => 'isEmployee'], function () {
        Route::get('/dashboard', [EmployeeController::class, 'index'])->name('employee.dashboard');

        Route::get('/history', [EmployeeController::class, 'history'])->name('employee.history');


        Route::get('/profile', [ProfileController::class, 'edit'])->name('employee.profile.edit');
    });

    Route::post('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::post('/change-password', [ProfileController::class, 'changePassword'])->name('profile.changePassword');
    Route::post('/change-profile-picture', [ProfileController::class, 'updatePicture'])->name('profile.pictureUpdate');
    Route::post('/profile-delete-picture', [ProfileController::class, 'deletePicture'])->name('profile.deletePicture');
});

require __DIR__ . '/auth.php';
