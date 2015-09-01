<?php
	$is_public = false;
	include_once('utility_lgmis_lib.php');
	include_once($link_to_utility_authorization);

	$header = '';
	$content = '';
	$footer = '';
	$prev_page = $link_to_admin;
	
	if (GetUserPrivileges() === admin_user_id) {
		$header .= 'Управление контентом';
	} else {
		$header .= 'Наш контент';
	}
	
	$content = '';
	$size = 0;
	$from = -1;
	$to = -1;
	$pages = -1;
	$cur_page = -1;

	//----D I S P L A Y----
	
	if (isset($_GET['content_type'])) {
		//----A R T I C L E S----
		if ($_GET['content_type'] == $content_types_short['articles']) {
			$articles = Article::FetchAll();
			$size = count($articles);
			$content .= MenuButton('Добавить новость', $link_to_admin_article, 'btn-primary', 'add', 'get');
			if ($size) {
				require($link_to_pagination_init_template);

				$content .= '<div class="row">';
				$content .= '<div class="'.ColAllTypes(1).' center-block"></div>';
				$content .= '<div class="'.ColAllTypes(10).' center-block">';
				$content .= '<table class="table table-striped text-center">';
				$content .= 	'<thead>';
				$content .= 		'<tr>';
				$content .=				'<th class="text-center" width="30%">Заголовок</th>';
				$content .=				'<th class="text-center">Автор</th>';
				$content .=				'<th class="text-center">Дата</th>';
				$content .=				'<th class="text-center">Действия</th>';
				$content .=			'</tr>';
				$content .=		'</thead>';
				$content .=		'<tbody>';
				for ($i = $from; $i <= $to; ++$i) {
					$atricle = $articles[$i];
					$content .= ($atricle->ToHTMLAutoShortForTable(GetUserPrivileges()));
				}
				$content .= 	'</tbody>';
				$content .= '</table>';
				$content .= '</div>';
				$content .= '</div>';
			} else {
				$content .= ToPageHeader("Отсутствуют", "h3", "black");
			}

			$header .= ' :Новости';
		}
		//----D I R E C T I O N S----
		else if ($_GET['content_type'] == $content_types_short['directions']) {
			$directions = Direction::FetchAll();
			$size = count($directions);
			$content .= MenuButton('Добавить направление', $link_to_admin_direction, 'btn-primary', 'add', 'get');
			if ($size) {
				require($link_to_pagination_init_template);

				$content .= '<div class="row">';
				$content .= '<div class="'.ColAllTypes(1).' center-block"></div>';
				$content .= '<div class="'.ColAllTypes(10).' center-block">';
				$content .= '<table class="table table-striped text-center">';
				$content .= 	'<thead>';
				$content .= 		'<tr>';
				$content .=				'<th class="text-center" width="30%">Название</th>';
				$content .=				'<th class="text-center">Дата</th>';
				$content .=				'<th class="text-center">Автор</th>';
				$content .=				'<th class="text-center">Действия</th>';
				$content .=			'</tr>';
				$content .=		'</thead>';
				$content .=		'<tbody>';
				for ($i = $from; $i <= $to; ++$i) {
					$direction = $directions[$i];
					$content .= $direction->ToHTMLAutoShortForTable(GetUserPrivileges());
				}
				$content .= 	'</tbody>';
				$content .= '</table>';
				$content .= '</div>';
				$content .= '</div>';
			} else {
				$content .= ToPageHeader("Отсутствуют", 'h3', 'black');
			}

			$header .= ' :Направления';
		}
		//----P R O J E C T S----
		else if ($_GET['content_type'] == $content_types_short['projects']) {
			$projects = Project::FetchAll();
			$size = count($projects);
			$content .= MenuButton('Добавить проект', $link_to_admin_project, 'btn-primary', 'add', 'get');
			if ($size) {
				require($link_to_pagination_init_template);

				$content .= '<div class="row">';
				$content .= '<div class="'.ColAllTypes(1).' center-block"></div>';
				$content .= '<div class="'.ColAllTypes(10).' center-block">';
				$content .= '<table class="table table-striped text-center">';
				$content .= 	'<thead>';
				$content .= 		'<tr>';
				$content .=				'<th class="text-center" width="20%">Направление</th>';
				$content .=				'<th class="text-center" width="20%">Название</th>';
				$content .=				'<th class="text-center">Дата</th>';
				$content .=				'<th class="text-center">Автор</th>';
				$content .=				'<th class="text-center">Действия</th>';
				$content .=			'</tr>';
				$content .=		'</thead>';
				$content .=		'<tbody>';
				for ($i = $from; $i <= $to; ++$i) {
					$project = $projects[$i];
					$content .= ($project->ToHTMLAutoShortForTable(GetUserPrivileges()));
				}
				$content .= 	'</tbody>';
				$content .= '</table>';
				$content .= '</div>';
				$content .= '</div>';
			} else {
				$content .= ToPageHeader("Отсутствуют", 'h3', 'black');
			}

			$header .= ' :Проекты';	
		} else if ($_GET['content_type'] === $content_types_short['about_us']) {
			$parts = TextPart::FetchByRole('about_us');
			$size = count($parts);
			$content .= MenuButton('Добавить блок текста', $link_to_admin_text_part, 'btn-primary', 'add', 'get');
			if ($size) {
				require($link_to_pagination_init_template);

				$content .= '<div class="row">';
				$content .= '<div class="'.ColAllTypes(12).' center-block">';
				$content .= '<table class="table table-striped text-center">';
				$content .= 	'<thead>';
				$content .= 		'<tr>';
				$content .=				'<th class="text-center">Название</th>';
				$content .=				'<th class="text-center">Автор</th>';
				$content .=				'<th class="text-center">Дата</th>';
				$content .= 			'<th class="text-center">Роль</th>';
				$content .= 			'<th class="text-center">Действия</th>';
				$content .=			'</tr>';
				$content .=		'</thead>';
				$content .=		'<tbody>';
				for ($i = $from; $i <= $to; ++$i) {
					$content .= $parts[$i]->ToHTMLAutoShortForTable(GetUserPrivileges());
				}
				$content .= 	'</tbody>';
				$content .= '</table>';
				$content .= '</div>';
				$content .= '</div>';
			} else {
				$content .= ToPageHeader('Отсутствуют', 'h3', 'black');
			}

			$header .= ' :О нас';
		}
		$prev_page = $link_to_admin_manage_content;
	} else {
		//Manage articles
		$content .= MenuButton('Новости', $_SERVER['PHP_SELF'].'?content_type='.$content_types_short['articles'], 'btn-default', '', 'get');

		//Manage directions
		$content .=	MenuButton('Направления', $_SERVER['PHP_SELF'].'?content_type='.$content_types_short['directions'], 'btn-default', '', 'get');

		//Manage projects
		$content .=	MenuButton('Проекты', $_SERVER['PHP_SELF'].'?content_type='.$content_types_short['projects'], 'btn-default', '', 'get');	

		//About us page
		$content .= MenuButton('О нас', $_SERVER['PHP_SELF'].'?content_type='.$content_types_short['about_us'], 'btn-default', '', 'get');	
	}

	$pagination = '';
	if ($size) {
		require($link_to_pagination_show_template);
		$content .= $pagination;
	}

	include($link_to_admin_template);
?>