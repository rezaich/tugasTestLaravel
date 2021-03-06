<?php

use App\Http\Controllers\api\v1\CartController;
use App\Http\Controllers\api\v1\CategoryController;
use App\Http\Controllers\API\V1\LoginController;
use App\Http\Controllers\api\v1\ProductController;
use App\Http\Controllers\api\v1\TransactionController;
use App\Http\Controllers\api\v1\UserController;
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

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::group(['prefix'=>'v1'],function(){
Route::post('/login',[LoginController::class,'login']);
Route::post('/register',[LoginController::class,'register']);

// Route::middleware('auth:api')->post('/logout',[LoginController::class,'logout']);

//authorization
Route::group(
    ['middleware'=>'auth:api'],
function(){

//Login Controller
Route::post('/logout',[LoginController::class,'logout']);

//Route for admin
Route::group([
    'middleware'=> 'is_admin',
    'as' => 'admin'
],function(){
    Route::get('/users',[
        App\http\Controllers\API\v1\admin\UserController::class
        ,
        'index'
    ]);
});

Route::group([
    'as' => 'user'
],function(){

});

//User Controller
Route::middleware('auth:api')->get('user',[UserController::class,'show']);
Route::middleware('auth:api')->post('/v1/user/store',[UserController::class,'store']);
Route::middleware('auth:api')->put('/v1/user/update',[UserController::class ,'update']);

//Category Controller
// Route::middleware('auth:api')->get('/v1/category',[CategoryController::class,'index']);

//CategoryController
Route::middleware('auth:api')->apiResource('/v1/category', CategoryController::class);

//Product Controller
Route::middleware('auth:api')->get('/v1/products',[ProductController::class,'index']);
Route::middleware('auth:api')->get('/v1/products/{product}',[ProductController::class,'show']);
Route::middleware('auth:api')->get('/v1/products/searchByCategory/{category}',[ProductController::class , 'searchByCategory']);

//cart controller
Route::middleware('auth:api')->post('/v1/cart',[CartController::class,'store']);
Route::middleware('auth:api')->get('/v1/cart/show',[CartController::class,'show']);
Route::middleware('auth:api')->get('/v1/cart/delete',[CartController::class,'destroy']);
Route::middleware('auth:api')->get('/v1/cart/showByUser',[CartController::class,'showByUser']);

//transaction controller
Route::middleware('auth:api')->get('/v1/transaction',[TransactionController::class,'store']);

});
});
