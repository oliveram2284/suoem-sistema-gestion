<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Afiliado extends Model
{
    protected $fillable = [
        'legajo',
        'apellido',
        'nombre',
        'cuil',
        'zona_id',
        'condicion_id',
        'cbu',
        'telefono',
        'activo',
    ];

    protected $casts = ['activo' => 'boolean'];

    public function zona()
    {
        return $this->belongsTo(Zona::class);
    }

    public function condicion()
    {
        return $this->belongsTo(Condicion::class);
    }

    public function getNombreCompletoAttribute(): string
    {
        return "{$this->apellido}, {$this->nombre}";
    }
}
