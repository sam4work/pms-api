<?php

use App\Http\Controllers\CustomerController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware(['auth:sanctum'])->get('/user', function (Request $request) {
    return $request->user();
});


Route::middleware(['auth:sanctum'])->group(function(){

//    DISPLAY ALL CUSTOMERS
    Route::get("/customers", [CustomerController::class, "index"]);

//    DISPLAY STATS ALL CUSTOMERS
    Route::get("/customers/stats", [CustomerController::class, "stats"]);

//    CREATE NEW CUSTOMER RECORD
    Route::post("/customers", [CustomerController::class, "store"]);

//    DISPLAY A SINGLE CUSTOMER RECORD
    Route::get("/customers/{customer}", [CustomerController::class, "show"]);

//    PARTIAL UPDATE OF CUSTOMER RECORDS
    Route::patch("/customers/{customer}/update", [CustomerController::class, "update"]);

//    DELETE CUSTOMER RECORDS - THIS WILL HIDE UNTIL FURTHER NEED
    Route::delete("/customers/{customer}/destroy", [CustomerController::class, "destroy"]);
});