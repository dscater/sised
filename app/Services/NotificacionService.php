<?php

namespace App\Services;

use App\Models\Notificacion;
use App\Models\EvidenciaArchivo;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class NotificacionService
{
    private $usersNotificados;

    public function __construct() {}

    public function listado(): Collection
    {
        $notificacions = Notificacion::select("notificacions.*")->get();
        return $notificacions;
    }

    public function listadoDataTable(int $length, int $start, int $page, string $search): LengthAwarePaginator
    {
        $notificacions = Notificacion::select("notificacions.*");
        if ($search && trim($search) != '') {
            $notificacions->where("descripcion", "LIKE", "%$search%");
        }
        $notificacions = $notificacions->paginate($length, ['*'], 'page', $page);
        return $notificacions;
    }

    /**
     * Crear notificacion por modificacion de archivo
     *
     * @param EvidenciaArchivo $evidenciaArchivo
     * @return Notificacion
     */
    public function crearNotificacionModificacionEvidenciaArchivo(EvidenciaArchivo $evidenciaArchivo): Notificacion
    {
        $user = Auth::user();

        $notificacion = Notificacion::create([
            "descripcion" => 'El usuario <b>' . $user->usuario . '</b> modifico el archivo de la evidencia <b>' . $evidenciaArchivo->evidencia->codigo . '</b>',
            "fecha" => date("Y-m-d"),
            "hora" => date("H:i"),
            "modulo" => "EvidenciaArchivo",
            "registro_id" => $evidenciaArchivo->id,
        ]);

        // notificar a los usuarios
        $this->generarUsuariosNotificacion();
        $this->notificarUsuarios($notificacion);

        return $notificacion;
    }

    /**
     * Crear notificacion por eliminacion de archivo
     *
     * @param EvidenciaArchivo $evidenciaArchivo
     * @return Notificacion
     */
    public function crearNotificacionEliminacionEvidenciaArchivo(EvidenciaArchivo $evidenciaArchivo): Notificacion
    {
        $user = Auth::user();

        $notificacion = Notificacion::create([
            "descripcion" => 'El usuario <b>' . $user->usuario . '</b> eliminó el archivo de la evidencia <b>' . $evidenciaArchivo->evidencia->codigo . '</b>',
            "fecha" => date("Y-m-d"),
            "hora" => date("H:i"),
            "modulo" => "EvidenciaArchivo",
            "registro_id" => $evidenciaArchivo->id,
        ]);

        // notificar a los usuarios
        $this->generarUsuariosNotificacion();
        $this->notificarUsuarios($notificacion);

        return $notificacion;
    }

    private function generarUsuariosNotificacion(): void
    {
        $this->usersNotificados = User::where("status", 1)->get();
    }

    /**
     * Notificar a los usuarios correspondientes
     *
     * @param Notificacion $notificacion
     * @return void
     */
    private function notificarUsuarios(Notificacion $notificacion): void
    {
        foreach ($this->usersNotificados as $user) {
            $user->notificacions()->attach($notificacion->id, ["visto" => 0]);
        }
    }
}
