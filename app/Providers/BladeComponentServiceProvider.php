<?php

namespace App\Providers;

use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;

class BladeComponentServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        $this->registerLayoutComponents();
        $this->registerFormComponents();
        $this->registerUserComponents();
    }

    private function registerLayoutComponents(): void
    {
        Blade::component('layouts.app', 'app-layout');
        Blade::component('layouts.kiosk', 'app-kiosk-layout');
        Blade::component('components.flashMessage', 'app-flash-message');
    }

    private function registerUserComponents(): void
    {
        Blade::component('kiosk.users._sidenav', 'user-side-navigation');
        Blade::component('kiosk.users._statusLabel', 'user-status-label');
    }

    private function registerFormComponents(): void
    {
        Blade::component('components.form', 'form');
        Blade::component('components.error', 'error');
    }
}
