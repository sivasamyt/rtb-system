<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdSlotController;
use App\Http\Controllers\BidController;

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

Route::post('/login', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/slots', [AdSlotController::class, 'index']);
    Route::post('/slots/{id}/bid', [BidController::class, 'placeBid']);
    Route::get('/slots/{id}/bids', [BidController::class, 'viewBids']);
    Route::get('/slots/{id}/winner', [BidController::class, 'viewWinner']);
    Route::get('/user/bids', [BidController::class, 'userBids']);
    Route::post('/slots', [AdSlotController::class, 'store'])->middleware('admin');
});