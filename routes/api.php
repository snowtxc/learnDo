<?php

use App\Http\Controllers\MensajeController;
use App\Http\Controllers\UsuarioController;
use App\Http\Controllers\CursoController;
use App\Http\Controllers\EventoController;
use App\Http\Controllers\ModuloController;
use App\Http\Controllers\OpcionController;
use App\Http\Controllers\ClaseController;
use App\Http\Controllers\EvaluacionController;
use App\Http\Controllers\PreguntaController;
use App\Http\Controllers\SeminarioPresencialController;
use App\Http\Controllers\SeminarioVirtualController;
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
], function () {
    Route::post("/login", [UsuarioController::class, "signin"])->name("login");
    Route::post("/signup", [UsuarioController::class, "create"])->name("signup");
    Route::put("/activate", [UsuarioController::class, "activate"])->name("activate");
    Route::get("/me", [UsuarioController::class, "me"])->name("me");
    Route::get("/checkNickname", [UsuarioController::class, "checkNickname"])->name("login");
});

Route::group([
    "prefix" => "messages",
], function () {
    Route::post("/create", [MensajeController::class, "create"])->name("create");
    Route::get("/", [MensajeController::class, "getMensajes"])->name("create");
});

Route::group([
    "prefix" => "cursos",
], function () {
    Route::get("/getInfoCurso", [CursoController::class, "getInfoCurso"])->name("getInfoCurso");
});

Route::group([
    "prefix" => "eventos",
], function() {
    Route::post('/createEvento', [EventoController::class, "create"]);
    Route::get("/", [EventoController::class, "listar"])->name("listar"); 
});

Route::group([
    "prefix" => "modulos",
], function() {
    Route::post('/createModulo', [ModuloController::class, "create"]);
});

Route::group([
    "prefix" => "clases",
], function() {
    Route::post('/createClase', [ClaseController::class, "create"]);
});

Route::group([
    "prefix" => "evaluaciones",
], function() {
    Route::post('/createEvaluacion', [EvaluacionController::class, "create"]);
});


Route::group([
    "prefix" => "preguntas",
], function() {
    Route::post('/createPregunta', [PreguntaController::class, "create"]);
});

Route::group([
    "prefix" => "opciones",
], function() {
    Route::post('/createOpcion', [OpcionController::class, "create"]);
});

Route::group([
    "prefix" => "seminarios",
], function() {
    Route::post('/createSeminarioVirtual', [SeminarioVirtualController::class, "create"]);
    Route::post('/createSeminarioPresencial', [SeminarioPresencialController::class, "create"]);
});

Route::group([
    "prefix" => "usuarios",
], function() {
    Route::get('/filterByNicknameOrEmail', [UsuarioController::class, "filterByNicknameOrEmail"]);
});


