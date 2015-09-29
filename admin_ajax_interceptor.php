<?php

	include_once('utility_lgmis_lib.php');
	$need_authorization = true;
	$content = NULL;

	if (isset($_REQUEST['load_users'])) {
		if (isset($_REQUEST['prefix'])) {
			$prefix = $_REQUEST['prefix'];
			$users = User::FetchByPrefix($prefix);
			$content = json_encode($users);
		}
	} else if (isset($_REQUEST['download'])) {
		switch ($_REQUEST['download']) {
			case 'more': {
				switch ($_REQUEST['type']) {
					case Article::$type: {
						$need_authorization = false;
						$offset = $_REQUEST['offset'];
						$res = Article::FetchBy(array(), array('order_by' => 'id DESC', 'limit' => $records_on_page, 'offset' => $offset));
						if (Error::IsError($res)) {
							$ret = array('error_msg' => '');
							$content = json_encode($ret);
							break;
						}
						$objs = array();
						for ($i = 0, $size = count($res); $i < $size; ++$i) {
							array_push($objs, $res[$i]->ToJSON(array('id', 'author_link', 'full_vers_link', 'name', 'annotation', 'creating_date', 'path_to_image')));
						}
						$content = json_encode($objs);
						break;
					}
					default: break;
				}
				break;
			}
			default: break;
		}
	}
	include_once($link_to_utility_authorization);
	echo $content;
	exit();
?>