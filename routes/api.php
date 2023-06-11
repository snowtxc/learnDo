<?php


use App\Http\Controllers\CalificacionController;
use App\Http\Controllers\CategoriaController;
use App\Http\Controllers\ColaboracionController;
use App\Http\Controllers\MensajeController;
use App\Http\Controllers\SugerenciaController;
use App\Http\Controllers\UsuarioController;
use App\Http\Controllers\EventoController;
use App\Http\Controllers\CursoController;
use App\Http\Controllers\ModuloController;
use App\Http\Controllers\OpcionController;
use App\Http\Controllers\ClaseController;
use App\Http\Controllers\EvaluacionController;
use App\Http\Controllers\PreguntaController;
use App\Http\Controllers\EstudiantesEventosController;

use App\Http\Controllers\PublicacionController;
use App\Http\Controllers\ComentarioController;
use App\Http\Controllers\SeminarioPresencialController;
use App\Http\Controllers\SeminarioVirtualController;

use App\Http\Controllers\VideoController;
use App\Http\Controllers\PuntuacionController;
use App\Http\Controllers\CertificadoController;

use App\Http\Controllers\CuponController;
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
], function () {
    Route::post("/login", [UsuarioController::class, "signin"])->name("login");
    Route::post("/signup", [UsuarioController::class, "create"])->name("signup");
    Route::put("/activate", [UsuarioController::class, "activate"])->name("activate");
    Route::get("/me", [UsuarioController::class, "me"])->name("me"); 
    Route::put("/me", [UsuarioController::class, "editMeInfo"])->name("editMeInfo");
    Route::get("/checkNickname", [UsuarioController::class, "checkNickname"])->name("checkNickname");
    Route::post("/signupWithOauth", [UsuarioController::class, "createUserWithOauth"])->name("createUserWithOauth");
    Route::put("/changeRole", [UsuarioController::class, "changeUserRole"])->name("changeRole");
});


Route::group([
    "prefix" => "eventos",
    'middleware' => ['cors'] 
], function() {
    Route::get("/", [EventoController::class, "listar"])->name("listar");
    Route::get("{id}/userIsStudentOrOwner", [EventoController::class, "userIsStudentOrOwner"])->name("userIsStudentOrOwner");
    Route::get("/getMyEventos", [EventoController::class, "getMyEventos"])->name("getMyEventos");
    Route::get("/getEventosAdmin", [EventoController::class, "getEventosAdmin"])->name("getEventosAdmin");
    Route::get("/listarTendencias", [EventoController::class, "listarTendencias"])->name("listarTendencias");
    Route::get("/getEventoInfo", [EventoController::class, "getEventoInfo"])->name("getEventoInfo");
});

Route::group([
    "prefix" => "messages",
], function () {
    Route::post("/create", [MensajeController::class, "create"])->name("create");
    Route::get("/", [MensajeController::class, "getMensajes"])->name("getMessages");
    Route::post("/changeIsRead", [MensajeController::class, "changeMessageIsRead"])->name("changeIsRead");
});

Route::group([
    "prefix" => "cursos",
], function () {
    
    Route::get("/getInfoCurso", [CursoController::class, "getInfoCurso"])->name("getInfoCurso"); 
    Route::get("/getCompleteInfoCurso", [CursoController::class, "getCursoInfo"])->name("getCursoInfo");
    Route::get("/getCursosComprados", [CursoController::class, "getCursosComprados"])->name("getCursosComprados");
    Route::get("/getCursoAndClases", [CursoController::class, "getCursoAndClases"])->name("getCursoAndClases"); // solo info del curso, modulos y clases. (sin evaluación también)
    Route::get("/{id}/canGetCertificate", [CursoController::class, "canGetCertificate"])->name("canGetCertificate");
    Route::get("/{id}/studentAlreadyHasCertificate", [CursoController::class, "studentAlreadyHasCertificate"])->name("studentAlreadyHasCertificate");
    Route::put("/updateCursoInfo", [CursoController::class, "updateCursoInfo"])->name("updateCursoInfo");
    Route::get("/getProgresoEstudiantes", [CursoController::class, "getProgresoEstudiantes"])->name("getProgresoEstudiantes"); // solo info del curso, modulos y clases. (sin evaluación también)
    Route::get("/listarComprados", [EstudiantesEventosController::class, "showNuevosAlumnos"])->name("showNuevosAlumnos");
});

Route::group([
    "prefix" => "eventos",
    'middleware' => ['cors']
], function () {
    Route::post('/createEvento', [EventoController::class, "create"]);
    Route::get("/", [EventoController::class, "listar"])->name("listar");
    Route::post("/comprarEvento", [EventoController::class, "comprarEvento"])->name("comprarEvento");
   
});

