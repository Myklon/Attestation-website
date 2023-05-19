<?php

namespace App\Policies;

use App\Models\Result;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class ResultPolicy
{
    public function show(User $user, Result $result): bool
    {
        return $user->id === $result->user_id || $user->id === $result->test->user_id;
    }
}
