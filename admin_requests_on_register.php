<?php
	include_once('utility_lgmis_lib.php');
	include_once($link_to_utility_authorization);

	$header = '';
	$content = '';
	$footer = '';
	$prev_page = $link_to_admin;
	
	$header .= Language::Word('requests on register');

	$reg_requests = RequestOnRegister::FetchAll();
	$size = count($reg_requests);

	if ($size) {
		$content = '<div class="row">';
		$content .= '<table class="table table-striped text-center">';
		$content .= 	'<thead>';
		$content .= 		'<tr>';
		$content .=				'<th class="text-center">'.Language::Word('full name').'</th>';
		$content .=				'<th class="text-center">'.Language::Word('date').'</th>';
		$content .=				'<th class="text-center">'.Language::Word('comment').'</th>';
		$content .=				'<th class="text-center">'.Language::Word('mail').'</th>';
		$content .=				'<th class="text-center">'.Language::Word('telephone').'</th>';
		$content .=				'<th class="text-center">'.Language::Word('actions').'</th>';
		$content .=			'</tr>';
		$content .=		'</thead>';
		$content .=		'<tbody>';

		$from = -1;
		$to = -1;
		require($link_to_pagination_init_template);

		for ($i = $from; $i <= $to; ++$i) {
			$request = $reg_requests[$i];
			if ($request == NULL) echo 'error on '.$i.'<br>';
			else {
				$content .= ($request->ToHTMLAutoShortForTable(GetUserPrivileges()));
			}
		}
		$content .= 	'</tbody>';
		$content .= '</table>';
		$content .= '</div>';

		$pagination = '';
		require($link_to_pagination_show_template);
		$content .= $pagination;
	} else {
		$content = ToPageHeader(Language::Word('absense'), "h3", "black");
	}
	
	include($link_to_admin_template);
?>