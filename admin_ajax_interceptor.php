<?php

	include_once('utility_lgmis_lib.php');
	$need_authorization = true;
	$content = NULL;

	if (isset($_REQUEST['load_users'])) {
		if (isset($_REQUEST['prefix'])) {
			$prefix = $_REQUEST['prefix'];
			$users = User::FetchLike($prefix, ['select_list' => 'id, name, surname', 'is_assoc' => true]);
			$content = json_encode($users);
		}
	} else if (isset($_REQUEST['search'])) {
		switch ($_REQUEST['search']) {
			case 'global': {
				$text = $_REQUEST['text'];

				$users = User::FetchLike($text, ['select_list' => 'id, name, surname', 'is_assoc' => true, 'special' => ['link_to_full']]);
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
			case 'link': {
				switch ($_REQUEST['type']) {
					case 'file': {
						$file = MyFile::FetchBy(['select_list' => 'name, path_to_file', 'eq_conds' => ['id' => $_REQUEST['id']], 'is_unique' => true]);
						$url = $file->GetURLToFile();
						$link = SecretLink::CreateForActualLink($url);
						if (Error::IsError($link)) {
							$content = json_encode(['error' => Error::ToString($link)]);
							break;
						}
						global $link_prefix;
						$content = json_encode(['link' => 'http://'.$_SERVER["HTTP_HOST"].$link_prefix.'download/'.$link->GetPublicLink()]);
						break;
					}
					default: break;
				}
				break;
			}
			case 'more': {
				switch ($_REQUEST['type']) {
					case Article::$type: {
						$need_authorization = false;
						$offset = $_REQUEST['offset'];
						$res = Article::FetchBy(['order_by' => 'id DESC', 'limit' => $records_on_page, 'offset' => $offset,
												'select_list' => 'id, name, annotation, creating_date, author_id', 'is_assoc' => true,
												'special' => array('author_link', 'full_vers_link', 'path_to_image')]);
						if (Error::IsError($res)) {
							$ret = array('error_msg' => Error::ToString($res));
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
			case 'info': {
				switch ($_REQUEST['type']) {
					case MyFile::$type: {
						$optional_data = json_decode($_REQUEST['optional_data']);
						$dir = $optional_data->cur_directory;
						$dirstr = '';
						for ($i = 0, $size = count($dir); $i < $size; ++$i) $dirstr .= $dir[$i].'/';
						$my_rights = MyFile::perm_to_all_registered;
						$author_id = GetUserID();
						$iam = User::FetchBy(['select_list' => 'position', 'eq_conds' => array('id' => $author_id), 'is_unique' => true]);
						if (Error::IsError($iam)) {
							$content = json_encode(['error' => Error::ToString($obs)]);
							break;
						}
						if ($iam->GetPositionNum() != NotEmployeeNum) $my_rights = MyFile::perm_to_only_empls;
						$obs = MyFile::FetchBy(['select_list' => 'id, name, is_directory, path_to_file, owner_id, permissions', 'order_by' => 'is_directory DESC, name', 'special' => ['file_type', 'link_to_download', 'link_to_delete', 'link_to_edit', 'link_to_link_to_download'], 'eq_conds' => ['path_to_file' => json_encode($dir)], 'is_assoc' => true, 'where_addition' => 'permissions <= '.$my_rights]);
						if (Error::IsError($obs)) {
							$content = json_encode(["error" => Error::ToString($obs)]);
							break;
						}
						$content = json_encode($obs);
						break;
					}
					default: break;
				}
			}
			default: break;
		}
	} else if (isset($_REQUEST['upload'])) {
		if (isset($_FILES['file'])) {
			global $link_prefix;
			$dir = '';
			$author_id = GetUserID();
			switch ($_REQUEST['type']) {
				case Report::$type: {
					global $link_to_report_files;
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
				case MyFile::$type: {
					global $link_to_files_manager_dir;
					$file = urlencode($_FILES['file']['name']);
					switch ($_REQUEST['files_action']) {
						case 'add': {
							$dir = $_SERVER['DOCUMENT_ROOT'].$link_prefix.$link_to_files_manager_dir.'tmp_'.$author_id.'/'.$file;
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
			global $link_prefix;
			switch ($_REQUEST['type']) {
				case Report::$type: {
					global $link_to_report_files;
					switch ($_REQUEST['files_action']) {
						case 'add': case 'edit': $dir = $_SERVER['DOCUMENT_ROOT'].$link_prefix.$link_to_report_files.'tmp_'.$author_id.'/file'; break;
						default: break;
					}
					break;
				}
				case MyFile::$type: {
					global $link_to_files_manager_dir;
					switch ($_REQUEST['files_action']) {
						case 'add': {
							$filename = $_REQUEST['filename'];
							$dir = $_SERVER['DOCUMENT_ROOT'].$link_prefix.$link_to_files_manager_dir.'tmp_'.$author_id.'/'.$filename;
							break;
						}
						case 'del': {
							$ob_id = $_REQUEST['remove'];
							$ob = MyFile::FetchBy(['select_list' => 'path_to_file, is_directory, id, name', 'eq_conds' => ['id' => $ob_id], 'is_unique' => true]);
							if (Error::IsError($ob)) {
								$content = json_encode(['error' => Error::ToString($ob)]);
								break;
							}
							$rc = $ob->Delete();
							if (Error::IsError($rc)) {
								$content = json_encode(['error' => Error::ToString($rc)]);
								break;
							}
							$content = json_encode(['ok' => true]);
							break;
						}
						default: break;
					}
					break;
				}
				default: break;
			}
			delete_file($dir);
		}
	} else if (isset($_REQUEST['edit'])) {
		global $link_prefix;
		$author_id = GetUserID();
		switch ($_REQUEST['type']) {
			case MyFile::$type: {
				global $link_to_files_manager_dir;
				$ob_id = $_REQUEST['edit'];
				$file = MyFile::FetchBy(['eq_conds' => ['id' => $ob_id], 'is_unique' => true]);
				if (Error::IsError($file)) {
					$content = json_encode(['error' => Error::ToString($file)]);
					break;
				}
				$old_name = $file->GetName();
				if (ArrayElemIsValidStr($_REQUEST, 'name')) $file->SetName(urlencode($_REQUEST['name']));
				if (ArrayElemIsValidStr($_REQUEST, 'permissions')) $file->SetPermissions($_REQUEST['permissions']);
				if ($old_name != $file->GetName()) {
					$path = $file->GetPathToFileStr();
					if (file_exists($path.$file->GetName())) {
						$content = json_encode(['error' => 'File '.$file->GetName().' already exists']);
						break;
					}
					if (!rename($path.$old_name, $path.$file->GetName())) {
						$content = json_encode(['error' => 'Error while renaming file']);
						break;
					}
				}
				$rc = $file->Save();
				if (Error::IsError($rc)) {
					$content = json_encode(['error' => Error::ToString($rc)]);
					break;
				}
				$content = json_encode(['ok' => true]);
				break;
			}
			default: break;
		}
	} else if (isset($_REQUEST['save'])) {
		global $link_prefix;
		$dir = '';
		$author_id = GetUserID();
		switch ($_REQUEST['type']) {
			case MyFile::$type: {
				global $link_to_files_manager_dir;
				$optional_data = json_decode($_REQUEST['optional_data']);
				$perms = MyFile::PermissionsFromString($optional_data->permissions);
				$dir = $_SERVER['DOCUMENT_ROOT'].$link_prefix;
				if ($_REQUEST['save'] === 'folder') {
					$cur_directory = '';
					foreach ($optional_data->cur_directory as $key => $value) {
						$cur_directory .= $value.'/';
					}
					$name = urlencode($optional_data->folder_name);
					$dir .= $cur_directory.$name;
					$rc = @mkdir($dir);
					if ($rc === false) {
						$content = json_encode(['error' => 'Directory can\'t be created']);
						break;
					}
					$rc = MyFile::InsertToDB(MyFile::FetchFromAssoc(['owner_id' => $author_id, 'name' => $name,
						'path_to_file' => $optional_data->cur_directory, 'permissions' => $perms, 'is_directory' => true]));
					if (Error::IsError($rc)) {
						$content = json_encode(['error' => Error::ToString($rc)]);
						break;
					}
					$content = json_encode(['ok' => true]);
					break;
				}

				$perms = MyFile::PermissionsFromString($optional_data->permissions);
				$dir .= $link_to_files_manager_dir.'tmp_'.$author_id.'/';
				$dir_it = new DirectoryIterator($dir);
				$myfiles = array();
				while ($dir_it->valid()) {
					if (!$dir_it->isDot()) {
						$myfile = MyFile::FetchFromAssoc(['owner_id' => $author_id, 'name' => $dir_it->getFilename(),
							'path_to_file' => $optional_data->cur_directory, 'permissions' => $perms, 'is_directory' => false]);
						array_push($myfiles, $myfile);
					}
					$dir_it->next();
				}
				$new_dir = '';
				for ($i = 0, $size = count($optional_data->cur_directory); $i < $size; ++$i) {
					$new_dir .= $optional_data->cur_directory[$i].'/';
				}
				$new_dir = $_SERVER['DOCUMENT_ROOT'].$link_prefix.$new_dir;
				//check existing names
				$new_dir_it = new DirectoryIterator($new_dir);
				$size = count($myfiles);
				$is_error = false;
				while ($new_dir_it->valid()) {
					$name = $new_dir_it->getFilename();
					for ($i = 0; $i < $size; ++$i) {
						if ($name === $myfiles[$i]->GetName()) {
							$is_error = true;
							$content = json_encode(['error' => 'File with name '.$name.' already exists']);
							break;
						}
					}
					if ($is_error) break;
					$new_dir_it->next();
				}
				if ($is_error) break;
				for ($i = 0; $i < $size; ++$i) {
					if ($rc = Error::IsError(MyFile::InsertToDB($myfiles[$i]))) {
						$content = json_encode(['error' => Error::ToString($rc)]);
						$is_error = true;
						break;
					}
				}
				if ($is_error) break;
				simple_copy($dir, $new_dir);
				clear_tmp_files_dir(MyFile::$type, 0);
				$content = json_encode(['ok' => true]);
				break;
			}
			default: break;
		}
	}
	include_once($link_to_utility_authorization);
	echo $content;
	exit();
?>