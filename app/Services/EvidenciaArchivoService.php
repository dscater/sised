<?php

namespace App\Services;

use App\Models\ControlIntegridad;
use App\Models\Evidencia;
use App\Models\EvidenciaArchivo;
use Illuminate\Container\Attributes\Log;
use Illuminate\Http\UploadedFile;

class EvidenciaArchivoService
{
    private $pathImages = "";
    public function __construct(
        private  CargarArchivoService $cargarArchivoService,
        private NotificacionService $notificacionService
    ) {
        $this->pathImages = public_path("evidencias");
    }

    /**
     * Cargar archivo
     *
     * @param Evidencia $evidencia
     * @param UploadedFile $foto
     * @return void
     */
    public function guardarArchivosEvidencia(array $archivos, Evidencia $evidencia): void
    {
        foreach ($archivos as $key => $archivo) {
            if (!is_string($archivo["file"])) {
                $nombre = $key . $evidencia->id . time();
                $archivo_cargado = $this->cargarArchivoService->cargarArchivo($archivo["file"], $this->pathImages, $nombre);
                $url_archivo = public_path("evidencias/" . $archivo_cargado);
                $hash_archivo = self::generaHashArchivo($url_archivo);
                $evidencia->archivos()->create([
                    "archivo" => $archivo_cargado,
                    "hash_archivo" => $hash_archivo
                ]);
            }
        }
    }

    public function actualizarArchivoEvidencia(EvidenciaArchivo $evidenciaArchivo, $archivo): void
    {
        $hash_antiguo = $evidenciaArchivo->hash_archivo;
        $nombre = $evidenciaArchivo->id . $evidenciaArchivo->evidencia->id . time();
        $archivo_cargado = $this->cargarArchivoService->cargarArchivo($archivo, $this->pathImages, $nombre);
        $url_archivo = public_path("evidencias/" . $archivo_cargado);
        $hash_archivo = self::generaHashArchivo($url_archivo);
        if ($hash_antiguo != $hash_archivo) {
            // GENERAR NOTIFICACIÓN
            $this->notificacionService->crearNotificacionModificacionEvidenciaArchivo($evidenciaArchivo);

            // CREAR CONTROL DE INTEGRIDAD
            $fecha_actual = date("Y-m-d");
            $hora_actual = date("H:i:s");
            ControlIntegridad::create([
                "evidencia_id" => $evidenciaArchivo->evidencia_id,
                "evidencia_archivo_id" => $evidenciaArchivo->id,
                "fecha_alteracion" => $fecha_actual,
                "hora_alteracion" => $hora_actual,
                "encriptado_original" => $hash_antiguo,
                "encriptado_alteracion" => $hash_archivo,
                "fecha_registro" => $fecha_actual,
            ]);
        }

        $evidenciaArchivo->update([
            "archivo" => $archivo_cargado,
            "hash_archivo" => $hash_archivo
        ]);
    }

    public static function generaHashArchivo($url)
    {
        return hash_file('sha256', $url);
    }

    /**
     * Eliminacion fisica de archivo evidencia
     *
     * @param EvidenciaArchivo $evidenciaArchivo
     * @return void
     */
    public function eliminarArchivoEvidencia(EvidenciaArchivo $evidenciaArchivo): void
    {
        // $archivo = $evidenciaArchivo->archivo;
        // if ($evidenciaArchivo->delete()) {
        //     \File::delete($this->pathImages . "/" . $archivo);
        // }

        // GENERAR NOTIFICACIÓN
        $this->notificacionService->crearNotificacionEliminacionEvidenciaArchivo($evidenciaArchivo);

        // CREAR CONTROL DE INTEGRIDAD
        $fecha_actual = date("Y-m-d");
        $hora_actual = date("H:i:s");
        // ControlIntegridad::create([
        //     "evidencia_id" => $evidenciaArchivo->evidencia_id,
        //     "evidencia_archivo_id" => $evidenciaArchivo->id,
        //     "fecha_alteracion" => $fecha_actual,
        //     "hora_alteracion" => $hora_actual,
        //     "encriptado_original" => $evidenciaArchivo->hash_archivo,
        //     "encriptado_alteracion" => $evidenciaArchivo->hash_archivo,
        //     "fecha_registro" => $fecha_actual,
        // ]);
        $evidenciaArchivo->status = 0;
        $evidenciaArchivo->save();
    }

    /**
     * Obtener extension del nombre de la archivo
     * ejem: image.png -> png
     * 
     * @param string $archivo
     * @return string
     */
    public static function getExtNomArchivo(string $archivo): string
    {
        $array = explode(".", $archivo);
        return $array[count($array) - 1];
    }
}
