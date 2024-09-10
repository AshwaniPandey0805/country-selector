<?php

use App\Http\Controllers\admin\AdminController;
use App\Http\Controllers\admin\CityController;
use App\Http\Controllers\admin\CountryController;
use App\Http\Controllers\admin\StateController;
use App\Http\Controllers\auth\AuthController;
use Illuminate\Support\Facades\Route;

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

Route::get('/', function () {
    return view('welcome');
});


Route::get('/register',[AuthController::class, 'registerPage'])->name('register.page');   
Route::get('/login',[AuthController::class, 'loginPage'])->name('login.page');   
Route::get('/logout',[AuthController::class, 'logout'])->name('logout');   
Route::post('/register-process',[AuthController::class, 'registerProcess'])->name('register.process');
Route::post('/login-process',[AuthController::class, 'loginProcess'])->name('login.process');

Route::group(['middleware' => 'authCheck' ,'prefix' => 'admin'], function($routes){

    Route::get('/dashboard', [AdminController::class, 'index'])->name('admin.dashboard');

    // Country Routes
    Route::get('/country/create', [CountryController::class, 'create'])->name('country.create');
    Route::post('/country/store', [CountryController::class, 'store'])->name('country.store');
    Route::get('/country/{id}/edit', [CountryController::class, 'edit'])->name('country.edit');
    Route::post('/country/{id}/update', [CountryController::class, 'update'])->name('country.update');
    Route::any('/country/{id}/delete', [CountryController::class, 'delete'])->name('country.delete');
    
    // state Routes
    Route::get('/state/create', [StateController::class, 'create'])->name('state.create');
    Route::post('/state/store', [StateController::class, 'store'])->name('state.store');
    Route::get('/state/{id}/edit', [StateController::class, 'edit'])->name('state.edit');
    Route::post('/state/{id}/update', [StateController::class, 'update'])->name('state.update');
    Route::any('/state/{id}/delete', [StateController::class, 'delete'])->name('state.delete');
    
    // city Routes
    Route::get('/city/create', [CityController::class, 'create'])->name('city.create');
    Route::post('/city/store', [CityController::class, 'store'])->name('city.store');
    Route::get('/city/{id}/edit', [CityController::class, 'edit'])->name('city.edit');
    Route::post('/city/{id}/update', [CityController::class, 'update'])->name('city.update');
    Route::any('/city/{id}/delete', [CityController::class, 'delete'])->name('city.delete');

    Route::post('/get-states',[CityController::class, 'getstates'])->name('city.getStates');

});