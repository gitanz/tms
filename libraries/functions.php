<?php
	/**
	 * This is the Functions File
	 *
	 * @package admin-login
	 * @author Jay Gaha
	 * @link http://jaygaha.com.np
	 * @date 13th Dec 2013
	 */
	 
	/**
	 * Return an array of timezones
	 * 
	 * @return array
	 */

	function timezoneList() {
	    $timezoneIdentifiers = DateTimeZone::listIdentifiers();
    	$utcTime = new DateTime('now', new DateTimeZone('UTC'));

	    $tempTimezones = array();
    	foreach ($timezoneIdentifiers as $timezoneIdentifier) :
        	$currentTimezone = new DateTimeZone($timezoneIdentifier);

	        $tempTimezones[] = array(
    	        'offset' => (int)$currentTimezone->getOffset($utcTime),
        	    'identifier' => $timezoneIdentifier
	        );
    	endforeach;

	    // Sort the array by offset,identifier ascending
    	usort($tempTimezones, function($a, $b) {
			return ($a['offset'] == $b['offset']) ? strcmp($a['identifier'], $b['identifier']) : $a['offset'] - $b['offset'];
	    });

		$timezoneList = array();
	    foreach ($tempTimezones as $tz) :
			$sign = ($tz['offset'] > 0) ? '+' : '-';
			$offset = gmdate('H:i', abs($tz['offset']));
	        $timezoneList[$tz['identifier']] = '(UTC ' . $sign . $offset . ') ' . $tz['identifier'];
	    endforeach;

	    return $timezoneList;
	}
	function getCountryList(){
		$country_list = array(
		"Afghanistan",
		"Albania",
		"Algeria",
		"Andorra",
		"Angola",
		"Antigua and Barbuda",
		"Argentina",
		"Armenia",
		"Australia",
		"Austria",
		"Azerbaijan",
		"Bahamas",
		"Bahrain",
		"Bangladesh",
		"Barbados",
		"Belarus",
		"Belgium",
		"Belize",
		"Benin",
		"Bhutan",
		"Bolivia",
		"Bosnia and Herzegovina",
		"Botswana",
		"Brazil",
		"Brunei",
		"Bulgaria",
		"Burkina Faso",
		"Burundi",
		"Cambodia",
		"Cameroon",
		"Canada",
		"Cape Verde",
		"Central African Republic",
		"Chad",
		"Chile",
		"China",
		"Colombi",
		"Comoros",
		"Congo (Brazzaville)",
		"Congo",
		"Costa Rica",
		"Cote d'Ivoire",
		"Croatia",
		"Cuba",
		"Cyprus",
		"Czech Republic",
		"Denmark",
		"Djibouti",
		"Dominica",
		"Dominican Republic",
		"East Timor (Timor Timur)",
		"Ecuador",
		"Egypt",
		"El Salvador",
		"Equatorial Guinea",
		"Eritrea",
		"Estonia",
		"Ethiopia",
		"Fiji",
		"Finland",
		"France",
		"Gabon",
		"Gambia, The",
		"Georgia",
		"Germany",
		"Ghana",
		"Greece",
		"Grenada",
		"Guatemala",
		"Guinea",
		"Guinea-Bissau",
		"Guyana",
		"Haiti",
		"Honduras",
		"Hungary",
		"Iceland",
		"India",
		"Indonesia",
		"Iran",
		"Iraq",
		"Ireland",
		"Israel",
		"Italy",
		"Jamaica",
		"Japan",
		"Jordan",
		"Kazakhstan",
		"Kenya",
		"Kiribati",
		"Korea, North",
		"Korea, South",
		"Kuwait",
		"Kyrgyzstan",
		"Laos",
		"Latvia",
		"Lebanon",
		"Lesotho",
		"Liberia",
		"Libya",
		"Liechtenstein",
		"Lithuania",
		"Luxembourg",
		"Macedonia",
		"Madagascar",
		"Malawi",
		"Malaysia",
		"Maldives",
		"Mali",
		"Malta",
		"Marshall Islands",
		"Mauritania",
		"Mauritius",
		"Mexico",
		"Micronesia",
		"Moldova",
		"Monaco",
		"Mongolia",
		"Morocco",
		"Mozambique",
		"Myanmar",
		"Namibia",
		"Nauru",
		"Nepal",
		"Netherlands",
		"New Zealand",
		"Nicaragua",
		"Niger",
		"Nigeria",
		"Norway",
		"Oman",
		"Pakistan",
		"Palau",
		"Panama",
		"Papua New Guinea",
		"Paraguay",
		"Peru",
		"Philippines",
		"Poland",
		"Portugal",
		"Qatar",
		"Romania",
		"Russia",
		"Rwanda",
		"Saint Kitts and Nevis",
		"Saint Lucia",
		"Saint Vincent",
		"Samoa",
		"San Marino",
		"Sao Tome and Principe",
		"Saudi Arabia",
		"Senegal",
		"Serbia and Montenegro",
		"Seychelles",
		"Sierra Leone",
		"Singapore",
		"Slovakia",
		"Slovenia",
		"Solomon Islands",
		"Somalia",
		"South Africa",
		"Spain",
		"Sri Lanka",
		"Sudan",
		"Suriname",
		"Swaziland",
		"Sweden",
		"Switzerland",
		"Syria",
		"Taiwan",
		"Tajikistan",
		"Tanzania",
		"Thailand",
		"Togo",
		"Tonga",
		"Trinidad and Tobago",
		"Tunisia",
		"Turkey",
		"Turkmenistan",
		"Tuvalu",
		"Uganda",
		"Ukraine",
		"United Arab Emirates",
		"United Kingdom",
		"United States",
		"Uruguay",
		"Uzbekistan",
		"Vanuatu",
		"Vatican City",
		"Venezuela",
		"Vietnam",
		"Yemen",
		"Zambia",
		"Zimbabwe"
	);
	return $country_list;
	}
	
	function getUserIP() {
	    $client  = @$_SERVER['HTTP_CLIENT_IP'];
    	$forward = @$_SERVER['HTTP_X_FORWARDED_FOR'];
	    $remote  = $_SERVER['REMOTE_ADDR'];

    	if(filter_var($client, FILTER_VALIDATE_IP))
	        $ip = $client;    	
	    elseif(filter_var($forward, FILTER_VALIDATE_IP))    	
	        $ip = $forward;
    	
	    else    
	        $ip = $remote;    

    	return $ip;
	}
	function mfdate($var = DATETIME){
		return date ( 'l. F j. Y', $var );
	}
	
	function randomkeys( $length = 10 ) {
 	   $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    	$randomString = '';
	    for ($i = 0; $i < $length; $i++) {
    	    $randomString .= $characters[rand(0, strlen($characters) - 1)];
	    }
    	return $randomString;
	}

	function dd($var = "here"){
		var_dump($var);
		exit;
	}
	/* Retrieve the video ID from a YouTube video URL
	* @param $ytURL The full YouTube URL from which the ID will be extracted
	* @return $ytvID The YouTube video ID string
	*/
	function getYTid($ytURL) { 
		$ytvIDlen = 11; // This is the length of YouTube's video IDs
 
		// The ID string starts after "v=", which is usually right after
		// "youtube.com/watch?" in the URL
		$idStarts = strpos($ytURL, "?v=");
 
		// In case the "v=" is NOT right after the "?" (not likely, but I like to keep my
		// bases covered), it will be after an "&":
		if($idStarts === FALSE)
			$idStarts = strpos($ytURL, "&v=");
		// If still FALSE, URL doesn't have a vid ID
		//if($idStarts === FALSE)
			//echo "YouTube video ID not found. Please double-check your URL.";
 
		// Offset the start location to match the beginning of the ID string
		$idStarts +=3;
 
		// Get the ID string and return it
		$ytvID = substr($ytURL, $idStarts, $ytvIDlen);
 
		return $ytvID; 
	}	
	function starts_with($needle,$haystack){
		$len = strlen(trim($needle));
		if(substr($haystack, 0, $len) == $needle)
			return true;
		else
			return false;
	}