Route::group([
    "prefix" => "modulos",
], function () { 
    Route::post('/createModulo', [ModuloController::class, "create"]);
    Route::get('/listByEventoId/{eventoId}', [ModuloController::class, "listByEventoId"]);
    Route::get('/{id}', [ModuloController::class, "show"]);
    Route::delete('/{id}', [ModuloController::class, "destroy"]);
    Route::put('/updateAllOfModulo', [ModuloController::class, "updateAllInfoOfModulo"]);
    Route::put('/{id}', [ModuloController::class, "update"]);
});

Route::group([
    "prefix" => "clases",
], function () {
    Route::post('/createClase', [ClaseController::class, "create"]);
    Route::get('/', [ClaseController::class, "getClaseInfo"]);
    Route::delete('/{id}', [ClaseController::class, "destroy"]);

});

Route::group([
    "prefix" => "evaluaciones",
], function () {
    Route::post('/createEvaluacion', [EvaluacionController::class, "create"]);
    Route::get('/', [EvaluacionController::class, "getInfo"]);

});


Route::group([
    "prefix" => "preguntas",
], function () {
    Route::post('/createPregunta', [PreguntaController::class, "create"]);
    Route::delete('/{id}', [PreguntaController::class, "destroy"]);
});

Route::group([
    "prefix" => "opciones",
], function () {
    Route::post('/createOpcion', [OpcionController::class, "create"]);
});

Route::group([
    "prefix" => "usuarios",
], function () {
    Route::get('/filterByNicknameOrEmail', [UsuarioController::class, "filterByNicknameOrEmail"]);
    Route::get('/userInfoById', [UsuarioController::class, "userInfoById"]);
});

Route::group([
    "prefix" => "seminarios",
], function () {
    Route::post('/createSeminarioVirtual', [SeminarioVirtualController::class, "create"]);
    Route::post('/createSeminarioPresencial', [SeminarioPresencialController::class, "create"]);
    Route::get('/presenciales', [SeminarioPresencialController::class, "listarSeminariosPresenciales"]);
    Route::get('/getCompleteInfoSeminario', [SeminarioPresencialController::class, "getCompleteInfoSeminario"]);
    Route::post("/virtuales/{id}/chat",  [MensajeSalaController::class , "create"]);    
});



Route::group([
    "prefix" => "publicaciones",
], function () {
    Route::get('/listByForoId/{foroId}', [PublicacionController::class, "list"]); 
    Route::post('/', [PublicacionController::class, "create"]);
    Route::put('/{id}', [PublicacionController::class, "edit"]);
    Route::delete('/{id}', [PublicacionController::class, "destroy"]);
});

Route::group([
    "prefix" => "comentarios",
], function () {
    Route::get('/listByPublicacionId/{publicacionId}', [ComentarioController::class, "listByPublicacionId"]);
    Route::post('/', [ComentarioController::class, "create"]);
    Route::put('/{id}', [ComentarioController::class, "edit"]);
    Route::delete('/{id}', [ComentarioController::class, "destroy"]);
});


Route::group([
    "prefix" => "colaboraciones",
], function () {
    Route::post('/createColaboraciones', [ColaboracionController::class, "create"]);
    Route::post('/isUserColaborador', [ColaboracionController::class, "isUserColaborador"]);
    Route::delete('/', [ColaboracionController::class, "destroy"]);
});

Route::group([
    "prefix" => "categorias",
], function () {
    Route::get('/', [CategoriaController::class, "getAll"]);
});

Route::group([
    "prefix" => "videos",
], function() {
    Route::post('/upload-video', [VideoController::class, 'uploadVideo']);
    Route::get('/getBase64OfVideo', [VideoController::class, 'getBase64OfVideo']);
});

Route::group([
    "prefix" => "puntuacion",
], function() {
    Route::post('/', [PuntuacionController::class, 'puntuarCurso']);
});

Route::group([
    "prefix" => "calificacion",
], function () {
    Route::post('/', [CalificacionController::class, "correjirCalificacion"]);



});

Route::group([
    "prefix" => "certificaciones",
], function () {
    Route::post("/", [CertificadoController::class, "create"])->name("create");
    Route::get('/{id}/getCertificationPDF', [CertificadoController::class, "getCertificationPdf"]); 

});

Route::group([
    "prefix" => "sugerencias",
], function () {
    Route::post('/createSugerencia', [SugerenciaController::class, "create"]);
    Route::put('/changeStatus', [SugerenciaController::class, "changeStatus"]);
});

Route::group([
    "prefix" => "cupon",
], function () {
    Route::post('/generateCupon', [CuponController::class, "generateNewCupon"]);
    Route::get('/validarCupon', [CuponController::class, "validarCupon"]);
    Route::get('/usarCupon', [CuponController::class, "usarCupon"]);
});



