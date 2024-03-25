<?php
/**
 *  @author: $rachow
 *  @copyright: Coinhoppa
 *
 *  Allows us to register exchange services,
 *  and boot any logics.
 *
 */

namespace Coinhoppa\Providers;

use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\ServiceProvider;
use Illuminate\Contracts\Support\DeferrableProvider;

class CoinhoppaExchangeServiceProvider extends ServiceProvider implements DeferrableProvider
{
    /**
     * Register any application services.
     * 
     * @return void
     */
    public function register()
    {
        /**
         * register exchange service or even better
         * check for the requested exchange service exists and bind it.
         */
        $this->app->singleton(Coinbase::class);

    }

    /**
     * Bootstrap services.
     * 
     * @return void
     */
    public function boot()
    {

        // defining macro, for easy call to the HTTP facade.

        Http::macro('coinbase', function ($app) {
            // Http::coinbase()->get('/xyz');
            $api_key = config('coinbase.api_key');
            $api_version = config('coinbase.api_version');
            $ssl = __DIR__ . '/../../cert/cacert.pem';
            $ssl_verify = file_exists($ssl) ? $ssl : false;
            return Http::withOptions([
                    'ssl_verify' => $ssl_verify,
                    'debug' => App::environment(['local', 'development'])
                ])->withHeaders([
                    'Accept' => 'application/json',
                    'Content-Type' => 'application/json'
                ])->baseUrl(config('coinbase.api_url'));
        });

        // macro for binance
        Http::macro('binance', function ($app) {

        });

    }
}
