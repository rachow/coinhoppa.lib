<?php
/**
 *  @author: $rachow
 *  @copyright: Coinhoppa
 */

namespace Coinhoppa\Providers;

use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;
use Coinhoppa\Observers\TraderObserver;
use Coinhoppa\Models\Trader;

class CoinhoppaEventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [

    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();

        // listening to event
        Trader::observe(TraderObserver::class);
    }
}
