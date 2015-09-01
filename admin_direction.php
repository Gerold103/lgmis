<?php
	include_once('utility_lgmis_lib.php');
	include_once($link_to_utility_authorization);

	$title = '';
	$header = '';
	$content = '';
	$prev_page = $link_to_admin_manage_content.'?content_type='.$content_types_short['directions'];

	if (isset($_REQUEST['add'])) {
		$id = User::GetIDByLogin($_SESSION['user_login']);
		clear_tmp_images_dir(Direction::$type, $id);

		global $link_to_utility_sql_worker;
		global $link_to_img_upload;

		$content .= '<form method="post" action="'.$link_to_utility_sql_worker.'" enctype="multipart/form-data">';
		$content .= 	PairLabelAndInput(4, 5, 'Заголовок', 'name', 'Введите заголовок').'<br>';
		$content .= 	PairLabelAndInputFile(4, 5, 'Обложка', 'cover');
		$content .= 	WrapToHiddenInputs(array('type' => Direction::$type, 'yes' => '', 'id' => $id));
		$content .= 	'<div class="row"><h3>Текст</h3></div>';
		$content .=		'<div class="row">';
		$content .=			'<div class="'.ColAllTypes(8).' '.ColOffsetAllTypes(2).'" align="center">';
		$content .= 			'<textarea id="text_block" name="text_block"></textarea>';
		$content .=			'</div>';
		$content .= 	'</div>';
		$content .=		'<script>';
		$content .=			'CKEDITOR.replace("text_block",';
		$content .= 			'{ filebrowserImageUploadUrl: "'.$link_to_img_upload.'?type='.Direction::$type.'&id='.$id.'&add=add",';
		$content .= 			'contentsCss: [CKEDITOR.basePath + "contents.css", "css/styles.css", "css/bootstrap.min.css"],';
		$content .= 			'allowedContent: true, });';
		$content .=			'CKEDITOR.config.height = 400;';
		$content .=		'</script>';
		$content .= 	'<div class="row">';
		$content .=			'<input type="submit" class="btn btn-primary btn-lg" name="add" value="Сохранить">';
		$content .=		'</div>';
		$content .= '</form>';

		$title = 'Добавление направления';
		$header = 'Добавление направления';
	} else if (isset($_REQUEST['edit'])) {
		global $link_to_utility_sql_worker;
		global $link_to_img_upload;
		$dir_id = $_REQUEST['id'];
		$direction = Direction::FetchByID($dir_id);
		$cover_src = $direction->path_to_image;

		$content .= '<form method="post" action="'.$link_to_utility_sql_worker.'" enctype="multipart/form-data">';
		$content .= 	PairLabelAndInput(4, 5, 'Заголовок', 'name', 'Введите заголовок', $direction->name).'<br>';
		$content .= 	PairLabelAndImage(4, 5, 'class="img-article-cover" src="'.$cover_src.'"', 'Обложка');
		$content .= 	PairLabelAndInputFile(4, 5, 'Сменить обложку', 'cover');
		$content .= 	WrapToHiddenInputs(array('type' => Direction::$type, 'yes' => '', 'id' => $dir_id));
		$content .= 	'<div class="row"><h3>Текст</h3></div>';
		$content .=		'<div class="row">';
		$content .=			'<div class="'.ColAllTypes(8).' '.ColOffsetAllTypes(2).'" align="center">';
		$content .= 			'<textarea id="text_block" name="text_block">'.$direction->text_block.'</textarea>';
		$content .=			'</div>';
		$content .= 	'</div>';
		$content .=		'<script>';
		$content .=			'CKEDITOR.replace("text_block",';
		$content .= 			'{ filebrowserImageUploadUrl: "'.$link_to_img_upload.'?type='.Direction::$type.'&id='.$dir_id.'&edit=edit",';
		$content .= 			'contentsCss: [CKEDITOR.basePath + "contents.css", "css/styles.css", "css/bootstrap.min.css"],';
		$content .= 			'allowedContent: true, });';
		$content .=			'CKEDITOR.config.height = 400;';
		$content .=		'</script>';
		$content .= 	'<div class="row">';
		$content .=			DialogInputsYesNo('edit', $_REQUEST['type'], $dir_id, 'Сохранить', 'Отменить');
		$content .=		'</div>';
		$content .= '</form>';

		$title = 'Редактирование направления';
		$header = 'Редактирование направления';
	} else {
		if (!isset($_REQUEST['id'])) {
			echo 'user id is unset';
			exit();
		}

		$direction = Direction::FetchByID($_REQUEST['id']);

		$title = 'Направление';

		$header = htmlspecialchars($direction->name);

		$content = $direction->ToHTMLAutoFull(GetUserPrivileges());
	}

	include_once($link_to_admin_template);
?>