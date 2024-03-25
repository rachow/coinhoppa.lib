<?php
/**
 *  @author: $rachow
 *  @copyright: Coinhoppa 
 */

namespace Coinhoppa\Contracts\TA;

interface TechnicalAnalysisInterface
{
    /**
     * Runs the technical analysis based on the algorithm.
     * 
     * @param $pair - trading pair
     * @param $data - OHLCV data or fetch from cache pool
     * 
     */
    public function run($pair = 'BTC/USD', $data = null);
}