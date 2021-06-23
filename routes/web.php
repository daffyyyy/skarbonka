<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\AnnouncementController;

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
// Strona główna
Route::get('/', function () {
    return view('index');
})->name('home');

// Autoryzacja
Auth::routes(['verify' => true]);

// Lista ogłoszeń, bez middleware, aby goście mogli zobaczyć
Route::get('ogloszenia', [AnnouncementController::class, 'index'])->name('announcement.index');

// Wyświetlanie kartegorii, bez middleware, aby goście mogli zobaczyć
Route::get('kategoria/{category}', [CategoryController::class, 'show'])->name('category.show');

// Wszystko co potrzebuje zalogowania i weryfikacji
Route::middleware(['auth', 'verified'])->group(function () {
    // Użytkownicy
    Route::resource('uzytkownik', UserController::class, ['parameters' => ['uzytkownik' => 'user'], 'except' => ['hide', 'destroy']]);
    Route::get('uzytkownik/{user}/addReputation', [UserController::class, 'addReputation'])->name('uzytkownik.addReputation');
    Route::post('uzytkownik/updateContact', [UserController::class, 'updateContact'])->name('uzytkownik.updateContact');

    // Ogłoszenia
    Route::get('ogloszenie/dodaj', [AnnouncementController::class, 'create'])->name('announcement.create');
    Route::post('ogloszenie/store', [AnnouncementController::class, 'store'])->name('announcement.store');
    Route::put('ogloszenie/{announcement}/put', [AnnouncementController::class, 'put'])->name('announcement.put');
    Route::delete('ogloszenie/{announcement}', [AnnouncementController::class, 'destroy'])->name('announcement.destroy');
    Route::get('ogloszenie/{announcement}', [AnnouncementController::class, 'show'])->name('announcement.show');
});

// Wszystko co potrzebuje admin
route::middleware(['auth', 'admin'])->group(function () {
    // Użytkownicy
    Route::delete('uzytkownik/{user}/destroy', [UserController::class, 'destroy'])->name('uzytkownik.destroy');
    Route::post('uzytkownik/{user}/hide', [UserController::class, 'hideAnnouncements'])->name('uzytkownik.hide');
    Route::post('uzytkownik/{user}/scammer', [UserController::class, 'markAsScammer'])->name('uzytkownik.scammer');
    Route::post('uzytkownik/{user}/vip', [UserController::class, 'setAsVip'])->name('uzytkownik.vip');

    // Kategorie
    Route::get('admin/kategoria', [CategoryController::class, 'adminIndex'])->name('admin.category.index');
    Route::post('admin/kategoria/store', [CategoryController::class, 'store'])->name('admin.category.store');
    Route::delete('admin/kategoria/{category}/destroy', [CategoryController::class, 'destroy'])->name('admin.category.destroy');
    Route::put('admin/kategoria/{category}/put', [CategoryController::class, 'put'])->name('admin.category.put');
});
