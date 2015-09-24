<?php
	include_once('utility_lgmis_lib.php');
	include_once($link_to_utility_authorization);

	$title = '';
	$header = '';
	$content = '';

	$title = Language::Word('bookkeeping');
	$header = $title;

	if (isset($_REQUEST['content_type'])) {
		switch ($_REQUEST['content_type']) {
			case $content_types_short['reports']: {
				$title .= ' :'.Language::Word('reports');
				$header = $title;

				$content .= MenuButton(Language::Word('send report'), $link_to_admin_report, 'btn-primary', '', 'get');

				$content .= MenuButton(Language::Word('received reports'), $link_to_admin_bookkeeping.'?content_type=received_reps', 'btn-default', '', 'get');

				$content .= MenuButton(Language::Word('sended reports'), $link_to_admin_bookkeeping.'?content_type=sended_reps', 'btn-default', '', 'get');

				break;
			}
			case 'received_reps': case 'sended_reps': {
				$content_type = $_REQUEST['content_type'];
				if ($content_type === 'received_reps') $title .= ' :'.Language::Word('received reports');
				else $title .= ' :'.Language::Word('sended reports');
				$header = $title;

				$reports = array();
				$my_id = User::GetIDByLogin(GetUserLogin());
				if ($content_type === 'received_reps') $reports = Report::FetchByRecipientID($my_id);
				else $reports = Report::FetchByAuthorID($my_id);

				if (Error::IsError($reports)) exit();

				$size = count($reports);
				if ($size) {
					require($link_to_pagination_init_template);

					$content .= '<div class="row">';
					$content .= '<div class="'.ColAllTypes(1).' center-block"></div>';
					$content .= '<div class="'.ColAllTypes(10).' center-block">';
					$content .= '<table class="table table-striped text-center">';
					$content .= 	'<thead>';
					$content .= 		'<tr>';
					$content .=				'<th class="text-center">'.Language::Word('author').'</th>';
					$content .=				'<th class="text-center">'.Language::Word('receiver').'</th>';
					$content .=				'<th class="text-center" width="30%">'.Language::Word('header').'</th>';
					$content .=				'<th class="text-center">'.Language::Word('date').'</th>';
					$content .=				'<th class="text-center">'.Language::Word('actions').'</th>';
					$content .=			'</tr>';
					$content .=		'</thead>';
					$content .=		'<tbody>';
					for ($i = $from; $i <= $to; ++$i) {
						$ob = $reports[$i];
						$content .= ($ob->ToHTMLAutoShortForTable(GetUserPrivileges()));
					}
					$content .= 	'</tbody>';
					$content .= '</table>';
					$content .= '</div>';
					$content .= '</div>';

					require($link_to_pagination_show_template);
				} else {
					$content .= ToPageHeader(Language::Word('absense'), "h3", "black");
				}
			}
			default: break;
		}
	} else {
		$content = MenuButton(Language::Word('reports'), $link_to_admin_bookkeeping.'?content_type='.$content_types_short['reports'], 'btn-default', '', 'get');
	}
	include_once($link_to_admin_template);
?>