<?php

namespace App\Providers;

use App\Adapters\ViaCepAdapter;
use GuzzleHttp\Client;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind('via-cep', function () {
            return new ViaCepAdapter(new Client(
                [
                    'base_uri' => config('services.via-cep.url'),
                    'headers' => [
                        'Content-Type' => 'application/json',
                    ]
                ]
            ));
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        if (app()->isProduction()) {
            URL::forceScheme('https');
        }

        Model::unguard();
        Model::preventLazyLoading(!app()->isProduction());

        Paginator::useBootstrapFive();
    }
}
