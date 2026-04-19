<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Condicion extends Model
{
    protected $table = 'condiciones';
    protected $fillable = ['nombre', 'activo'];

    protected $casts = ['activo' => 'boolean'];

    public function afiliados()
    {
        return $this->hasMany(Afiliado::class);
    }
}
