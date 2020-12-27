<?php

namespace App\Providers;

use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;

/**
 * Class BladeComponentServiceProvider
 *
 * @package App\Providers
 */
class BladeComponentServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot(): void
    {
        $this->registerLayoutComponents();
        $this->registerFormComponents();
        $this->registerUserComponents();
    }

    /**
     * Method for registering the base layout views in the application.
     *
     * @return void
     */
    private function registerLayoutComponents(): void
    {
        Blade::component('layouts.app', 'app-layout');
        Blade::component('layouts.kiosk', 'app-kiosk-layout');
        Blade::component('components.flashMessage', 'app-flash-message');
    }

    /**
     * Method for registering components that are related to the user section.
     *
     * @return void
     */
    private function registerUserComponents(): void
    {
        Blade::component('kiosk.users._sidenav', 'user-side-navigation');
        Blade::component('kiosk.users._statusLabel', 'user-status-label');

        // Two factor authentication components
        Blade::component('auth.settings._setup-2fa', 'setup-two-factor-authentication');
    }

    /**
     * method for registering the form related components in the application.
     *
     * @return void
     */
    private function registerFormComponents(): void
    {
        Blade::component('components.form', 'form');
        Blade::component('components.error', 'error');
    }
}
