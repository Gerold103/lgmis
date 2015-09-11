<?php
	session_set_cookie_params(0);
	session_start();
	include_once('utility_lgmis_lib.php');
	
	if (isset($_REQUEST['lang'])) {
		$lang = $_REQUEST['lang'];
		if (CheckLanguage($lang) === false) {
			echo AlertMessage('danger', 'Язык '.$lang.' не найден');
			exit();
		}
		$_SESSION['lang'] = $lang;
	}
	header('Location: '.Link::Get(''));
?>