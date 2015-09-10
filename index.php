<?php
	$is_public = true;

	require_once('utility_lgmis_lib.php');
	require_once($link_to_utility_authorization);

	$header = '';
	$content = '';
	$footer = '';
	
	$size = 0;
	$from = -1;
	$to = -1;
	$pages = -1;
	$cur_page = -1;

	//----D I S P L A Y----
	
	//----A R T I C L E S----
	if ((!isset($_GET['content_type'])) || ($_GET['content_type'] == $content_types_short['articles'])) {
		$articles = Article::FetchAll();
		$size = count($articles);
		if ($size) {
			require($link_to_pagination_init_template);

			for ($i = $from; $i <= $to; ++$i) {
				$atricle = $articles[$i];
				$content .= ($atricle->ToHTMLAutoShortForTable(GetUserPrivileges()));
				if ($i != $to) $content .= '<hr><div style="background-color: #eeeeee;"><br></div><hr>';
			}
		} else {
			$content .= ToPageHeader(Language::Word('no news'), "h3", "black");
		}

		$header .= Language::PublicMenu('articles');
	} else if (isset($_GET['content_type'])) {
		//----D I R E C T I O N S----
		if ($_GET['content_type'] == $content_types_short['directions']) {
			$directions = Direction::FetchAll();
			$size = count($directions);
			if ($size) {
				require($link_to_pagination_init_template);

				for ($i = $from; $i <= $to; ++$i) {
					$direction = $directions[$i];
					$content .= $direction->ToHTMLAutoShortForTable(GetUserPrivileges());
					if ($i != $to) $content .= '<hr><div style="background-color: #eeeeee;"><br></div><hr>';
				}
			} else {
				$content .= ToPageHeader(Language::Word('no directions'), 'h3', 'black');
			}

			$header .= Language::PublicMenu('directions');
		}
		//----P R O J E C T S----
		else if ($_GET['content_type'] == $content_types_short['projects']) {
			$directions = Direction::FetchAll();
			$projects = array();
			for ($i = 0, $size = count($directions); $i < $size; ++$i) {
				$tmp = Project::FetchByDirectionID($directions[$i]->id);
				if ($tmp !== NULL) {
					$projects = array_merge($projects, $tmp);
				}
			}
			$size = count($projects);
			if ($size) {
				require($link_to_pagination_init_template);

				for ($i = $from; $i <= $to; ++$i) {
					$project = $projects[$i];
					if (($i === $from) || ($i > $from) && ($projects[$i - 1]->direction_id != $project->direction_id)) {
						if ($i != $from) $content .= '<hr>';
						$content .= '<div align="left" style="padding: 15px; background-color: #eeeeee;">';
						$content .= 	Language::Word('direction').': '.Direction::FetchByID($project->direction_id)->LinkToThis();
						$content .= '</div><hr>';
					}
					$content .= ($project->ToHTMLAutoShortForTable(GetUserPrivileges()));
				}
			} else {
				$content .= ToPageHeader(Language::Word('no projects'), 'h3', 'black');
			}

			$header .= Language::PublicMenu('projects');	
		}
	} else {
		//Manage articles
		$content .= MenuButton(Language::PublicMenu('articles'), $_SERVER['PHP_SELF'].'?content_type='.$content_types_short['articles']);

		//Manage directions
		$content .=	MenuButton(Language::PublicMenu('directions'), $_SERVER['PHP_SELF'].'?content_type='.$content_types_short['directions']);

		//Manage projects
		$content .=	MenuButton(Language::PublicMenu('projects'), $_SERVER['PHP_SELF'].'?content_type='.$content_types_short['projects']);		
	}

	$pagination = '';
	if ($size) {
		require($link_to_pagination_show_template);
		$content .= $pagination;
	}

	include($link_to_public_template);
?>