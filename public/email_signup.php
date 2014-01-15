<?php
	include_once("../includes/initialize.php");
	require_once("../includes/PHPMailer/class.phpmailer.php");
	require_once("../includes/PHPMailer/class.smtp.php");
	//require_once("../includes/PHPMailer/language/phpmailer.lang-en.php");

	if(isset($_POST["submit"])) {
		if(!empty($_POST["email"])) {
			$email = $database->sanitize($_POST["email"]);
			$sql = "INSERT INTO emails (";
			$sql .= "email_address) ";
			$sql .= "VALUES ('" . $email . "')";
			$result = $database->query($sql);
			if ($result) {
				$subject = "Thanks for signing up | TraveLog";
				$message = "Thanks for signing up to follow our travels on TraveLog. Our blog is updated periodically, so you shouldn't expect an overwhelming number of emails. If you ever want to unsubscribe, just email info@travelog.com.";
				$from_name = "TraveLog";
				$from_address = "fair.dan@outlook.com";

				$mail = new PHPMailer();
				$mail->IsSMTP();   
				$mail->Host = 'smtp-mail.outlook.com'; 
				$mail->Port = '25';
				$mail->SMTPAuth = true;
				$mail->Username = 'fair.dan@outlook.com';
				$mail->Password = '######';
				$mail->SMTPSecure = 'tls';

				$mail->From = $from_address;
				$mail->FromName = $from_name;
				$mail->AddAddress($email, $email);
				$mail->AddReplyTo($from, 'TraveLog');
				$mail->Subject = "Thanks from TraveLog!";
				$mail->AddBCC('');
				$mail->WordWrap = 50;      
				$mail->IsHTML(true);                                  // Set email format to HTML
				$mail->Body    =  "<!DOCTYPE html>
			        <html lang='en-us'>
			            <head>
			                <meta charset='utf-8'>
			                <title></title>
			            </head>
			            <body>" . $message . "</body>
				    </html>";
				$result = $mail->Send();
				if ($result) {
					$session->set_email_message("Thanks! You should receive a confirmation email shortly.");
				}
				else {
					$session->set_email_message("Sorry, PHPMailer did not work." . $mail->ErrorInfo);
				}
			}
			else {
				$session->set_email_message("Sorry, we weren't able to add your email. Please try again later.");
			}
			redirect_to("index.php");
		}
		else {
			$session->set_email_message("WHAT");
		}
	}
	else
	{
		$session->set_email_message("Sorry, there was an error connecting with the database. Your email was not saved.");
		redirect_to("index.php");
	}

?>