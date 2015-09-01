<?php
	include_once('utility_lgmis_lib.php');
	include_once($link_to_utility_authorization);

	$title = '';
	$header = '';
	$content = '';
	$prev_page = $link_to_admin_manage_content.'?content_type='.$content_types_short['projects'];

	if (isset($_REQUEST['add'])) {
		$id = User::GetIDByLogin($_SESSION['user_login']);
		clear_tmp_images_dir(Project::$type, $id);

		global $link_to_utility_sql_worker;
		global $link_to_img_upload;

		$dirs = Direction::FetchAll();
		$select_fields = array();
		for ($i = 0, $size = count($dirs); $i < $size; ++$i) {
			$select_fields[$dirs[$i]->id] = $dirs[$i]->name;
		}

		$content .= '<form method="post" action="'.$link_to_utility_sql_worker.'">';
		$content .= 	PairLabelAndInput(4, 5, 'Заголовок', 'name', 'Введите заголовок').'<br>';
		$content .= 	PairLabelAndSelect(4, 5, 'Выберите направление', 'direction_id', $select_fields);
		$content .= 	WrapToHiddenInputs(array('type' => Project::$type, 'yes' => '', 'id' => $id));
		$content .= 	'<div class="row"><h3>Текст</h3></div>';
		$content .=		'<div class="row">';
		$content .=			'<div class="'.ColAllTypes(8).' '.ColOffsetAllTypes(2).'" align="center">';
		$content .= 			'<textarea id="text_block" name="text_block"></textarea>';
		$content .=			'</div>';
		$content .= 	'</div>';
		$content .=		'<script>';
		$content .=			'CKEDITOR.replace("text_block",';
		$content .= 			'{ filebrowserImageUploadUrl: "'.$link_to_img_upload.'?type='.Project::$type.'&id='.$id.'&add=add",';
		$content .= 			'contentsCss: [CKEDITOR.basePath + "contents.css", "css/styles.css", "css/bootstrap.min.css"],';
		$content .= 			'allowedContent: true, });';
		$content .=			'CKEDITOR.config.height = 400;';
		$content .=		'</script>';
		$content .= 	'<div class="row">';
		$content .=			'<input type="submit" class="btn btn-primary btn-lg" name="add" value="Сохранить">';
		$content .=		'</div>';
		$content .= '</form>';

		$title = 'Добавление проекта';
		$header = 'Добавление проекта';
	} else if (isset($_REQUEST['edit'])) {
		global $link_to_utility_sql_worker;
		global $link_to_img_upload;
		$proj_id = $_REQUEST['id'];
		$project = Project::FetchByID($proj_id);

		$dirs = Direction::FetchAll();
		$select_fields = array();
		$selected_field = array();
		for ($i = 0, $size = count($dirs); $i < $size; ++$i) {
			if ($dirs[$i]->id != $project->direction_id)
				$select_fields[$dirs[$i]->id] = $dirs[$i]->name;
			else 
				$selected_field = array($dirs[$i]->id, $dirs[$i]->name);
		}

		$content .= '<form method="post" action="'.$link_to_utility_sql_worker.'">';
		$content .= 	PairLabelAndInput(4, 5, 'Заголовок', 'name', 'Введите заголовок', htmlspecialchars($project->name)).'<br>';
		$content .= 	PairLabelAndSelect(4, 5, 'Направление', 'direction_id', $select_fields, $selected_field);
		$content .= 	WrapToHiddenInputs(array('type' => Project::$type, 'yes' => '', 'id' => $proj_id));
		$content .= 	'<div class="row"><h3>Текст</h3></div>';
		$content .=		'<div class="row">';
		$content .=			'<div class="'.ColAllTypes(8).' '.ColOffsetAllTypes(2).'" align="center">';
		$content .= 			'<textarea id="text_block" name="text_block">'.$project->text_block.'</textarea>';
		$content .=			'</div>';
		$content .= 	'</div>';
		$content .=		'<script>';
		$content .=			'CKEDITOR.replace("text_block",';
		$content .= 			'{ filebrowserImageUploadUrl: "'.$link_to_img_upload.'?type='.Project::$type.'&id='.$proj_id.'&edit=edit",';
		$content .= 			'contentsCss: [CKEDITOR.basePath + "contents.css", "css/styles.css", "css/bootstrap.min.css"],';
		$content .= 			'allowedContent: true, });';
		$content .=			'CKEDITOR.config.height = 400;';
		$content .=		'</script>';
		$content .= 	'<div class="row">';
		$content .=			DialogInputsYesNo('edit', $_REQUEST['type'], $proj_id, 'Сохранить', 'Отменить');
		$content .=		'</div>';
		$content .= '</form>';

		$title = 'Редактирование проекта';
		$header = 'Редактирование проекта';
	} else {
		if (!isset($_REQUEST['id'])) {
			echo 'user id is unset';
			exit();
		}

		$project = Project::FetchByID($_REQUEST['id']);

		$title = 'Проект';

		$header = htmlspecialchars($project->name);

		$content = $project->ToHTMLAutoFull(GetUserPrivileges());
	}

	include_once($link_to_admin_template);
?>