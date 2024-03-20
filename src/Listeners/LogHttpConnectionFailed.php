<?php
/**
 *  @author: $rachow
 *  @copyright: Coinhoppa 
 */

namespace Coinhoppa\Listeners;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Client\Events\ConnectionFailed;

class LogHttpConnectionFailed
{
    public function handle(ConnectionFailed $event): void
    {
        $headers = collect($event->request->headers())->map(function ($item, $key) {
            return $item[0]; 
         })->sort()->toArray();
         
         $context = [
             'url' => (string) $event->request->url(),
             'headers' => $headers,
         ];

        Log::error('HTTP Connection has failed.', $context);
    }
}