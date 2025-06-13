<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Evidencia extends Model
{
    use HasFactory;

    protected $fillable = [
        "codigo",
        "descripcion",
        "nombre_creador",
        "fecha_creacion",
        "hora_creacion",
        "origen_archivo",
        "fecha_hallazgo",
        "hora_hallazgo",
        "lugar_recoleccion",
        "persona_recolector",
        "herramienta_utilizada",
        "fecha_registro",
        "status"
    ];

    protected $appends = ["fecha_registro_t", "fecha_hora_creacion_t", "fecha_hora_hallazgo_t"];

    public function getFechaHoraCreacionTAttribute()
    {
        return date("d/m/Y H:i a", strtotime($this->fecha_creacion . ' ' . $this->hora_creacion));
    }

    public function getFechaHoraHallazgoTAttribute()
    {
        return date("d/m/Y H:i a", strtotime($this->fecha_hallazgo . ' ' . $this->hora_hallazgo));
    }

    public function getFechaRegistroTAttribute()
    {
        return date("d/m/Y", strtotime($this->fecha_registro));
    }

    // RELACIONES
    public function archivos()
    {
        return $this->hasMany(EvidenciaArchivo::class, 'evidencia_id');
    }
}
