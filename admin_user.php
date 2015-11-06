<?php
	require_once('utility_lgmis_lib.php');
	require_once($link_to_utility_authorization);

	if ((isset($_POST['id'])) && (isset($_GET['id'])) && ($_POST['id'] !== $_GET['id'])) {
		$content = AlertMessage('alert-danger', 'Неоднозначные id');
	} else {
		$user = User::FetchBy(['eq_conds' => ['id' => $_REQUEST['id']], 'is_unique' => true]);
		if (Error::IsError($user)) {
			echo Error::ToString($user);
			exit();
		}
		$prev_page = '';

		if (isset($_REQUEST['edit'])) {
			$title = Language::Word('profile edit');
			$header = $title;
			$content = $user->ToHTMLEditing();
		} else {

			$title = $user->GetName();

			$header = htmlspecialchars(Language::Translit($user->GetName().' '.$user->GetSurname().' '.$user->GetFathername()));

			$content = $user->ToHTMLAutoFull(GetUserPrivileges());
			$no_content_center = true;
		}
	}

	require_once($link_to_admin_template);
?>