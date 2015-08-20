<?php
	include_once('utility_lgmis_lib.php');
	//----------------------------------------------------------------A U X I L I A R Y   F U N C T I O N S----------------------------------------------------------------

	//------------------------------------------------D E L E T I N G------------------------------------------------
	if (isset($_POST['del'])) {
		//if action is deleting
		if (isset($_POST['type'])) {
			if (isset($_POST['id'])) {
				$header = '';
				if (!isset($_POST['info'])) {
					$header = 'Вы уверены, что хотите удалить <b>'.$_POST['type'].'</b> с <b>id</b> = '.$_POST['id'].'?';
				} else {
					$header = htmlspecialchars($_POST['info']);
				}
				//form for agree or cancel
				$title = 'Подтверждение удаления';
				$content = DialogFormYesNo($link_to_utility_sql_worker, 'del', $_POST['type'], $_POST['id']);
				require_once($link_to_registering_template);
				exit();
			} else {
				echo 'id is not specified';
			}
		} else {
			echo 'type is not specified';
		}

	//------------------------------------------------E D I T I N G------------------------------------------------

	} else if (isset($_POST['edit'])) {
		//if action is editing
		if (isset($_POST['type'])) {
			if (isset($_POST['id'])) {
				//form for editing
				echo 'Editing here. Details: type='.$_POST['type'].', id='.$_POST['id'].'<br>';
				echo DialogFormYesNo($link_to_utility_sql_worker, 'edit', $_POST['type'], $_POST['id'], 'Сохранить', 'Отменить');
				
				//link on start page
				echo OnStartAdminPage();
				if (isset($_POST['prev_page'])) {
					echo '<br>'.OnPreviousPage($_POST['prev_page']);
				}
			} else {
				echo 'id is not specified';
			}
		} else {
			echo 'type is not specified';
		}

	//------------------------------------------------A D D I N G------------------------------------------------

	} else if (isset($_POST['add'])) {
		//if action is adding
		if (isset($_POST['type'])) {
			if (isset($_POST['id'])) {
				$header = '';
				if (isset($_POST['info'])) {
					$header = $_POST['info'];
				} else {
					$header = 'Вы уверены, что хотите добавить <b>'.$_POST['type'].'</b> с <b>id</b> = '.$_POST['id'].'?';
				}
				//form for agree or cancel
				$title = 'Подтверждение добавления';
				$content = DialogFormYesNo($link_to_utility_sql_worker, 'add', $_POST['type'], $_POST['id']);
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