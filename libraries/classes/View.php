<?php
	/**
     * user display class
	 * Handles the view functionality of our MVC framework
	 *
	 * @package marvelousnepal
	 * @author Jay Gaha
	 * @link http://jaygaha.com.np
	 * @date 07th Jan 2014
	 */
	class View {
		private $site_meta = array();
		
		public function __construct() {

			$this->site_meta['site_title'] = SITE_TITLE;
			$this->site_meta['meta_description'] = SITE_DESCRIPTION;
			$this->site_meta['meta_keywords'] = SITE_KEYWORDS;

			$this->site_meta['defaultcss'] = [
											"/assets/css/bootstrap-responsive.css",
											"/assets/css/navbar.css" ,
											"/assets/css/carousel.css" ,
											"/assets/css/bootstrap.css" ,
											"/assets/css/nivo/default.css",
											"/assets/css/style.css" ,
											"/assets/css/nivo/nivo-slider",
											"/assets/css/jquery.bxslider.css"
											];
			$this->site_meta['css'] = '';
			
			$this->site_meta['defaultjs'] =	[
											"/assets/js/jquery.js",
											"/assets/js/bootstrap.js",
											"/assets/js/jquery.nivo.slider.pack.js",
											"/assets/js/jquery.bxslider.min.js"
											];
										
			$this->site_meta['js'] = '';
			
		}
		
		public function Set_Site_Title( $name ){
			$this->site_meta['site_title'] = '' . $name . '';
		}
		
		public function Set_Meta_Keywords( $words ){
			$this->site_meta['meta_keywords'] = '' . $words . '';
		}

		public function Set_Meta_Description( $descr ){
			$this->site_meta['meta_description'] = '' . $descr . '';
		}

		
		public function Set_CSS( $filenames = false ){
			foreach ($this->site_meta['defaultcss'] as $cssFile):
				$cssFilePath = SITE_URL . $cssFile;
				// $header_response = get_headers($cssFilePath, 1);
				//if ( $header_response['Content-Type'] == 'text/css' )
					$this->site_meta['css'] = $this->site_meta['css'] . "\t\t".'<link href="' . $cssFilePath . '" rel="stylesheet" />'."\n";
			endforeach;
			
			if($filenames) :
				foreach ($filenames as $cssFile):
					$cssFilePath = SITE_URL . $cssFile;
					// $header_response = get_headers($cssFilePath, 1);
					//if ( $header_response['Content-Type'] == 'text/css' )
						$this->site_meta['css'] = $this->site_meta['css'] . "\t\t".'<link href="' . $cssFilePath . '" rel="stylesheet" />'."\n";
				endforeach;
			endif;
			
		}
		public function get_captcha(){
			require_once('libraries/recaptchalib.php');
			$publickey = "6LcVjfESAAAAAJO_ZoqmjiTOQKsebqzyYSxi4Ri7"; // you got this from the signup page
			return recaptcha_get_html($publickey);
		}
		public function Set_JS( $filenames = false ){
			foreach ($this->site_meta['defaultjs'] as $jsFile):
				$jsFilePath = SITE_URL . $jsFile;
				// $header_response = get_headers($jsFilePath, 1);
				// if ( $header_response['Content-Type'] == 'application/javascript' )
					$this->site_meta['js'] = $this->site_meta['js'] . "\t\t".'<script src="' . $jsFilePath . '"></script>'."\n";
			endforeach;
			
			if($filenames) :
				foreach ($filenames as $jsFile):
					$jsFilePath = SITE_URL . $jsFile;
					// $header_response = get_headers($jsFilePath, 1);
					// if ( $header_response['Content-Type'] == 'application/javascript' )
						$this->site_meta['js'] = $this->site_meta['js'] . "\t\t".'<script src="' . $jsFilePath . '"></script>'."\n";
				endforeach;
			endif;
			
			$this->site_meta['js'] = $this->site_meta['js'] . "\t\t".'<script src="' . SITE_URL . '/assets/js/site.custom.js"></script>'."";
			
		}
		
		public function render($filename, $special_page = false) {
			if ( SITE_OFFLINE == 'Yes' ): //if site is offline
				require 'views/offline/index.php';
			else:
		        if ($special_page == true) :
		            require 'views/' . $filename . '.php';            
        		else:            
	        	    require 'views/_templates/header.php';
	            	require 'views/' . $filename . '.php';
	        	    require 'views/_templates/footer.php'; 
	        	    require 'views/_templates/tail.php';            
				endif;
			endif;        
	    }
		
		public function error_level_tostring($intval, $separator){
    		$errorlevels = array(
					        2047 => 'E_ALL',
					        1024 => 'E_USER_NOTICE',
							512 => 'E_USER_WARNING',
							256 => 'E_USER_ERROR',
							128 => 'E_COMPILE_WARNING',
							64 => 'E_COMPILE_ERROR',
							32 => 'E_CORE_WARNING',
							16 => 'E_CORE_ERROR',
							8 => 'E_NOTICE',
							4 => 'E_PARSE',
							2 => 'E_WARNING',
							1 => 'E_ERROR');
			$result = '';
		    foreach($errorlevels as $number => $name) :
		        if (($intval & $number) == $number) {
        		    $result .= ($result != '' ? $separator : '').$name; }
			endforeach;
		    return $result;
		}
		
		public function attachmentThumbPathCorrect( $filePath ) {
			$pos = strpos($filePath, "/uploads/");
			if($pos !== false)
	    		$filpath = substr($filePath, $pos+strlen("/"));
			$newpath = str_replace('uploads', 'thumbs', $filpath);			
			$correctpath = SITE_URL.'/'.$newpath;
			return $correctpath;
		}
		
		public function attachmentFullPathCorrect( $filePath ) {
			$pos = strpos($filePath, "/uploads/");
			if($pos !== false)
	    		$filpath = substr($filePath, $pos+strlen("/"));
			
			$correctpath = SITE_URL.'/'.$filpath;
			return $correctpath;
		}
		
		public function attachmentPathCorrect( $filePath ) {
			$pos = strpos($filePath, "/uploads/");
			if($pos !== false)
	    		$filpath = substr($filePath, $pos+strlen("/"));
			else
				$filpath = false;

			return $filpath;
		}
		
		public function text_cut($text, $length = 40, $dots = true) {
			$text = trim(preg_replace('#[\s\n\r\t]{2,}#', ' ', $text));
		    $text_temp = $text;
		    while (substr($text, $length, 1) != " ") { $length++; if ($length > strlen($text)) { break; } }
		    $text = substr($text, 0, $length);
		    return $text . ( ( $dots == true && $text != '' && strlen($text_temp) > $length ) ? '...' : '');	
		}
		
		// Simply change the content url according to the changed site
		public function imgPathCorrectContent( $content ){
			if( strlen($content) > 0 ):
				
				$dom = new DOMDocument();
				$dom->loadHTML($content);
				$imgs = $dom->getElementsByTagName("img");
				$updatedContent = $content;
				foreach($imgs as $img) :
		    		$value = $img->attributes->getNamedItem("src")->nodeValue;
    				//echo $value;
					$pos = strpos($value, "/uploads/");
					if($pos!== false)
			    		$imgpath = substr($value, $pos+strlen("/"));
		
					//echo $imgpath;
    				$correctpath = SITE_URL . '/'. $imgpath;
		    		//echo $correctpath;
					$updatedContent = str_replace($value, $correctpath, stripcslashes($updatedContent));
				endforeach;
				return $updatedContent;
			else:
				return $content;
			endif;
		}
	}