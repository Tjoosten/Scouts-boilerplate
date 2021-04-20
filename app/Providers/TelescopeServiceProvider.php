<?php

namespace App\Providers;

use Illuminate\Http\Response;
use Illuminate\Support\Facades\Gate;
use Laravel\Telescope\EntryType;
use Laravel\Telescope\IncomingEntry;
use Laravel\Telescope\Telescope;
use Laravel\Telescope\TelescopeApplicationServiceProvider;

class TelescopeServiceProvider extends TelescopeApplicationServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        // Telescope::night();

        $this->hideSensitiveRequestDetails();
        $this->unwantedTrafficTracking();

        Telescope::filter(function (IncomingEntry $entry) {
            if ($this->app->environment('local')) {
                return true;
            }

            return $entry->isReportableException() ||
                   $entry->isFailedRequest() ||
                   $entry->isFailedJob() ||
                   $entry->isScheduledTask() ||
                   $entry->hasMonitoredTag();
        });
    }

    /**
     * Prevent sensitive request details from being logged by Telescope.
     */
    protected function hideSensitiveRequestDetails(): void
    {
        if ($this->app->environment('local')) {
            return;
        }

        Telescope::hideRequestParameters(['_token']);

        Telescope::hideRequestHeaders([
            'cookie',
            'x-csrf-token',
            'x-xsrf-token',
        ]);
    }

    /**
     * Register the Telescope gate.
     *
     * This gate determines who can access Telescope in non-local environments.
     */
    protected function gate(): void
    {
        Gate::define('viewTelescope', function ($user) {
            return in_array($user->email, [], true);
        });
    }

    /**
     * Track the unwanted traffic on the application.
     * Example: bots that try to access the .env files
     */
    protected function unwantedTrafficTracking(): void
    {
        Telescope::filter(static function (IncomingEntry $incomingEntry) {
            // Log all requests which are not successful
            if ($incomingEntry->type === EntryType::REQUEST) {
                return ! in_array($incomingEntry->content['response_status'], [200, 202, 204, 301, 302], true);
            }
        });

        Telescope::tag(static function (IncomingEntry $incomingEntry): array {
            if ($incomingEntry->type === EntryType::REQUEST) {
                return [
                    'status:' . $incomingEntry->content['response_status'],
                    'method:' . $incomingEntry->content['method'],
                ];
            }

            return [];
        });
    }
}
