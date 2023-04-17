<?php

use Illuminate\Support\Facades\Route;

/*controllers */
use App\Http\Controllers\ClientController; 
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/clientes', [ClientController::class, 'index']); 
Route::put('/clientes/actualizar',  [ClientController::class, 'update']);  
Route::post('/clientes/guardar', [ClientController::class, 'store']);
Route::delete('/clientes/borrar/{id}',  [ClientController::class, 'destroy']);

 