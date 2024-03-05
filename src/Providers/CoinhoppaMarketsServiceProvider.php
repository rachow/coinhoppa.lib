<?php
/**
 *  @author: $rachow
 *  @copyright: Coinhoppa
 * 
 *  Inject the market services to the IoC
 */

namespace Coinhoppa\Providers;

use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\ServiceProvider;
use Illuminate\Contracts\Support\DeferrableProvider;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;
use App\Services\Markets\CoinCap;
use App\Services\Markets\CoinGecko;
use App\Services\Markets\CoinMarketCap;
use Coinhoppa\Exceptions\Markets\MarketsServiceConfigurationException;

class CoinhoppaMarketsServiceProvider extends ServiceProvider implements DeferrableProvider
{
    /**
     * Register any application services.
     * 
     * @return void
     */
    public function register(): void
    {
        $this->app->singleton(CoinCap::class, function ($app) {
            if ($config = config('coincap')) {
                $config = collect($config);    
            } elseif (file_exists(__DIR__ . '/../../config/coincap.php')) {
                $config = collect((object) include __DIR__ . '/../../config/coincap.php');
            } else {
                throw new MarketsServiceConfigurationException('Coincap Service has no configurations.');
            }

            $ssl = (file_exists(__DIR__ . '/../../cert/cacert.pem')) ?
            __DIR__ . '/../../cert/cacert.pem' : false;

            $client = new Http();
            $client->withOptions([
                'ssl_verify' => $ssl,
                'debug' => App::environment(['local', 'development']),
            ]);
            $client->withHeaders([
                'X-Coinhoppa-QRY' => $config->request_key ?? Str::uuid()->toString(),
                'Accept' => 'application/json',
                'Content-Type' => 'application/json',
            ]);

            $client->baseUrl($config[0]->api_url . $config[0]->api_version);

            return new Coincap($client);
        });
        
        $this->app->singleton(CoinGecko::class, function ($app) {
                if ($config = config('coingecko')) {
                    $config = collect($config);
                } elseif (file_exists(__DIR__ . '/../../config/coingecko.php')) {
                    $config = collect((object) include __DIR__ . '/../../config/coingecko.php');
                } else {
                    throw new MarketsServiceConfigurationException('CoinGecko Service has no configurations.');
                }

                $ssl = (file_exists(__DIR__ . '/../../cert/cacert.pem')) ?
                __DIR__ . '/../../cert/cacert.pem' : false;
    
                $client = new Http();
                $client->withOptions([
                    'ssl_verify' => $ssl,
                    'debug' => App::environment(['local', 'development']),
                ]);
                $client->withHeaders([
                    'X-Coinhoppa-QRY' => $config->request_key ?? Str::uuid()->toString(),
                    'Accept' => 'application/json',
                    'Content-Type' => 'application/json',
                ]);
    
                $client->baseUrl($config[0]->api_url . $config[0]->api_version);
    
                return new CoinGecko($client);
        });

        $this->app->singleton(CoinMarketCap::class, function ($app) {
            if ($config = config('coinmarketcap')) {
                $config = collect($config);
            } elseif (file_exists(__DIR__ . '/../../config/coinmarketcap.php')) {
                $config = collect((object) include __DIR__ . '/../../config/coinmarketcap.php');
            } else {
                throw new MarketsServiceConfigurationException('CoinMarketCap Service has no configurations.');
            }

            $ssl = (file_exists(__DIR__ . '/../../cert/cacert.pem')) ?
            __DIR__ . '/../../cert/cacert.pem' : false;

            $client = new Http();
            $client->withOptions([
                'ssl_verify' => $ssl,
                'debug' => App::environment(['local', 'development']),
            ]);
            $client->withHeaders([
                'X-Coinhoppa-QRY' => $config->request_key ?? Str::uuid()->toString(),
                'Accept' => 'application/json',
                'Content-Type' => 'application/json',
            ]);

            $client->baseUrl($config[0]->api_url . $config[0]->api_version);

            return new CoinMarketCap($client);
        });
    }

    /**
     * Get the services provided by the provider.
     * 
     * @return array
     */
    public function provides(): array
    {
        return [
            Coincap::class,
            CoinGecko::class,
            CoinMarketCap::class,
        ];
    }
}
