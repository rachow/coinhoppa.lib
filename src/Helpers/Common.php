<?php
/**
 *  @author: $rachow
 *  @copyright: Coinhoppa 
 */

namespace Coinhoppa\Helpers;

use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class Common
{
    // get user agenst string
    public static function fetchUserAgent()
    {
        $agents = [
            "Mozilla/5.0 (Windows; U; Windows NT 5.1; en-GB; rv:1.8.1.6) Gecko/20070725 Firefox/2.0.0.6",
        ];
        return $agents[0];
    }

    // grab the database neutral format for dates.
    public static function fetchDateTimeParts($dateTimeStr)
    {
		if ($dateTimeStr == '' || $dateTimeStr == null) {
			return '';
		}

		$formatted = '';

		// dd/mm/yyyy
		if (preg_match("/(\d){2}\/(\d){2}\/(\d){4}/", $dateTimeStr)) {
			$parts = explode("/", $dateTimeStr);
			$formatted = $parts[2] . '-' . $parts[1] . '-' . $parts[0];
			return $formatted;
		}
	
		// dd/mm/yyyy H:i
		if (preg_match("/(\d){2}\/(\d){2}\/(\d){4}\s(\d){2}:(\d){2}/", $dateTimeStr)) {
			list($dateParts, $timeParts) = explode(" ", $dateTimeStr);
			$parts = explode("/", $dateParts);
			$formatted  = $parts[2] . '-' . $parts[1] . '-' . $parts[0];
			$formatted .= ' ' . $timeParts . ':00';
			return $formatted;
		}

		// dd-mm-yyyy
		if (preg_match("/(\d){2}\-(\d){2}\-(\d){4}/", $dateTimeStr)) {
			$parts = explode("-", $dateTimeStr);
			$formatted = $parts[2] . '-' . $parts[1] . '-' . $parts[0];
			return $formatted;
		}

		// dd-mm-yyyy H:i
		if (preg_match("/(\d){2}\-(\d){2}\-(\d){4}\s(\d){2}:(\d){2}/", $dateTimeStr)) {
			list($dateParts, $timeParts) = explode(" ", $dateTimeStr);
			$parts = explode("-", $dateParts);
			$formatted = $parts[2] . '-' . $parts[1] . '-' . $parts[0];
			$formatted .= ' ' . $timeParts . ':00';
			return $formatted;
		}

        return $dateTimeStr;
    }

    // get phone based on E.164 standards for storing.
    // @var $countryCode ISO 3166-1 (alpha-2)
    public static function getE164PhoneNumber($phone, $countryCode = 'GB')
    {
        try {
            $phone = \Propaganistas\LaravelPhone\PhoneNumber::make($phone, $country_code)->formatE164();
		    return $phone;
		} catch(Exception $e) {
		    return $phone;
		}
    }
}
