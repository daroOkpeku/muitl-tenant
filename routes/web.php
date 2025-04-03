<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\adminController;
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

// Route::get('/', function () {
//     return view('welcome');
// });


Route::middleware('admin_tenant')->group(function () {
Route::get('/', [adminController::class, 'login_view']);
Route::post('/login', [adminController::class, 'login'])->name('login');
Route::get("/dashboard", [adminController::class, 'dashboard'])->name('dashboard');
});
