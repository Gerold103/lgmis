<?php
	$is_public = true;

	include_once('utility_lgmis_lib.php');
	include_once($link_to_utility_authorization);

	if (isset($_GET['id']) && (isset($_POST['id'])) && ($_GET['id'] !== $_POST['id'])) {
		$content = AlertMessage('alert-danger', 'Неоднозначные id');
	} else {
		$article = Article::FetchByID($_REQUEST['id']);
		$header = '';
		$content = '';
		$footer = '';
		$title = '';

		$header_type = 'h4';

		if ($article === NULL) {
			$title = Language::Word('error');
			$header = $title;
			$content = Language::Word('internal server error');
		} else if ($article === Error::no_translation) {
			$title = Language::Word('error');
			$header = Language::Word('sorry');
			$content = Language::Word('no translation for this article');
		} else {
			$title = $article->name;

			$header = htmlspecialchars($article->name);

			$content .= '<br><div class="row" align="center">';
			$content .= 	'<div class="'.ColAllTypes(3).'">'.$article->GetCreatingDateStr().'</div>';
			$content .= 	'<div class="'.ColAllTypes(4).'">'.User::FetchByID($article->GetAuthorID())->LinkToThis().'</div>';
			$content .= '</div>';
			$content .= '<br><hr>';
			$content .= '<div class="row"><div class="'.ColAllTypes(12).'">'.$article->text_block.'</div></div>';

			$no_content_center = true;
		}
	}

	include($link_to_public_template);
?>