<?php
	require_once('utility_lgmis_lib.php');

	$protocol = !empty($_SERVER['HTTPS']) ? 'https://' : 'http://';
    $site = $protocol. $_SERVER['SERVER_NAME'] .$link_prefix;

	$to = 'vshpilevoi@mail.ru';
	$subject = 'Subject';
	$message = 'Simple message';
	$headers = 'From: Vladislav Shpilevoi <vshpilevoi@lgmis.cs.msu.ru>'.PHP_EOL;
	if (!mail($to, $subject, $message, $headers)) {
		echo 'error:'.error_get_last();
	} else {
		echo 'ok';
	}
	// $password = password_hash('123456', PASSWORD_DEFAULT);
	// $res = $db_connection->query("UPDATE users SET password = '".$password."' WHERE id = 21");
	// if ($res) echo 'ok';
	// else echo 'error';
	//move_uploaded_file($_FILES['file']['tmp_name'], 'files/'.urldecode($_FILES['file']['name']));
	//file_put_contents('files/[debug].txt', grab_dump($_FILES)."\xA");


?>