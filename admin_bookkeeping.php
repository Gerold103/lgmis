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
				break;
			}
			default: break;
		}
	} else {
		$content = MenuButton(Language::Word('reports'), $link_to_admin_bookkeeping.'?content_type='.$content_types_short['reports'], 'btn-default', '', 'get');
	}
	include_once($link_to_admin_template);
?>