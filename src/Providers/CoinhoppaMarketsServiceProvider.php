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
use Illuminate\Http\Client\PendingRequest;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;
use Coinhoppa\Services\Markets\CoinApiService;
use Coinhoppa\Services\Markets\CoinCapService;
use Coinhoppa\Services\Markets\CoinGeckoService;
use Coinhoppa\Services\Markets\CoinMarketCapService;
use Coinhoppa\Actions\Markets\MarketsServiceTokenGenerator;
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
        // todo: move configurations in database. 
        $this->app->singleton(CoinApiService::class, function ($app) {
            try
            {
                if (! $config = $app->make('config')->get('coinapi')) {
                    if (file_exists(__DIR__ . '/../../config/coinapi.php')) {
                            $config = include __DIR__ . '/../../config/coinapi.php';
                    } else {
                        throw new MarketsServiceConfigurationException('CoinApi Service has no configurations.');
                    }
                }
            } catch (MarketsServiceConfigurationException $e) {
                throw new MarketsServiceConfigurationException($e->getMessage());
            }
            
            $ssl = (file_exists(__DIR__ . '/../../cert/cacert.pem')) ?
                __DIR__ . '/../../cert/cacert.pem' : false;
             
            $debug = ($app->environment(['local', 'development'])) ? 
            fopen(storage_path('logs/app.log'), 'w+') : false;

            $client = Http::withOptions([
                'ssl_verify' => $ssl,
                'debug' => $debug,
                'timeout' => 10,
                'connect_timeout' => 2,
            ]);
           
            $client->withHeaders([
                'X-Coinhoppa-QRY' => $config['request_key'] ?? Str::uuid()->toString(),
                'X-CoinAPI-Key' => $config['api_token'] ?? '',
                'Accept' => 'application/json',
                'Content-Type' => 'application/json',
            ]);

            // retry for CoinApi and Token ?
            if ($token = $config['api_token']) {
                $client->withToken($token) // adding bearer authorization.
                    ->retry(2, 0, function ($exception, $request) use ($app, $token, $config) {
                    
                        if (! $exception instanceof RequestException || $exception->response->status() !== 401) {
                            return false;
                        }
                    
                        if (class_exists(MarketsServiceTokenGenerator::class)) {
                            $tokenGenerator = $app->makeWith(
                                MarketsServiceTokenGenerator::class, ['service' => CoinApiService::class]);
                            $token = $tokenGenerator->handle($token);
                        }
                    
                        $request->withToken($token); // we could log here.
                        return true;
                    });
            }
            
            $client->baseUrl($config->api_url . $config->api_version);
            return new CoinApiService($client);
        });

        $this->app->singleton(CoinCapService::class, function ($app) {

            if ($config = $app->make('config')->get('coincap')) {
                $config = collect($config);    
            } elseif (file_exists(__DIR__ . '/../../config/coincap.php')) {
                $config = collect((object) include __DIR__ . '/../../config/coincap.php');
            } else {
                throw new MarketsServiceConfigurationException('Coincap Service has no configurations.');
            }

            $ssl = (file_exists(__DIR__ . '/../../cert/cacert.pem')) ?
            __DIR__ . '/../../cert/cacert.pem' : false;

            $debug = ($app->environment(['local', 'development'])) ? 
            fopen(storage_path('logs/app.log'), 'w+') : false;

            $client = Http::withOptions([
                'ssl_verify' => $ssl,
                'debug' => $debug,
                'timeout' => 10,
                'connect_timeout' => 2,
            ]);

            $client->withHeaders([
                'X-Coinhoppa-QRY' => $config['request_key'] ?? Str::uuid()->toString(),
                'Accept' => 'application/json',
                'Content-Type' => 'application/json',
            ]);
            
            if ($token = $config['api_token']) {
                $client->withToken($token) // adding bearer authorization.
                ->retry(2, 0, function ($exception, $request) use ($app, $token, $config) {
                    
                    if (! $exception instanceof RequestException || $exception->response->status() !== 401) {
                        return false;
                    }
                    
                    if (class_exists(MarketsServiceTokenGenerator::class)) {
                        $tokenGenerator = $app->makeWith(
                            MarketsServiceTokenGenerator::class, ['service' => CoinCapService::class]);
                        $token = $tokenGenerator->handle($token);
                    }

                    $request->withToken($token); // we could log here.
                    return true;
                });
            }
            
            $client->baseUrl($config['api_url'] . $config['api_version']);
            return new CoinCapService($client);
        });
        
        $this->app->singleton(CoinGeckoService::class, function ($app) {
                if ($config = $app->make('config')->get('coingecko')) {
                    $config = collect($config);
                } elseif (file_exists(__DIR__ . '/../../config/coingecko.php')) {
                    $config = collect((object) include __DIR__ . '/../../config/coingecko.php');
                } else {
                    throw new MarketsServiceConfigurationException('CoinGecko Service has no configurations.');
                }

                $ssl = (file_exists(__DIR__ . '/../../cert/cacert.pem')) ?
                __DIR__ . '/../../cert/cacert.pem' : false;

                $debug = ($app->environment(['local', 'development'])) ? 
                fopen(storage_path('logs/app.log'), 'w+') : false;
                    
                $client = Http::withOptions([
                    'ssl_verify' => $ssl,
                    'debug' => $debug,
                    'timeout' => 10,
                    'connect_timeout' => 2,
                ]);

                $client->withHeaders([
                    'X-Coinhoppa-QRY' => $config['request_key'] ?? Str::uuid()->toString(),
                    'Accept' => 'application/json',
                    'Content-Type' => 'application/json',
                ]);
    
                if ($token = $config['api_token']) {
                    $client->withToken($token) // adding bearer authorization
                    ->retry(2, 0, function ($exception, $request) use ($app, $token, $config) {
                    
                        if (! $exception instanceof RequestException || $exception->response->status() !== 401) {
                            return false;
                        }
                        
                        if (class_exists(MarketsServiceTokenGenerator::class)) {
                            $tokenGenerator = $app->makeWith(
                                MarketsServiceTokenGenerator::class, ['service' => CoinGeckoService::class]);
                            $token = $tokenGenerator->handle($token);
                        }
    
                        $request->withToken($token); // we could log here.
                        return true;
                    });
                }

                $client->baseUrl($config['api_url'] . $config['api_version']);
                return new CoinGeckoService($client);
        });

        $this->app->singleton(CoinMarketCapService::class, function ($app) {
            if ($config = $app->make('config')->get('coinmarketcap')) {
                $config = collect($config);
            } elseif (file_exists(__DIR__ . '/../../config/coinmarketcap.php')) {
                $config = collect((object) include __DIR__ . '/../../config/coinmarketcap.php');
            } else {
                throw new MarketsServiceConfigurationException('CoinMarketCap Service has no configurations.');
            }

            $ssl = (file_exists(__DIR__ . '/../../cert/cacert.pem')) ?
            __DIR__ . '/../../cert/cacert.pem' : false;
        
            $client = Http::withOptions([
                'ssl_verify' => $ssl,
                'debug' => $debug,
                'timeout' => 10,
                'connect_timeout' => 2,
            ]);

            $client->withHeaders([
                'X-Coinhoppa-QRY' => $config['request_key'] ?? Str::uuid()->toString(),
                'Accept' => 'application/json',
                'Content-Type' => 'application/json',
            ]);

            if ($token = $config['api_token']) {
                $client->withToken($token) // adding bearer authorization.
                ->retry(2, 0, function ($exception, $request) use ($app, $token, $config) {
                    
                    if (! $exception instanceof RequestException || $exception->response->status() !== 401) {
                        return false;
                    }
                    
                    if (class_exists(MarketsServiceTokenGenerator::class)) {
                        $tokenGenerator = $app->makeWith(
                            MarketsServiceTokenGenerator::class, ['service' => CoinMarketCapService::class]);
                        $token = $tokenGenerator->handle($token);
                    }

                    $request->withToken($token); // we could log here.
                    return true;
                });
            }

            $client->baseUrl($config['api_url'] . $config['api_version']);
            return new CoinMarketCapService($client);
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
            CoinCapService::class,
            CoinApiService::class,
            CoinGeckoService::class,
            CoinMarketCapService::class,
        ];
    }
}