<?php

namespace App\Observers;

use App\Helpers\ActivityLogger;
use  Spatie\Permission\Models\Role;

class RoleObserver
{
    /**
     * Handle the Role "created" event.
     */
    public function created(Role $role): void
    {
        ActivityLogger::log('Role  created', ' Role created.', ['Role' => $role]);
    }

    /**
     * Handle the Role "updated" event.
     */
    public function updated(Role $role): void
    {
        ActivityLogger::log('Role  updated', ' Role updated.', ['Role' => $role]);
    }

    /**
     * Handle the Role "deleted" event.
     */
    public function deleted(Role $role): void
    {
        ActivityLogger::log('Role  deleted', ' Role deleted.', ['Role' => $role]);
    }

    /**
     * Handle the Role "restored" event.
     */
    public function restored(Role $role): void
    {
        ActivityLogger::log('Role  restored', ' Role restored.', ['Role' => $role]);
    }

    /**
     * Handle the Role "force deleted" event.
     */
    public function forceDeleted(Role $role): void
    {
        ActivityLogger::log('Role  forceDeleted', ' Role forceDeleted.', ['Role' => $role]);
    }
}
