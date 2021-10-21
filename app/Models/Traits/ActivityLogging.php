<?php

namespace App\Models\Traits;

use App\Models\User;

trait ActivityLogging
{
   public function logActivity(string $logName, string $message): void
   {
        activity($logName)->causedBy($this)->log($message);
   }
}
