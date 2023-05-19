<?php

namespace App\Policies;

use App\Models\Test;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class TestPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Test  $test
     * @return \Illuminate\Auth\Access\Response|bool
     */
    public function edit(User $user, Test $test)
    {
        return $user->id === $test->user_id;
    }

    public function delete(User $user, Test $test)
    {
        return $user->id === $test->user_id ;
    }
}
