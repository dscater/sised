<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ControlIntegridad extends Model
{
    use HasFactory;

    protected $fillable = [
        "evidencia_id",
        "evidencia_archivo_id",
        "fecha_alteracion",
        "hora_alteracion",
        "encriptado_original",
        "encriptado_alteracion",
        "fecha_registro",
    ];

    protected $appends = ["fecha_registro_t", "fecha_hora_alteracion_t"];
    public function getFechaHoraAlteracionTAttribute()
    {
        return date("d/m/Y H:i a", strtotime($this->fecha_alteracion . ' ' . $this->hora_alteracion));
    }

    public function getFechaRegistroTAttribute()
    {
        return date("d/m/Y", strtotime($this->fecha_registro));
    }

    // RELACIONES

    public function evidencia()
    {
        return $this->belongsTo(Evidencia::class, 'evidencia_id');
    }

    public function evidencia_archivo()
    {
        return $this->belongsTo(EvidenciaArchivo::class, 'evidencia_archivo_id');
    }
}
