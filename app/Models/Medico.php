<?php
// 17-4-23 creación de Modelo para registro de evaluaciones médicas
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use \Illuminate\Database\Eloquent\Relations\BelongsTo;

class Medico extends Model
{    protected $fillable = [
    'id_evaluado',
    'periodo',
    'pulso',
    'saturacion',
    'presion',
    'presion2',
    'presion3',
    'altura',
    'abdomen',
    'cuello',
    'mediabocue',
    'factoabdocue',
    'factoaltu',
    'grasa',
    'musculo',
    'pesoreal',
    'pesoideal',
    'exceso',
    'medico',
    'condicion',
    'grado_policial',
    'observaciones',
    'doc_firma',
    'lugar',
    'equipo',
    'user_id',
    'lugar_id',
    'sa',
    'smm',
    'srmg'
];

    //PERTENECE A
    public function evaluado() {
        return $this->belongsTo(Evaluado::class, 'id_evaluado');
     }

      //TIENE MUCHOS
    public function principal() {
        return $this->hasMany(EventosPrincipal::class, 'id_medico');
    }

    public function lugarEvaluacion(): BelongsTo
    {
        return $this->belongsTo(LugarEvaluacion::class, 'lugar_id');
    }
}
