<?php
	$is_public = false;
	include_once('utility_lgmis_lib.php');
	include_once($link_to_utility_authorization);

	$header = '';
	$content = '';
	$footer = '';
	$on_start_page = true;
	
	$header .= 'Главная';

	if (GetUserPrivileges() == admin_user_id) {
		//Manage staff
		$content .=	MenuButton('Управление штатом', $link_to_admin_manage_staff, 'btn-default', '', 'get');

		//Manage content
		$content .= MenuButton('Управление контентом', $link_to_admin_manage_content, 'btn-default', '', 'get');

		//Requests on register
		$content .= MenuButton('Заявки на регистрацию', $link_to_admin_requests_on_register, 'btn-default', '', 'get');
	} else {
		//Manage staff
		$content .=	MenuButton('Наш коллектив', $link_to_admin_manage_staff, 'btn-default', '', 'get');

		//Manage content
		$content .= MenuButton('Наш контент', $link_to_admin_manage_content, 'btn-default', '', 'get');
	}

	include($link_to_admin_template);
?>