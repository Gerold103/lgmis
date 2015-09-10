<?php
	session_set_cookie_params(0);
	session_start();
	include_once('utility_lgmis_lib.php');

	function GetUserPrivileges()
	{
		if (!isset($_SESSION['user_login']) || (isset($_SESSION['is_public'])) && ($_SESSION['is_public'] === true)) return unauthorized_user_id;
		if ($_SESSION['user_login'] == 'admin') return admin_user_id;
		else return simple_user_id;
	}

	function GetUserLogin()
	{
		if (!isset($_SESSION['user_login'])) return authorization_error;
		return $_SESSION['user_login'];
	}

	function IsSessionPublic()
	{
		if (isset($_SESSION['is_public'])) return $_SESSION['is_public'];
		else return false;
	}

	//Проверка авторизационных данных
	
	if (isset($_POST['exit'])) {
		session_unset();
		session_destroy();
		echo Language::Word('you logout').'<br>';
		echo OnStartAdminPage();
		exit();
	}
			
	if (isset($_POST['login']) && (!isset($_POST['name']))) {
		if (isset($_POST['enter'])) {
			if (isset($_POST['login'])) {
				if (isset($_POST['password'])) {
					$user = User::FetchByLogin($_POST['login']);
					if (!password_verify($_POST['password'], $user->password)) {
						echo Language::Word('incorrect password').'<br>'.OnStartAdminPage();
						exit();
					}
					$_SESSION['user_login'] = $user->login;
				} else {
					echo Language::Word('it was not succeeded to be authorized').'<br>'.OnStartAdminPage();
					exit();
				}
			} else {
				echo Language::Word('it was not succeeded to be authorized').'<br>'.OnStartAdminPage();
				exit();
			}
		} else if (isset($_POST['register'])) {
			$header = Language::Word('registration');
			$content = RequestOnRegister::FormForCreating();
			require_once($link_to_registering_template);
			exit();
		} else {
			echo 'Ошибка 1';
			exit();
		}
	}

	if (isset($is_public) && ($is_public === true)) $_SESSION['is_public'] = true;
	else $_SESSION['is_public'] = false;

	//Проверка авторизации
	
	if (((!isset($is_public)) || ($is_public === false)) && (!isset($_SESSION['user_login']))) {
		echo Language::Word('login please').'<br>';
		$login_form = '';
		$login_form .= '<table height="100%" align="center">';
		$login_form .= 		'<tr>';
		$login_form .= 			'<td>';
		$login_form .= 				'<form action="" method="post">';
		$login_form .=					'<table align="center">';
		$login_form .=						'<tr>';
		$login_form .=							'<td>Login</td>';
		$login_form .=							'<td><input type="text" name="login" /></td>';
		$login_form .=						'</tr>';
		$login_form .=						'<tr>';
		$login_form .=							'<td>Password</td>';
		$login_form .=							'<td><input type="password" name="password" /></td>';
		$login_form .=						'</tr>';
		$login_form .=						'<tr>';
		$login_form .=							'<td>';
		$login_form .=								'<input type="submit" name="enter" value="'.Language::Word('login').'"/>';
		$login_form .=							'</td>';
		$login_form .=							'<td>';
		$login_form .=								'<input type="submit" name="register" value="'.Language::Word('registration').'"/>';
		$login_form .=							'</td>';						
		$login_form .=						'</tr>';
		$login_form .=					'</table>';
		$login_form .= 				'</form>';
		$login_form .= 			'</td>';
		$login_form .= 		'</tr>';
		$login_form .= 	'</table>';
		
		echo $login_form;
		exit();
	}
?>