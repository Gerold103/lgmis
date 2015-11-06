<?php
	$is_public = false;
	include_once('utility_lgmis_lib.php');
	include_once($link_to_utility_authorization);

	$header = '';
	$content = '';
	$footer = '';
	$on_start_page = true;
	
	$header .= Language::Word('main admin page');
	$user = User::FetchBy(['select_list' => 'position', 'eq_conds' => ['id' => GetUserID()], 'is_unique' => true]);

	if (GetUserPrivileges() == admin_user_id) {
		//Manage staff
		$content .=	MenuButton(Language::Word('staff management'), $link_to_admin_manage_staff, 'btn-default', '', 'get');

		//Manage content
		$content .= MenuButton(Language::Word('content management'), $link_to_admin_manage_content, 'btn-default', '', 'get');

		//Requests on register
		$content .= MenuButton(Language::Word('requests on register'), $link_to_admin_requests_on_register, 'btn-default', '', 'get');

	} else {
		//Manage staff
		$content .=	MenuButton(Language::Word('our collective'), $link_to_admin_manage_staff, 'btn-default', '', 'get');

		//Manage content
		$content .= MenuButton(Language::Word('our content'), $link_to_admin_manage_content, 'btn-default', '', 'get');
	}

	$content .= MenuButton(Language::Word('file manager'), $link_to_admin_file_manager, 'btn-default', '', 'get');

	if ($user->GetPositionNum() != NotEmployeeNum)
		$content .= MenuButton(Language::Word('bookkeeping'), $link_to_admin_bookkeeping, 'btn-default', '', 'get');

	include($link_to_admin_template);

	if ($need_to_show_timer)
		echo 'secs: '.(microtime(true) - $start_timer__);
?>