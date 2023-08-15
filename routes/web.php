<?php

use App\Http\Controllers\OfferController;
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
    return redirect()->route('home');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::middleware(['check.token.expiration'])->prefix('offers')->group(function () {
    Route::get('/', [OfferController::class, 'index'])->name('offers.offers_list');
    Route::get('/get-create', [OfferController::class, 'getCreate'])->name('offers.get.create');
    Route::post('/create', [OfferController::class, 'createOffer'])->name('offers.create');
    Route::get('/details/{id}',  [OfferController::class, 'getDetails'])->name('offers.details');
    Route::get('/get-update/{id}', [OfferController::class, 'getUpdate'])->name('offers.get.update');
    Route::post('/update/{id}', [OfferController::class, 'updateOffer'])->name('offers.update');
    Route::post('/delete/{id}', [OfferController::class, 'deleteOffer'])->name('offers.delete');
});


