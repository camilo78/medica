<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\HomeController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProductController;

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
    return view('welcome');
});

Auth::routes();

Route::get('/home', [HomeController::class, 'index'])->name('home');

Route::group(['middleware' => ['auth']], function () {
    Route::resource('roles', RoleController::class, ['except' => ['destroy']]);
    Route::delete('roles', [RoleController::class, 'destroy'])->name('roles.destroy');
    Route::resource('users', UserController::class, ['except' => ['destroy']]);
    Route::delete('users', [UserController::class, 'destroy'])->name('users.destroy');
    Route::post('/user/search', [UserController::class, 'search'])->name('users.search');
    Route::post('/getCountries', [UserController::class, 'getCountries'])->name('countries');
    Route::post('/getStates/{id}', [UserController::class, 'getStates'])->name('states');;
    Route::post('/getCities/{id}', [UserController::class, 'getCities'])->name('cities');;
});
