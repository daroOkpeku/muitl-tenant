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
Route::get("/approve", [adminController::class, 'approve'])->name('approve');

Route::get("/create_blog", [adminController::class, 'create_blog'])->name('create_blog');
Route::post("/create_blog_send", [adminController::class, 'create_blog_send'])->name('create_blog_send');
Route::get('/list', [adminController::class, 'list'])->name('list');
Route::get('/del_list', [adminController::class, 'del_list'])->name('del_list');
Route::get('edit_blog/{id}', [adminController::class, 'edit_blog'])->name('edit_blog');
Route::put('create_blog_edit/{id}', [adminController::class, 'create_blog_edit'])->name('create_blog_edit');
});
