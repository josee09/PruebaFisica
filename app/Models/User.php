<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasRoles, HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'firstname',
        'lastname',
        'grado',
        'assignment',
        'address',
        'udep',
        'department',
        'email',
        'password',
    ];

    public static $rules = [
        'name' => 'required|unique:users|alpha_num|min:3|max:255',
        'email' => 'required|unique:users|email|max:255',
        'password' => 'nullable|string|min:8|confirmed',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    //TIENE MUCHOS
    public function evaluados() {
        return $this->hasMany(Evaluado::class);
    }

    //TIENE MUCHOS
    public function principal() {
        return $this->hasMany(EventosPrincipal::class);
    }

    //TIENE MUCHOS
    public function alterno() {
        return $this->hasMany(EventosPrincipal::class);
    }

    //TIENE MUCHOS
    public function resutado() {
        return $this->hasMany(ResultadoPrueba::class);
    }

}
