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
		$content .= 	PairLabelAndInput(4, 5, Language::Word('header'), 'name', Language::Word('insert header')).'<br>';
		$content .= 	PairLabelAndInputFile(4, 5, Language::Word('cover'), 'cover');
		$content .= 	PairLabelAndSelect(4, 5, Language::Word('language'), 'language', $languages, array('rus', $languages['rus']));
		$content .= 	WrapToHiddenInputs(array('type' => Direction::$type, 'yes' => '', 'id' => $id));
		$content .= 	'<div class="row"><h3>'.Language::Word('text').'</h3></div>';
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
		$content .=			'<input type="submit" class="btn btn-primary btn-lg" name="add" value="'.Language::Word('save').'">';
		$content .=		'</div>';
		$content .= '</form>';

		$title = Language::Word('direction adding');
		$header = $title;
	} else if (isset($_REQUEST['edit'])) {
		global $link_to_utility_sql_worker;
		global $link_to_img_upload;
		global $link_to_img_browse;
		$dir_id = $_REQUEST['id'];
		$direction = Direction::FetchByID($dir_id);
		$cover_src = $direction->path_to_image;

		$content .= '<form method="post" action="'.$link_to_utility_sql_worker.'" enctype="multipart/form-data">';
		$content .= 	PairLabelAndInput(4, 5, Language::Word('header'), 'name', Language::Word('insert header'), $direction->name).'<br>';
		$content .= 	PairLabelAndImage(4, 5, 'class="img-article-cover" src="'.$cover_src.'"', Language::Word('cover'));
		$content .= 	PairLabelAndInputFile(4, 5, Language::Word('change cover'), 'cover');
		$content .= 	WrapToHiddenInputs(array('type' => Direction::$type, 'yes' => '', 'id' => $dir_id));
		$content .= 	'<div class="row"><h3>'.Language::Word('text').'</h3></div>';
		$content .=		'<div class="row">';
		$content .=			'<div class="'.ColAllTypes(8).' '.ColOffsetAllTypes(2).'" align="center">';
		$content .= 			'<textarea id="text_block" name="text_block">'.$direction->text_block.'</textarea>';
		$content .=			'</div>';
		$content .= 	'</div>';
		$content .=		'<script>';
		$content .=			'CKEDITOR.replace("text_block",';
		$content .= 			'{ filebrowserImageUploadUrl: "'.$link_to_img_upload.'?type='.Direction::$type.'&id='.$dir_id.'&edit=edit",';
		$content .= 			'filebrowserImageBrowseUrl : "'.$link_to_img_browse.'?type='.Direction::$type.'&id='.$dir_id.'&edit=edit",';
		$content .= 			'contentsCss: [CKEDITOR.basePath + "contents.css", "css/styles.css", "css/bootstrap.min.css"],';
		$content .= 			'allowedContent: true, });';
		$content .=			'CKEDITOR.config.height = 400;';
		$content .=		'</script>';
		$content .= 	'<div class="row">';
		$content .=			DialogInputsYesNo('edit', $_REQUEST['type'], $dir_id, Language::Word('save'), Language::Word('cancel'));
		$content .=		'</div>';
		$content .= '</form>';

		$title = Language::Word('direction editing');
		$header = $title;
	} else if (isset($_REQUEST['add_lang'])) {
		$direction = Direction::FetchByID($_REQUEST['id']);
		$dir_langs = $direction->FetchLanguages();
		$free_languages = array_diff($languages, $dir_langs);
		if (count($free_languages) === 0) {
			$content = AlertMessage('alert-danger', Language::Word('all languages of this direction is implemented'));
		} else {
			$id = User::GetIDByLogin($_SESSION['user_login']);
			clear_tmp_images_dir(Direction::$type, $id);

			global $link_to_utility_sql_worker;
			global $link_to_img_upload;
			global $link_to_img_browse;
			global $languages;

			$content .= '<form method="post" action="'.$link_to_utility_sql_worker.'" enctype="multipart/form-data">';
			$content .= 	PairLabelAndInput(4, 5, Language::Word('header'), 'name', Language::Word('insert header')).'<br>';
			$content .= 	PairLabelAndInputFile(4, 5, Language::Word('cover'), 'cover');
			$content .= 	PairLabelAndSelect(4, 5, Language::Word('language'), 'language', $free_languages, array(key($free_languages), current($free_languages)));
			$content .= 	WrapToHiddenInputs(array('type' => Direction::$type, 'yes' => '', 'id' => $id, 'glob_id' => $direction->id));
			$content .= 	'<div class="row"><h3>'.Language::Word('text').'</h3></div>';
			$content .=		'<div class="row">';
			$content .=			'<div class="'.ColAllTypes(8).' '.ColOffsetAllTypes(2).'" align="center">';
			$content .= 			'<textarea id="text_block" name="text_block"></textarea>';
			$content .=			'</div>';
			$content .= 	'</div>';
			$content .=		'<script>';
			$content .=			'CKEDITOR.replace("text_block",';
			$content .= 			'{ filebrowserImageUploadUrl: "'.$link_to_img_upload.'?type='.Direction::$type.'&id='.$id.'&add=add$glob_id='.$direction->id.'",';
			$content .= 			'filebrowserImageBrowseUrl : "'.$link_to_img_browse.'?type='.Direction::$type.'&id='.$direction->id.'&edit=edit",';
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

		$direction = Direction::FetchByID($_REQUEST['id']);

		$title = Language::Word('direction');

		$header = htmlspecialchars($direction->name);

		$content = $direction->ToHTMLAutoFull(GetUserPrivileges());
	}

	include_once($link_to_admin_template);
?>