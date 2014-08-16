<?php
	/**
     * user display class
	 *
	 * @package admin-login
	 * @author Jay Gaha
	 * @link http://jaygaha.com.np
	 * @date 11th Dec 2013
	 */
	 
	class View {		
		
		public function render($filename, $special_page = false) {        
	        if ($special_page == true) :
	            require 'views/' . $filename . '.php';            
        	else:            
	            require 'views/_templates/header.php';
	            require 'views/' . $filename . '.php';
        	    require 'views/_templates/footer.php';            
			endif;        
	    }
		
		/*
     	 * handling the navigation's active/non-active link     	 
     	 */
    	private function checkForActiveController($filename, $navigation_controller) {
        
        	$splitted_filename = explode("/", $filename);
	        $active_controller = $splitted_filename[0];
        
    	    if ($active_controller == $navigation_controller)
            	return true;
        	else            
            	return false;        
    	}
		
		private function checkForActiveControllerAndAction($filename, $navigation_controller_and_action) {
        
        	$splitted_filename = explode("/", $filename);
	        $active_controller = $splitted_filename[0];
    	    $active_action = $splitted_filename[1];
        	
			if( $active_action == 'form' ) $active_action = 'create';
			
        	$splitted_filename = explode("/", $navigation_controller_and_action);
	        $navigation_controller = $splitted_filename[0];
    	    $navigation_action = $splitted_filename[1];        
        
        	if ($active_controller == $navigation_controller AND $active_action == $navigation_action)
	            return true;            
        	else            
            	return false;        
	    }
		
		public function text_cut($text, $length = 10, $dots = true) {
			$text = trim(preg_replace('#[\s\n\r\t]{2,}#', ' ', $text));
		    $text_temp = $text;
		    while (substr($text, $length, 1) != " ") { $length++; if ($length > strlen($text)) { break; } }
		    $text = substr($text, 0, $length);
		    return $text . ( ( $dots == true && $text != '' && strlen($text_temp) > $length ) ? '...' : '');	
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
		
		public function getPageAlias( $alias ){
			return substr($alias, strrpos($alias, '/') + 1);			
		}
		
	}