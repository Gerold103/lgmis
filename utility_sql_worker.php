<?php
	require_once('utility_lgmis_lib.php');

	//--------------------A U X I L I A R Y   F U N C T I O N S--------------------

	if (isset($_POST['new'])) {
		$no_content_center = true;
		$header = Language::Word('registration');
		$content = '';
		switch ($_POST['type']) {
			case RequestOnRegister::$type:
				$req = RequestOnRegister::FetchFromPost();
				if ($req === NULL) {
					$content = AlertMessage('alert-danger', Language::Word('not all fields are filled').': '.RequestOnRegister::$last_error);
				} else if (!$req->InsertToDB()) {
					$content = AlertMessage('alert-danger', Language::Word('error while inserting register request').': '.RequestOnRegister::$last_error);
				} else $content = AlertMessage('alert-success', Language::Word('request was successfully sended'));
				break;
			default:
				echo '<font color="red">Некорректный тип объекта для добавления</font>';
				exit();
				break;
		}
		require_once($link_to_registering_template);
		exit();
	}
	require_once($link_to_utility_authorization);

	if (isset($_POST['del'])) {
		if (isset($_POST['no'])) {
			$title = Language::Word('deleting result');
			$header = $title;
			$content = AlertMessage('alert-warning', Language::Word('deleting is canceled'));
			require_once($link_to_admin_template);
			exit();
		} else if (isset($_POST['yes'])) {
			//if action is deleting
			if (isset($_POST['type'])) {
				if (isset($_POST['id'])) {
					$title = Language::Word('deleting result');
					$header = $title;
					$content = '';
					switch($_POST['type']) {
						case RequestOnRegister::$type: {
							if (!RequestOnRegister::Delete($_POST['id'])) {
								$content = AlertMessage('alert-danger', Language::Word('error while request rejecting'));
							} else {
								$content = AlertMessage('alert-success', Language::Word('request is rejected'));
							}
							break;
						}
						case User::$type: {
							if (!User::Delete($_POST['id'])) {
								$content = AlertMessage('alert-danger', Language::Word('error while user deleting'));
							} else {
								$content = AlertMessage('alert-success', Language::Word('user is deleted'));
							}
							break;
						}
						case Article::$type: {
							if (!Article::Delete($_POST['id'])) {
								$content = AlertMessage('alert-danger', Language::Word('error while article deleting'));
							} else {
								$content = AlertMessage('alert-success', Language::Word('article is deleted'));
							}
							break;
						}
						case Report::$type: {
							if (!Report::Delete($_POST['id'])) {
								$content = AlertMessage('alert-danger', Language::Word('error while report deleting'));
							} else {
								$content = AlertMessage('alert-success', Language::Word('report is deleted'));
							}
							break;
						}
						case Direction::$type: {
							if (!Direction::Delete($_POST['id'])) {
								$content = AlertMessage('alert-danger', Language::Word('error while direction deleting'));
							} else {
								$content = AlertMessage('alert-success', Language::Word('direction is deleted'));
							}
							break;
						}
						case UserBlock::$type: {
							if (!UserBlock::Delete($_POST['id'])) {
								$content = AlertMessage('alert-danger', Language::Word('error while user block deleting'));
							} else {
								$content = AlertMessage('alert-success', Language::Word('user block is deleted'));
							}
							break;
						}
						case Project::$type: {
							if (!Project::Delete($_POST['id'])) {
								$content = AlertMessage('alert-danger', Language::Word('error while project deleting'));
							} else {
								$content = AlertMessage('alert-success', Language::Word('project is deleted'));
							}
							break;
						}
						case TextPart::$type: {
							if (!TextPart::Delete($_POST['id'])) {
								$content = AlertMessage('alert-danger', Language::Word('error while text block deleting'));
							} else {
								$content = AlertMessage('alert-success', Language::Word('text block is deleted'));
							}
							break;
						}
					}
					require_once($link_to_admin_template);
					exit();
				} else {
					echo 'id is not specified';
				}
			} else {
				echo 'type is not specified';
			}
		} else {
			echo 'action is not specified';
		}
	} else if (isset($_POST['edit'])) {
		if (isset($_POST['no'])) {
			$title = Language::Word('editing result');
			$header = $title;
			$content = AlertMessage('alert-warning', Language::Word('editing is canceled'));
			require_once($link_to_admin_template);
			exit();
		} else if (isset($_POST['yes'])) {
			//if action is editing
			if (isset($_POST['type'])) {
				if (isset($_POST['id'])) {
					$title = Language::Word('editing result');
					$header = $title;
					$content = '';
					switch ($_POST['type']) {
						case User::$type: {
							$user = User::FetchByID($_POST['id']);
							if ($user->FetchFromAssocEditing($_POST) < 0) {
								$content .= AlertMessage('alert-warning', Language::Word('user was not changed'));
							}
							if ($user->Save() === false) {
								$content .= AlertMessage('alert-danger', Language::Word('it was not succeeded to save'));
							} else {
								$content .= AlertMessage('alert-success', Language::Word('changes are saved'));
								if ($user->FetchPhotoFromAssocEditing($_FILES) < 0) {
									$content .= AlertMessage('alert-warning', Language::Word('photo was not uploaded'));
								}
							}
							break;
						}
						case UserBlock::$type: {
							$block = UserBlock::FetchByID($_POST['id']);
							if ($block === NULL) break;
							$block->FetchFromAssocEditing($_POST);
							if ($block->Save() === false) {
								$content .= AlertMessage('alert-danger', Language::Word('it was not succeeded to save'));
							} else {
								$content .= AlertMessage('alert-success', Language::Word('changes are saved'));
							}
							break;
						}
						case Article::$type: {
							$article = Article::FetchByID($_POST['id']);
							if ($article === NULL) break;
							$article->FetchFromAssocEditing($_POST);
							if ($article->Save() === false) {
								$content .= AlertMessage('alert-danger', Language::Word('it was not succeeded to save'));
							} else {
								$content .= AlertMessage('alert-success', Language::Word('changes are saved'));
								if ($article->FetchCoverFromAssocEditing($_FILES) < 0) {
									$content .= AlertMessage('alert-warning', Language::Word('cover was not uploaded'));
								}
							}
							break;
						}
						case Report::$type: {
							$ob = Report::FetchByID($_POST['id']);
							if (Error::IsError($ob)) break;
							$ob->FetchFromAssocEditing($_POST);
							if (Error::IsError($ob->Save())) {
								$content .= AlertMessage('alert-danger', Language::Word('it was not succeeded to save'));
							} else {
								$content .= AlertMessage('alert-success', Language::Word('changes are saved'));
								// if ($ob->FetchFileFromAssocEditing($_FILES) < 0) {
								// 	$content .= AlertMessage('alert-warning', Language::Word('file was not uploaded'));
								// }
							}
							break;
						}
						case Direction::$type: {
							$direction = Direction::FetchByID($_POST['id']);
							if ($direction === NULL) break;
							$direction->FetchFromAssocEditing($_POST);
							if ($direction->Save() === false) {
								$content .= AlertMessage('alert-danger', Language::Word('it was not succeeded to save'));
							} else {
								$content .= AlertMessage('alert-success', Language::Word('changes are saved'));
								if ($direction->FetchCoverFromAssocEditing($_FILES) < 0) {
									$content .= AlertMessage('alert-warning', Language::Word('cover was not uploaded'));
								}
							}
							break;
						}
						case Project::$type:
							$project = Project::FetchByID($_POST['id']);
							if ($project === NULL) break;
							$project->FetchFromAssocEditing($_POST);
							if ($project->Save() === false) {
								$content .= AlertMessage('alert-danger', Language::Word('it was not succeeded to save'));
							} else {
								$content .= AlertMessage('alert-success', Language::Word('changes are saved'));
							}
							break;
						case TextPart::$type:
							$txt_part = TextPart::FetchByID($_POST['id']);
							if ($txt_part === NULL) break;
							$txt_part->FetchFromAssocEditing($_POST);
							if ($txt_part->Save() === false) {
								$content .= AlertMessage('alert-danger', Language::Word('it was not succeeded to save'));
							} else {
								$content .= AlertMessage('alert-success', Language::Word('changes are saved'));
							}
							break;
						default:
							# code...
							break;
					}

					require_once($link_to_admin_template);
					exit();
				} else {
					echo 'id is not specified';
				}
			} else {
				echo 'type is not specified';
			}
		} else {
			echo 'action is not specified';
		}
	} else if (isset($_POST['add'])) {
		if (isset($_POST['no'])) {
			echo 'Canceled';
		} else if (isset($_POST['yes'])) {
			//if action is adding
			if (isset($_POST['type'])) {
				if (isset($_POST['id'])) {
					$title = Language::Word('adding result');
					$header = $title;
					$content = '';
					$new_id = -1;
					switch ($_POST['type']) {
						case RequestOnRegister::$type:
							$request = RequestOnRegister::FetchByID($_POST['id']);
							if ($request == NULL) {
								$content = AlertMessage('alert-danger', Language::Word('error while user adding'));
							} else {
								if (!(User::InsertToDB($request))) {
									$content = AlertMessage('alert-danger', Language::Word('error while user adding'));
								} else {
									$content = AlertMessage('alert-success', Language::Word('request is accepted'));
									RequestOnRegister::Delete($_POST['id']);
								}
							}
							break;
						case UserBlock::$type:
							$usr_block = UserBlock::FetchFromAssoc($_POST);
							if ($usr_block === NULL) {
								$content = AlertMessage('alert-danger', Language::Word('error while user block adding'));
							} else {
								$glob_id = 0;
								if (isset($_POST['glob_id'])) $glob_id = $_POST['glob_id'];
								if (UserBlock::InsertToDB($usr_block, $_POST['language'], $glob_id))
									$content = AlertMessage('alert-success', Language::Word('user block is successfully added'));
								else
									$content = AlertMessage('alert-danger', Language::Word('error during user block inserting'));
							}
							break;
						case Article::$type:
							$assoc = $_POST;
							$assoc['author_id'] = $_POST['id'];
							unset($assoc['id']);
							$article = Article::FetchFromAssoc($assoc);
							if ($article === NULL) {
								$content = AlertMessage('alert-danger', Language::Word('error while article adding'));
							} else  {
								$glob_id = 0;
								if (isset($_POST['glob_id'])) $glob_id = $_POST['glob_id'];
								if (Article::InsertToDB($article, $_POST['language'], $glob_id))
									$content = AlertMessage('alert-success', Language::Word('article is successfully added'));
								else 
									$content = AlertMessage('alert-danger', Language::Word('error during article inserting'));
							}
							break;
						case Report::$type:
							$assoc = $_POST;
							$assoc['author_id'] = $_POST['id'];
							unset($assoc['id']);
							$ob = Report::FetchFromAssoc($assoc);
							if (Error::IsError($ob)) {
								$content = AlertMessage('alert-danger', Language::Word('error while report sending'));
							} else {
								if (Report::InsertToDB($ob))
									$content = AlertMessage('alert-success', Language::Word('report is successfully sended'));
								else
									$content = AlertMessage('alert-danger', Language::Word('error while report inserting'));
							}
							break;
						case Direction::$type:
							$assoc = $_POST;
							$assoc['author_id'] = $_POST['id'];
							unset($assoc['id']);
							$direction = Direction::FetchFromAssoc($assoc);
							if ($direction === NULL) {
								$content = AlertMessage('alert-danger', Language::Word('error during direction adding'));
							} else {
								$glob_id = 0;
								if (isset($_POST['glob_id'])) $glob_id = $_POST['glob_id'];
								if (Direction::InsertToDB($direction, $_POST['language'], $glob_id))
									$content = AlertMessage('alert-success', Language::Word('direction is successfully added'));
								else
									$content = AlertMessage('alert-danger', Language::Word('error during direction inserting'));
							}
							break;
						case Project::$type:
							$assoc = $_POST;
							$assoc['author_id'] = $_POST['id'];
							unset($assoc['id']);
							$project = Project::FetchFromAssoc($assoc);
							if ($project === NULL) {
								$content = AlertMessage('alert-danger', Language::Word('error during project adding'));
							} else {
								$glob_id = 0;
								if (isset($_POST['glob_id'])) $glob_id = $_POST['glob_id'];
								if (Project::InsertToDB($project, $_POST['language'], $glob_id))
									$content = AlertMessage('alert-success', Language::Word('project is successfully added'));
								else
									$content = AlertMessage('alert-danger', Language::Word('error during project inserting'));
							}
							break;
						case TextPart::$type:
							$assoc = $_POST;
							$assoc['author_id'] = $_POST['id'];
							unset($assoc['id']);
							$part = TextPart::FetchFromAssoc($assoc);
							if ($part === NULL) {
								$content = AlertMessage('alert-danger', Language::Word('error during text block adding'));
							} else {
								$glob_id = 0;
								if (isset($_POST['glob_id'])) $glob_id = $_POST['glob_id'];
								if (TextPart::InsertToDB($part, $_POST['language'], $glob_id))
									$content = AlertMessage('alert-success', Language::Word('text block is successfully added'));
								else
									$content = AlertMessage('alert-danger', Language::Word('error during text block inserting'));
							}
							break;
						default:
							# code...
							break;
					}

					require_once($link_to_admin_template);
					exit();
				} else {
					echo 'id is not specified';
				}
			} else {
				echo 'type is not specified';
			}
		} else {
			echo 'action is not specified';
		}
	}else {
		echo 'nothing to do';
	}
?>