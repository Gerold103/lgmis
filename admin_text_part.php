<?php
	include_once('utility_lgmis_lib.php');
	include_once($link_to_utility_authorization);

	$title = '';
	$header = '';
	$content = '';

	if (isset($_REQUEST['add'])) {
		$id = User::GetIDByLogin($_SESSION['user_login']);
		clear_tmp_images_dir(TextPart::$type, $id);

		global $link_to_utility_sql_worker;
		global $link_to_img_upload;
		global $languages;

		$content .= '<form method="post" action="'.$link_to_utility_sql_worker.'" enctype="multipart/form-data">';
		$content .= 	PairLabelAndInput(4, 5, Language::Word('header'), 'name', Language::Word('insert header')).'<br>';
		$content .=		PairLabelAndInput(4, 5, Language::Word('priority'), 'priority', Language::Word('number'));
		$content .= 	PairLabelAndSelect(4, 5, Language::Word('choose role'), 'role', $content_types_full);
		$content .= 	PairLabelAndSelect(4, 5, Language::Word('language'), 'language', $languages, array('rus', $languages['rus']));
		$content .= 	WrapToHiddenInputs(array('type' => TextPart::$type, 'yes' => '', 'id' => $id));
		$content .= 	'<div class="row"><h3>'.Language::Word('text').'</h3></div>';
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
		$content .=			'<input type="submit" class="btn btn-primary btn-lg" name="add" value="'.Language::Word('save').'">';
		$content .=		'</div>';
		$content .= '</form>';

		$title = Language::Word('text adding');
		$header = $title;
	} else if (isset($_REQUEST['edit'])) {
		global $link_to_utility_sql_worker;
		global $link_to_img_upload;
		global $link_to_img_browse;
		$txt_id = $_REQUEST['id'];
		$text_part = TextPart::FetchByID($txt_id);

		$selected_field = array($text_part->GetRole(), $content_types_full[$text_part->GetRole()]);

		$content .= '<form method="post" action="'.$link_to_utility_sql_worker.'" enctype="multipart/form-data">';
		$content .= 	PairLabelAndInput(4, 5, Language::Word('header'), 'name', Language::Word('insert header'), htmlspecialchars($text_part->GetName())).'<br>';
		$content .=		PairLabelAndInput(4, 5, Language::Word('priority'), 'priority', Language::Word('number'), htmlspecialchars($text_part->GetPriority()));
		$content .=		PairLabelAndSelect(4, 5, Language::Word('choose role'), 'role', $content_types_full, $selected_field);
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
		$content .= 			'filebrowserImageBrowseUrl : "'.$link_to_img_browse.'?type='.TextPart::$type.'&id='.$txt_id.'&edit=edit",';
		$content .= 			'contentsCss: [CKEDITOR.basePath + "contents.css", "css/styles.css", "css/bootstrap.min.css"],';
		$content .= 			'allowedContent: true, });';
		$content .=			'CKEDITOR.config.height = 400;';
		$content .=		'</script>';
		$content .= 	'<div class="row">';
		$content .=			DialogInputsYesNo('edit', $_REQUEST['type'], $txt_id, Language::Word('save'), Language::Word('cancel'));
		$content .=		'</div>';
		$content .= '</form>';

		$title = Language::Word('text editing');
		$header = $title;
	} else if (isset($_REQUEST['add_lang'])) {
		$text_part = TextPart::FetchByID($_REQUEST['id']);
		$txt_langs = $text_part->FetchLanguages();
		$free_languages = array_diff($languages, $txt_langs);
		if (count($free_languages) === 0) {
			$content = AlertMessage('alert-danger', Language::Word('all languages of this text block is implemented'));
		} else {
			$id = User::GetIDByLogin($_SESSION['user_login']);
			clear_tmp_images_dir(TextPart::$type, $id);

			global $link_to_utility_sql_worker;
			global $link_to_img_upload;
			global $languages;

			$content .= '<form method="post" action="'.$link_to_utility_sql_worker.'" enctype="multipart/form-data">';
			$content .= 	PairLabelAndInput(4, 5, Language::Word('header'), 'name', Language::Word('insert header')).'<br>';
			$content .=		PairLabelAndInput(4, 5, Language::Word('priority'), 'priority', Language::Word('number'));
			$content .= 	PairLabelAndSelect(4, 5, Language::Word('choose role'), 'role', $content_types_full);
			$content .= 	PairLabelAndSelect(4, 5, Language::Word('language'), 'language', $free_languages, array(key($free_languages), current($free_languages)));
			$content .= 	WrapToHiddenInputs(array('type' => TextPart::$type, 'yes' => '', 'id' => $id, 'glob_id' => $text_part->GetID()));
			$content .= 	'<div class="row"><h3>Текст</h3></div>';
			$content .=		'<div class="row">';
			$content .=			'<div class="'.ColAllTypes(8).' '.ColOffsetAllTypes(2).'" align="center">';
			$content .= 			'<textarea id="text_block" name="text_block"></textarea>';
			$content .=			'</div>';
			$content .= 	'</div>';
			$content .=		'<script>';
			$content .=			'CKEDITOR.replace("text_block",';
			$content .= 			'{ filebrowserImageUploadUrl: "'.$link_to_img_upload.'?type='.TextPart::$type.'&id='.$id.'&add=add",';
			$content .= 			'filebrowserImageBrowseUrl : "'.$link_to_img_browse.'?type='.TextPart::$type.'&id='.$text_part->GetID().'&edit=edit",';
			$content .= 			'contentsCss: [CKEDITOR.basePath + "contents.css", "css/styles.css", "css/bootstrap.min.css"],';
			$content .= 			'allowedContent: true, });';
			$content .=			'CKEDITOR.config.height = 400;';
			$content .=		'</script>';
			$content .= 	'<div class="row">';
			$content .=			'<input type="submit" class="btn btn-primary btn-lg" name="add" value="'.Language::Word('save').'">';
			$content .=		'</div>';
			$content .= '</form>';

			$title = Language::Word('language adding');
			$header = $title;
		}
	} else {
		if (!isset($_REQUEST['id'])) {
			echo 'user id is unset';
			exit();
		}

		$text_part = TextPart::FetchByID($_REQUEST['id']);

		$title = '';
		$header = '';
		$content = '';

		$title = Language::Word('text block');

		$header = htmlspecialchars($text_part->GetName());

		$content = $text_part->ToHTMLAutoFull(GetUserPrivileges());
	}

	include_once($link_to_admin_template);
?>