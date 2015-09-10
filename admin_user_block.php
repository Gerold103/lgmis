<?php
	include_once('utility_lgmis_lib.php');
	include_once($link_to_utility_authorization);

	$title = '';
	$header = '';
	$content = '';

	if (isset($_REQUEST['add'])) {
		clear_tmp_images_dir(UserBlock::$type, $_REQUEST['id']);

		$title = Language::Word('user block adding');
		$header = $title;

		global $link_to_utility_sql_worker;
		global $link_to_img_upload;
		$content .= '<form method="post" action="'.$link_to_utility_sql_worker.'">';
		$content .= 	PairLabelAndInput(4, 5, Language::Word('header'), 'name', Language::Word('insert header'));
		$content .=		PairLabelAndInput(4, 5, Language::Word('priority'), 'priority', Language::Word('number'));
		$content .= 	PairLabelAndSelect(4, 5, Language::Word('language'), 'language', $languages, array('rus', $languages['rus']));
		$content .= 	WrapToHiddenInputs(array('type' => UserBlock::$type, 'yes' => '', 'id' => $_REQUEST['id'], 'author_id' => $_REQUEST['id']));
		$content .= 	'<div class="row"><h3>Текст</h3></div>';
		$content .=		'<div class="row">';
		$content .=			'<div class="'.ColAllTypes(8).' '.ColOffsetAllTypes(2).'" align="center">';
		$content .= 			'<textarea id="text_block" name="text_block"></textarea>';
		$content .=			'</div>';
		$content .= 	'</div>';
		$content .=		'<script>';
		$content .=			'CKEDITOR.replace("text_block",';
		$content .= 			'{ filebrowserImageUploadUrl: "'.$link_to_img_upload.'?'.http_build_query($_REQUEST).'",';
		$content .= 			'contentsCss: [CKEDITOR.basePath + "contents.css", "css/styles.css", "css/bootstrap.min.css"],';
		$content .= 			'allowedContent: true, });';
		$content .=			'CKEDITOR.config.height = 400;';
		$content .=		'</script>';
		$content .= 	'<div class="row">';
		$content .=			'<input type="submit" class="btn btn-primary btn-lg" name="add" value="'.Language::Word('save').'">';
		$content .=		'</div>';
		$content .= '</form>';
	} else if (isset($_REQUEST['edit'])) {
		global $link_to_utility_sql_worker;
		global $link_to_img_upload;
		$block_id = $_REQUEST['id'];
		$block = UserBlock::FetchByID($block_id);
		$assoc = $_REQUEST;
		$assoc['author_id'] = $block->author_id;

		$content .= '<form method="post" action="'.$link_to_utility_sql_worker.'">';
		$content .= 	PairLabelAndInput(4, 5, Language::Word('header'), 'name', Language::Word('insert header'), $block->name);
		$content .=		PairLabelAndInput(4, 5, Language::Word('priority'), 'priority', Language::Word('number'), $block->priority);
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
		$content .= 			'filebrowserImageBrowseUrl : "'.$link_to_img_browse.'?'.http_build_query($assoc).'",';
		$content .= 			'contentsCss: [CKEDITOR.basePath + "contents.css", "css/styles.css", "css/bootstrap.min.css"],';
		$content .= 			'allowedContent: true, });';
		$content .=			'CKEDITOR.config.height = 400;';
		$content .=		'</script>';
		$content .= 	'<div class="row">';
		$content .=			DialogInputsYesNo('edit', $_REQUEST['type'], $block_id, Language::Word('save'), Language::Word('cancel'), true);
		$content .=		'</div>';
		$content .= '</form>';


		$title = Language::Word('user block editing');
		$header = $title;
	} else if (isset($_REQUEST['add_lang'])) {
		$user_block = UserBlock::FetchByID($_REQUEST['id']);
		$blk_langs = $user_block->FetchLanguages();
		$free_languages = array_diff($languages, $blk_langs);
		if (count($free_languages) === 0) {
			$content = AlertMessage('alert-danger', Language::Word('all languages of this user block is implemented'));
		} else {
			clear_tmp_images_dir(UserBlock::$type, $_REQUEST['id']);

			$title = Language::Word('language adding');
			$header = $title;

			$assoc = $_REQUEST;
			$assoc['edit'] = 'edit';
			$assoc['author_id'] = $user_block->author_id;
			$assoc['id'] = $user_block->GetID();

			global $link_to_utility_sql_worker;
			global $link_to_img_upload;
			$content .= '<form method="post" action="'.$link_to_utility_sql_worker.'">';
			$content .= 	PairLabelAndInput(4, 5, Language::Word('header'), 'name', Language::Word('insert header'));
			$content .=		PairLabelAndInput(4, 5, Language::Word('priority'), 'priority', Language::Word('number'));
			$content .= 	PairLabelAndSelect(4, 5, Language::Word('language'), 'language', $free_languages, array(key($free_languages), current($free_languages)));
			$content .= 	WrapToHiddenInputs(array('type' => UserBlock::$type, 'yes' => '', 'id' => $_REQUEST['id'], 'glob_id' => $user_block->GetID(), 'author_id' => $user_block->author_id));
			$content .= 	'<div class="row"><h3>Текст</h3></div>';
			$content .=		'<div class="row">';
			$content .=			'<div class="'.ColAllTypes(8).' '.ColOffsetAllTypes(2).'" align="center">';
			$content .= 			'<textarea id="text_block" name="text_block"></textarea>';
			$content .=			'</div>';
			$content .= 	'</div>';
			$content .=		'<script>';
			$content .=			'CKEDITOR.replace("text_block",';
			$content .= 			'{ filebrowserImageUploadUrl: "'.$link_to_img_upload.'?'.http_build_query($assoc).'",';
			$content .= 			'filebrowserImageBrowseUrl : "'.$link_to_img_browse.'?'.http_build_query($assoc).'",';
			$content .= 			'contentsCss: [CKEDITOR.basePath + "contents.css", "css/styles.css", "css/bootstrap.min.css"],';
			$content .= 			'allowedContent: true, });';
			$content .=			'CKEDITOR.config.height = 400;';
			$content .=		'</script>';
			$content .= 	'<div class="row">';
			$content .=			'<input type="submit" class="btn btn-primary btn-lg" name="add" value="'.Language::Word('save').'">';
			$content .=		'</div>';
			$content .= '</form>';
		}
	} else {

		if (!isset($_REQUEST['full'])) {
			echo 'action_type is unset. Must be "full"';
			exit();
		}
		if (!isset($_REQUEST['type'])) {
			echo 'object type is unset. Must be "user"';
			exit();
		}
		if (!isset($_REQUEST['id'])) {
			echo 'user id is unset';
			exit();
		}

		$user_block = UserBlock::FetchByID($_REQUEST['id']);

		$title = Language::Word('user block');

		$header = htmlspecialchars($user_block->name);

		$content = $user_block->ToHTMLAutoFull(GetUserPrivileges());
	}

	include_once($link_to_admin_template);
?>