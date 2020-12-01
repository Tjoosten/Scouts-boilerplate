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
    }

    /**
     * Method for registering the base layout views in the application.
     *
     * @return void
     */
    private function registerLayoutComponents(): void
    {
        Blade::component('layouts.app', 'app-layout');
    }

    /**
     * method for registering the form related components in the application.
     *
     * @return void
     */
    private function registerFormComponents()
    {
        Blade::component('components.form', 'form');
        Blade::component('components.error', 'error');
    }
}
