<?php
	$is_public = true;

	include_once('utility_lgmis_lib.php');
	include_once($link_to_utility_authorization);

	$direction = Direction::FetchByID($_POST['id']);

	$header = '';
	$content = '';
	$footer = '';

	$header_type = 'h4';

	$title = $direction->name;

	$header = htmlspecialchars($direction->name);

	$content .= '<div class="row"><div class="'.ColAllTypes(12).'">'.$direction->text_block.'</div></div>';

	$projects = Project::FetchByDirectionID($direction->id);
	$size = count($projects);
	if ($size > 0) {
		$content .= '<hr><div class="row" align="center">'.ToPageHeader('Связанные проекты', 'h4', 'grey').'</div><hr>';
		
		require($link_to_pagination_init_template);

		for ($i = $from; $i <= $to; ++$i) {
			$content .= $projects[$i]->ToHTMLAutoShortForTable(GetUserPrivileges());
			if ($i != $to) $content .= '<hr>';
		}

		require($link_to_pagination_show_template);
	}

	$no_content_center = true;

	include($link_to_public_template);
?>