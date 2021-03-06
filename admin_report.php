<?php

	include_once('utility_lgmis_lib.php');
	include_once($link_to_utility_authorization);

	$title = '';
	$header = '';
	$content = '';
	$head_addition = '<script type="text/javascript" src="'.$link_to_classes.'/report.js"></script>';

	if (isset($_REQUEST['add'])) {
		$id = GetUserID();
		$head_addition .= '<script type="text/javascript" src="js/files_upload.js"></script>';
		$head_addition .= MakeScript('files_type = "'.Report::$type.'"; files_action = "add"; author_id = '.$id.'; max_files = 1;');
		clear_tmp_images_dir(Report::$type, $id);
		clear_tmp_files_dir(Report::$type, $id);

		global $link_to_utility_sql_worker;
		global $link_to_img_upload;

		$content .= '<form method="post" action="'.$link_to_utility_sql_worker.'" enctype="multipart/form-data">';
		$content .= 	'<div class="row">';
		$content .=			'<div class="'.ColAllTypes(4).' vcenter" align="right">';
		$content .= 			'<b>'.Language::Word('choose receivers').'</b>';
		$content .= 		'</div>';
		$content .= 		'<div class="'.ColAllTypes(5).' vcenter" align="center">';
		$content .= 			'<div class="dropdown">';
		$content .= 				'<input onkeyup="showUsers(this);" placeholder="'.Language::Word('start to insert name').'" class="form-control margin-sm dropdown-toggle" type="text" id="recipient_input" name="recipient_input" aria-haspopup="true" value="">';
		$content .= 				'<ul class="dropdown-menu" id="users_list">';
		$content .= 				'</ul>';
		$content .= 				'<input type="hidden" id="recipient_ids" name="recipient_ids" value="">';
		$content .= 				'<div style="font-size: 19px;" id="recipients"></div>';
		$content .= 			'</div>';
		$content .= 		'</div>';
		$content .= 	'</div>';

		$content .= 	PairLabelAndInput(4, 5, Language::Word('header'), 'name', Language::Word('insert header')).'<br>';
		$content .= 	PairLabelAndInputFileArea(4, 5, Language::Word('file'));

		$content .= 	WrapToHiddenInputs(array('type' => Report::$type, 'yes' => '', 'id' => $id));
		$content .= 	'<div class="row"><h3>'.Language::Word('text').'</h3></div>';
		$content .=		'<div class="row">';
		$content .=			'<div class="'.ColAllTypes(8).' '.ColOffsetAllTypes(2).'" align="center">';
		$content .= 			'<textarea id="text_block" name="text_block"></textarea>';
		$content .=			'</div>';
		$content .= 	'</div>';
		$content .=		'<script>';
		$content .=			'CKEDITOR.replace("text_block",';
		$content .= 			'{ filebrowserImageUploadUrl: "'.$link_to_img_upload.'?type='.Report::$type.'&id='.$id.'&add=add",';
		$content .= 			'contentsCss: [CKEDITOR.basePath + "contents.css", "css/styles.css", "css/bootstrap.min.css"],';
		$content .= 			'allowedContent: true, });';
		$content .=			'CKEDITOR.config.height = 400;';
		$content .=		'</script>';
		$content .= 	'<div class="row">';
		$content .=			'<input type="submit" class="btn btn-primary btn-lg" name="add" value="'.Language::Word('save').'">';
		$content .=		'</div>';
		$content .= '</form>';

		$title = Language::Word('report sending');
		$header = $title;
	} else if (isset($_REQUEST['edit'])) {
		global $link_to_utility_sql_worker;
		global $link_to_img_upload;
		global $link_to_img_browse;
		clear_tmp_images_dir(Report::$type, $id);
		clear_tmp_files_dir(Report::$type, $id);
		$head_addition .= '<script type="text/javascript" src="js/files_upload.js"></script>';
		$ob_id = $_POST['id'];
		$ob = Report::FetchBy(['eq_conds' => ['id' => $ob_id], 'is_unique' => true]);
		$receivers = User::FetchBy(['select_list' => 'id, name, surname', 'where_addition' => '(received_reports LIKE ("%\"'.$ob_id.'\"%"))']);
		$users = '';
		foreach ($receivers as $key => $user) {
			$users .= '<div class="row">';
			$users .= 	'<div class="'.ColAllTypes(12).'">';
			$users .= 		$user->LinkToThis();
			$users .= 	'</div>';
			$users .= '</div>';
		}
		if (Error::IsError($ob)) {
			$content = AlertMessage('alert-danger', 'Error occured during fetching: '.Error::ToString($ob));
		} else {
			$path_to_file = $ob->GetPathToFile();
			$author_id = GetUserID();
			$head_addition .= MakeScript('files_type = "'.Report::$type.'"; files_action = "edit"; owner_id = '.$ob->GetID().'; max_files = 1; author_id = '.$author_id.';');

			$content .= '<form method="post" action="'.$link_to_utility_sql_worker.'" enctype="multipart/form-data">';
			$content .= 	PairLabelAndPanel(4, 5, Language::Word('current receivers'), $users);
			$content .= 	'<div class="row">';
			$content .=			'<div class="'.ColAllTypes(4).' vcenter" align="right">';
			$content .= 			'<b>'.Language::Word('change receivers').'</b>';
			$content .= 		'</div>';
			$content .= 		'<div class="'.ColAllTypes(5).' vcenter" align="center">';
			$content .= 			'<div class="dropdown">';
			$content .= 				'<input onkeyup="showUsers(this);" placeholder="'.Language::Word('start to insert name').'" class="form-control margin-sm dropdown-toggle" type="text" id="recipient_input" name="recipient_input" aria-haspopup="true" value="">';
			$content .= 				'<ul class="dropdown-menu" id="users_list">';
			$content .= 				'</ul>';
			$content .= 				'<input type="hidden" id="recipient_ids" name="recipient_ids" value="">';
			$content .= 				'<div style="font-size: 19px;" id="recipients"></div>';
			$content .= 			'</div>';
			$content .= 		'</div>';
			$content .= 	'</div>';
			$content .= 	PairLabelAndInput(4, 5, Language::Word('header'), 'name', Language::Word('insert header'), htmlspecialchars($ob->GetName())).'<br>';
			$content .= 	PairLabelAndPanel(4, 5, Language::Word('current file'), $ob->GetLinkToFile());
			$content .= 	PairLabelAndInputFileArea(4, 5, Language::Word('change file'));
			$content .= 	WrapToHiddenInputs(array('type' => Report::$type, 'yes' => '', 'id' => $ob_id));
			$content .= 	'<div class="row"><h3>'.Language::Word('text').'</h3></div>';
			$content .=		'<div class="row">';
			$content .=			'<div class="'.ColAllTypes(8).' '.ColOffsetAllTypes(2).'" align="center">';
			$content .= 			'<textarea id="text_block" name="text_block">'.htmlspecialchars($ob->GetTextBlock()).'</textarea>';
			$content .=			'</div>';
			$content .= 	'</div>';
			$content .=		'<script>';
			$content .=			'CKEDITOR.replace("text_block",';
			$content .= 			'{ filebrowserImageUploadUrl: "'.$link_to_img_upload.'?type='.Report::$type.'&id='.$ob_id.'&edit=edit",';
			$content .= 			'contentsCss: [CKEDITOR.basePath + "contents.css", "css/styles.css", "css/bootstrap.min.css"],';
			$content .= 			'allowedContent: true, });';
			$content .=			'CKEDITOR.config.height = 400;';
			$content .=		'</script>';
			$content .= 	'<div class="row">';
			$content .=			DialogInputsYesNo('edit', $_POST['type'], $ob_id, Language::Word('save'), Language::Word('cancel'));
			$content .=		'</div>';
			$content .= '</form>';

			$title = Language::Word('report editing');
			$header = $title;
		}
	} else {
		if (!isset($_REQUEST['id'])) {
			echo 'user id is unset';
			exit();
		}

		$ob = Report::FetchBy(['eq_conds' => ['id' => $_REQUEST['id']], 'is_unique' => true]);
		$user_id = GetUserID();
		$user = User::FetchBy(['eq_conds' => ['id' => $user_id], 'is_unique' => true, 'select_list' => 'received_reports']);
		if (($user_id !== $ob->GetAuthorID()) && (!in_array($ob->GetID(), $user->GetReceivedReports())) && (GetUserPrivileges() !== admin_user_id)){
			$content = AlertMessage('alert-danger', Language::Word('access denied'));
		} else {
			$title = '';
			$header = '';
			$content = '';

			$title = Language::Word('report');

			$header = htmlspecialchars($ob->GetName());

			$content = $ob->ToHTMLAutoFull(GetUserPrivileges());
		}
	}

	include_once($link_to_admin_template);

?>