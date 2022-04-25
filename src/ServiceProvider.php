<?php

namespace Wdelfuego\Nova\DateTime;

use DateTimeInterface;
use Illuminate\Support\ServiceProvider as BaseServiceProvider;
use Laravel\Nova\Fields as NovaFields;
use Wdelfuego\Nova\DateTime\Fields\DateTime;

class ServiceProvider extends BaseServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->mergeConfigFrom(
            __DIR__.'/../config/nova-datetime.php', 'nova-datetime'
        );
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        // Publish config
        $this->publishes([
            __DIR__.'/../config/nova-datetime.php' => config_path('nova-datetime.php'),
        ]);
        
        // Add the withDateFormat macro to normal DateFields
        NovaFields\DateTime::macro('withDateFormat', function (string $format) {
            return $this->displayUsing(fn ($d) => ($d instanceof DateTimeInterface) ? $d->format($format) : '');
        });
        
        // Set the global datetime format for our own DateFields from config
        DateTime::setGlobalFormat(config('nova-datetime.globalFormat'));
    }
}
