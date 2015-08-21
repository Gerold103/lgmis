<?php
	$is_public = true;

	include_once('utility_lgmis_lib.php');
	include_once($link_to_utility_authorization);

	$project = Project::FetchByID($_POST['id']);

	$header = '';
	$content = '';
	$footer = '';

	$header_type = 'h4';

	$title = $project->name;

	$header = htmlspecialchars($project->name);

	$content .= '<br><div class="row" align="center">';
	$content .= 	'Направление проекта: '.Direction::FetchByID($project->direction_id)->LinkToThis();
	$content .= '</div>';
	$content .= '<br><hr>';
	$content .= '<div class="row"><div class="'.ColAllTypes(12).'">'.$project->text_block.'</div></div>';

	$no_content_center = true;

	include($link_to_public_template);
?>