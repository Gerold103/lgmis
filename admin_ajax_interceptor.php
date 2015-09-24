<?php

	include_once('utility_lgmis_lib.php');
	include_once($link_to_utility_authorization);

	if (isset($_REQUEST['load_users'])) {
		if (isset($_REQUEST['prefix'])) {
			$prefix = $_REQUEST['prefix'];
			$users = User::FetchByPrefix($prefix);
			echo json_encode($users);
			exit();
		}
	}

?>