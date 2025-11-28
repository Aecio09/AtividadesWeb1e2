<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ResourcePolicy
{
    use HandlesAuthorization;


    public function before(?User $user, $ability)
    {
        if ($user && $user->role === 'admin') {
            return true;
        }
    }


    public function viewAny(User $user): bool
    {
        return true; 
    }

    public function view(User $user, $model): bool
    {
        return true; 
    }


    public function create(User $user): bool
    {
        return in_array($user->role, ['admin', 'bibliotecario'], true);
    }


    public function update(User $user, $model): bool
    {
        return in_array($user->role, ['admin', 'bibliotecario'], true);
    }

  
    public function delete(User $user, $model): bool
    {
        return in_array($user->role, ['admin', 'bibliotecario'], true);
    }
}
