<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Admin\LogoutController;


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

/* Public routes */
Route::get('/', function () {
    return view('welcome');
});
/* Public routes */

/* Breeze frontend dashboard */
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

/* Breeze frontend dashboard  routes*/
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});
/* Breeze frontend dashboard  routes*/

/* Filamen backend logout */
Route::prefix('admin')->group(function(){
    Route::post('/logout',LogoutController::class)->name('filament.auth.logout');

});
/* Filamen backend logout */

/* Breeze routes*/
require __DIR__.'/auth.php';
/* Breeze routes*/
