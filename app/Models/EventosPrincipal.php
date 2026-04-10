<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EventosPrincipal extends Model
{
    use HasFactory; 
    protected $guarded = [
        'id',
        'created_at',
        'updated_at',
    ];

    // protected $table="eventos_principals";

    //PERTENECE A
    public function user() {
        return $this->belongsTo(User::class);
    }
 
    //PERTENECE A
    public function evaluado() {
        return $this->belongsTo(Evaluado::class, 'id_evaluado');
    }

    //PERTENECE A
    public function medico() {
        return $this->belongsTo(Medico::class, 'id_medico');
    }

    //TIENE MUCHOS
    public function alterno() {
        return $this->hasMany(EventosAlterno::class, 'id_principal');
    }

    //TIENE MUCHOS
    public function resutado() {
        return $this->hasMany(ResultadoPrueba::class, 'id_principal');
    }
    
}
