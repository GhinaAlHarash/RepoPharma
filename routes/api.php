<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
Route::post('/register',[\App\Http\Controllers\AuthUserController::class,'register']);
Route::post('/login',[\App\Http\Controllers\AuthUserController::class,'login']);
Route::get('/show_user_info/{id}',[\App\Http\Controllers\AuthUserController::class,'show_user_info']);

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/logout',[\App\Http\Controllers\AuthUserController::class,'logout']);

    //medicine
    Route::post('/add_classification',[\App\Http\Controllers\MedicineController::class,'add_classification']);
    Route::post('/update_medicine/{id}',[\App\Http\Controllers\MedicineController::class,'update_medicine']);
    Route::post('/add_medicine',[\App\Http\Controllers\MedicineController::class,'add_medicine']);
    Route::get('/show_medicines/{classification_id}',[\App\Http\Controllers\MedicineController::class,'show_medicines']);
    Route::get('/show_classifications',[\App\Http\Controllers\MedicineController::class,'show_classifications']);
   // Route::post('/show_medicines_classification',[\App\Http\Controllers\MedicineController::class,'show_medicines_classification']);
    Route::post('/show_medicine_info/{id}',[\App\Http\Controllers\MedicineController::class,'show_medicine_info']);
    Route::post('/search_medicine',[\App\Http\Controllers\MedicineController::class,'search_medicine']);




    //favorite
    Route::post('/add_to_favorite/{id}',[\App\Http\Controllers\FavoriteController::class,'add_to_favorite']);
    Route::post('/remove_from_favorite/{id}',[\App\Http\Controllers\FavoriteController::class,'remove_from_favorite']);
    Route::get('/show_favorite',[\App\Http\Controllers\FavoriteController::class,'show_favorite']);
});


Route::controller(\App\Http\Controllers\OrderesController::class)->group(function (){
    Route::post('order/create','new_order');
    Route::get('orders/show/{id}','show_orders');
    Route::get('order/info/{id}','show_order_info');
    Route::post('order/paymentStatus/{id}','change_payment_status');
    Route::post('order/orderStatus/{id}','change_order_status');
});

