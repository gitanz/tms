<?php
	/**
	 * Default Site setting class
	 * @package admin-login
	 * @author Jay Gaha
	 * @link http://jaygaha.com.np
	 * @date 11th Dec 2013
	 */
	 
	class SiteSetting {
		public function __construct() {
			
		}
		
		public function get_varibales( $var ) {
			require_once ( 'Database.php' );
			$db = new Database;
        	$sth = $db->prepare("SELECT `variable_value` FROM `".TABLE_PREFIX."variables` WHERE `variable_name` = '".$var."'");
        	$sth->execute();
			//var_dump($sth->fetch());
       	 	$oVar = $sth->fetch();
			return stripslashes( $oVar->variable_value);
	    }
	 }