<?php
	include_once('utility_lgmis_lib.php');
	include_once($link_to_utility_authorization);

	$title = '';
	$header = '';
	$content = '';

	if (isset($_POST['add'])) {
		clear_tmp_images_dir(UserBlock::$type, $_POST['id']);

		$title = 'Добавление блока';
		$header = 'Добавление блока';

		global $link_to_utility_sql_worker;
		global $link_to_img_upload;
		$content .= '<form method="post" action="'.$link_to_utility_sql_worker.'">';
		$content .= 	PairLabelAndInput(4, 5, 'Заголовок', 'name', 'Введите заголовок');
		$content .=		PairLabelAndInput(4, 5, 'Приоритет', 'priority', '(пока обязательно)');
		$content .= 	WrapToHiddenInputs(array('type' => UserBlock::$type, 'yes' => '', 'id' => $_POST['id']));
		$content .= 	'<div class="row"><h3>Текст</h3></div>';
		$content .=		'<div class="row">';
		$content .=			'<div class="'.ColAllTypes(8).' '.ColOffsetAllTypes(2).'" align="center">';
		$content .= 			'<textarea id="text_block" name="text_block"></textarea>';
		$content .=			'</div>';
		$content .= 	'</div>';
		$content .=		'<script>';
		$content .=			'CKEDITOR.replace("text_block",';
		$content .= 			'{ filebrowserImageUploadUrl: "'.$link_to_img_upload.'?'.http_build_query($_POST).'",';
		$content .= 			'contentsCss: [CKEDITOR.basePath + "contents.css", "css/styles.css", "css/bootstrap.min.css"],';
		$content .= 			'allowedContent: true, });';
		$content .=			'CKEDITOR.config.height = 400;';
		$content .=		'</script>';
		$content .= 	'<div class="row">';
		$content .=			'<input type="submit" class="btn btn-primary btn-lg" name="add" value="Сохранить">';
		$content .=		'</div>';
		$content .= '</form>';
	} else if (isset($_POST['edit'])) {
		global $link_to_utility_sql_worker;
		global $link_to_img_upload;
		$block_id = $_POST['id'];
		$block = UserBlock::FetchByID($block_id);
		$assoc = $_POST;
		$assoc['author_id'] = $block->author_id;

		$content .= '<form method="post" action="'.$link_to_utility_sql_worker.'">';
		$content .= 	PairLabelAndInput(4, 5, 'Заголовок', 'name', 'Введите заголовок', $block->name);
		$content .=		PairLabelAndInput(4, 5, 'Приоритет', 'priority', '(пока обязательно)', $block->priority);
		$content .= 	WrapToHiddenInputs(array('type' => UserBlock::$type, 'yes' => '', 'id' => $block_id));
		$content .= 	'<div class="row"><h3>Текст</h3></div>';
		$content .=		'<div class="row">';
		$content .=			'<div class="'.ColAllTypes(8).' '.ColOffsetAllTypes(2).'" align="center">';
		$content .= 			'<textarea id="text_block" name="text_block">'.$block->text_block.'</textarea>';
		$content .=			'</div>';
		$content .= 	'</div>';
		$content .=		'<script>';
		$content .=			'CKEDITOR.replace("text_block",';
		$content .= 			'{ filebrowserImageUploadUrl: "'.$link_to_img_upload.'?'.http_build_query($assoc).'",';
		$content .= 			'contentsCss: [CKEDITOR.basePath + "contents.css", "css/styles.css", "css/bootstrap.min.css"],';
		$content .= 			'allowedContent: true, });';
		$content .=			'CKEDITOR.config.height = 400;';
		$content .=		'</script>';
		$content .= 	'<div class="row">';
		$content .=			DialogInputsYesNo('edit', $_POST['type'], $block_id, 'Сохранить', 'Отменить', true);
		$content .=		'</div>';
		$content .= '</form>';


		$title = 'Редактирование блока';
		$header = 'Редактирование блока';
	} else {

		if (!isset($_POST['full'])) {
			echo 'action_type is unset. Must be "full"';
			exit();
		}
		if (!isset($_POST['type'])) {
			echo 'object type is unset. Must be "user"';
			exit();
		}
		if (!isset($_POST['id'])) {
			echo 'user id is unset';
			exit();
		}

		$user_block = UserBlock::FetchByID($_POST['id']);

		$title = 'Блок информации';

		$header = htmlspecialchars($user_block->name);

		$content = $user_block->ToHTMLAutoFull(GetUserPrivileges());
	}

	include_once($link_to_admin_template);
?>