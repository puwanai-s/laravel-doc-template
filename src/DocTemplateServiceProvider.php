<?php

namespace Ps\DocTemplate;

use Illuminate\Support\ServiceProvider;

class DocTemplateServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->singleton('doc-template', function ($app) {
            return new DocTemplate($app);
        });
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
