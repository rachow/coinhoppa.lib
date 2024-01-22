<?php
/**
 *  @author: $rachow
 *  @copyright: Coinhoppa
 */

namespace Coinhoppa\Observers;

use Coinhoppa\Models\Trader;

class TraderObserver 
{
    /**
     * Handles the new trader account created.
     *
     * @param  \Coinhoppa\Models\Trader
     * @return void
     */
    public function created(Trader $trader)
    {
        // push events to emailer or store to database ?
    }

    /*
     * Handles the updated event of the ORM for trader account.
     *
     * @param  \Coinhoppa\Models\Trader
     * @return void
     */
    public function updated(Trader $trader)
    {
        // some data updated.
    }

    /**
     * Handles the account delete request.
     *
     * @param  \Coinhoppa\Models\Trader
     * @return void
     */
    public function deleted(Trader $trader)
    {
        // deleted account, send notification, store storable
        // for limited period.
    }
}
