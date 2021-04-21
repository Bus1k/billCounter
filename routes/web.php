<?php

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

Route::middleware('auth')->group(function(){
    Route::view('/dashboard', 'dashboard');

    //--------------------------------------------------BILLS------------------------------------------------------------------------//
    Route::get('/bills', [\App\Http\Controllers\BillsController::class, 'index'])->name('index_bill');
    Route::post('/bills', [\App\Http\Controllers\BillsController::class, 'store'])->name('store_bill');
    Route::post('/bills/ajax', [\App\Http\Controllers\BillsController::class, 'ajax'])->name('ajax_bill');
    Route::get('/bills/create', [\App\Http\Controllers\BillsController::class, 'create'])->name('create_bill');

    Route::get('/bills/{bill}', [\App\Http\Controllers\BillsController::class, 'show']);
    Route::post('/bills/{bill}', [\App\Http\Controllers\BillsController::class, 'update'])->name('update_bill');
    Route::get('/bills/{bill}/edit', [\App\Http\Controllers\BillsController::class, 'edit'])->name('edit_bill');

    Route::get('/bills/{bill}/delete', [\App\Http\Controllers\BillsController::class, 'destroy'])->name('delete_bill');

    //--------------------------------------------------SETTINGS---------------------------------------------------------------------//
    Route::get('/settings', [\App\Http\Controllers\SettingsController::class, 'index'])->name('index_settings');
    Route::post('/settings', [\App\Http\Controllers\SettingsController::class, 'store'])->name('store_settings');

    //--------------------------------------------------CATEGORIES------------------------------------------------------------------//
    Route::get('/categories', [\App\Http\Controllers\CategoriesController::class, 'index'])->name('index_categories');

});

