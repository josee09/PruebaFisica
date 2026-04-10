<?php
// 4-5-23 creación de politicas de seguridad para modulo de personal evaluado
namespace App\Policies;

use App\Models\Evaluado;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class EvaluadoPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        //
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Evaluado $evaluado): bool
    {
        //
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        //
    }

    /**
     * EDITAR REGISTROS DE UN USUARIO ESPECIFICO.
     * @param  \App\Models\User  $user
     * @param  \App\Models\Evaluado  $evaluado
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function update(User $user, Evaluado $evaluado): bool
    {
        return $user->id === $evaluado->user->id;
    }

    /**
     * ELIMINAR REGISTROS DE UN USUARIO ESPECIFICO.
    *  @param  \App\Models\User  $user
     * @param  \App\Models\Evaluado  $evaluado
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function delete(User $user, Evaluado $evaluado): bool
    {
        return $user->id === $evaluado->user->id;
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Evaluado $evaluado): bool
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Evaluado $evaluado): bool
    {
        //
    }
}
