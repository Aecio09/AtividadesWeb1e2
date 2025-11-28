<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class UserPolicy
{
    use HandlesAuthorization;


    public function before(?User $user, $ability)
    {
        if ($user && $user->role === 'admin') {
            return true;
        }
    }


    public function viewAny(?User $user): bool
    {
        return $user !== null && $user->role === 'admin';
    }


    public function view(User $authUser, User $user): bool
    {
        return $authUser->id === $user->id;
    }


    public function create(User $user): bool
    {
        return $user->role === 'admin';
    }


    public function update(User $authUser, User $user): bool
    {
        return $authUser->id === $user->id;
    }


    public function delete(User $user, User $model): bool
    {
        return false;
    }
}