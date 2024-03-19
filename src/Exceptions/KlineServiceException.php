<?php
/**
 *  @author: $rachow
 *  @copyright: Coinhoppa
 */

namespace Coinhoppa\Exceptions;

use Exception;
use Illuminate\Support\Facades\Log;

class KlineServiceException extends Exception
{
    public function report()
    {
        Log::error($this->getMessage());
    }
}