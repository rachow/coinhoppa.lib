<?php
/**
 *  @author: $rachow
 *  @copyright: Coinhoppa
 */

namespace Coinhoppa\Providers;

use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Http;
use Coinhoppa\Services\KlineService;
use Illuminate\Support\ServiceProvider;
use Coinhoppa\Exceptions\KlineServiceException;
use Illuminate\Contracts\Support\DeferrableProvider;

class CoinhoppKlineServiceProvider extends ServiceProvider implements DeferrableProvider
{
    /**
     * Register any application services.
     * 
     * @return void 
    */
    public function register()
    {
        $this->app->singleton(KlineService::class, function ($app) {
            try {
                if (! $config = $app->make()->get('kline')) {
                    if (file_exists(__DIR__ . '/../../config/kline.php')) {
                        $config = include __DIR__ . '/../../config/kline.php';
                    } else {
                        throw new KlineServiceException('Kline Service has no configurations.');
                    }
                }
            } catch (KlineServiceException $e) {
                throw new KlineServiceException($e->getMessage());
            }

            // -> port binding e.g. 0.0.0.0:9898 [reverse proxy]
            // -> DNS mapping /etc/hosts
            
            $forceHttps = false;

            $ssl = ($forceHttps && file_exists(__DIR__ . '/../../cert/cacert.pem')) ? 
                __DIR__ . '/../../cert/cacert.pem' : false;
     
            // to force debugging.
            $forceDebug = false;

            // Guzzle will need to close the resource.
            $debug = ( (bool) $forceDebug || $app->environment(['local', 'development'])) ? 
                fopen(storage_path('logs/app.log')) : false;

            $client = Http::withOptions([
                'ssl_verify' => $ssl,
                'debug' => $debug,
                'timeout' => 10,
                'connect_timeout' => 2,
            ]);

            // service will need a valid AppId

            $client->withHeaders([
                'X-Coinhoppa-AppId' => ($config['app_id']) ?? Str::uuid()->toString(),
                'Content-Type' => 'application/json',
                'Accept' => 'application/json',
                'X-Coinhoppa-Token' => $config['api_token'] ?: '',
            ]);
            
            if ($token = $config['api_token']) {
                $client->withToken($token);
                // no retry attempts needed ?
            }
        
            $client->baseUrl($config['api_url'] . $config['api_version']);
            return new KlineService($client);
        });
    }

    public function provides(): array
    {
        return [
            KlineService::class
        ];
    }
}