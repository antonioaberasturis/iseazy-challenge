<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Application\Api\Shop\ShopPutController;
use Application\Api\Shop\ShopPostController;
use Application\Api\Shop\ShopsGetController;

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
/*
Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
*/

Route::prefix('shops')->group(function(){
    Route::get('/', [ShopsGetController::class, '__invoke']);
    Route::post('/', [ShopPostController::class, '__invoke']);
    Route::put('/{id}', [ShopPutController::class, '__invoke'])->whereUuid('id');
});