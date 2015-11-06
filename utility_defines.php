<?php
	include_once('utility_links.php');

	$use_mod_rewrite = true;
	
	$type_to_table = array(
		'user' => 'users_tb',
		'req_on_reg' => 'requests_on_register_tb',
	);
	
	$content_types_short = array(
		'articles' => 'arts',
		'directions' => 'dirs',
		'projects' => 'projs',
		'about_us' => 'abt_us', 
		'reports' => 'reps',  
	);

	$content_types_full = array(
		'articles' => 'Новости',
		'directions' => 'Направления',
		'projects' => 'Проекты',
		'about_us' => 'О нас',
	);

	$positions = array(
		1 => 'Не сотрудник',
		10 => 'Новичок',
		20 => 'Стажер',
		30 => 'Программист',
		40 => 'Старший программист',
		50 => 'Ведущий программист',
		60 => 'Руководитель',
	);

	$act_type_to_text = array(
		'del' => 'Удалить',
		'add' => 'Добавить',
		'edit' => 'Редактировать',
		'full' => 'Подробнее',
		'add_lang' => 'Добавить язык',
	);

	$act_type_to_css_class = array(
		'del' => 'btn btn-danger',
		'full' => 'btn btn-info',
		'add' => 'btn btn-primary',
		'edit' => 'btn btn-default',
		'def' => 'btn btn-default',
		'succ' => 'btn btn-success',
		'add_lang' => 'btn btn-primary',
	);

	$languages = array(
		'eng' => 'English',
		'rus' => 'Русский',
	);

	$image_extensions = array('bmp', 'gif', 'jpg', 'jpe', 'png', 'jpeg', 'svg');

	$valid_extensions = ['zip', 'rar', 'doc', 'xls', 'ppt', 'xlsx', 'pptx', 'docx', 'pdf', 'txt', 'mp3', 'wma', 'm4a', 'flac',
		'mp4', 'wmv', 'mov', 'avi', 'mkv', 'bmp', 'jpg', 'jpeg', 'gif', 'png'];

	function CheckLanguage($lang) {
		global $languages;
		if (isset($languages[$lang])) return true;
		else return false;
	}

	const NewEmployeeNum = 10;
	const NotEmployeeNum = 1;
	const DirectorPositionNum = 60;

	function PositionFromID($id) {
		global $positions;
		if (($id < 0) || ($id >= count($positions))) {
			return 0;
		} else {
			return $positions[$id];
		}
	}

	function PositionToID($position) {
		global $positions;
		for ($i = 1, $size = count($positions); $i <= $size; ++$i) {
			if ($positions[$i] == $position) {
				return $i;
			}
		}
		return -1;
	}

	$records_on_page = 6;
	$page_numbers_on_page = 5;

	const need_cache_level1 = true;
	
	const string_undef = '#Undefined#';
	const time_undef = -1;
	const id_undef = -1;
	const html_error = '<font color="red">Error</font>';
	const html_undef = '<font color="yellow">Undefined</font>';
	const sql_error = -1;
	const authorization_error = -1;
	const undef = '';

	const admin_user_id = 0;
	const unauthorized_user_id = 1;
	const simple_user_id = 2;
?>