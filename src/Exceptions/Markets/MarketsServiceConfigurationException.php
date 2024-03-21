<?php
/**
 *  @author: $rachow
 *  @copyright: Coinhoppa
 * 
 */

namespace Coinhoppa\Exceptions\Markets;

use Exception;
use Illuminate\Support\Facades\Log;

class MarketsServiceConfigurationException extends Exception
{
    public function __construct()
    {
        parent::__construct();
    }

    public function report()
    {
        // push to flare, slack, logging service (ELK)
        Log::error($this->getMessage());
    }
}
