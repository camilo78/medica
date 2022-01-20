<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\PatientController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ImpersonateController;
use App\Http\Controllers\edit;
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
    return view('welcome');
});

Auth::routes();



Route::group(['middleware' => ['auth']], function () {
    Route::get('/home', [HomeController::class, 'index'])->name('home')->middleware(['role:Admin|Médico']);
    // Rutas del modulo Roles
    Route::resource('roles', RoleController::class, ['except' => ['destroy']])->middleware(['role:Admin']);;
    Route::delete('roles', [RoleController::class, 'destroy'])->name('roles.destroy')->middleware(['role:Admin']);
    // Rutas del modulo de Usuarios
    Route::resource('users', UserController::class, ['except' => ['destroy']]);
    Route::delete('users', [UserController::class, 'destroy'])->name('users.destroy');
    Route::post('/user/search', [UserController::class, 'search'])->name('users.search');
    Route::get('/user/trash', [UserController::class, 'trash'])->name('users.trash');
    Route::post('/user/restore', [UserController::class, 'restore'])->name('users.restore');
    Route::post('/getCountries', [UserController::class, 'getCountries'])->name('countries');
    Route::post('/getStates/{id}', [UserController::class, 'getStates'])->name('states');
    Route::post('/getCities/{id}', [UserController::class, 'getCities'])->name('cities');
    // Rutas del modulo de Configuración
    Route::resource('settings', SettingController::class, ['except' => ['destroy']]);
    // Rutas Pacientes
    // Route::get('/patient', [PatientController::class, 'patient'])->name('patient.dashboard');
    // Rutas Ajustes
    Route::get('settings', [SettingController::class, 'index'])->name('settings.index');
    Route::post('settings/create', [SettingController::class, 'create'])->name('settings.create');
    Route::put('settings/{setting}', [SettingController::class, 'update'])->name('settings.update');
    Route::get('settings/{setting}/edit', [SettingController::class, 'edit'])->name('settings.edit');
    Route::post('settings/store', [SettingController::class, 'store'])->name('settings.store');
    Route::delete('settings/{setting}', [SettingController::class, 'destroy'])->name('settings.destroy');
    // Ruta Impersonate
    Route::post('/impersonate/{user}/start', [ImpersonateController::class, 'start'])->name('impersonate.start');
    Route::get('/impersonate/stop', [ImpersonateController::class, 'stop'])->name('impersonate.stop');

});
