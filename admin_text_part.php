<?php
	include_once('utility_lgmis_lib.php');
	include_once($link_to_utility_authorization);

	$title = '';
	$header = '';
	$content = '';

	//adding new article
	if (isset($_POST['add'])) {
		$id = User::GetIDByLogin($_SESSION['user_login']);
		clear_tmp_images_dir(TextPart::$type, $id);

		global $link_to_utility_sql_worker;
		global $link_to_img_upload;

		$content .= '<form method="post" action="'.$link_to_utility_sql_worker.'" enctype="multipart/form-data">';
		$content .= 	PairLabelAndInput(4, 5, 'Заголовок', 'name', 'Введите заголовок').'<br>';
		$content .=		PairLabelAndInput(4, 5, 'Приоритет', 'priority', 'Число');
		$content .= 	PairLabelAndSelect(4, 5, 'Выберите роль', 'role', $content_types_full);
		$content .= 	WrapToHiddenInputs(array('type' => TextPart::$type, 'yes' => '', 'id' => $id));
		$content .= 	'<div class="row"><h3>Текст</h3></div>';
		$content .=		'<div class="row">';
		$content .=			'<div class="'.ColAllTypes(8).' '.ColOffsetAllTypes(2).'" align="center">';
		$content .= 			'<textarea id="text_block" name="text_block"></textarea>';
		$content .=			'</div>';
		$content .= 	'</div>';
		$content .=		'<script>';
		$content .=			'CKEDITOR.replace("text_block",';
		$content .= 			'{ filebrowserImageUploadUrl: "'.$link_to_img_upload.'?type='.TextPart::$type.'&id='.$id.'&add=add",';
		$content .= 			'contentsCss: [CKEDITOR.basePath + "contents.css", "css/styles.css", "css/bootstrap.min.css"],';
		$content .= 			'allowedContent: true, });';
		$content .=			'CKEDITOR.config.height = 400;';
		$content .=		'</script>';
		$content .= 	'<div class="row">';
		$content .=			'<input type="submit" class="btn btn-primary btn-lg" name="add" value="Сохранить">';
		$content .=		'</div>';
		$content .= '</form>';

		$title = 'Добавление текста';
		$header = 'Добавление текста';
	} else if (isset($_POST['edit'])) {
		global $link_to_utility_sql_worker;
		global $link_to_img_upload;
		$txt_id = $_POST['id'];
		$text_part = TextPart::FetchByID($txt_id);

		$selected_field = array($text_part->GetRole(), $content_types_full[$text_part->GetRole()]);

		$content .= '<form method="post" action="'.$link_to_utility_sql_worker.'" enctype="multipart/form-data">';
		$content .= 	PairLabelAndInput(4, 5, 'Заголовок', 'name', 'Введите заголовок', htmlspecialchars($text_part->GetName())).'<br>';
		$content .=		PairLabelAndInput(4, 5, 'Приоритет', 'priority', 'Число', htmlspecialchars($text_part->GetPriority()));
		$content .=		PairLabelAndSelect(4, 5, 'Выберите роль', 'role', $content_types_full, $selected_field);
		$content .= 	WrapToHiddenInputs(array('type' => TextPart::$type, 'yes' => '', 'id' => $txt_id));
		$content .= 	'<div class="row"><h3>Текст</h3></div>';
		$content .=		'<div class="row">';
		$content .=			'<div class="'.ColAllTypes(8).' '.ColOffsetAllTypes(2).'" align="center">';
		$content .= 			'<textarea id="text_block" name="text_block">'.htmlspecialchars($text_part->GetTextBlock()).'</textarea>';
		$content .=			'</div>';
		$content .= 	'</div>';
		$content .=		'<script>';
		$content .=			'CKEDITOR.replace("text_block",';
		$content .= 			'{ filebrowserImageUploadUrl: "'.$link_to_img_upload.'?type='.TextPart::$type.'&id='.$txt_id.'&edit=edit",';
		$content .= 			'contentsCss: [CKEDITOR.basePath + "contents.css", "css/styles.css", "css/bootstrap.min.css"],';
		$content .= 			'allowedContent: true, });';
		$content .=			'CKEDITOR.config.height = 400;';
		$content .=		'</script>';
		$content .= 	'<div class="row">';
		$content .=			DialogInputsYesNo('edit', $_POST['type'], $txt_id, 'Сохранить', 'Отменить');
		$content .=		'</div>';
		$content .= '</form>';

		$title = 'Редактирование текста';
		$header = 'Редактирование текста';
	} else {
		if (!isset($_POST['id'])) {
			echo 'user id is unset';
			exit();
		}

		$text_part = TextPart::FetchByID($_POST['id']);

		$title = '';
		$header = '';
		$content = '';

		$title = 'Текстовый блок';

		$header = htmlspecialchars($text_part->GetName());

		$content = $text_part->ToHTMLAutoFull(GetUserPrivileges());
	}

	include_once($link_to_admin_template);
?>