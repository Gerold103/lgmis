<?php
	require_once('utility_lgmis_lib.php');

	//--------------------A U X I L I A R Y   F U N C T I O N S--------------------

	if (isset($_POST['new'])) {
		$no_content_center = true;
		$header = 'Регистрация';
		$content = '';
		switch ($_POST['type']) {
			case RequestOnRegister::$type:
				$req = RequestOnRegister::FetchFromPost();
				if ($req === NULL) {
					$content = AlertMessage('alert-danger', 'Не все поля заполнены: '.RequestOnRegister::$last_error);
				} else if (!$req->InsertToDB()) {
					$content = AlertMessage('alert-danger', 'Ошибка при вставке заявки на регистрацию: '.RequestOnRegister::$last_error);
				} else $content = AlertMessage('alert-success', 'Заявка успешно отправлена');
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
			$title = 'Результат удаления';
			$header = 'Результат удаления';
			$content = AlertMessage('alert-warning', 'Удаление отменено');
			require_once($link_to_admin_template);
			exit();
		} else if (isset($_POST['yes'])) {
			//if action is deleting
			if (isset($_POST['type'])) {
				if (isset($_POST['id'])) {
					$title = 'Результат удаления';
					$header = 'Результат удаления';
					$content = '';
					switch($_POST['type']) {
						case RequestOnRegister::$type: {
							if (!RequestOnRegister::Delete($_POST['id'])) {
								$content = AlertMessage('alert-danger', 'Ошибка при отклонении заявки');
							} else {
								$content = AlertMessage('alert-success', 'Заявка отклонена');
							}
							break;
						}
						case User::$type: {
							if (!User::Delete($_POST['id'])) {
								$content = AlertMessage('alert-danger', 'Ошибка при удалении пользователя');
							} else {
								$content = AlertMessage('alert-success', 'Пользователь удален');
							}
							break;
						}
						case Article::$type: {
							if (!Article::Delete($_POST['id'])) {
								$content = AlertMessage('alert-danger', 'Ошибка при удалении новости');
							} else {
								$content = AlertMessage('alert-success', 'Новость удалена');
							}
							break;
						}
						case Direction::$type: {
							if (!Direction::Delete($_POST['id'])) {
								$content = AlertMessage('alert-danger', 'Ошибка при удалении направления');
							} else {
								$content = AlertMessage('alert-success', 'Направление удалено');
							}
							break;
						}
						case UserBlock::$type: {
							if (!UserBlock::Delete($_POST['id'])) {
								$content = AlertMessage('alert-danger', 'Ошибка при удалении блока');
							} else {
								$content = AlertMessage('alert-success', 'Блок удален');
							}
							break;
						}
						case Project::$type: {
							if (!Project::Delete($_POST['id'])) {
								$content = AlertMessage('alert-danger', 'Ошибка при удалении проекта');
							} else {
								$content = AlertMessage('alert-success', 'Проект удален');
							}
							break;
						}
						case TextPart::$type: {
							if (!TextPart::Delete($_POST['id'])) {
								$content = AlertMessage('alert-danger', 'Ошибка при удалении текстового блока');
							} else {
								$content = AlertMessage('alert-success', 'Текстовый блок удален');
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
			$title = 'Результат редактирования';
			$header = 'Результат редактирования';
			$content = AlertMessage('alert-warning', 'Редактирование отменено');
			require_once($link_to_admin_template);
			exit();
		} else if (isset($_POST['yes'])) {
			//if action is editing
			if (isset($_POST['type'])) {
				if (isset($_POST['id'])) {
					$title = 'Результат редактирования';
					$header = 'Результат редактирования';
					$content = '';
					switch ($_POST['type']) {
						case User::$type: {
							$user = User::FetchByID($_POST['id']);
							if ($user->FetchFromAssocEditing($_POST) < 0) {
								$content .= AlertMessage('alert-warning', 'Пользователь не был изменен');
							}
							if ($user->Save() === false) {
								$content .= AlertMessage('alert-danger', 'Не удалось сохранить');
							} else {
								$content .= AlertMessage('alert-success', 'Изменения сохранены');
								if ($user->FetchPhotoFromAssocEditing($_FILES) < 0) {
									$content .= AlertMessage('alert-warning', 'Фото не было загружено');
								}
							}
							break;
						}
						case UserBlock::$type: {
							$block = UserBlock::FetchByID($_POST['id']);
							if ($block === NULL) break;
							$block->FetchFromAssocEditing($_POST);
							if ($block->Save() === false) {
								$content .= AlertMessage('alert-danger', 'Не удалось сохранить');
							} else {
								$content .= AlertMessage('alert-success', 'Изменения сохранены');
							}
							break;
						}
						case Article::$type: {
							$article = Article::FetchByID($_POST['id']);
							if ($article === NULL) break;
							$article->FetchFromAssocEditing($_POST);
							if ($article->Save() === false) {
								$content .= AlertMessage('alert-danger', 'Не удалось сохранить');
							} else {
								$content .= AlertMessage('alert-success', 'Изменения сохранены');
								if ($article->FetchCoverFromAssocEditing($_FILES) < 0) {
									$content .= AlertMessage('alert-warning', 'Обложка не была загружена');
								}
							}
							break;
						}
						case Direction::$type: {
							$direction = Direction::FetchByID($_POST['id']);
							if ($direction === NULL) break;
							$direction->FetchFromAssocEditing($_POST);
							if ($direction->Save() === false) {
								$content .= AlertMessage('alert-danger', 'Не удалось сохранить');
							} else {
								$content .= AlertMessage('alert-success', 'Изменения сохранены');
								if ($direction->FetchCoverFromAssocEditing($_FILES) < 0) {
									$content .= AlertMessage('alert-warning', 'Обложка не была загружена');
								}
							}
							break;
						}
						case Project::$type:
							$project = Project::FetchByID($_POST['id']);
							if ($project === NULL) break;
							$project->FetchFromAssocEditing($_POST);
							if ($project->Save() === false) {
								$content .= AlertMessage('alert-danger', 'Не удалось сохранить');
							} else {
								$content .= AlertMessage('alert-success', 'Изменения сохранены');
							}
							break;
						case TextPart::$type:
							$txt_part = TextPart::FetchByID($_POST['id']);
							if ($txt_part === NULL) break;
							$txt_part->FetchFromAssocEditing($_POST);
							if ($txt_part->Save() === false) {
								$content .= AlertMessage('alert-danger', 'Не удалось сохранить');
							} else {
								$content .= AlertMessage('alert-success', 'Изменения сохранены');
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
					$title = 'Результат добавления';
					$header = 'Результат добавления';
					$content = '';
					$new_id = -1;
					switch ($_POST['type']) {
						case RequestOnRegister::$type:
							$request = RequestOnRegister::FetchByID($_POST['id']);
							if ($request == NULL) {
								$content = AlertMessage('alert-danger', 'Ошибка при добавлении пользователя');
							} else {
								if (!(User::InsertToDB($request))) {
									$content = AlertMessage('alert-danger', 'Ошибка при добавлении пользователя');
								} else {
									$content = AlertMessage('alert-success', 'Заявка принята');
									RequestOnRegister::Delete($_POST['id']);
								}
							}
							break;
						case UserBlock::$type:
							$assoc = $_POST;
							$assoc['author_id'] = $_POST['id'];
							unset($assoc['id']);
							$usr_block = UserBlock::FetchFromAssoc($assoc);
							if ($usr_block === NULL) {
								$content = AlertMessage('alert-danger', 'Ошибка при добавлении блока пользователя');
							} else {
								if (UserBlock::InsertToDB($usr_block))
									$content = AlertMessage('alert-success', 'Блок пользователя успешно добавлен');
								else
									$content = AlertMessage('alert-danger', 'Ошибка при вставке блока в базу');
							}
							break;
						case Article::$type:
							$assoc = $_POST;
							$assoc['author_id'] = $_POST['id'];
							unset($assoc['id']);
							$article = Article::FetchFromAssoc($assoc);
							if ($article === NULL) {
								$content = AlertMessage('alert-danger', 'Ошибка при добавлении новости');
							} else  {
								if (Article::InsertToDB($article))
									$content = AlertMessage('alert-success', 'Новость успешно добавлена');
								else 
									$content = AlertMessage('alert-danger', 'Ошибка при вставке новости в базу');
							}
							break;
						case Direction::$type:
							$assoc = $_POST;
							$assoc['author_id'] = $_POST['id'];
							unset($assoc['id']);
							$direction = Direction::FetchFromAssoc($assoc);
							if ($direction === NULL) {
								$content = AlertMessage('alert-danger', 'Ошибка при добавлении направления');
							} else {
								if (Direction::InsertToDB($direction))
									$content = AlertMessage('alert-success', 'Направление успешно добавлено');
								else
									$content = AlertMessage('alert-danger', 'Ошибка при вставке направления в базу');
							}
							break;
						case Project::$type:
							$assoc = $_POST;
							$assoc['author_id'] = $_POST['id'];
							unset($assoc['id']);
							$project = Project::FetchFromAssoc($assoc);
							if ($project === NULL) {
								$content = AlertMessage('alert-danger', 'Ошибка при добавлении проекта');
							} else {
								if (Project::InsertToDB($project))
									$content = AlertMessage('alert-success', 'Проект успешно добавлен');
								else
									$content = AlertMessage('alert-danger', 'Ошибка при вставки проекта в базу');
							}
							break;
						case TextPart::$type:
							$assoc = $_POST;
							$assoc['author_id'] = $_POST['id'];
							unset($assoc['id']);
							$part = TextPart::FetchFromAssoc($assoc);
							if ($part === NULL) {
								$content = AlertMessage('alert-danger', 'Ошибка при добавлении текстового блока');
							} else {
								if (TextPart::InsertToDB($part))
									$content = AlertMessage('alert-success', 'Текст успешно добавлен');
								else
									$content = AlertMessage('alert-danger', 'Ошибка при вставке текста в базу');
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