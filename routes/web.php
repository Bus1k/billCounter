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

    Route::get('/bills', [\App\Http\Controllers\BillsController::class, 'index'])->name('index_bill');
    Route::post('/bills', [\App\Http\Controllers\BillsController::class, 'store'])->name('store_bill');
    Route::post('/bills/ajax', [\App\Http\Controllers\BillsController::class, 'ajax'])->name('ajax_bill');
    Route::get('/bills/create', [\App\Http\Controllers\BillsController::class, 'create'])->name('create_bill');
    Route::get('/bills/{bill}', [\App\Http\Controllers\BillsController::class, 'show']);

    Route::get('/bills/{bill}/edit', [\App\Http\Controllers\BillsController::class, 'edit'])->name('edit_bill');
    Route::put('/bills/{bill}', [\App\Http\Controllers\BillsController::class, 'update'])->name('update_bill');

    Route::get('/bills/{bill}/delete', [\App\Http\Controllers\BillsController::class, 'destroy'])->name('delete_bill');
});

