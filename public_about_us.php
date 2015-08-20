<?php
	$is_public = true;

	include_once('utility_lgmis_lib.php');
	include_once($link_to_utility_authorization);

	$header = 'О нас';
	$content = '';
	$footer = '';

	$header_type = 'h4';

	$title = 'О нас';

	$txt_parts = TextPart::FetchByRole('about_us');
	$size = count($txt_parts);
	if ($size > 0) {
		$records_on_page_old = $records_on_page;
		$records_on_page = 1;

		require($link_to_pagination_init_template);

		for ($i = $from; $i <= $to; ++$i) {
			$content .= '<div class="row">';
			$content .= 	'<div class="'.ColAllTypes(12).'">';
			$content .= 		$txt_parts[$i]->GetTextBlock();
			$content .= 	'</div>';
			$content .= '</div>';
		}

		require($link_to_pagination_show_template);
		$content .= $pagination;
		$records_on_page = $records_on_page_old;
	}

	$no_content_center = true;

	include($link_to_public_template);
?>