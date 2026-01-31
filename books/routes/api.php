<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ApiController;
use App\Http\Controllers\UserController;

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



Route::get('/allbook/{page}', [ApiController::class, 'allbook']);
Route::get('/allauthor', [ApiController::class, 'allauthor']);
Route::get('/book/{id}', [ApiController::class, 'show']);



Route::post('/login', [UserController::class, 'login'])->name('login');
Route::post('/register', [UserController::class, 'register']);
Route::post('/logout', [UserController::class, 'logout']);
Route::middleware(['auth:sanctum'])->group(function () {
    Route::get('me', [UserController::class, 'me']);
    Route::post('author',[ApiController::class,'create']);
    Route::post('/book', [ApiController::class, 'createb']);
    Log::info("this is info message");
    Log::error("This is error message");
    Route::post('/author/update/{id}', [ApiController::class, 'updateauthor']);
    Route::get('/author/{id}', [ApiController::class, 'showauthor']);
    Route::post('/book/update/{id}', [ApiController::class, 'updatebook']);
Route::DELETE('/author/delete/{id}', [ApiController::class, 'destroyauthor']);
Route::DELETE('/book/delete/{id}', [ApiController::class, 'destorybook']);
});




// Route::group(['middleware' => (['auth', 'auth.session'])], function () {
//     // Routes requiring session functionality
//     Route::post('logout', [UserController::class, 'logout']);
// });

Route::apiResource('categories', CategoryController::class);

Route::get('/books', [ApiController::class, 'getBooks']);
Route::get('/user/profile', [ApiController::class, 'userProfile']);
Route::put('/user/profile', [ApiController::class, 'updateUserProfile']);

