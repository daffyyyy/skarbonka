<?php

use App\Http\Controllers\AnnouncementController;
use App\Http\Controllers\CategoryController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

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

Route::get('/', function () {
    return view('index');
})->name('home');

Auth::routes();

Route::get('ogloszenie', [AnnouncementController::class, 'index'])->name('ogloszenie.index');

Route::middleware('auth')->group(function () {
    Route::resource('ogloszenie', AnnouncementController::class, ['except' => [
        'show', 'destroy', 'index'
    ]]);
    Route::delete('ogloszenie/{announcement}', [AnnouncementController::class, 'destroy'])->name('ogloszenie.destroy');
    Route::get('ogloszenie/{announcement}', [AnnouncementController::class, 'show'])->name('ogloszenie.show');

    Route::get('category/{category}', [AnnouncementController::class, 'category'])->name('category');
});

Route::prefix('category')->as('category.')->group(function () {
    Route::get('{category}', [CategoryController::class, 'show'])->name('show');
});


