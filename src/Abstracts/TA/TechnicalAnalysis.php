<?php
/**
 *  @author: $rachow
 *  @copyright: Coinhoppa
 */

namespace Coinhoppa\Abstracts\TA;

use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Log;
use Symfony\Component\Process\Process;
use Symfony\Component\Process\Exception\ProcessFailedException;

abstract class TechnicalAnalysis
{
    /**
     * @var - holds the current data set (OHLCV).
     */
    protected $data;

    /**
     * @var - holds the available indicators.
     */
    protected array $indicators;

    /**
     * @var - mapping to TA CONSTANTS available through ext.
     */
    protected $movingAverageTypes = [
        'sma'   => TRADER_MA_TYPE_SMA,   // simple moving average
		'ema'   => TRADER_MA_TYPE_EMA,   // exponential moving average
		'wma'   => TRADER_MA_TYPE_WMA,   // weighted moving average
		'dema'  => TRADER_MA_TYPE_DEMA,  // double exponential moving average
		'tema'  => TRADER_MA_TYPE_TEMA,  // triple exponential moving average
		'trima' => TRADER_MA_TYPE_TRIMA, // triangular moving average
		'kama'  => TRADER_MA_TYPE_KAMA,  // kaufman's adaptive moving average
		'mama'  => TRADER_MA_TYPE_MAMA,  // the mother of adaptive moving average
		't3'	=> TRADER_MA_TYPE_T3,	 // the triple exponential moving average        
    ];

    /**
     * Grab the constant value for Moving Averages (MA)
     * 
     * @param  string $type
     * @return int
     */
    public function getMovingAverageTypes(string $type): int
    {
        if (Arr::exists($this->movingAverageTypes, \strtolower($type))) {
            return $this->getMovingAverageTypes[$type];
        }
        return 0;
    }

    /**
     * Collect all available indicator services for TA.
     * 
     * @param  none
     * @return array
     */
    public function getAvailableIndicators(): array
    {
        if (! empty($this->indicators)) {
            return $this->indicators;
        }
 
        $directory = __DIR__ . '/../../Services/TA';
        
        if (! is_dir($directory)) {
            throw new \Exception('There are no technical indicators.');
        }

        $indicators = [];
        if ($dh = \opendir($directory)) {
            while (false !== ($file = readdir($dh))) {
                if ($file == '.' || $file == '..' || is_dir($directory . '/' . $file)) {
                    continue;
                }
                $ext = \pathinfo($directory . '/' . $file, PATHINFO_EXTENSION);
                if (\strtolower($ext) != 'php') {
                    continue;
                }
                $indicators = Arr::add($indicators, preg_replace("/\.$ext$/", '', $file));        
            }
        } else {
            throw new \Exception('Could not traverse technical indicators.');
        }    

        return $this->indicators = $indicators;
    }
}