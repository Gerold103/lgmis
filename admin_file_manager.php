<?php
	
	$is_public = false;
	include_once('utility_lgmis_lib.php');
	include_once($link_to_utility_authorization);
	clear_tmp_files_dir(MyFile::$type, 0);

	$perms = MyFile::perm_to_only_empls;
	$user = User::FetchBy(['select_list' => 'position', 'eq_conds' => ['id' => GetUserID()], 'is_unique' => true]);
	if ($user->GetPositionNum() == NotEmployeeNum) $perms = MyFile::perm_to_all_registered;

	$header = '';
	$content = '';
	$footer = '';
	if ($perms > MyFile::perm_to_all_registered)
		$head_addition = '<script type="text/javascript" src="js/files_upload.js"></script>';
	$head_addition .= '<script type="text/javascript" src="js/file_manager.js"></script>';
	$head_addition .= MakeScript('files_type="'.MyFile::$type.'"; author_id='.GetUserID().'; max_files=10; files_action="add";');

	$content .= '<div style="display: table; width: 100%; height: 80%;">';
	$content .= 	'<div class="row" style="height: 100%; display: table-row;">';
	$col_width = 8;
	if ($perms <= MyFile::perm_to_all_registered) $col_width = 12;
	$content .= 		'<div class="'.ColAllTypes($col_width).' modal-open" style="border: 3px solid #dadada; display: table-cell; float: none;">';
	$content .= 			'<ol class="breadcrumb" id="current_manager_path" align="left">';
	$content .=					'<li><a href="#" onclick="goUpDir(0);">Home</a></li>';
	$content .=				'</ol>';
	$content .= 			'<div class="row" id="files_place"></div>';
	$content .= 			'<div id="file_backdrop_area" align="center"></div>';
	$content .= 		'</div>';
	if ($perms > MyFile::perm_to_all_registered) {
		$content .= 	'<div id="files_area" class="'.ColAllTypes(4).'" style="border: 3px dashed #dadada; display: table-cell; float: none;">';
		$content .= 		'<input type="file" onchange="send_files(this.files);" id="one_file_upload" style="display: none;">';
		$content .= 		'<button onclick="elem(\'one_file_upload\').click(); return false;" type="button" class="btn btn-success btn-lg" style="margin-bottom: 30px; padding: 0px; width: 100%;">'.Language::Word('add file').'</button>';
		$content .= 		'<ul id="progress_bars" style="list-style-type: none;">';
		$content .= 		'</ul>';
		$content .=			'<div style="position: absolute; left: 10%; top: 40%; text-align: center;" align="center" id="files_area_background_text">';
		$content .=				'<h1 style="color: #dadada;"><span class="glyphicon glyphicon-paste" aria-hidden="true"></span>   '.Language::Word('file').'</h1>';
		$content .= 		'</div>';
		$content .= 	'</div>';
		$content .= 	'<input id="files_count" type="hidden" name="files_count" value="0">';
	}
	$content .= 	'</div>';
	$content .= '</div>';
	$content .= '<div class="row">';
	$content .= 	'<div class="'.ColAllTypes(9).'" align="center">';
	if ($perms > MyFile::perm_to_all_registered)
		$content .=		'<button class="btn btn-info btn-lg" onclick="create_folder();">+<span class="glyphicon glyphicon-folder-open" aria-hidden="true"></span>   '.Language::Word('create folder').'</button>';
	$content .= 	'</div>';
	$content .= 	'<div class="'.ColAllTypes(3).'" align="center">';
	if ($perms > MyFile::perm_to_all_registered)
		$content .= 	'<button class="btn btn-primary btn-lg" data-toggle="modal" data-target="#myModal">'.Language::Word("send").'</button>';
	
	$content .= 		'<div class="modal fade" id="folder_create" tabindex="-1" role="dialod">';
	$content .= 			'<div class="modal-dialog" role="document">';
	$content .=					'<div class="modal-content">';
	$content .=						'<div class="modal-header">';
	$content .= 						'<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>';
	$content .= 						'<h4 class="modal-title" id="myModalLabel">'.Language::Word('actions').'</h4>';
	$content .= 					'</div>';
	$content .=						'<div class="modal-body">';
	$content .= 						PairLabelAndInput(3, 9, Language::Word('name'), 'folder_name');
	$content .= 						PairLabelAndRadio(3, 9, Language::Word('permissions'), 'folder_permissions', [['name' => 'for_employees', 'val' => Language::Word('for employees')], ['name' => 'for_registered', 'val' => Language::Word('for registered')]]);
	$content .= 					'</div>';
	$content .= 					'<div class="modal-footer">';
	$content .= 						'<button type="button" class="btn btn-default" data-dismiss="modal">'.Language::Word('close').'</button>';
	$content .= 						'<button type="button" class="btn btn-primary" onclick="do_create_folder();">'.Language::Word('create folder').'</button>';
	$content .= 					'</div>';
	$content .=					'</div>';
	$content .=				'</div>';
	$content .= 		'</div>';

	$content .= 		'<div class="modal fade" id="file_actions" tabindex="-1" role="dialod">';
	$content .= 			'<div class="modal-dialog" role="document">';
	$content .=					'<div class="modal-content">';
	$content .=						'<div class="modal-header">';
	$content .= 						'<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>';
	$content .= 						'<h4 class="modal-title" id="myModalLabel">'.Language::Word('actions').'</h4><h5 name="file_name"></h5>';
	$content .= 					'</div>';
	$content .=						'<div class="modal-body">';
	$content .= 					'</div>';
	$content .= 					'<div class="modal-footer">';
	$content .= 						'<button type="button" class="btn btn-default" data-dismiss="modal">'.Language::Word('close').'</button>';
	$content .= 					'</div>';
	$content .=					'</div>';
	$content .=				'</div>';
	$content .= 		'</div>';

	$content .= 		'<div class="modal fade" id="edit_file" tabindex="-1" role="dialog">';
	$content .= 			'<div class="modal-dialog" role="document">';
	$content .= 				'<div class="modal-content">';
	$content .=						'<div class="modal-header">';
	$content .= 						'<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>';
	$content .= 						'<h4 class="modal-title" id="myModalLabel">'.Language::ActionTypeToText('edit').'</h4>';
	$content .= 					'</div>';
	$content .=						'<div class="modal-body">';
	$content .= 						PairLabelAndInput(5, 7, Language::Word('name'), 'file_name');
	$content .= 						PairLabelAndRadio(3, 9, Language::Word('permissions'), 'file_permissions', [['name' => 'for_employees', 'val' => Language::Word('for employees')], ['name' => 'for_registered', 'val' => Language::Word('for registered')]], -1);
	$content .= 					'</div>';
	$content .= 					'<div class="modal-footer">';
	$content .= 						'<button type="button" class="btn btn-default" data-dismiss="modal">'.Language::Word('cancel').'</button>';
	$content .= 						'<button name="save" type="button" class="btn btn-primary">'.Language::Word('save').'</button>';
	$content .= 					'</div>';
	$content .= 				'</div>';
	$content .= 			'</div>';
	$content .= 		'</div>';

	$content .= 		'<div class="modal fade" id="myModal" tabindex="-1" role="dialog">';
	$content .= 			'<div class="modal-dialog" role="document">';
	$content .= 				'<div class="modal-content">';
	$content .=						'<div class="modal-header">';
	$content .= 						'<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>';
	$content .= 						'<h4 class="modal-title" id="myModalLabel">'.Language::Word('options').': '.Language::Word('permissions').'</h4>';
	$content .= 					'</div>';
	$content .=						'<div class="modal-body">';
	$content .= 						'<div class="btn-group" data-toggle="buttons" id="options_permissions">';
	$content .= 							'<label class="btn btn-primary active">';
	$content .= 								'<input type="radio" name="options" id="for_employees" autocomplete="off" checked>'.Language::Word('for employees');
	$content .= 							'</label>';
	$content .= 							'<label class="btn btn-primary">';
	$content .= 								'<input type="radio" name="options" id="for_registered" autocomplete="off" checked>'.Language::Word('for registered');
	$content .= 							'</label>';
	$content .=							'</div>';
	$content .= 					'</div>';
	$content .= 					'<div class="modal-footer">';
	$content .= 						'<button type="button" class="btn btn-default" data-dismiss="modal">'.Language::Word('cancel').'</button>';
	$content .= 						'<button type="button" class="btn btn-primary" onclick="saveFiles();">'.Language::Word('save').'</button>';
	$content .= 					'</div>';
	$content .= 				'</div>';
	$content .= 			'</div>';
	$content .= 		'</div>';
	$content .= 	'</div>';
	$content .= '</div>';

	include($link_to_admin_template);
	
?>