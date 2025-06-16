<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CadenaCustodia extends Model
{
    use HasFactory;

    protected $fillable = [
        "evidencia_id",
        "responsable",
        "cargo",
        "accion",
        "destino",
        "fecha",
        "hora",
        "observaciones",
        "fecha_registro",
        "status"
    ];

    protected $appends = ["fecha_registro_t", "fecha_hora_t", "fecha_t"];


    public function getFechaTAttribute()
    {
        return date("d/m/Y", strtotime($this->fecha));
    }


    public function getFechaHoraTAttribute()
    {
        return date("d/m/Y H:i a", strtotime($this->fecha . ' ' . $this->hora));
    }

    public function getFechaRegistroTAttribute()
    {
        return date("d/m/Y", strtotime($this->fecha_registro));
    }


    public function evidencia()
    {
        return $this->belongsTo(Evidencia::class, 'evidencia_id');
    }
}
