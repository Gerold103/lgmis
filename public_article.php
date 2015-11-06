<?php
	$is_public = true;

	include_once('utility_lgmis_lib.php');
	include_once($link_to_utility_authorization);

	if (isset($_GET['id']) && (isset($_POST['id'])) && ($_GET['id'] !== $_POST['id'])) {
		$content = AlertMessage('alert-danger', 'Неоднозначные id');
	} else {
		$ob_id = $_REQUEST['id'];
		$ob = Article::FetchBy(['eq_conds' => array('id' => $ob_id), 'is_unique' => true]);
		if (Error::IsError($ob)) {
			$content = AlertMessage('alert-danger', Error::ToString($ob));
		} else {
			$header = '';
			$content = '';
			$footer = '';
			$title = '';

			$header_type = 'h4';
			$title = $ob->GetName();
			$header = htmlspecialchars($ob->GetName());
			$content = $ob->ToHTMLUserPublicFull();
			$no_content_center = true;
		}
	}

	include($link_to_public_template);
?>