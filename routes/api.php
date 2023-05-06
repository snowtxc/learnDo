<?php

use App\Http\Controllers\UsuarioController;
use App\Http\Controllers\EventoController;
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

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::group([
    "prefix" => "auth",
    'middleware' => ['cors']
], function() {
    Route::post("/login", [UsuarioController::class, "signin"])->name("login");
    Route::post("/signup", [UsuarioController::class, "create"])->name("signup");
    Route::put("/activate", [UsuarioController::class, "activate"])->name("activate");
    Route::get("/me", [UsuarioController::class, "me"])->name("me");
    Route::get("/checkNickname", [UsuarioController::class, "checkNickname"])->name("login");
});


Route::group([
    "prefix" => "eventos",
    'middleware' => ['cors']
], function() {
    Route::get("/", [EventoController::class, "listar"])->name("listar"); 

});
