<?php
	require_once('utility_lgmis_lib.php');
	require_once($link_to_utility_authorization);

	$header = '';
	$content = '';
	$footer = '';
	$prev_page = $link_to_admin;

	$size = User::GetCount();
	if (GetUserPrivileges() === admin_user_id) {
		$header .= Language::Word('staff management');
	} else {
		$header .= Language::Word('our collective');
	}

	if ($size) {
		$content .= '<div class="row">';
		$content .= '<div class="'.ColAllTypes(2).'"></div>';
		$content .= '<div class="'.ColAllTypes(8).' center-block">';
		$content .= '<table class="table table-striped text-center">';
		$content .= 	'<thead>';
		$content .= 		'<tr>';
		$content .=				'<th class="text-center">'.Language::Word('name').'</th>';
		$content .=				'<th class="text-center">'.Language::Word('surname').'</th>';
		$content .=				'<th class="text-center">'.Language::Word('position').'</th>';
		$content .=				'<th class="text-center">'.Language::Word('actions').'</th>';
		$content .=			'</tr>';
		$content .=		'</thead>';
		$content .=		'<tbody>';

		$from = -1;
		$to = -1;

		require($link_to_pagination_init_template);
		$users = User::FetchBy(['limit' => $count, 'offset' => $from]);

		for ($i = 0; $i < $count; ++$i) {
			$content .= $users[$i]->ToHTMLAutoShortForTable(GetUserPrivileges());
		}
		$content .= 	'</tbody>';
		$content .= '</table>';
		$content .= '</div>';
		$content .= '</div>';

		$pagination = '';
		require($link_to_pagination_show_template);
		$content .= $pagination;
	} else {
		$content = AlertMessage('alert-danger', Language::Word('error').': '.User::$last_error);
	}

	require($link_to_admin_template);
?>