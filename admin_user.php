<?php
	require_once('utility_lgmis_lib.php');
	require_once($link_to_utility_authorization);

	if ((isset($_POST['id'])) && (isset($_GET['id'])) && ($_POST['id'] !== $_GET['id'])) {
		$content = AlertMessage('alert-danger', 'Неоднозначные id');
	} else {
		$user = User::FetchByID($_REQUEST['id']);
		if ($user == NULL) {
			header('Location: '.$link_to_admin);
			exit();
		}
		$prev_page = '';

		if (isset($_REQUEST['edit'])) {
			$title = 'Редактирование профиля';
			$header = 'Редактирование профиля';
			$content = $user->ToHTMLEditing();
		} else {

			$title = $user->name;

			$header = htmlspecialchars($user->name.' '.$user->surname.' '.$user->fathername);

			$content = $user->ToHTMLAutoFull(GetUserPrivileges());
			$no_content_center = true;
		}
	}

	require_once($link_to_admin_template);
?>