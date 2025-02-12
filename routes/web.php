<?php

use App\Http\Controllers\FactureClientController;
use App\Http\Controllers\LoginController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
*/

Route::redirect("/", "login");
Route::get('/login', [LoginController::class, 'showLogin'])->name('login-form');
Route::post('/login', [LoginController::class, 'login'])->name('login');

Route::group(['middleware' => ['auth']], function () {
    // vente module routes
    Route::resource('ventes', FactureClientController::class);
    Route::get('/logout', [LoginController::class, 'logout'])->name('logout');
});
