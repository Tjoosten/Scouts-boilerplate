<?php

namespace App\Models\Traits;

trait KioskMethods
{
    public function hasKioskRoles(): bool
    {
        return $this->hasRole(['administrator', 'webmaster']);
    }

    public function canAccessKiosk(): bool
    {
       return $this->hasKioskRoles() && $this->isNotOnKiosk();
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
