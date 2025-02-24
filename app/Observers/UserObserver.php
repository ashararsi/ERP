<?php

namespace App\Observers;

use App\Models\User;
use App\Helpers\ActivityLogger;

class UserObserver
{
    public function created(User $user)
    {
        ActivityLogger::log('User Created', 'A new user was created.', ['user_id' => $user->id]);
    }

    public function updated(User $user)
    {
        ActivityLogger::log('User Updated', 'User details were updated.', ['user_id' => $user->id, 'changes' => $user->getChanges()]);
    }

    public function deleted(User $user)
    {
        ActivityLogger::log('User Deleted', 'User account deleted.', ['user_id' => $user->id]);
    }
}
