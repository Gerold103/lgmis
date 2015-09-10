<?php
	$is_public = true;


	include_once('utility_lgmis_lib.php');
	include_once($link_to_utility_authorization);


	$header = Language::PublicMenu('contacts');
	$content = '';
	$footer = '';

	$header_type = 'h4';

	$title = Language::PublicMenu('contacts');

	$content .= '<br><div class="row" align="center">';
	$content .= 	'<div class="'.ColAllTypes(6).' vcenter">';
	$content .= 		'<iframe class="google-map" src="https://www.google.com/maps/embed?pb=!1m24!1m8!1m3!1d8994.513616455022!2d37.532702!3d55.695448!3m2!1i1024!2i768!4f13.1!4m13!3e2!4m5!1s0x46b54cf533082589%3A0x402540c5efcc4157!2z0KHRgtCw0L3RhtC40Y8g0LzQtdGC0YDQviDCq9Cj0L3QuNCy0LXRgNGB0LjRgtC10YLCuywg0KDQvtGB0YHQuNGP!3m2!1d55.692679999999996!2d37.536882!4m5!1s0x46b54c6129ed4359%3A0xe03aa689c99f60f5!2z0KTQsNC60YPQu9GM0YLQtdGCINCS0JzQmiDQnNCT0KMsINGD0LvQuNGG0LAg0JvQtdCx0LXQtNC10LLQsCwg0KHRgtCw0YDQstC40LvRjCwg0JzQvtGB0LrQvtCy0YHQutCw0Y8g0L7QsdC70LDRgdGC0YwsINCg0L7RgdGB0LjRjw!3m2!1d55.698434999999996!2d37.530196!5e0!3m2!1sru!2sru!4v1432075564575"></iframe>';
	$content .= 	'</div>';
	$content .= 	'<div class="'.ColAllTypes(6).' vcenter">'.Language::Address().'</div>';
	$content .= '</div>';
	$content .= '<br>';
	
	$users = User::FetchAllEmployes();
	$size = count($users);
	if ($size > 0) {
		$content .= '<hr><div class="row" align="center">'.ToPageHeader(Language::Word('employees'), 'h4', 'grey').'</div><hr>';
		
		require($link_to_pagination_init_template);

		for ($i = $from; $i <= $to; ++$i) {
			$content .= $users[$i]->ToHTMLAutoShortForTable(GetUserPrivileges());
			if ($i != $to) $content .= '<hr>';
		}

		require($link_to_pagination_show_template);
		$content .= $pagination;
	}

	$no_content_center = true;

	include($link_to_public_template);
?>