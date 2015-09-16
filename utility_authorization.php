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
		?>
		<script type="text/javascript">
			function checkLoginField(field_id) {
				var field = document.getElementById(field_id);
				var errors = document.getElementById("errors");
				if (/^[\w]+$/.test(field.value) == false) {
					errors.innerHTML = '<font color="red">Такого логина не существует</font>';
					return false;
				}
				return true;
			}

			function checkAuthForm(form_obj) {
				if (checkLoginField("login") == true) {
					form_obj.submit();
					return true;
				}
				return false;
			}

			function toRegisterPage() {
				window.location.href = <?php echo '"'.$link_to_admin_registration.'"'; ?>;
			}
		</script>
		<table height="100%" align="center">
			<tr>
				<td>
					<form action="" method="post" onsubmit="return checkAuthForm(this);" id="register_form">
						<table align="center">
							<tr>
								<span id="errors"></span>
							</tr>
							<tr>
								<td>Login</td>
								<td><input type="text" id="login" name="login"/></td>
							</tr>
							<tr>
								<td>Password</td>
								<td><input type="password" name="password" /></td>
							</tr>
							<tr>
								<td>
									<input type="submit" name="enter" value=<?php echo '"'.Language::Word('login').'"'; ?> />
								</td>
								<td>
									<input type="button" name="register" value=<?php echo '"'.Language::Word('registration').'"'; ?> onclick="toRegisterPage();" />
								</td>
							</tr>
						</table>
					</form>
				</td>
			</tr>
		</table>
		<?php
		exit();
	}
?>