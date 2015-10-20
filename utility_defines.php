<?php
	include_once('utility_links.php');

	$use_mod_rewrite = true;

	$user_blocks_in_db = array(
		0 => array(
			'id' => 0,
			'author_id' => 0,
			'name' => 'Some text block with id = 0',
			'text_block' => '<img src="files/images/users/0/blocks/0/0.png" width="100px"> Donec lacinia quam vel porttitor porttitor. Sed varius urna non felis malesuada fermentum. Duis elit justo, maximus porta varius ut, varius sed dui. Nullam pellentesque tortor ut neque vehicula eleifend.',
		),
		1 => array(
			'id' => 1,
			'author_id' => 0,
			'name' => 'Some text block with id = 1',
			'text_block' => '<img src="files/images/users/0/blocks/1/0.png" width="100px"> Mauris id massa dictum ligula porttitor condimentum eget at ligula. Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Nulla convallis nec nunc eu viverra.',
		),
		2 => array(
			'id' => 2,
			'author_id' => 1,
			'name' => 'Some text block with id = 2',
			'text_block' => '<img src="files/images/users/1/blocks/2/0.png" width="100px"> Curabitur nec purus vel tortor consectetur ultricies. Suspendisse nec hendrerit sapien. Nunc nisl augue, lobortis eget ornare eget, sollicitudin luctus mi.',
		),
		3 => array(
			'id' => 3,
			'author_id' => 1,
			'name' => 'Some text block with id = 3',
			'text_block' => '<img src="files/images/users/1/blocks/3/0.png" width="100px"> Pellentesque facilisis felis eget volutpat ultrices. Donec eu nisl iaculis, varius erat sed, ornare lacus. Suspendisse sed vehicula massa, suscipit dapibus mi.',
		),
		4 => array(
			'id' => 4,
			'author_id' => 2,
			'name' => 'Some text block with id = 4',
			'text_block' => '<img src="files/images/users/2/blocks/4/0.png" width="100px"> Praesent lobortis cursus lacus nec posuere. Ut quis odio at nulla elementum ornare non a sem. Morbi vel felis scelerisque, consequat eros et, iaculis velit.',
		),
		5 => array(
			'id' => 5,
			'author_id' => 2,
			'name' => 'Some text block with id = 5',
			'text_block' => '<img src="files/images/users/2/blocks/5/0.png" width="100px"> In finibus, enim ut semper ornare, ante ante ultrices massa, et lobortis quam dolor quis sapien. Praesent nec accumsan leo. Etiam dignissim odio gravida dolor commodo, at ultrices mauris malesuada.',
		),
		6 => array(
			'id' => 6,
			'author_id' => 3,
			'name' => 'Some text block with id = 6',
			'text_block' => '<img src="files/images/users/3/blocks/6/0.png" width="100px"> Quisque augue libero, accumsan at lobortis et, tempor et dui. Sed mauris magna, condimentum ut massa eget, pellentesque ultricies odio.',
		),
		7 => array(
			'id' => 7,
			'author_id' => 3,
			'name' => 'Some text block with id = 7',
			'text_block' => '<img src="files/images/users/3/blocks/7/0.png" width="100px"> Pellentesque commodo rutrum lectus. Nam mollis posuere nulla eget gravida. Morbi mollis ipsum sit amet vehicula ullamcorper.',
		),
		8 => array(
			'id' => 8,
			'author_id' => 0,
			'name' => 'Some text block with id = 8',
			'text_block' => '<img src="files/images/users/0/blocks/8/0.png" width="100px"> text8',
		),
		9 => array(
			'id' => 9,
			'author_id' => 0,
			'name' => 'Some text block with id = 9',
			'text_block' => '<img src="files/images/users/0/blocks/9/0.png" width="100px"> text9',
		),
		10 => array(
			'id' => 10,
			'author_id' => 0,
			'name' => 'Some text block with id = 10',
			'text_block' => '<img src="files/images/users/0/blocks/10/0.png" width="100px"> text10',
		),
		11 => array(
			'id' => 11,
			'author_id' => 0,
			'name' => 'Some text block with id = 11',
			'text_block' => '<img src="files/images/users/0/blocks/11/0.png" width="100px"> text11',
		),
	);

	$directions_in_db = array(
		0 => array(
			'id' => 0,
			'author_id' => 2,
			'name' => 'Кодовая телеметрия',
			'creating_date' => 1421883448,
			'text_block' => 'По данному направлению мы занимаемся расшифровкой пакетов данных, приходящих по протоколу UDP.',
		),
		1 => array(
			'id' => 1,
			'author_id' => 0,
			'name' => 'Виртуальная реальность',
			'creating_date' => 1421883448,
			'text_block' => 'Здесь мы занимаемся созданием программного обеспечения для тренировки космонавтов.',
		),
		2 => array(
			'id' => 2,
			'author_id' => 1,
			'name' => 'Визуализация полетов',
			'creating_date' => 1421883448,
			'text_block' => 'В рамках данного направления мы занимаемся визуализацией процесса взлета и нахождения на орбите аппаратов.',
		),
	);

	$projects_in_db = array(
		0 => array(
			'id' => 0,
			'direction_id' => 0,
			'author_id' => 2,
			'name' => 'Vestibulum auctor',
			'text_block' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Lorem ipsum dolor sit amet, consectetur adipiscing elit.',
			'creating_date' => 1421883448,
		),
		1 => array(
			'id' => 1,
			'direction_id' => 0,
			'author_id' => 2,
			'name' => 'Quisque facilisis convallis',
			'text_block' => 'Proin enim leo, tincidunt quis suscipit elementum, consequat ac neque. Etiam finibus auctor rhoncus. Proin viverra cursus lectus eu sagittis.',
			'creating_date' => 1421883448,
		),
		2 => array(
			'id' => 2,
			'direction_id' => 1,
			'author_id' => 1,
			'name' => 'Sed blandit imperdiet ',
			'text_block' => 'Nullam dictum odio sit amet dignissim congue. Integer sed turpis non est dictum condimentum nec ac lacus.',
			'creating_date' => 1421883448,
		),
		3 => array(
			'id' => 3,
			'direction_id' => 1,
			'author_id' => 3,
			'name' => 'Mauris sit amet aliquam metus',
			'text_block' => 'Morbi vulputate purus nisi, ut ultricies lectus pellentesque ac.',
			'creating_date' => 1421883448,
		),
		4 => array(
			'id' => 4,
			'direction_id' => 2,
			'author_id' => 3,
			'name' => 'Proin pharetra leo sed ex faucibus',
			'text_block' => 'Maecenas non arcu sagittis, consequat risus et, dignissim erat. In rhoncus elit a velit volutpat tempor.',
			'creating_date' => 1421883448,
		),
		5 => array(
			'id' => 5,
			'direction_id' => 2,
			'author_id' => 0,
			'name' => 'Proin ex massa, sollicitudin',
			'text_block' => 'Donec aliquam nunc vitae mollis hendrerit. Quisque ultrices convallis enim.',
			'creating_date' => 1421883448,
		),
	);

	$articles_in_db = array(
		0 => array(
			'id' => 0,
			'author_id' => 0,
			'name' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit',
			'annotation' => 'Donec eget dui eu orci facilisis',
			'text_block' => 'Maecenas ut pretium nibh. Morbi consectetur efficitur congue. Duis pellentesque orci in nisi blandit, a tempor lorem aliquet. Morbi sit amet diam ut massa sollicitudin commodo.',
			'creating_date' => 1421883448,
		),
		1 => array(
			'id' => 1,
			'author_id' => 3,
			'name' => 'Proin tincidunt aliquam consequat',
			'annotation' => 'Praesent porttitor',
			'text_block' => 'Integer et erat id turpis dapibus consequat. Mauris ullamcorper convallis placerat. Sed mi nulla.',
			'creating_date' => 1421883448,
		),
		2 => array(
			'id' => 2,
			'author_id' => 1,
			'name' => 'Suspendisse vitae orci non lectus aliquet',
			'annotation' => 'Praesent vitae dui vitae augue ornare tincidunt id eu magna. Nam quis nisi',
			'text_block' => 'In pulvinar, ipsum id laoreet suscipit, arcu dolor fermentum neque, nec varius lacus purus et ex. Aliquam massa elit, porttitor quis justo vitae, viverra euismod mi.',
			'creating_date' => 1421883448,
		),
	);

	$register_requests = array(
		0 => array(
			'id' => 0,
			'name' => 'Иван',
			'surname' => 'Иванов',
			'fathername' => 'Иванович',
			'login' => 'vanek2005',
			'request_time' => '1421883448',
			'email' => 'ivan@yandex.ru',
			'telephone' => '8-903-453-25-73',
			'text' => 'Запрос мистера Иванова',
		),
		1 => array(
			'id' => 1,
			'name' => 'Василий',
			'surname' => 'Васильев',
			'fathername' => 'Васильевич',
			'login' => 'vasek2005',
			'request_time' => '1421883448',
			'email' => 'vasya@yandex.ru',
			'telephone' => '8-903-495-19-53',
			'text' => 'Запрос мистера Васильева',
		),
		2 => array(
			'id' => 2,
			'name' => 'Альберт',
			'surname' => 'Сукаев',
			'fathername' => 'Отчествович',
			'login' => 'lohpidr',
			'request_time' => '1421883448',
			'email' => 'lohpidr@yandex.ru',
			'telephone' => '8-903-583-13-46',
			'text' => 'Запрос мистера Сукаева',
		),
	);
	
	$users_from_db = array(
		0 => array(
			'id' => 0,
			'name' => 'Администратор',
			'surname' => '',
			'fathername' => '',
			'login' => 'admin',
			'password' => 'admin',
			'position' => 'Администратор',
			'email' => 'vshpilevoi@yandex.ru',
			'telephone' => '8-903-590-87-27',
			'register_time' => 1421883448,
			'last_visit_time' => 1421883448
		),
		1 => array(
			'id' => 1,
			'name' => 'Владислав',
			'surname' => 'Шпилевой',
			'fathername' => 'Дмитриевич',
			'login' => 'gerold',
			'password' => '123456',
			'position' => 'Стажер',
			'email' => 'vshpilevoi@yandex.ru',
			'telephone' => '8-903-590-87-27',
			'register_time' => 1421883448,
			'last_visit_time' => 1421883448
		),
		2 => array(
			'id' => 2,
			'name' => 'Татьяна',
			'surname' => 'Романенко',
			'fathername' => 'Евгеньевна',
			'login' => 'tatiana',
			'password' => '678910',
			'position' => 'Ведущий программист',
			'email' => 'romanenko@cs.msu.ru',
			'telephone' => '8-903-123-45-67',
			'register_time' => 1421883448,
			'last_visit_time' => 1421883448
		),
		3 => array(
			'id' => 3,
			'name' => 'Владимир',
			'surname' => 'Путин',
			'fathername' => 'Владимирович',
			'login' => 'vovan',
			'password' => '111213',
			'position' => 'Президент',
			'email' => 'vova@cremlin.ru',
			'telephone' => '8-903-891-01-11',
			'register_time' => 1421883448,
			'last_visit_time' => 1421883448
		),
		4 => array(
			'id' => 4,
			'name' => 'Name4',
			'surname' => 'Surname4',
			'fathername' => 'FatherName4',
			'login' => 'name4',
			'password' => '678910',
			'position' => 'Программист',
			'email' => 'name@cs.msu.ru',
			'telephone' => '8-903-123-45-67',
			'register_time' => 1421883448,
			'last_visit_time' => 1421883448
		),
		5 => array(
			'id' => 5,
			'name' => 'Name5',
			'surname' => 'Surname5',
			'fathername' => 'FatherName5',
			'login' => 'name5',
			'password' => '678910',
			'position' => 'Программист',
			'email' => 'name@cs.msu.ru',
			'telephone' => '8-903-123-45-67',
			'register_time' => 1421883448,
			'last_visit_time' => 1421883448
		),
		6 => array(
			'id' => 6,
			'name' => 'Name6',
			'surname' => 'Surname6',
			'fathername' => 'FatherName6',
			'login' => 'name6',
			'password' => '678910',
			'position' => 'Программист',
			'email' => 'name@cs.msu.ru',
			'telephone' => '8-903-123-45-67',
			'register_time' => 1421883448,
			'last_visit_time' => 1421883448
		),
		7 => array(
			'id' => 7,
			'name' => 'Name7',
			'surname' => 'Surname7',
			'fathername' => 'FatherName7',
			'login' => 'name7',
			'password' => '678910',
			'position' => 'Программист',
			'email' => 'name@cs.msu.ru',
			'telephone' => '8-903-123-45-67',
			'register_time' => 1421883448,
			'last_visit_time' => 1421883448
		),
		8 => array(
			'id' => 8,
			'name' => 'Name8',
			'surname' => 'Surname8',
			'fathername' => 'FatherName8',
			'login' => 'name8',
			'password' => '678910',
			'position' => 'Программист',
			'email' => 'name@cs.msu.ru',
			'telephone' => '8-903-123-45-67',
			'register_time' => 1421883448,
			'last_visit_time' => 1421883448
		),
		9 => array(
			'id' => 9,
			'name' => 'Name9',
			'surname' => 'Surname9',
			'fathername' => 'FatherName9',
			'login' => 'name9',
			'password' => '678910',
			'position' => 'Программист',
			'email' => 'name@cs.msu.ru',
			'telephone' => '8-903-123-45-67',
			'register_time' => 1421883448,
			'last_visit_time' => 1421883448
		),
	);
	
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