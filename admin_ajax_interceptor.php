<?php

	include_once('utility_lgmis_lib.php');
	$need_authorization = true;
	$content = NULL;

	if (isset($_REQUEST['load_users'])) {
		if (isset($_REQUEST['prefix'])) {
			$prefix = $_REQUEST['prefix'];
			$users = User::FetchByPrefix($prefix, array('select_list' => array('id', 'name', 'surname')));
			$content = json_encode($users);
		}
	} else if (isset($_REQUEST['search'])) {
		switch ($_REQUEST['search']) {
			case 'global': {
				$text = $_REQUEST['text'];

				$users = User::FetchByPrefix($text, array('select_list' => array('link_to_full', 'id', 'name', 'surname')));
				for ($i = 0; $i < count($users); ++$i) {
					$users[$i]['name'] = Language::Translit($users[$i]['name']);
					$users[$i]['surname'] = Language::Translit($users[$i]['surname']);
				}
				$res = array('users' => $users, 'users_name' => Language::Word('users'));

				$articles = Article::FetchByName($text, array('format' => 'assoc', 'select_list' => array('id', 'name', 'link_to_full')));
				$res['articles'] = $articles;
				$res['articles_name'] = Language::PublicMenu('articles');

				$directions = Direction::FetchByName($text, array('format' => 'assoc', 'select_list' => array('id', 'name', 'link_to_full')));
				$res['directions'] = $directions;
				$res['directions_name'] = Language::PublicMenu('directions');

				$projects = Project::FetchByName($text, array('format' => 'assoc', 'select_list' => array('id', 'name', 'link_to_full')));
				$res['projects'] = $projects;
				$res['projects_name'] = Language::PublicMenu('projects');
 
				$content = json_encode($res);
				break;
			}
			default: break;
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