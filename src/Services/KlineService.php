<?php
/**
 *  @author: $rachow
 *  @copyright: Coinhoppa
 */

use Carbon\Carbon;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Coinhoppa\Helpers\Common;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Client\Response;
use Illuminate\Http\Client\PendingRequest;
use Illuminate\Http\Client\ConnectionException;
use Illuminate\Http\Client\RequestException;

class KlineService
{
    /**
     * @var \Illuminate\Http\Client\Response
     */
    protected $response;

    /**
     * Creates an instance.
     * 
     * @param  \Illuminate\Http\Client\PendingRequest
     * @return void
     */
    public function __construct(
        protected PendingRequest $client,
        private $logger = null
    )
    {
        $this->logger = $logger ?? fopen('php://stderr', 'w');
    }

    /**
     * Grab the candlestick data from service.
     * 
     * @param $pair - trading
     * @param $intval - interval
     * @param $options - optional
     */
    public function candle(string $pair = 'BTC/USD', string $intval = '5m', array $options = [])
    {
        if (!Arr::exists(['5m', '10m', '15m'], $intval)) {
            $intval = '5m';
        }
        $page = 1;
        $params = [
            'pair' => $pair,
            'intval' => $intval
        ];

        if (Arr::exists($options, 'exchange')) {
            $params = Arr::add($params, 'exchange', $options['exchange']);
        }
        
        try {
            
            $this->response = $this->client->get(Common::buildQuery('kline/' . $page, $params)); 
            $this->response->onError(function (Response $response) {
                //
            });

        } catch (Illuminate\Http\Client\ConnectionException $e) {
            
        } catch (Illuminate\Http\Client\RequestException $ee) {
        
        }

        return $this->response;
    }

    /**
     * Write to the logging stream service.
     * or you can print to STDERR and enable
     * AWS Cloudwatch to trace.
     * 
     * @param  $messsage
     * @return void
     */
    private function log($message)
    {
        if (is_resource($this->logger)) {
            fwrite($this->logger, $message);           
        }
    }
}