<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class UserPolicy
{
    use HandlesAuthorization;

    public function edit(User $user, User $model)
    {
        return $user->id === $model->id;
    }

    public function seeResults(User $user, User $model)
    {
        return $user->id === $model->id;
    }
}
