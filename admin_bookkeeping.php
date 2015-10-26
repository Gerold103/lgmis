<?php
	include_once('utility_lgmis_lib.php');
	include_once($link_to_utility_authorization);

	$title = '';
	$header = '';
	$content = '';

	$title = Language::Word('bookkeeping');
	$header = $title;

	$head_addition = '<script type="text/javascript" src="'.$link_to_classes.'/report.js"></script>';

	if (isset($_REQUEST['content_type'])) {
		switch ($_REQUEST['content_type']) {
			case $content_types_short['reports']: {
				$title .= ' :'.Language::Word('reports');
				$header = $title;

				$content .= MenuButton(Language::Word('send report'), $link_to_admin_report, 'btn-primary', 'add', 'get');

				$content .= MenuButton(Language::Word('received reports'), $link_to_admin_bookkeeping.'?content_type=received_reps', 'btn-default', '', 'get');

				$content .= MenuButton(Language::Word('sended reports'), $link_to_admin_bookkeeping.'?content_type=sended_reps', 'btn-default', '', 'get');

				if (GetUserLogin() === 'admin') {
					$content .= MenuButton(Language::Word('all reports'), $link_to_admin_bookkeeping.'?content_type=all_reps', 'btn-default', '', 'get');
				}

				break;
			}
			case 'received_reps': case 'sended_reps': case 'all_reps': {
				$content_type = $_REQUEST['content_type'];
				if ($content_type === 'all_reps') {
					if (GetUserLogin() !== 'admin') {
						$content = AlertMessage('alert-danger', Language::Word('access denied'));
						break;
					}
				}
				if ($content_type === 'received_reps') $title .= ' :'.Language::Word('received reports');
				else if ($content_type === 'sended_reps') $title .= ' :'.Language::Word('sended reports');
				else $title .= ' :'.Language::Word('all reports');
				$header = $title;

				$reports = array();
				$user = User::FetchBy(['select_list' => 'id, received_reports, sended_reports', 'eq_conds' => ['id' => GetUserID()], 'is_unique' => true]);
				$size = 0;
				$received = array();
				$sended = array();
				if ($content_type === 'received_reps') {
					$received = $user->GetReceivedReports();
					$size = count($received);
				}
				else if ($content_type === 'sended_reps') {
					$sended = $user->GetSendedReports();
					$size = count($sended);
				}
				else {
					$size = Report::GetCount();
				}

				if ($size) {
					require($link_to_pagination_init_template);

					$content .= '<div class="row">';
					$content .= '<div class="'.ColAllTypes(1).' center-block"></div>';
					$content .= '<div class="'.ColAllTypes(10).' center-block">';
					$content .= '<table class="table table-striped text-center">';
					$content .= 	'<thead>';
					$content .= 		'<tr>';
					$content .=				'<th class="text-center">'.Language::Word('author').'</th>';
					$content .=				'<th class="text-center">'.Language::Word('receivers').'</th>';
					$content .=				'<th class="text-center" width="30%">'.Language::Word('header').'</th>';
					$content .=				'<th class="text-center">'.Language::Word('date').'</th>';
					$content .=				'<th class="text-center">'.Language::Word('actions').'</th>';
					$content .=			'</tr>';
					$content .=		'</thead>';
					$content .=		'<tbody>';
					$target = NULL;
					if ($content_type === 'received_reps') {
						$target = $received;
					} else if ($content_type === 'sended_reps') {
						$target = $sended;
					}
					$limit = ($to - $from + 1);
					if ($content_type != 'all_reps') {
						$ids = '';
						for ($i = 0, $cnt = count($target); $i < $cnt; ++$i) {
							$ids .= '(id = '.$target[$i].')';
							if ($i < $cnt - 1) $ids .= ' OR';
						}
						$reports = Report::FetchBy(['where_addition' => $ids, 'limit' => $limit, 'offset' => $from, 'order_by' => 'id DESC']);
					} else {
						$reports = Report::FetchBy(['limit' => $limit, 'offset' => $from, 'order_by' => 'id DESC']);
					}

					for ($i = 0; $i < $limit; ++$i) {
						$content .= ($reports[$i]->ToHTMLAutoShortForTable(GetUserPrivileges()));
					}
					$content .= 	'</tbody>';
					$content .= '</table>';
					$content .= '</div>';
					$content .= '</div>';

					require($link_to_pagination_show_template);
					$content .= $pagination;
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