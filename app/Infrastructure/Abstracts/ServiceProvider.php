<?php

declare(strict_types=1);

namespace App\Infrastructure\Abstracts;

use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider as LaravelServiceProvider;
use ReflectionClass;
use ReflectionException;

/**
 * Class ServiceProvider
 *
 * @package App\Infrastructure\Abstracts
 */
abstract class ServiceProvider extends LaravelServiceProvider
{
    /**
     * Alias for load translations and views.
     */
    protected string $alias;

    /**
     * Configuration flag vor loading commands.
     */
    protected bool $hasCommands = false;

    /**
     * Configuration flag for loading factories.
     */
    protected bool $hasFactories = false;

    /**
     * Configuration flag for loading migrations
     */
    protected bool $hasMigrations = false;

    /**
     * Configuration flag for loading translations
     */
    protected bool $hasTranslations = false;

    /**
     * Configuration flag for loading policies
     */
    protected bool $hasPolicies = false;

    /**
     * List of custom Artisan commands
     */
    protected array $commands = [];

    /**
     * List of model factories to load
     */
    protected array $factories = [];

    /**
     * List of providers to load
     */
    protected array $providers = [];

    /**
     * List of policies to load
     */
    protected array $policies = [];

    /**
     * Boot required registering of views and translations.
     *
     * @throws ReflectionException
     */
    public function boot(): void
    {
        $this->registerPolicies();
        $this->registerCommands();
        $this->registerFactories();
        $this->registerMigrations();
        $this->registerTranslations();
    }

    /**
     * Register the application's policies.
     */
    public function registerPolicies(): void
    {
        if ($this->hasPolicies && config('boilerplate.serviceprovider.policies', false)) {
            foreach ($this->policies as $key => $policy) {
                Gate::policy($key, $policy);
            }
        }
    }

    /**
     * Register domain custom artisan commands.
     */
    protected function registerCommands(): void
    {
        if ($this->hasCommands && config('boilerplate.serviceprovider.commands', false)) {
            $this->commands($this->commands);
        }
    }

    /**
     * Register domain specific migrations
     */
    protected function registerMigrations(): void
    {
        if ($this->hasMigrations && config('boilerplate.serviceprovider.migrations', false)) {
            $this->loadMigrationsFrom($this->domainPath('Database/Migrations'));
        }
    }

    /**
     * Register Model Factories.
     */
    protected function registerFactories()
    {
        if ($this->hasFactories && config('boilerplate.serviceprovider.factories', false)) {
            collect($this->factories)->each(fn($factoryName) => (new $factoryName())->define());
        }
    }

    /**
     * Register domain translations
     */
    protected function registerTranslations(): void
    {
        if ($this->hasTranslations && config('boilerplate.serviceprovider.translations', false)) {
            $this->loadJsonTranslationsFrom($this->domainPath('Resources/Lang'));
        }
    }

    /**
     * Register domain ServiceProviders
     */
    public function register(): void
    {
        collect($this->providers)->each(fn($providerClass) => $this->app->register($providerClass));
    }

    /**
     * Detects the domain base path so resources can be proper loaded on child classes.
     */
    protected function domainPath(string|null $append = null): string
    {
        $reflection = new ReflectionClass($this);
        $realPath = dirname($reflection->getFileName(), 2) . '/';

        if (! $append) {
            return $realPath;
        }

        return $realPath . '/' . $append;
    }
}
