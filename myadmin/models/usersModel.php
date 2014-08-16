<?php
	/**
	 * class Users_Model
	 * handles the user's login, logout, username editing, password changing...
	 *
	 * @package admin-login
	 * @author Jay Gaha
	 * @link http://jaygaha.com.np
	 * @date 12th Dec 2013
	 */
	 
	class Users_Model extends Model{
		public $errors = array();
		public $redirect = null;
		public $profile_id = null;

    	public function __construct() {        
	        parent::__construct();            
	    }
		
		public function login() {
			if (!empty($_POST['username']) && !empty($_POST['password'])):
				// get user's data
            	// (we check if the password fits the password_hash via password_verify() some lines below)
				//# STH means "Statement Handle" 
				$sth = $this->db->prepare("SELECT `user_id`, 
                                              `user_name`, 
                                              `user_email`,
											  `user_fullname`, 
                                              `user_password_hash`, 
                                              `user_active`, 
                                              `user_account_type`,
                                              `user_failed_logins`, 
                                              `user_last_failed_login`  
                                       FROM `".TABLE_PREFIX."users`
                                       WHERE `user_name` = :user_name");
				$sth->execute(array(':user_name' => $_POST['username']));
				$count =  $sth->rowCount();
				
				if ($count == 1): //if user exist
					// fetch one row (we only have one result)
	                $result = $sth->fetch();
					
					if ( ($result->user_failed_logins >= 2) && ($result->user_last_failed_login > (time()-30)) ) :                    
	                   
					    $this->errors[] = 'You have typed in a wrong password 3 or more times already. Please wait <span id="failed-login-countdown-value">30</span> seconds to try again.';						
	                    return false;
						
					else:
						
						if (password_verify($_POST['password'], $result->user_password_hash)):
							
							if ($result->user_active == 1):
							
								// login and initiate session
								Session::init();
	                            Session::set('admin_logged_in', true);
    	                        Session::set('admin_id', $result->user_id);
        	                    Session::set('admin_username', $result->user_name);
								Session::set('admin_name', $result->user_fullname);
            	                Session::set('admin_email', $result->user_email);
                	            Session::set('admin_account_type', $result->user_account_type);
								
								// reset the failed login counter for that user
								$sth = $this->db->prepare("UPDATE `".TABLE_PREFIX."users` SET `user_failed_logins` = 0, `user_last_failed_login` = NULL WHERE `user_id` = :user_id AND `user_failed_logins` != 0");
	                            $sth->execute(array(':user_id' => $result->user_id));
								// if user has check the "remember me" checkbox, then write cookie
								if (isset($_POST['rememberme'])):
									// generate 64 char random string
	                                $random_token_string = hash('sha256', mt_rand());
									$sth = $this->db->prepare("UPDATE `".TABLE_PREFIX."users` SET `user_rememberme_token` = :user_rememberme_token WHERE `user_id` = :user_id");
	                                $sth->execute(array(':user_rememberme_token' => $random_token_string, ':user_id' => $result->user_id));

									// generate cookie string that consists of userid, randomstring and combined hash of both
	                                $cookie_string_first_part = $result->user_id . ':' . $random_token_string;
    	                            $cookie_string_hash = hash('sha256', $cookie_string_first_part);        
        	                        $cookie_string = $cookie_string_first_part . ':' . $cookie_string_hash;        

            	                    // set cookie
                	                setcookie('rememberme', $cookie_string, time() + COOKIE_RUNTIME, "/", COOKIE_DOMAIN);
								endif;
								//redirect to this path
								$this->redirect = (!empty($_POST['continue'])) ? $_POST['continue'] : null;
								return true;
							else:
								$this->errors[] = 'Your account is not activated yet. Please contact to Super Admin.';
	                            return false;
							endif;
							
						else:
							
							// increment the failed login counter for that user
	                        $sth = $this->db->prepare("UPDATE `".TABLE_PREFIX."users` "
                                	. "SET `user_failed_logins` = user_failed_logins+1, `user_last_failed_login` = :user_last_failed_login "
                                	. "WHERE `user_name` = :user_name");
    	                    $sth->execute(array(':user_name' => $_POST['username'], ':user_last_failed_login' => time() ));

        	                $this->errors[] = 'Password was wrong.';
            	            return false;
						
						endif;
						
					endif;
				else:
				
					$this->errors[] = 'This user does not exist.';
	                return false;
					
				endif;
			
			elseif (empty($_POST['username'])) :
	            $this->errors[] = 'Username field was empty.';
	        elseif (empty($_POST['password'])) :
	            $this->errors[] = 'Password field was empty.';	
			endif;	
		}
		
		/**
     	 * log out
     	 * delete cookie, delete session
     	 */
    	public function logout() {
	        setcookie('rememberme', false, time() - (3600 * 3650), '/');        
	        // delete the session
    	    Session::destroy();
	    }
		
		function getMyProfile(){
			$user_id = Session::get('admin_id');
			$sth = $this->db->prepare("SELECT * FROM `".TABLE_PREFIX."users` WHERE `user_id` = :user_id;");
			$sth->execute(array(':user_id' => $user_id));    

        	return $sth->fetch();
		}
		
		/**
     	 * edit the user's name, provided in the editing form
     	 */
	   	public function saveFormData() {
			$this->profile_id = $_POST['id'];
						
			if(isset( $_POST['profile'] )) :
				//print_r($_POST);
				$email = filter_var($_POST['user_email'], FILTER_SANITIZE_EMAIL);
		  		if ( empty( $_POST['full_name'] ) || empty( $_POST['user_name'] ) || empty( $_POST['user_email'] )) :
					$this->errors[] = 'All fields are required.';					
				elseif (!preg_match("/^(?=.{2,64}$)[a-zA-Z][a-zA-Z0-9]*(?: [a-zA-Z0-9]+)*$/", $_POST['user_name'])) :
					$this->errors[] = 'Username is not valid. Select only with alphabet and number';
				elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)):
					$this->errors[] = 'Email is invalid. Enter valid Email Address.';
				else:
					// escapin' this
                    $this->user_name = htmlentities($_POST['user_name'], ENT_QUOTES);
					$this->user_email = htmlentities($email, ENT_QUOTES);
					//check username is available or not
                    $sth = $this->db->prepare("SELECT * FROM `".TABLE_PREFIX."users` WHERE `user_name` = :user_name ;");
                    $sth->execute(array(':user_name' => $this->user_name));
					$count =  $sth->rowCount();
					if((Session::get('admin_username') != $this->user_name) && $count == 1) :
						$this->errors[] = 'This username is already taken, Choose other one.';
						return false;
					else:
						$sth = $this->db->prepare("UPDATE `".TABLE_PREFIX."users` SET `user_name` = :user_name, `user_fullname` = :user_fullname, `user_email` = :user_email WHERE `user_id` = :user_id ;");
                        $sth->execute(array(
									':user_name' => trim($this->user_name),
									':user_fullname' => trim($_POST['full_name']), 
									':user_email' => trim($this->user_email), 
									':user_id' => $_POST['id']));
						$count =  $sth->rowCount();
						if ($count == 1):
							Session::set('admin_username', $this->user_name);
							Session::set('admin_name', $_POST['full_name']);
							Session::set('admin_email', $this->user_email);							
							return true;
						else:
							$this->errors[] = 'Nothing updated.';							
						endif;
					endif;
				endif;
				return false;
		  	endif;
			
			if(isset( $_POST['password'] )) :
				
				if ( empty( $_POST['old_passwrd'] ) || empty( $_POST['new_passwrd'] ) || empty( $_POST['new_cpassword'] )) :
					$this->errors[] = 'All fields are required.';
				elseif ( strlen($_POST['new_passwrd']) < 6 ) :
					$this->errors[] = 'Password must be atlreast 6 characters.';
				elseif ( $_POST['new_passwrd'] !== $_POST['new_cpassword'] ) :
					$this->errors[] = 'Password does not matched.';
				else:
					
					// check if password is right
                	$sth = $this->db->prepare("SELECT `user_id`, `user_password_hash` FROM `".TABLE_PREFIX."users` WHERE `user_id` = :user_id");
                	$sth->execute(array(':user_id' => $_POST['id']));

                	$count =  $sth->rowCount();
					if ($count == 1) :
																
	                    $result = $sth->fetch(); // fetch one row (we only have one result)
						if (password_verify($_POST['old_passwrd'], $result->user_password_hash)) :
							// no need to escape as this is only used in the hash function
			                $this->user_password = $_POST['new_passwrd'];							
            			    $this->hash_cost_factor = (defined('HASH_COST_FACTOR') ? HASH_COST_FACTOR : null);
							$this->user_password_hash = password_hash($this->user_password, PASSWORD_DEFAULT, array('cost' => $this->hash_cost_factor));
							$sth = $this->db->prepare("UPDATE `".TABLE_PREFIX."users` SET `user_password_hash` = :user_password_hash WHERE `user_id` = :user_id ;");
                        	$sth->execute(array(
									':user_password_hash' => $this->user_password_hash,									
									':user_id' => $_POST['id']));
							$count =  $sth->rowCount();
							if ($count == 1)
								return true;
							else
								$this->errors[] = 'Nothing updated.';							
						
						else:							
							$this->errors[] = 'Current password does not matched.';						
						endif;
						
					else:
						$this->errors[] = 'Current password does not matched.';
					endif;
					
				endif;
				return false;
			endif;
	   	}
	}