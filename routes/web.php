<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\admin\AdminController;
use App\Http\Controllers\admin\DashboardController;
 use App\Http\Controllers\admin\CategoryController;
use App\Http\Controllers\admin\OrderController;
use App\Http\Controllers\admin\SettingController;
use App\Http\Controllers\admin\ProductBookingController;


Route::group(['prefix'=>'admin',
'middleware' => 'admin'], function(){  
   
  Route::get('/login', [AdminController::class, 'login']); 
  Route::get('/logout', [AdminController::class, 'logout']);   
  
    Route::get('/dashboard', [DashboardController::class, 'index']); 
    // Route::get('/order', [OrderController::class, 'index']);
    // Route::post('/order', [OrderController::class, 'store']);
    // Route::get('/order/create', [OrderController::class, 'create']);
    // Route::get('/order/{id}/edit', [OrderController::class, 'edit']); 

    Route::get('/order/invoiceList', [OrderController::class, 'invoiceList']);
    Route::get('/order/order_status', [OrderController::class, 'order_status']);
    Route::post('/order/newProductSelectionChange', [OrderController::class, 'newProductSelectionChange']); 
    Route::post('/order/newProductEditSelectionChange', [OrderController::class, 'newProductEditSelectionChange']); 
    Route::post('/order/newProductUpdateChange', [OrderController::class, 'newProductUpdateChange']); 
    Route::post('/order/ProductUpdateChangeOfNewOrder', [OrderController::class, 'ProductUpdateChangeOfNewOrder']); 

    Route::post('/order/{id}', [OrderController::class, 'update']); 
    Route::get('/convertOrder', [OrderController::class, 'convertOrder']); 
    Route::get('/order/editHistory/{id}', [OrderController::class, 'editHistory']); 
    Route::get('/product/report', [OrderController::class, 'productReport']); 
    Route::get('/single_order_invoice/{id}', [OrderController::class, 'single_order_invoice']); 
    Route::get('/orderStatus/report', [OrderController::class, 'orderStatusReport']);
    Route::post('/storeInvoice', [OrderController::class, 'storeInvoice']);
    Route::get('/currentMonthStaffReport', [OrderController::class, 'currentMonthStaffReport']);
    Route::get('/order/getTotalProductsReport', [OrderController::class, 'getTotalProductsReport']);
    Route::get('getAllOrderTrackHistory', [OrderController::class, 'getAllOrderTrackHistory']);   
    Route::get('storeOrderEditHistory', [OrderController::class, 'storeOrderEditHistory']);   
    Route::get('getAllProductsForOrder', [OrderController::class, 'getAllProductsForOrder']);   
    Route::get('getOrderMeta', [OrderController::class, 'getOrderMeta']);   
    Route::get('getCityByCourierId', [OrderController::class,'getCityByCourierId']);
    Route::get('getZoneByCityId', [OrderController::class, 'getZoneByCityId']);   

    Route::post('/orderExchange', [OrderController::class, 'orderExchange']);
    Route::get('/order/pagination', [OrderController::class, 'pagination']); 
     Route::get('/order/searchOrderOfRedexCourier', [OrderController::class, 'searchOrderOfRedexCourier']);  
     Route::get('/order/orderUpdateByOrderStatus', [OrderController::class, 'orderUpdateByOrderStatus']);  
    Route::get('/order/getSinglePercel', [OrderController::class, 'getSinglePercel']); 
    
//    start  product booking route 
Route::get('/productBookingToRedex', [ProductBookingController::class, 'productBookingToRedex']);
Route::post('/productBookingToRedex', [ProductBookingController::class, 'sendProductToRedex']);

Route::get('/productBookingToSteadFast', [ProductBookingController::class, 'productBookingToSteadFast']);
Route::post('/productBookingToSteadFast', [ProductBookingController::class, 'sendProductToSteaddFast']);


//    end    product booking route

    
    Route::get('/setting', [SettingController::class,'setting']);  
    Route::post('/setting', [SettingController::class,'setting']);
    Route::get('excelExport', [OrderController::class,'excelExport']);
    Route::resource('order', OrderController::class);

     
});

Route::get('/', [AdminController::class, 'login']);
Route::get('/login', [AdminController::class, 'login']);
Route::post('/login', [AdminController::class, 'LoginCheck']);
Route::get('/admin/cache-clean',
    function() {
        Cache::flush();
        Artisan::call('cache:clear');
        Artisan::call('view:clear');
        return view('admin.setting.cache');
    }
);

Route::get('/{id}', [AdminController::class,'login']);
