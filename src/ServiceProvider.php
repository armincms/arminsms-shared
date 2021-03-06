<?php

namespace Armincms\ArminsmsShared;

use Illuminate\Support\ServiceProvider as LaravelServiceProvider; 
use Laravel\Nova\Nova;

class ServiceProvider extends LaravelServiceProvider 
{ 
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        Nova::resources([
            ArminsmsShared::class
        ]);

        $this->app->afterResolving('qasedak', function($manager) {
            $manager->extend('armin-sms-shared', function() use ($manager) {
                return $manager->repository(new SahredService(
                    (array) $this->config->get('armin-sms-shared')
                ));
            });
        });
    }
}
