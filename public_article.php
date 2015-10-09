<?php
	$is_public = true;

	include_once('utility_lgmis_lib.php');
	include_once($link_to_utility_authorization);

	if (isset($_GET['id']) && (isset($_POST['id'])) && ($_GET['id'] !== $_POST['id'])) {
		$content = AlertMessage('alert-danger', 'Неоднозначные id');
	} else {
		$ob = Article::FetchByID($_REQUEST['id']);

		$header = '';
		$content = '';
		$footer = '';
		$title = '';

		$header_type = 'h4';

		if ($ob === NULL) {
			$title = Language::Word('error');
			$header = $title;
			$content = Language::Word('internal server error');
		} else if ($ob === Error::no_translation) {
			$title = Language::Word('error');
			$header = Language::Word('sorry');
			$content = Language::Word('no translation for this article');
		} else {
			$title = $ob->name;

			$header = htmlspecialchars($ob->name);

			$content = $ob->ToHTMLUserPublicFull();

			$no_content_center = true;
		}
	}

	include($link_to_public_template);
?>