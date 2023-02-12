<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Application\Api\Shop\ShopPutController;
use Application\Api\Shop\ShopPostController;
use Application\Api\Shop\ShopsGetController;
use Application\Api\Shop\ShopDeleteController;
use Application\Api\Shop\ShopDetailsGetController;
use Application\Api\Product\ProductsPostController;
use Application\Api\Product\ProductBuyGetController;

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
    Route::delete('/{id}', [ShopDeleteController::class, '__invoke'])->whereUuid('id');
    Route::get('/{id}/details', [ShopDetailsGetController::class, '__invoke'])->whereUuid('id');
    Route::post('/{id}/products', [ProductsPostController::class, '__invoke'])->whereUuid('id');
    Route::get('/{shopId}/products/{productId}/buy', [ProductBuyGetController::class, '__invoke'])->whereUuid('shopId')->whereUuid('productId');
});