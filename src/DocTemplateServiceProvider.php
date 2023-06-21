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
        $this->app->bind('doc-template', function () {
            return new DocTemplate;
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
