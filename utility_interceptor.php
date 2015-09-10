<?php
	include_once('utility_lgmis_lib.php');
	require_once($link_to_utility_authorization);

	//----------------------------------------------------------------A U X I L I A R Y   F U N C T I O N S----------------------------------------------------------------
	if (isset($_REQUEST['lang'])) {
		$lang = $_REQUEST['lang'];
		if (CheckLanguage($lang) === false) {
			echo AlertMessage('danger', 'Язык '.$lang.' не найден');
			exit();
		}
		$_SESSION['lang'] = $lang;
		header('Location: '.Link::Get(''));
	}

	//------------------------------------------------D E L E T I N G------------------------------------------------
	if (isset($_REQUEST['del'])) {
		//if action is deleting
		if (isset($_REQUEST['type'])) {
			if (isset($_REQUEST['id'])) {
				$header = '';
				if (!isset($_REQUEST['info'])) {
					if ($_REQUEST['type'] === RequestOnRegister::$type) {
						$_REQUEST['info'] = 'Вы уверены, что хотите отклонить запрос пользователя '.RequestOnRegister::FetchByID($_REQUEST['id'])->name.'?';
					} else if ($_REQUEST['type'] === Article::$type) {
						$_REQUEST['info'] = 'Вы уверены, что хотите удалить новость с заголовком '.Article::FetchByID($_REQUEST['id'])->name.'?';
					}
				}
				if (!isset($_REQUEST['info'])) {
					$header = 'Вы уверены, что хотите удалить <b>'.$_REQUEST['type'].'</b> с <b>id</b> = '.$_REQUEST['id'].'?';
				} else {
					$header = htmlspecialchars($_REQUEST['info']);
				}
				//form for agree or cancel
				$title = 'Подтверждение удаления';
				$content = DialogFormYesNo($link_to_utility_sql_worker, 'del', $_REQUEST['type'], $_REQUEST['id']);
				require_once($link_to_registering_template);
				exit();
			} else {
				echo 'id is not specified';
			}
		} else {
			echo 'type is not specified';
		}

	//------------------------------------------------E D I T I N G------------------------------------------------

	} else if (isset($_REQUEST['edit'])) {
		//if action is editing
		if (isset($_REQUEST['type'])) {
			if (isset($_REQUEST['id'])) {
				//form for editing
				echo 'Editing here. Details: type='.$_REQUEST['type'].', id='.$_REQUEST['id'].'<br>';
				echo DialogFormYesNo($link_to_utility_sql_worker, 'edit', $_REQUEST['type'], $_REQUEST['id'], 'Сохранить', 'Отменить');
				
				//link on start page
				echo OnStartAdminPage();
				if (isset($_REQUEST['prev_page'])) {
					echo '<br>'.OnPreviousPage($_REQUEST['prev_page']);
				}
			} else {
				echo 'id is not specified';
			}
		} else {
			echo 'type is not specified';
		}

	//------------------------------------------------A D D I N G------------------------------------------------

	} else if (isset($_REQUEST['add'])) {
		//if action is adding
		if (isset($_REQUEST['type'])) {
			if (isset($_REQUEST['id'])) {
				$header = '';
				if (!isset($_REQUEST['info'])) {
					if ($_REQUEST['type'] === RequestOnRegister::$type) {
						$_REQUEST['info'] = 'Вы уверены, что хотите принять запрос пользователя '.RequestOnRegister::FetchByID($_REQUEST['id'])->name.'?';
					}
				}

				if (isset($_REQUEST['info'])) {
					$header = $_REQUEST['info'];
				} else {
					$header = 'Вы уверены, что хотите добавить <b>'.$_REQUEST['type'].'</b> с <b>id</b> = '.$_REQUEST['id'].'?';
				}
				//form for agree or cancel
				$title = 'Подтверждение добавления';
				$content = DialogFormYesNo($link_to_utility_sql_worker, 'add', $_REQUEST['type'], $_REQUEST['id']);
				require_once($link_to_registering_template);
				exit();
			} else {
				echo 'id is not specified';
			}
		} else {
			echo 'type is not specified';
		}
	} else {
		echo 'nothing to do';
	}
?>