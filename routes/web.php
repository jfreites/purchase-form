<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\PurchaseOrderController;

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

Route::get('/purchase-order/create', [PurchaseOrderController::class, 'create'])->name('purchase-order.create');
Route::post('/purchase-order/confirm', [PurchaseOrderController::class, 'confirmation'])->name('purchase-order.confirmation');
Route::post('/purchase-order/store', [PurchaseOrderController::class, 'store'])->name('purchase-order.store');
