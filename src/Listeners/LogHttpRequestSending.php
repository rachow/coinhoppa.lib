<?php
/**
 *  @author: $rachow
 *  @copyright: Coinhoppa 
 */

namespace Coinhoppa\Listeners;

use Illuminate\Support\Facades\Log;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Http\Client\Events\RequestSending;

class LogHttpRequestSending
{
    public function handle(RequestSending $event): void
    {
        if (app()->environment(['local', 'development'])) {
            $headers = collect($event->request->headers())->map(function ($item, $key) {
                return $item[0]; 
             })->sort()->toArray();
             
             $context = [
                 'url' => (string) $event->request->url(),
                 'headers' => $headers,
             ];

             Log::debug('HTTP Request being sent.', $context); 
        }
    }
}