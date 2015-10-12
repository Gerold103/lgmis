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

				$articles = Article::FetchLike('name', ['text' => $text, 'select_list' => 'id, name', 'special' => 'link_to_full', 'is_assoc' => true]);
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
						//$res = Article::FetchBy(array(), array('order_by' => 'id DESC', 'limit' => $records_on_page, 'offset' => $offset));
						$res = Article::FetchBy(['order_by' => 'id DESC', 'limit' => $records_on_page, 'offset' => $offset,
												'select_list' => 'id, name, annotation, creating_date, author_id', 'is_assoc' => true,
												'special' => array('author_link', 'full_vers_link', 'path_to_image')]);
						//var_dump($res);
						if (Error::IsError($res)) {
							$ret = array('error_msg' => '');
							$content = json_encode($ret);
							break;
						}
						$content = json_encode($res);
						break;
					}
					default: break;
				}
				break;
			}
			default: break;
		}
	} else if (isset($_REQUEST['upload'])) {
		if (isset($_FILES['file'])) {
			$dir = '';
			$author_id = GetUserID();
			switch ($_REQUEST['type']) {
				case Report::$type: {
					global $link_to_report_files;
					global $link_prefix;
					$type = fileExtension($_FILES['file']['name']);
					switch ($_REQUEST['files_action']) {
						case 'add': case 'edit': {
							$dir = $_SERVER['DOCUMENT_ROOT'].$link_prefix.$link_to_report_files.'tmp_'.$author_id.'/file.'.$type;
							break;
						}
						default: break;
					}
					break;
				}
				default: break;
			}
			file_put_contents('files/[debug].txt', $dir."\xA".$author_id."\xA");
			move_uploaded_file($_FILES['file']['tmp_name'], $dir);
		}
	} else if (isset($_REQUEST['remove'])) {
		if (isset($_REQUEST['file'])) {
			$dir = '';
			$author_id = GetUserID();
			switch ($_REQUEST['type']) {
				case Report::$type: {
					global $link_to_report_files;
					global $link_prefix;
					switch ($_REQUEST['files_action']) {
						case 'add': case 'edit': $dir = $_SERVER['DOCUMENT_ROOT'].$link_prefix.$link_to_report_files.'tmp_'.$author_id.'/file'; break;
						default: break;
					}
					break;
				}
				default: break;
			}
			delete_file($dir);
		}
	}
	include_once($link_to_utility_authorization);
	echo $content;
	exit();
?>