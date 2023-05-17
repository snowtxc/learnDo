<?php

use App\Http\Controllers\MensajeController;
use App\Http\Controllers\UsuarioController;
use App\Http\Controllers\EventoController;
use App\Http\Controllers\CursoController;
use App\Http\Controllers\ModuloController;
use App\Http\Controllers\OpcionController;
use App\Http\Controllers\ClaseController;
use App\Http\Controllers\EvaluacionController;
use App\Http\Controllers\PreguntaController;
use App\Http\Controllers\CategoriaController;
use App\Http\Controllers\PublicacionController;
use App\Http\Controllers\ComentarioController;


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
    Route::put("/me", [UsuarioController::class, "editMeInfo"])->name("editMeInfo");
    Route::get("/checkNickname", [UsuarioController::class, "checkNickname"])->name("login");
});


Route::group([
    "prefix" => "eventos",
    'middleware' => ['cors'] 
], function() {
    Route::get("/", [EventoController::class, "listar"])->name("listar"); 

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
    Route::post('/createCurso', [CursoController::class, "create"]);
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
    "prefix" => "categorias",
], function() {
    Route::post('/', [CategoriaController::class, "create"]);
    Route::get('/', [CategoriaController::class, "getAll"]);
    Route::delete('/{id}', [CategoriaController::class, "destroy"]);
    Route::put('/{id}', [CategoriaController::class, "update"]);
});

Route::group([
    "prefix" => "modulos",
], function() {
    Route::post('/', [ModuloController::class, "create"]);
    Route::get('/listByEventoId/{eventoId}', [ModuloController::class, "listByEventoId"]);
    Route::get('/{id}', [ModuloController::class, "show"]);
    Route::delete('/{id}', [ModuloController::class, "destroy"]);
    Route::put('/{id}', [ModuloController::class, "update"]);
}); 

Route::group([
    "prefix" => "publicaciones",
], function() {
    Route::post('/', [PublicacionController::class, "create"]);
    Route::put('/{id}', [PublicacionController::class, "edit"]);
    Route::delete('/{id}', [PublicacionController::class, "destroy"]);
});  

Route::group([
    "prefix" => "comentarios",
], function() {
    Route::post('/', [ComentarioController::class, "create"]);
    Route::put('/{id}', [ComentarioController::class, "edit"]);
    Route::delete('/{id}', [ComentarioController::class, "destroy"]);


});  
 




