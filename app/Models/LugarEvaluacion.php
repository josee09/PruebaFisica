<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\Relations\HasMany;
class LugarEvaluacion extends Model
{
    use HasFactory;

    protected $table = 'lugares_evaluacion';

    protected $guarded = [
        'id',
        'created_at',
        'updated_at',
    ];

    //PERTENECE A
    public function EvaluacionMedica(): HasMany
    {
        return $this->hasMany(Medico::class);
    }
}
