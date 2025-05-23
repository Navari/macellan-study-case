<?php

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

Route::post('/get-price', '\Modules\Location\Controllers\PriceServiceController');
Route::post('/callback', '\Modules\Location\Controllers\CallbackServiceController');

Route::get('test', function (\Modules\User\Repositories\UserRepositoryInterface $userRepository) {
    $userRepository->addAccess(1, 1);
    return $userRepository->getAccessCountByLocationId(1, 1);
});
Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
