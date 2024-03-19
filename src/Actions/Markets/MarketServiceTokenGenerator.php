<?php
/**
 *  @author: $rachow
 *  @copyright: Coinhoppa
 */

namespace Coinhoppa\Actions\Markets;

use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;

class MarketServiceTokenGenerator
{
    public function __construct(protected $service){}

    public function handle(string $token)
    {
        $this->log('Attempting to generate token for ' . $this->service);
        return $token;
    }

    private function log($message)
    {
        Log::info($message);
    }
}