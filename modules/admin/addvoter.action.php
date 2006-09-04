<?php

/* Restricts access to specified user types or no user type at all */
$this->restrict(USER_ADMIN);

/* Required Files */
Hypworks::loadDao('Voter');
Hypworks::loadAddin('rfc822');
require_once APP_LIB . '/phpmailer/class.phpmailer.php';

/*
 * Places the POST variables in local context.
 * E.g, $_POST['username'] can be accessed
 * using $username directly. If the variable
 * $username already exists, then it will not
 * be overwritten.
 */
extract($_POST, EXTR_REFS|EXTR_SKIP);

if(empty($firstname))
	$this->addError('firstname', 'First name is required');
if(empty($lastname))
	$this->addError('lastname', 'Last name is required');
if(empty($email)) {
	$this->addError('email', 'Email is required');
}
else {
	if(!isValidEmail($email)) {
		$this->addError('email', 'Email is invalid');
	}	
}

if($this->hasError()) {
	$this->addUserInput($_POST);
	$this->forward('addvoter');
}
else {
	// generate password
	$chars = "ABCDEFGHJKLMNPQRSTUVWXYZabcdefghijkmnopqrstuvwxyz023456789";
	srand((double)microtime()*1000000);
	$i = 0;
	$password = '' ;
	while ($i < 8) {
		$num = rand() % 58;
		$tmp = substr($chars, $num, 1);
		$password = $password . $tmp;
		$i++;
	}
	// generate pin
	$chars = "ABCDEFGHJKLMNPQRSTUVWXYZabcdefghijkmnopqrstuvwxyz023456789";
	srand((double)microtime()*1000000);
	$i = 0;
	$pin = '';
	while ($i < 8) {
		$num = rand() % 58;
		$tmp = substr($chars, $num, 1);
		$pin = $pin . $tmp;
		$i++;
	}

	// Create PHPMailer object
	$mail = new PHPMailer();
	$mail->From     = MAIL_FROM;
	$mail->FromName = MAIL_FROM_NAME;
	$mail->Host     = MAIL_HOST;
	$mail->Port     = MAIL_PORT;
	$mail->Mailer   = MAIL_MAILER;
	$mail->SMTPAuth  = MAIL_SMTPAUTH;
	$mail->Username  = MAIL_USERNAME;
	$mail->Password  = MAIL_PASSWORD;
	$mail->Subject = "Halalan Auto-Generated Password and Pin";

	// Create Mail Body
	$body  = "Mabuhay!<br /><br />";
	$body .= "Ang password mo ay " . $password;
	$body .= " at ang pin mo ay " . $pin;
	$body .= "<br /><br />";
	$body .= "Halalan";

	// Plain text body (for mail clients that cannot read HTML)
	$text_body  = "Mabuhay!\n\n";
	$text_body .= "Ang password mo ay " . $password;
	$text_body .= " at ang pin mo ay " . $pin;
	$text_body .= "\n\n";
	$text_body .= "Halalan";

	$mail->Body    = $body;
	$mail->AltBody = $text_body;
	$mail->AddAddress($email);

	if(!$mail->Send()) {
		echo $mail->ErrorInfo;
		echo '<br />There has been a mail sending error.<br/>';
		echo '<a href="addvoter">[Back to Add Voter]</a></p>';
		exit();
	}
		
	// Clear all addresses and attachments for next loop
	$mail->ClearAddresses();
	$mail->ClearAttachments();

	$password = sha1($password);
	$pin = sha1($pin);
	Voter::insert(compact('firstname', 'lastname', 'email', 'password', 'pin'));
	$this->addMessage('addvoter', 'A new voter has been successfully added');
	$this->forward('voters');
}

?>