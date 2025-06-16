<?php

use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\CadenaCustodiaController;
use App\Http\Controllers\ConfiguracionController;
use App\Http\Controllers\ControlIntegridadController;
use App\Http\Controllers\EvidenciaController;
use App\Http\Controllers\InicioController;
use App\Http\Controllers\NotificacionController;
use App\Http\Controllers\PortalController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ReporteController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\UsuarioController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    if (Auth::check()) {
        return redirect()->route('inicio');
    }
    return Inertia::render('Auth/Login');
});


Route::get('/clear-cache', function () {
    Artisan::call('config:cache');
    Artisan::call('config:clear');
    Artisan::call('optimize');
    return 'Cache eliminado <a href="/">Ir al inicio</a>';
})->name('clear.cache');

Route::get('/login', function () {
    if (Auth::check()) {
        return redirect()->route('inicio');
    }
    return Inertia::render('Auth/Login');
})->name("login");

Route::get("configuracions/getConfiguracion", [ConfiguracionController::class, 'getConfiguracion'])->name("configuracions.getConfiguracion");

// ADMINISTRACION
Route::middleware(['auth', 'permisoUsuario'])->prefix("admin")->group(function () {
    // INICIO
    Route::get('/inicio', [InicioController::class, 'inicio'])->name('inicio');

    // CONFIGURACION
    Route::resource("configuracions", ConfiguracionController::class)->only(
        ["index", "show", "update"]
    );

    // USUARIO
    Route::get('profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::patch('profile/update_foto', [ProfileController::class, 'update_foto'])->name('profile.update_foto');
    Route::delete('profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::get("getUser", [UserController::class, 'getUser'])->name('users.getUser');
    Route::get("permisosUsuario", [UserController::class, 'permisosUsuario']);

    // USUARIOS
    Route::get("usuarios/clientes", [UsuarioController::class, 'clientes'])->name("usuarios.clientes");
    Route::put("usuarios/password/{user}", [UsuarioController::class, 'actualizaPassword'])->name("usuarios.password");
    Route::get("usuarios/api_clientes", [UsuarioController::class, 'api_clientes'])->name("usuarios.api_clientes");
    Route::get("usuarios/api", [UsuarioController::class, 'api'])->name("usuarios.api");
    Route::get("usuarios/paginado", [UsuarioController::class, 'paginado'])->name("usuarios.paginado");
    Route::get("usuarios/listado", [UsuarioController::class, 'listado'])->name("usuarios.listado");
    Route::get("usuarios/listado/byTipo", [UsuarioController::class, 'byTipo'])->name("usuarios.byTipo");
    Route::get("usuarios/show/{user}", [UsuarioController::class, 'show'])->name("usuarios.show");
    Route::put("usuarios/update/{user}", [UsuarioController::class, 'update'])->name("usuarios.update");
    Route::delete("usuarios/{user}", [UsuarioController::class, 'destroy'])->name("usuarios.destroy");
    Route::resource("usuarios", UsuarioController::class)->only(
        ["index", "store"]
    );

    // EVIDENCIAS
    Route::get("evidencias/api", [EvidenciaController::class, 'api'])->name("evidencias.api");
    Route::get("evidencias/paginado", [EvidenciaController::class, 'paginado'])->name("evidencias.paginado");
    Route::get("evidencias/listado", [EvidenciaController::class, 'listado'])->name("evidencias.listado");
    Route::get("evidencias/visualizar", [EvidenciaController::class, 'visualizar'])->name("evidencias.visualizar");
    Route::resource("evidencias", EvidenciaController::class)->only(
        ["index", "store", "show", "update", "destroy"]
    );

    // CONTROL INTEGRIDAD
    Route::get("control_integridads/api", [ControlIntegridadController::class, 'api'])->name("control_integridads.api");
    Route::get("control_integridads/paginado", [ControlIntegridadController::class, 'paginado'])->name("control_integridads.paginado");
    Route::get("control_integridads/listado", [ControlIntegridadController::class, 'listado'])->name("control_integridads.listado");
    Route::get("control_integridads/ver/{control_integridad}", [ControlIntegridadController::class, 'ver'])->name("control_integridads.ver");
    Route::resource("control_integridads", ControlIntegridadController::class)->only(
        ["index", "store", "show", "update", "destroy"]
    );

    // CADENA DE CUSTODIA
    Route::get("cadena_custodias/api", [CadenaCustodiaController::class, 'api'])->name("cadena_custodias.api");
    Route::get("cadena_custodias/paginado", [CadenaCustodiaController::class, 'paginado'])->name("cadena_custodias.paginado");
    Route::get("cadena_custodias/listado", [CadenaCustodiaController::class, 'listado'])->name("cadena_custodias.listado");
    Route::get("cadena_custodias/pdf/{cadena_custodia}", [CadenaCustodiaController::class, 'pdf'])->name("cadena_custodias.pdf");
    Route::resource("cadena_custodias", CadenaCustodiaController::class)->only(
        ["index", "store", "show", "update", "destroy"]
    );

    // NOTIFICACIONS
    Route::get("notificacions/api", [NotificacionController::class, 'api'])->name("notificacions.api");
    Route::get("notificacions/listadoPorUsuario", [NotificacionController::class, "listadoPorUsuario"])->name("notificacions.listadoPorUsuario");
    Route::get("notificacions", [NotificacionController::class, "index"])->name("notificacions.index");
    Route::get("notificacions/show/{notificacion}", [NotificacionController::class, "show"])->name("notificacions.show");

    // REPORTES
    Route::get('reportes/usuarios', [ReporteController::class, 'usuarios'])->name("reportes.usuarios");
    Route::get('reportes/r_usuarios', [ReporteController::class, 'r_usuarios'])->name("reportes.r_usuarios");

    Route::get('reportes/evidencias', [ReporteController::class, 'evidencias'])->name("reportes.evidencias");
    Route::get('reportes/r_evidencias', [ReporteController::class, 'r_evidencias'])->name("reportes.r_evidencias");

    Route::get('reportes/cadena_custodias', [ReporteController::class, 'cadena_custodias'])->name("reportes.cadena_custodias");
    Route::get('reportes/r_cadena_custodias', [ReporteController::class, 'r_cadena_custodias'])->name("reportes.r_cadena_custodias");

    Route::get('reportes/control_integridads', [ReporteController::class, 'control_integridads'])->name("reportes.control_integridads");
    Route::get('reportes/r_control_integridads', [ReporteController::class, 'r_control_integridads'])->name("reportes.r_control_integridads");
});
require __DIR__ . '/auth.php';
