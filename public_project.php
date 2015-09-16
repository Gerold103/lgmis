<?php
	$is_public = true;

	include_once('utility_lgmis_lib.php');
	include_once($link_to_utility_authorization);

	if ((isset($_POST['id'])) && (isset($_GET['id'])) && ($_POST['id'] !== $_GET['id'])) {
		$content = AlertMessage('alert-danger', 'Неоднозначные id');
	} else {
		$project = Project::FetchByID($_REQUEST['id']);

		$header = '';
		$content = '';
		$footer = '';

		$header_type = 'h4';

		if ($project === NULL) {
			$title = Language::Word('error');
			$header = $title;
			$content = Language::Word('internal server error');
		} else if ($project === Error::no_translation) {
			$title = Language::Word('error');
			$header = Language::Word('sorry');
			$content = Language::Word('no translation for this project');
		} else {

			$title = $project->name;

			$header = htmlspecialchars($project->name);

			$content .= '<br><div class="row" align="center">';
			$content .= 	Language::Word('direction of project').': '.Direction::FetchByID($project->direction_id)->LinkToThis();
			$content .= '</div>';
			$content .= '<br><hr>';
			$content .= '<div class="row"><div class="'.ColAllTypes(12).'">'.$project->text_block.'</div></div>';

			$no_content_center = true;
		}
	}

	include($link_to_public_template);
?>