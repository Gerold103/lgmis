<?php
	$is_public = false;
	include_once('utility_lgmis_lib.php');
	include_once($link_to_utility_authorization);

	$header = '';
	$content = '';
	$footer = '';
	$prev_page = $link_to_admin;
	
	if (GetUserPrivileges() === admin_user_id) {
		$header .= Language::Word('content management');
	} else {
		$header .= Language::Word('our content');
	}
	$user = User::FetchBy(['select_list' => 'position', 'eq_conds' => ['id' => GetUserID()], 'is_unique' => true]);
	
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
			$size = Article::FetchCountOf();
			if ($user->GetPositionNum() != NotEmployeeNum)
				$content .= MenuButton(Language::Word('add article'), $link_to_admin_article, 'btn-primary', 'add', 'get');
			if ($size) {
				require($link_to_pagination_init_template);
				$limit = $to - $from + 1;
				$articles = Article::FetchBy(['limit' => $limit, 'offset' => $from, 'order_by' => 'id DESC']);

				$content .= '<div class="row">';
				$content .= '<div class="'.ColAllTypes(1).' center-block"></div>';
				$content .= '<div class="'.ColAllTypes(10).' center-block">';
				$content .= '<table class="table table-striped text-center">';
				$content .= 	'<thead>';
				$content .= 		'<tr>';
				$content .=				'<th class="text-center" width="30%">'.Language::Word('header').'</th>';
				$content .=				'<th class="text-center">'.Language::Word('author').'</th>';
				$content .=				'<th class="text-center">'.Language::Word('date').'</th>';
				$content .=				'<th class="text-center">'.Language::Word('actions').'</th>';
				$content .=			'</tr>';
				$content .=		'</thead>';
				$content .=		'<tbody>';
				for ($i = 0; $i < $limit; ++$i) {
					$content .= ($articles[$i]->ToHTMLAutoShortForTable(GetUserPrivileges()));
				}
				$content .= 	'</tbody>';
				$content .= '</table>';
				$content .= '</div>';
				$content .= '</div>';
			} else {
				$content .= ToPageHeader(Language::Word('absense'), "h3", "black");
			}

			$header .= ' :'.Language::PublicMenu('articles');
		}
		//----D I R E C T I O N S----
		else if ($_GET['content_type'] == $content_types_short['directions']) {
			$directions = Direction::FetchAll();
			$size = count($directions);
			if ($user->GetPositionNum() != NotEmployeeNum)
				$content .= MenuButton(Language::Word('add direction'), $link_to_admin_direction, 'btn-primary', 'add', 'get');
			if ($size) {
				require($link_to_pagination_init_template);

				$content .= '<div class="row">';
				$content .= '<div class="'.ColAllTypes(1).' center-block"></div>';
				$content .= '<div class="'.ColAllTypes(10).' center-block">';
				$content .= '<table class="table table-striped text-center">';
				$content .= 	'<thead>';
				$content .= 		'<tr>';
				$content .=				'<th class="text-center" width="30%">'.Language::Word('header').'</th>';
				$content .=				'<th class="text-center">'.Language::Word('date').'</th>';
				$content .=				'<th class="text-center">'.Language::Word('author').'</th>';
				$content .=				'<th class="text-center">'.Language::Word('actions').'</th>';
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
				$content .= ToPageHeader(Language::Word('absense'), 'h3', 'black');
			}

			$header .= ' :'.Language::PublicMenu('directions');
		}
		//----P R O J E C T S----
		else if ($_GET['content_type'] == $content_types_short['projects']) {
			$projects = Project::FetchAll();
			$size = count($projects);
			if ($user->GetPositionNum() != NotEmployeeNum)
				$content .= MenuButton(Language::Word('add project'), $link_to_admin_project, 'btn-primary', 'add', 'get');
			if ($size) {
				require($link_to_pagination_init_template);

				$content .= '<div class="row">';
				$content .= '<div class="'.ColAllTypes(1).' center-block"></div>';
				$content .= '<div class="'.ColAllTypes(10).' center-block">';
				$content .= '<table class="table table-striped text-center">';
				$content .= 	'<thead>';
				$content .= 		'<tr>';
				$content .=				'<th class="text-center" width="20%">'.Language::Word('direction').'</th>';
				$content .=				'<th class="text-center" width="20%">'.Language::Word('object name').'</th>';
				$content .=				'<th class="text-center">'.Language::Word('date').'</th>';
				$content .=				'<th class="text-center">'.Language::Word('author').'</th>';
				$content .=				'<th class="text-center">'.Language::Word('actions').'</th>';
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
				$content .= ToPageHeader(Language::Word('absense'), 'h3', 'black');
			}

			$header .= ' :'.Language::PublicMenu('projects');	
		} else if ($_GET['content_type'] === $content_types_short['about_us']) {
			$parts = TextPart::FetchByRole('about_us');
			$size = count($parts);
			if ($user->GetPositionNum() != NotEmployeeNum)
				$content .= MenuButton(Language::Word('add text block'), $link_to_admin_text_part, 'btn-primary', 'add', 'get');
			if ($size) {
				require($link_to_pagination_init_template);

				$content .= '<div class="row">';
				$content .= '<div class="'.ColAllTypes(12).' center-block">';
				$content .= '<table class="table table-striped text-center">';
				$content .= 	'<thead>';
				$content .= 		'<tr>';
				$content .=				'<th class="text-center">'.Language::Word('object name').'</th>';
				$content .=				'<th class="text-center">'.Language::Word('author').'</th>';
				$content .=				'<th class="text-center">'.Language::Word('date').'</th>';
				$content .= 			'<th class="text-center">'.Language::Word('role').'</th>';
				$content .= 			'<th class="text-center">'.Language::Word('actions').'</th>';
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
				$content .= ToPageHeader(Language::Word('absense'), 'h3', 'black');
			}

			$header .= ' :'.Language::PublicMenu('about_us');
		}
		$prev_page = $link_to_admin_manage_content;
	} else {
		//Manage articles
		$content .= MenuButton(Language::PublicMenu('articles'), $_SERVER['PHP_SELF'].'?content_type='.$content_types_short['articles'], 'btn-default', '', 'get');

		//Manage directions
		$content .=	MenuButton(Language::PublicMenu('directions'), $_SERVER['PHP_SELF'].'?content_type='.$content_types_short['directions'], 'btn-default', '', 'get');

		//Manage projects
		$content .=	MenuButton(Language::PublicMenu('projects'), $_SERVER['PHP_SELF'].'?content_type='.$content_types_short['projects'], 'btn-default', '', 'get');	

		if (GetUserPrivileges() === admin_user_id)
			$content .= MenuButton(Language::PublicMenu('about_us'), $_SERVER['PHP_SELF'].'?content_type='.$content_types_short['about_us'], 'btn-default', '', 'get');	
	}

	$pagination = '';
	if ($size) {
		require($link_to_pagination_show_template);
		$content .= $pagination;
	}

	include($link_to_admin_template);
?>