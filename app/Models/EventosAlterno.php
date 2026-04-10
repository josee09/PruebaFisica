<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EventosAlterno extends Model
{
    use HasFactory;
    protected $guarded = [
        'id',
        'created_at',
        'updated_at',
    ];

   //PERTENECE A
    public function user() {
        return $this->belongsTo(User::class);
    }

    //PERTENECE A
    public function evaluado() {
        return $this->belongsTo(Evaluado::class, 'id_evaluado', 'id');
    }

    //PERTENECE A
    public function medico() {
        return $this->belongsTo(Medico::class, 'id_medico');
    }

    //PERTENECE A
    public function principal() {
        return $this->belongsTo(EventosPrincipal::class, 'id_principal');
    }

    //TIENE MUCHOS
    public function resultado() {
        return $this->hasMany(ResultadoPrueba::class);
    }

};