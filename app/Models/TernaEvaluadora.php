<?php

namespace App\Models;

use App\Http\Controllers\EvaluadoController;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use \Illuminate\Database\Eloquent\Relations\BelongsToMany;

/**
 *
 */
class TernaEvaluadora extends Model
{
    use HasFactory;

    protected $table = 'ternas_evaluadoras';

    protected $fillable = [
        "descripcion",
        "evaluado_id",
        'ternas_evaluadoras_id',
        'E1_id',
        'E2_id',
        'E3_id',
        'E4_id',
        'OJEE_id',
    ];

    //TODO crear metodos de para mostrar cada uno de los evaluados
    public function evaluador1()
    {
        return $this->hasOne(Evaluado::class,'id','E1_id');
    }

    public function evaluador2()
    {
        return $this->hasOne(Evaluado::class,'id','E2_id');
    }

    public function evaluador3()
    {
        return $this->hasOne(Evaluado::class,'id','E3_id');
    }

    public function evaluador4()
    {
        return $this->hasOne(Evaluado::class,'id','E4_id');


    }

    public function evaluadorJefe()
    {
        return $this->hasOne(Evaluado::class,'id','OJEE_id');
    }

    public function evaluadosAsignados()
    {
        return $this->belongsToMany(Evaluado::class, 'evaluado_terna_evaluadora')
                    ->withPivot('periodo', 'fecha_asignacion', 'estado')
                    ->withTimestamps();
    }
}
