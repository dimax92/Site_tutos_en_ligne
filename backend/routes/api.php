<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthentificationController;
use App\Http\Controllers\TutosController;

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

Route::post('/register', [AuthentificationController::class, 'register']);
Route::post('/login', [AuthentificationController::class, 'login']);
Route::get("/tutos", [TutosController::class, "index"]);
Route::get("/tutos/{id}", [TutosController::class, "show"]);
Route::post("/search/{search}", [TutosController::class, "search"]);

//Protecting Routes
Route::group(['middleware' => ['auth:sanctum']], function () {
    Route::get('/profile', [AuthentificationController::class, 'profile']);
    Route::post('/logout', [AuthentificationController::class, 'logout']);
    Route::post('/updateprofil/{id}', [AuthentificationController::class, 'update']);
    Route::post('/suppressionprofil/{id}', [AuthentificationController::class, 'destroy']);
    Route::post("/creationtutos/{id}", [TutosController::class, "store"]);
    Route::post("/destroy/{id}", [TutosController::class, "destroy"]);
    Route::post("/update/{id}", [TutosController::class, "update"]);
    Route::get("/mestutos/{id}", [TutosController::class, "mesTutos"]);
});