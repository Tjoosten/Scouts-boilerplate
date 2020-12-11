<?php

namespace App\Models\Traits;

use App\Models\User;

/**
 * Trait ActivityLogging
 *
 * @package Traits\Logging
 */
trait ActivityLogging
{
    /**
     * Method for logging activities and handling's in the application.
     *
     * @param  string $logName The log category that is attached to the log message.
     * @param  string $message The actual log message that needs to be stored.
     * @return void
     */
   public function logActivity(string $logName, string $message): void
   {
        activity($logName)->causedBy($this)->log($message);
   }
}
