<?php

use Illuminate\Support\Facades\Route;

//Importamos nuestros controladors
use App\Http\Controllers\UsuarioController;
use App\Http\Controllers\RolController;
use App\Http\Controllers\CarreraController;
use App\Http\Controllers\EstudianteController;
use App\Http\Controllers\DivisioneController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
});


Route::group(['middleware' => ['auth']], function(){
    // Agrupa las rutas bajo el middleware 'auth', que requiere que el usuario inicie sesión para acceder a estas rutas.

    // Crea rutas para el recurso 'roles' usando el controlador 'RolController'.
    Route::resource('roles', RolController::class);

    // Crea rutas para el recurso 'usuarios' usando el controlador 'UsuarioController'.
    Route::resource('usuarios', UsuarioController::class);

    // Crea rutas para el recurso 'divisiones' usando el controlador 'DivisionController'.
    Route::resource('divisiones', DivisioneController::class);

    // Crea rutas para el recurso 'carreras' usando el controlador 'CarreraController'.
    Route::resource('carreras', CarreraController::class);

    // Crea rutas para el recurso 'estudiantes' usando el controlador 'EstudianteController'.
    Route::resource('estudiantes', EstudianteController::class);
});