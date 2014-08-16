<?php 
class Form extends Controller {
		public $loadCSS = array();
		public $loadJS = array();

		
		
		function __construct() {
        	parent::__construct();
			// $redirect_link = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
			// Authorize::handleLogin( $redirect_link ); //check user is logged or not
    	}
    	function inquiry(){
			$fullname = trim($_POST['name']);
			$phone = trim($_POST['phone']);
			$mobile = trim($_POST['mobile']);
			$email = trim($_POST['email']);
			$country = trim($_POST['country']);
			$message = trim($_POST['message']);
			$to_email = SITE_EMAIL;
			$to_name = SITE_NAME;
			$subject = "Quick Inquiry Form Submission";
			$body = "<p> $fullname left a message via ".SITE_URL."</p>
					 Name:  	$fullname<br/>
					 Email:		$email<br/>
					 Mobile:	$mobile<br/>
					 Phone:		$phone<br/>
					 Country:	$country<br/>
					 ----------------------------------------------------<br/>
					 	Message <br />
					 ----------------------------------------------------<br/>
					 $message<br/>

					 with regards,<br/>
					 ".SITE_NAME." bot";
			$altbody = $body;
			require 'libraries/classes/external/PHPMailerAutoload.php';
    		$mail = new PHPmailer();
    		$mail->From = $email;
			$mail->FromName = $fullname;
			$mail->addAddress($to_email,$to_name);
			$mail->Subject    = $subject;
			$mail->isHTML(true);    
			$mail->Body    = $body;
			$mail->MsgHTML($body); 
			if(!$mail->send()){
				$message = "Email could not be sent!<br>Mailer Error: ".$mail->ErrorInfo;
				$error = true;
			}
			else{
				$message ="Message sent!";
				$error = false;
			}
			if($error)
				$data = ["success"=>false, "message"=>$message];
			else
				$data = ["success"=>true, "message"=>$message];
			echo json_encode($data);
		}
		function send(){
						$messages = [];
						$errors = [];
						$resp = check_captcha();
						if (!$resp->is_valid) {
						// when the CAPTCHA was entered incorrectly
							$errors[] = "Incorrect Captcha! Try again";
						} 
						else {
						// code to handle successful vericafication of captcha
							$fname = trim($_POST['fname']);
							$lname = trim($_POST['lname']);
							$fullname = $fname." ".$lname;
							$email = trim($_POST['email']);
							$message = trim($_POST['message']);
							$to_email = SITE_EMAIL;
							$to_name = SITE_NAME;
							$subject = "Contact Form Submission";
							$body = "<p> $fullname left a message via ".SITE_URL."</p>
									 Name:  	$fullname<br/>
									 Email:		$email<br/>
									 ----------------------------------------------------<br/>
									 	Message <br />
									 ----------------------------------------------------<br/>
									 $message<br/>

									 with regards,<br/>
									 ".SITE_NAME." bot";
							$altbody = $body;
							require 'libraries/classes/external/PHPMailerAutoload.php';
				    		$mail = new PHPmailer();
				    		$mail->From = $email;
							$mail->FromName = $fullname;
							$mail->addAddress($to_email,$to_name);
							$mail->Subject    = $subject;
							$mail->isHTML(true);    
							$mail->Body    = $body;
							$mail->MsgHTML($body); 
							if(!$mail->send()){
								$errors[] = "Email could not be sent!<br>Mailer Error: ".$mail->ErrorInfo;
							}
							else{
								$messages[] ="Message sent!";
							}
						}
// shouldnot use setcookie or echoing statements just before header ---causes error---	_anz
						//wrong way---use ajax
						count($messages) > 0 ? setcookie("MessageCookieContact",serialize($messages),time()+60,'/'):"";
						count($errors) > 0 ? setcookie("ErrorCookieContact",serialize($errors),time()+60,'/'):"";

		header('location:'.Session::get('contact_form'));
	}

	function search(){
		$this->view->Set_Site_Title( SITE_TITLE.' &#8250; Site Search');
		$this->view->Set_Meta_Keywords( SITE_KEYWORDS );		
		$this->view->Set_Meta_Description( SITE_DESCRIPTION );
		$this->view->Set_CSS();
		$this->view->Set_JS();
		$this->view->results = $this->model->search_site($_GET['keyword']);
		$this->view->render('content/search_site');
	}

}