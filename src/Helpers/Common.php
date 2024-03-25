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
    /**
	 * Grab the user agent string.
	 * 
	 * @param none
	 */
    public static function fetchUserAgent(): string
    {
        $agents = [
            "Mozilla/5.0 (Windows; U; Windows NT 5.1; en-GB; rv:1.8.1.6) Gecko/20070725 Firefox/2.0.0.6",
        ];
        return $agents[0];
    }

    /**
	 * Grab the database native date formats.
	 * 
	 * @var $dateTimeStr
	 */
    public static function fetchDateTimeParts($dateTimeStr): string
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

	/**
	 * Grab the phone number based on the E.164 standards for storing.
	 * 
	 * @var $countryCode = ISO 3166-1 (alpha-2)
	 */
    public static function getE164PhoneNumber($phone, $countryCode = 'GB')
    {
        try {
            $phone = \Propaganistas\LaravelPhone\PhoneNumber::make($phone, $country_code)->formatE164();
		    return $phone;
		} catch(Exception $e) {
		    return $phone;
		}
    }

	/**
	 * Not used, but LUA will be used for Redis comms.
	 * 
	 * @param none
	 */
	public static function releaseLock()
	{
		$args = func_get_args();
		return <<<RELEASE_LUA
			if redis.call("get",KEYS[1]) == $args[1] then
				return redis.call("del",KEYS[1])
			else
				return 0
			end
RELEASE_LUA;
	}

	/**
	 * Build the URL or URI with provided params.
	 * 
	 * @param $url
	 * @param $params
	 */
	public static function buildQuery($url, array $params): string
	{
        if (! preg_match("/^[a-zA-Z]+:\/\//", $url)) {
            if (preg_match("/\?/", $url)) {
                list($uri, $query) = explode('?', $url);
                if (! empty($query)) {
                    parse_str($query, $queryParams);
                    $params = array_merge($queryParams, $params);
                    $url = rtrim($uri, '/');
                }
            }
            
            return sprintf('%s/?%s', $url, http_build_query($params));

        } else {
            
            $queryParams = [];
		    $urlParsed = parse_url($url);
		    parse_str(array_key_exists('query', $urlParsed) ? $urlParsed['query'] : '', $queryParams);
		    $queryParams = array_merge($queryParams, $params);
		    return sprintf('%s://%s%s/?%s',
			    $urlParsed['scheme'],
			    $urlParsed['host'],
			    $urlParsed['path'],
			    http_build_query($queryParams)
		    );
	    }
	}
}