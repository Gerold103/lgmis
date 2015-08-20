<?php
	include_once('utility_lgmis_lib.php');
	include_once($link_to_utility_authorization);

	$title = '';
	$header = '';
	$content = '';
	$prev_page = $link_to_admin_manage_content.'?content_type='.$content_types_short['articles'];

	//adding new article
	if (isset($_POST['add'])) {
		$id = User::GetIDByLogin($_SESSION['user_login']);
		clear_tmp_images_dir(Article::$type, $id);

		global $link_to_utility_sql_worker;
		global $link_to_img_upload;

		$content .= '<form method="post" action="'.$link_to_utility_sql_worker.'" enctype="multipart/form-data">';
		$content .= 	PairLabelAndInput(4, 5, 'Заголовок', 'name', 'Введите заголовок').'<br>';
		$content .=		PairLabelAndTextarea(4, 5, 'Аннотация', 'annotation', 'Введите текст аннотации');
		$content .= 	PairLabelAndInputFile(4, 5, 'Обложка', 'cover');
		$content .= 	WrapToHiddenInputs(array('type' => Article::$type, 'yes' => '', 'id' => $id));
		$content .= 	'<div class="row"><h3>Текст</h3></div>';
		$content .=		'<div class="row">';
		$content .=			'<div class="'.ColAllTypes(8).' '.ColOffsetAllTypes(2).'" align="center">';
		$content .= 			'<textarea id="text_block" name="text_block"></textarea>';
		$content .=			'</div>';
		$content .= 	'</div>';
		$content .=		'<script>';
		$content .=			'CKEDITOR.replace("text_block",';
		$content .= 			'{ filebrowserImageUploadUrl: "'.$link_to_img_upload.'?type='.Article::$type.'&id='.$id.'&add=add",';
		$content .= 			'contentsCss: [CKEDITOR.basePath + "contents.css", "css/styles.css", "css/bootstrap.min.css"],';
		$content .= 			'allowedContent: true, });';
		$content .=			'CKEDITOR.config.height = 400;';
		$content .=		'</script>';
		$content .= 	'<div class="row">';
		$content .=			'<input type="submit" class="btn btn-primary btn-lg" name="add" value="Сохранить">';
		$content .=		'</div>';
		$content .= '</form>';

		$title = 'Добавление новости';
		$header = 'Добавление новости';
	} else if (isset($_POST['edit'])) {
		global $link_to_utility_sql_worker;
		global $link_to_img_upload;
		$art_id = $_POST['id'];
		$article = Article::FetchByID($art_id);
		$cover_src = $article->path_to_image;

		$content .= '<form method="post" action="'.$link_to_utility_sql_worker.'" enctype="multipart/form-data">';
		$content .= 	PairLabelAndInput(4, 5, 'Заголовок', 'name', 'Введите заголовок', htmlspecialchars($article->name)).'<br>';
		$content .=		PairLabelAndTextarea(4, 5, 'Аннотация', 'annotation', 'Введите текст аннотации', htmlspecialchars($article->annotation));
		$content .= 	PairLabelAndImage(4, 5, 'class="img-article-cover" src="'.$cover_src.'"', 'Обложка');
		$content .= 	PairLabelAndInputFile(4, 5, 'Сменить обложку', 'cover');
		$content .= 	WrapToHiddenInputs(array('type' => Article::$type, 'yes' => '', 'id' => $art_id));
		$content .= 	'<div class="row"><h3>Текст</h3></div>';
		$content .=		'<div class="row">';
		$content .=			'<div class="'.ColAllTypes(8).' '.ColOffsetAllTypes(2).'" align="center">';
		$content .= 			'<textarea id="text_block" name="text_block">'.htmlspecialchars($article->text_block).'</textarea>';
		$content .=			'</div>';
		$content .= 	'</div>';
		$content .=		'<script>';
		$content .=			'CKEDITOR.replace("text_block",';
		$content .= 			'{ filebrowserImageUploadUrl: "'.$link_to_img_upload.'?type='.Article::$type.'&id='.$art_id.'&edit=edit",';
		$content .= 			'contentsCss: [CKEDITOR.basePath + "contents.css", "css/styles.css", "css/bootstrap.min.css"],';
		$content .= 			'allowedContent: true, });';
		$content .=			'CKEDITOR.config.height = 400;';
		$content .=		'</script>';
		$content .= 	'<div class="row">';
		$content .=			DialogInputsYesNo('edit', $_POST['type'], $art_id, 'Сохранить', 'Отменить');
		$content .=		'</div>';
		$content .= '</form>';

		$title = 'Редактирование новости';
		$header = 'Редактирование новости';
	} else {
		if (!isset($_POST['id'])) {
			echo 'user id is unset';
			exit();
		}

		$article = Article::FetchByID($_POST['id']);

		$title = '';
		$header = '';
		$content = '';

		$title = 'Статья';

		$header = htmlspecialchars($article->name);

		$content = $article->ToHTMLAutoFull(GetUserPrivileges());
	}

	include_once($link_to_admin_template);
?>