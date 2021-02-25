<?php

use App\Http\Controllers\Api\RealStateSearchController;
use App\Http\Controllers\Api\Auth\LoginJwtController;
use App\Http\Controllers\Api\RealStatePhotoController;
use App\Http\Controllers\Api\CategoryController;
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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::prefix('v1')->group(function(){

    Route::post('login', [LoginJwtController::class, 'login']);
    Route::get('logout', [LoginJwtController::class, 'logout']);
    Route::get('refresh', [LoginJwtController::class, 'refresh']);

    Route::get('/search', [RealStateSearchController::class, 'index']);

    Route::group(['middleware' => ['jwt.auth']], function () {
        
        Route::name('real_states.')->group(function(){

            Route::resource('real-states', 'App\Http\Controllers\Api\RealStateController');
    
        });
    
        Route::name('users.')->group(function(){
    
            Route::resource('users', 'App\Http\Controllers\Api\UserController');
    
        });
    
        Route::name('categories.')->group(function(){
    
            Route::get('categories/{id}/real-states', [CategoryController::class, 'realState']);
            Route::resource('categories', 'App\Http\Controllers\Api\CategoryController');
    
        });
    
        Route::name('photos.')->prefix('photos')->group(function(){
    
            Route::put('/set-thumb/{photoId}/{realStateId}', [RealStatePhotoController::class, 'setThumb']);
            Route::delete('/{id}', [RealStatePhotoController::class, 'remove']);
    
        });

    });

});
