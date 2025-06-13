<?php

namespace App\Services;

use App\Models\Evidencia;
use App\Models\EvidenciaArchivo;
use Illuminate\Http\UploadedFile;

class EvidenciaArchivoService
{
    private $pathImages = "";
    public function __construct(private  CargarArchivoService $cargarArchivoService)
    {
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
        $archivo = $evidenciaArchivo->archivo;
        if ($evidenciaArchivo->delete()) {
            \File::delete($this->pathImages . "/" . $archivo);
        }
        $evidenciaArchivo->delete();
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
