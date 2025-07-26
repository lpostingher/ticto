<?php

namespace App\Observers;

use App\Models\User;

class UserObserver
{
    /**
     * Handle the User "created" event.
     */
    public function created(User $user): void
    {
        if (auth()->check() && auth()->user()->isAdmin() && !$user->isAdmin()) {
            $user->update(['manager_id' => auth()->user()->id]);
        }
    }
}
