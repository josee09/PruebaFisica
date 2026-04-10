<?php
// 17-4-23 creación de Modelo para registro de personal
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 *
 */
class Evaluado extends Model
{
/**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    use HasFactory;
    protected $guarded = [
        'id',
        'created_at',
        'updated_at',
    ];


    public function rules(){
        return[
            'dni'=> 'required|unique:evaluados,dni,' .$this->id,
            'fechanac' => 'required|date|before_or_equal:today',
        ];
    }

    //PERTENECE A
    public function lugarAsignacion() {
        return $this->belongsTo(OrgSIG::class,'lugarasig','CLAVE_SIG',);
    }

    //PERTENECE A
    public function user() {
        return $this->belongsTo(User::class);
    }

    //TIENE MUCHOS
    public function principal() {
        return $this->hasMany(EventosPrincipal::class, 'id_evaluado');
    }

    //TIENE MUCHOS
    public function alterno() {
        return $this->hasMany(EventosAlterno::class, 'id_evaluado');
    }

    //TIENE MUCHOS
    public function resutado() {
        return $this->hasMany(ResultadoPrueba::class);
    }

    public function nombreCompletoRango()
    {
        return $this->grado.' '.$this->nombre.' '.$this->apellido;
    }

    public function ternasEvaluadoras()
    {
        return $this->belongsToMany(TernaEvaluadora::class, 'evaluado_terna_evaluadora')
                    ->withPivot('periodo', 'fecha_asignacion', 'estado')
                    ->withTimestamps();
    }
}
