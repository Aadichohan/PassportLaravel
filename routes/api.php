<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AuthController;
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


Route::group(['middleware' => [ 'cors', 'json.response']], function () {
    
    Route::get('/', function(){
        echo 'PHP Version: '. phpversion();
    });
    Route::post('/', function(){
        echo 'PHP Version: '. phpversion();
    });

    Route::post('/register', [UserController::class, 'createUser']);
    
    Route::get('login',    function(){
        echo "Login";
    });
    Route::post('login',    [AuthController::class, 'login']);
    
    
    Route::middleware(['auth:api'])->group( function () {
        
        Route::get('users',      [UserController::class, 'index'])->name('users.api');
    });

});
// Route::post('/login', [AuthController::class, 'login']);

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });
