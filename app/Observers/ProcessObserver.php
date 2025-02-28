<?php

namespace App\Observers;

use App\Helpers\ActivityLogger;
use App\Models\Processe;

class ProcessObserver
{
    /**
     * Handle the Process "created" event.
     */
    public function created(Processe $process): void
    {
        ActivityLogger::log('Process', 'A new user was created.', ['user_id' => $process]);

    }

    /**
     * Handle the Process "updated" event.
     */
    public function updated(Processe $process): void
    {
        ActivityLogger::log('Process updated', 'A   Process was updatd.', ['user_id' => $process]);

    }

    /**
     * Handle the Process "deleted" event.
     */
    public function deleted(Processe $process): void
    {
        ActivityLogger::log('Process delete', 'A Process deleted.', ['user_id' => $process]);

    }

    /**
     * Handle the Process "restored" event.
     */
    public function restored(Processe $process): void
    {
        ActivityLogger::log('Process restore', 'A Process restore.', ['user_id' =>$process]);

    }

    /**
     * Handle the Process "force deleted" event.
     */
    public function forceDeleted(Processe $process): void
    {
        ActivityLogger::log('Process delete', 'Process delete.', ['user_id' => $process]);

    }
}
