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
     * Determine if the user has one of the needed roles for accessing the kiosk.
     *
     * @return bool
     */
    public function hasKioskRoles(): bool
    {
        return $this->hasRole(['administrator', 'webmaster']);
    }

    /**
     * Determine whether the authenticated user can access the kiosk or not.
     *
     * @return bool
     */
    public function canAccessKiosk(): bool
    {
       return $this->hasKioskRoles() && $this->isNotOnKiosk();
    }

    /**
     * Determine whether the authenticated user is on the kiosk section.
     *
     * @return bool
     */
    public function isOnKiosk(): bool
    {
        return is_active('kiosk*');
    }

    /**
     * Determine if the authenticated used is not on the kiosk section.
     *
     * @return bool
     */
    public function isNotOnKiosk(): bool
    {
        return ! $this->isOnKiosk();
    }
}
