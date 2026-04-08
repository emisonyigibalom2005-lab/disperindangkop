<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        Schema::defaultStringLength(191);

        // Fix pluralisasi bahasa Indonesia
        \Illuminate\Database\Eloquent\Relations\Relation::morphMap([]);
        
        \Illuminate\Support\Str::macro('pluralStudly', function ($value) {
            return $value;
        });
    }
}