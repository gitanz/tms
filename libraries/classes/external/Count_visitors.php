<?php 
/************************************************************************
Counter & visitor statistics version 2.01 - 
Easy to use system to track users and visitor statistics

Copyright (C) 2004 - 2005 by Olaf Lederer

This program is free software; you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation; either version 2 of the License, or
(at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program; if not, write to the Free Software
Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA

_________________________________________________________________________
available at http://www.finalwebsites.com 
Comments & suggestions: http://www.finalwebsites.com/contact.php

Updates:
version 2.0 - Please read the documentation file about all new features.

version 2.01 - I forgot to remove an old variable: $remote_adr, this var
is replaced by $_SERVER['REMOTE_ADDR']. The error will not occur anymore.
*************************************************************************/

	class Count_visitors {		
		var $delay = 1;
		
		public function __construct() {        
			try {				
				$this->db = new Database();
				$this->referer = (isset($_SERVER['HTTP_REFERER'])) ? $_SERVER['HTTP_REFERER'] : "";
				$this->onpage = $_SERVER['REQUEST_URI'];
			} catch (PDOException $e) {
				die('Database connection could not be established.');
			}    
		}
		
		function check_last_visit() {			
			$sth = $this->db->prepare("SELECT time + 0 as times FROM ".TABLE_PREFIX."ip2visits WHERE ip_adr = '".$_SERVER['REMOTE_ADDR']."' AND visit_date = CURDATE() AND on_page = '".$this->onpage."' ORDER BY time DESC LIMIT 0, 1");
			$sth->execute();
			$check_row = $sth->fetch();
			
			if ( $sth->rowCount() != 0 ) :
				$last_hour = date("H") - $this->delay; 
				$check_time = date($last_hour."is");
				if ($check_row->times < $check_time)
					return true;
				else
					return false;
			else:
				return true;
			endif;
		}
		
		function get_country() {
			
			$sth = $this->db->prepare("SELECT `country` FROM `".TABLE_PREFIX."ip2nation` WHERE ip < INET_ATON('".$_SERVER['REMOTE_ADDR']."') ORDER BY ip DESC LIMIT 0,1");
			$sth->execute();
			return $sth->fetch()->country;
		}
		
		function insert_new_visit() {
			if ( $this->check_last_visit() ) :
				
				$insert_sql = sprintf("INSERT INTO %s (id, ip_adr, referer, country, client, visit_date, time, on_page) VALUES (NULL, '%s', '%s', '%s', '%s',  CURDATE(), CURTIME(), '%s')", TABLE_PREFIX."ip2visits", $_SERVER['REMOTE_ADDR'], $this->referer, $this->get_country(), $_SERVER['HTTP_USER_AGENT'], $this->onpage);
				$sth = $this->db->prepare( $insert_sql );
				$sth->execute();
				
			endif;
		}
	}
?>