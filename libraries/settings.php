<?php
	/**
	 * Sets up Site vars and included files
	 *
	 * @package admin-login
	 * @author Jay Gaha
	 * @link http://jaygaha.com.np
	 * @date 11th Dec 2013
	 */
	 
	 /** Sets up Site non-db functions. */
	require_once('functions.php');
	 
	 // load the setting class
	require_once('classes/SiteSetting.php');
	$site = new SiteSetting();

	/**
 	 * Configuration for: Site Name
 	 */
	define('SITE_NAME', $site->get_varibales('site_name'));
	
	/**
 	 * Configuration for: Base URL
 	 */
	define('SITE_URL', $site->get_varibales('site_url'));
	//define('SITE_URL',"http://".$_SERVER['HTTP_HOST']."/");
	
	/**
 	 * Configuration for: Site Offline
 	 */
	define('SITE_OFFLINE', $site->get_varibales('site_offline'));
	define('SITE_OFFLINE_MSG', $site->get_varibales('site_offlinemsg'));
	
	/**
 	 * Configuration for: Site Phone
 	 */
	define('SITE_PHONE', $site->get_varibales('site_phone'));
	
	/**
 	 * Configuration for: Admin URL
 	 */
	define('ADMIN_URL', SITE_URL."/myadmin");
	
	/**
 	 * Configuration for: SITE EMAIL
 	 */
	define('SITE_EMAIL', $site->get_varibales('site_email'));
	
	/**
 	 * Configuration for: Site Timezone
 	 */	 
	$timestamp = time(); // timestamp to convert	
	$tz = $site->get_varibales('site_timezone');  // set this to the time zone provided by the user
	$dtzone = new DateTimeZone($tz); // create the DateTimeZone object for later
	$time = date('r', $timestamp); // first convert the timestamp into a string representing the local time
	$dtime = new DateTime($time);  // now create the DateTime object for this time
	$dtime->setTimeZone($dtzone); // convert this to the user's timezone using the DateTimeZone object
	$dtime->setTimestamp($timestamp);
	$dtime->format('U');
	$time_stamp = $dtime->format('U');
	/**
 	 * Configuration for: System Date & Time
 	 */
	define('DATETIME', $time_stamp);
	
	/**
 	 * Configuration for: System MAX upload size
 	 */
	define('MAX_SIZE', $site->get_varibales('site_max_upload'));
	/**
 	 * Configuration for: System Image Thumb
 	 */
	define('IMG_HEIGHT', 150);
	define('IMG_WIDTH', 150);
	/**
 	 * Configuration for: Pagination Per Page
 	 */
	define('PER_PAGE', $site->get_varibales('site_list_limit'));
	
	/**
 	 * Configuration for: ORDER BY
 	 */
	define('ORDER_MENU', $site->get_varibales('site_menu_order'));
	define('ORDER_MENU_BY', $site->get_varibales('site_menu_orderby'));
	define('ORDER_PAGE', $site->get_varibales('site_page_order'));
	define('ORDER_PAGE_BY', $site->get_varibales('site_page_orderby'));
	define('ORDER_BANNER', $site->get_varibales('site_banner_order'));
	define('ORDER_BANNER_BY', $site->get_varibales('site_banner_orderby'));
	
	/**
 	 * Configuration for: Social Icons
 	 */
	define('SOCIAL_TITLE', $site->get_varibales('site_social_title'));
	define('SOCIAL_LINKS', $site->get_varibales('site_social_links'));
	define('SOCIAL_ICONS', $site->get_varibales('site_social_icons'));
	/**
 	 * Configuration for: Association Icons
 	 */
	define('ASSOC_TITLE', $site->get_varibales('site_assoc_title'));
	define('ASSOC_LINKS', $site->get_varibales('site_assoc_links'));
	define('ASSOC_ICONS', $site->get_varibales('site_assoc_icons'));
	/**
 	 * Configuration for: Site Meta Tags
 	 */
	define('SITE_TITLE', $site->get_varibales('site_title'));
	define('SITE_KEYWORDS', $site->get_varibales('site_meta_keywords'));
	define('SITE_DESCRIPTION', $site->get_varibales('site_meta_description'));
	define('SITE_COPYRIGHT', $site->get_varibales('site_copyright'));


	$districts_list = array(
			'Achham',
			'Arghakhanchi',
			'Baglung',
			'Baitadi',
			'Bajhang',
			'Bajura',
			'Banke',
			'Bara',
			'Bardiya',			
			'Bhaktapur',			
			'Bhojpur',			
			'Chitwan',
			'Dadeldhura',
			'Dailekh',
			'Dang',			
			'Darchula',
			'Dhading',
			'Dhankuta',
			'Dhanusa',			
			'Dholkha',			
			'Dolpa',
			'Doti',			
			'Gorkha',			
			'Gulmi',			
			'Humla',			
			'Ilam',			
			'Jajarkot',			
			'Jhapa',			
			'Jumla',			
			'Kailali',			
			'Kalikot',			
			'Kanchanpur',			
			'Kapilvastu',			
			'Kaski',			
			'Kathmandu',
			'Kavrepalanchok',
			'Khotang',			
			'Lalitpur',			
			'Lamjung',			
			'Mahottari',			
			'Makwanpur',			
			'Manang',			
			'Morang',			
			'Mugu',			
			'Mustang',			
			'Myagdi',			
			'Nawalparasi',			
			'Nuwakot',			
			'Okhaldhunga',			
			'Palpa',			
			'Panchthar',			
			'Parbat',			
			'Parsa',			
			'Pyuthan',			
			'Ramechhap',			
			'Rasuwa',			
			'Rautahat',			
			'Rolpa',			
			'Rukum',			
			'Rupandehi',			
			'Salyan',			
			'Sankhuwasabha',			
			'Saptari',			
			'Sarlahi',			
			'Sindhuli',			
			'Sindhupalchok',			
			'Siraha',			
			'Solukhumbu',			
			'Sunsari',
			'Surkhet',
			'Syangja',
			'Tanahu',			
			'Taplejung',			
			'Terhathum',			
			'Udayapur'
		);
	