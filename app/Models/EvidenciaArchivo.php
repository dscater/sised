<?php

namespace App\Models;

use App\Services\EvidenciaArchivoService;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EvidenciaArchivo extends Model
{
    use HasFactory;

    protected $fillable = [
        "evidencia_id",
        "archivo",
        "hash_archivo",
    ];

    protected $appends = ["url_archivo", "archivo_b64", "url_archivo", "url_file", "name", "ext"];

    public function getExtAttribute()
    {
        $array = explode(".", $this->archivo);
        return $array[1];
    }

    public function getNameAttribute()
    {
        return $this->archivo;
    }

    public function getUrlFileAttribute()
    {
        $array_imgs = ["jpg", "jpeg", "png", "webp", "gif"];
        $ext = EvidenciaArchivoService::getExtNomArchivo($this->archivo);
        if (in_array($ext, $array_imgs)) {
            return asset("/evidencias/" . $this->archivo);
        }
        return asset("/imgs/attach.png");
    }

    public function getUrlArchivoAttribute()
    {
        return asset("evidencias/" . $this->archivo);
    }

    public function getUrlImagenAttribute()
    {
        if ($this->archivo) {
            return asset("evidencias/" . $this->archivo);
        }
        return asset("evidencias/default.png");
    }

    public function getArchivoB64Attribute()
    {
        $path = public_path("evidencias/" . $this->archivo);
        $array_imgs = ["jpg", "jpeg", "png", "webp", "gif"];
        $ext = EvidenciaArchivoService::getExtNomArchivo($this->archivo);
        if (in_array($ext, $array_imgs)) {
            if (!$this->archivo || !file_exists($path)) {
                $path = public_path("evidencias/default.png");
                $type = pathinfo($path, PATHINFO_EXTENSION);
                $data = file_get_contents($path);
                $base64 = 'data:image/' . $type . ';base64,' . base64_encode($data);
                return $base64;
            }
        }
        return "";
    }

    public function evidencia()
    {
        return $this->belongsTo(Evidencia::class, 'evidencia_id');
    }
}
