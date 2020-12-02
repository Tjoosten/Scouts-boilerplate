<?php

namespace App\Models\Traits;

/**
 * Trait KioskMethods
 *
 * @package App\Models\Traits
 */
trait KioskMethods
{
    /**
     * Determine whether the authenticated user can access the kiosk or not.
     *
     * @return bool
     */
    public function canAccesskiosk(): bool
    {
       return $this->hasRole(['administrator', 'webmaster']);
    }

    public function isOnKiosk(): bool
    {
        return is_active('kiosk*');
    }

    public function isNotOnKiosk(): bool
    {
        return ! $this->isOnKiosk();
    }
}
