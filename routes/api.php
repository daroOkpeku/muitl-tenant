<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Models\Tenant;
use App\Http\Controllers\UserAuthController;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

// Route::get("test", function () {
//     $tenant = new Tenant();
//     $tenant->id = 1;
//     $tenant->name = 'user';
//     $tenant->domain = request()->root();
//     $tenant->save();
  
// });

Route::middleware('tenant')->group(function () {
   
    Route::post('register', [UserAuthController::class, 'register']);

    Route::post('login', [UserAuthController::class, 'login']);

    Route::middleware('auth:api')->group(function () {
    Route::get('blog_list', [UserAuthController::class, 'list']);
    });

});


Route::middleware('admin_tenant')->group(function () {
    Route::post('create_tenant', [UserAuthController::class, 'create_tenant']);
});


