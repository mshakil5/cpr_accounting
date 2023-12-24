<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\AccountController;
use App\Http\Controllers\Admin\ClientController;
use App\Http\Controllers\Admin\TicketSaleController;
use App\Http\Controllers\Admin\RoomRentController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\SalesController;
use App\Http\Controllers\Admin\ChartOfAccountController;


/*------------------------------------------
--------------------------------------------
All Admin Routes List
--------------------------------------------
--------------------------------------------*/
Route::group(['prefix' =>'admin/', 'middleware' => ['auth', 'is_admin']], function(){
  
    Route::get('/dashboard', [HomeController::class, 'adminHome'])->name('admin.dashboard');
    //profile
    Route::get('/profile', [AdminController::class, 'profile'])->name('profile');
    Route::put('profile/{id}', [AdminController::class, 'adminProfileUpdate']);
    Route::post('changepassword', [AdminController::class, 'changeAdminPassword']);
    Route::put('image/{id}', [AdminController::class, 'adminImageUpload']);
    //profile end

    Route::get('/new-admin', [AdminController::class, 'getAdmin'])->name('alladmin');
    Route::post('/new-admin', [AdminController::class, 'adminStore']);
    Route::get('/new-admin/{id}/edit', [AdminController::class, 'adminEdit']);
    Route::post('/new-admin-update', [AdminController::class, 'adminUpdate']);
    Route::get('/new-admin/{id}', [AdminController::class, 'adminDelete']);

    
    Route::get('/account', [AccountController::class, 'index'])->name('admin.account');
    Route::post('/account', [AccountController::class, 'store']);
    Route::get('/account/{id}/edit', [AccountController::class, 'edit']);
    Route::post('/account-update', [AccountController::class, 'update']);
    Route::get('/account/{id}', [AccountController::class, 'delete']);

    
    Route::get('/client', [ClientController::class, 'index'])->name('admin.client');
    Route::post('/client', [ClientController::class, 'store']);
    Route::get('/client/{id}/edit', [ClientController::class, 'edit']);
    Route::post('/client-update', [ClientController::class, 'update']);
    Route::get('/client/{id}', [ClientController::class, 'delete']);


    // ticket sales 
    Route::get('/ticket-sale', [TicketSaleController::class, 'index'])->name('admin.ticketsale');
    Route::post('/ticket-sale', [TicketSaleController::class, 'store']);
    Route::get('/ticket-sale/{id}/edit', [TicketSaleController::class, 'edit']);
    Route::post('/ticket-sale-update', [TicketSaleController::class, 'update']);

    // room rent 
    Route::get('/room-rent', [RoomRentController::class, 'index'])->name('admin.roomrent');
    Route::post('/room-rent', [RoomRentController::class, 'store']);
    Route::get('/room-rent/{id}/edit', [RoomRentController::class, 'edit']);
    Route::post('/room-rent-update', [RoomRentController::class, 'update']);

    // product 
    Route::get('/product', [ProductController::class, 'index'])->name('admin.product');
    Route::post('/product', [ProductController::class, 'store']);
    Route::get('/product/{id}/edit', [ProductController::class, 'edit']);
    Route::post('/product-update', [ProductController::class, 'update']);
    Route::get('/product/{id}', [ProductController::class, 'delete']);

    
    // sales 
    Route::get('/sales', [SalesController::class, 'index'])->name('admin.sales');
    Route::post('/sales', [SalesController::class, 'store']);
    Route::get('/sales/{id}/edit', [SalesController::class, 'edit'])->name('admin.salesEdit');
    Route::post('/sales-update', [SalesController::class, 'update']);
    Route::get('/sales/{id}', [SalesController::class, 'delete']);
    
    Route::post('getproduct', [SalesController::class, 'getproduct']);

    
    Route::post('getchartofaccount', [ChartOfAccountController::class, 'getaccounthead']);
    Route::get('/chart-of-account', [ChartOfAccountController::class, 'index'])->name('admin.coa');
    Route::post('/chart-of-account', [ChartOfAccountController::class, 'store']);
    Route::get('/chart-of-account/{id}/edit', [ChartOfAccountController::class, 'edit']);
    Route::post('/chart-of-account-update', [ChartOfAccountController::class, 'update']);
    Route::get('/chart-of-account/{id}', [ChartOfAccountController::class, 'delete']);

});
  