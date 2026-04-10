<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ResultadoPrueba extends Model
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
        return $this->belongsTo(Evaluado::class, 'id_evaluado');
    }

    //PERTENECE A
    public function medico() {
        return $this->belongsTo(Medico::class, 'id_medico');
    }

    //PERTENECE A
    public function principal() {
        return $this->belongsTo(EventosPrincipal::class, 'id_principal');
    }

    //PERTENECE A
    public function alterno() {
        return $this->belongsTo(EventosAlterno::class);
    }

    //TIENE MUCHOS
    public function resultado() {
        return $this->hasMany(ResultadoPrueba::class);
    }


    // protected $fillable = [
    //     'grado1',
    //     'grado2',
    //     'grado3',
    //     'grado4',

    // ];



}
