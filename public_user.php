<?php
	$is_public = true;

	include_once('utility_lgmis_lib.php');
	include_once($link_to_utility_authorization);

	
	if ((isset($_POST['id'])) && (isset($_GET['id'])) && ($_POST['id'] !== $_GET['id'])) {
		$content = AlertMessage('alert-danger', 'Неоднозначные id');
	} else {
		$user = User::FetchByID($_REQUEST['id']);

		$header = '';
		$content = '';
		$footer = '';

		$header_type = 'h3';

		$title = $user->surname.' '.$user->name.' '.$user->fathername;

		$header = htmlspecialchars($user->surname.' '.$user->name.' '.$user->fathername);

		$content .= '<div class="row" align="center">';
		$content .= 	'<div class="'.ColAllTypes(4).'"><img src="'.Link::Get($user->path_to_photo).'" class="img-avatar"></div>';
		$content .= 	'<div class="'.ColAllTypes(8).'">';
		$content .= 		'<br><div class="row" align="center">';
		$content .= 			'<div class="'.ColAllTypes(6).'" align="right"><font color="grey">Должность:</font></div>';
		$content .= 			'<div class="'.ColAllTypes(6).'" align="left">'.$user->GetPosition().'</div>';
		$content .= 		'</div>';

		$articles = Article::FetchByAuthorID($user->id);
		$content .= 		'<div class="row" align="center">';
		$content .= 			'<div class="'.ColAllTypes(6).'" align="right"><font color="grey">Опубликовано новостей:</font></div>';
		$content .= 			'<div class="'.ColAllTypes(6).'" align="left">'.count($articles).'</div>';
		$content .= 		'</div>';
		$content .= 		'<hr>';
		$content .= 		ToPageHeader('Контактные данные', 'h4', 'grey');
		$content .= 		'<div class="row" align="center">';
		$content .= 			'<div class="'.ColAllTypes(6).'" align="right"><font color="grey">Почта:</font></div>';
		$content .= 			'<div class="'.ColAllTypes(6).'" align="left"><a href="mailto:'.$user->GetEmail().'">'.$user->GetEmail().'</a></div>';
		$content .= 		'</div>';
		$content .= 	'</div>';
		$content .= '</div>';
		$content .= '<hr>';

		$blocks = UserBlock::FetchAllByAuthorID($user->id);
		$size = count($blocks);
		if ($size) {
			require($link_to_pagination_init_template);

			for ($i = $from; $i <= $to; ++$i) {
				$content .= $blocks[$i]->ToHTMLAutoFull(GetUserPrivileges()).'<hr>';
			}

			require($link_to_pagination_show_template);
			$content .= $pagination;
		}

		$no_content_center = true;
	}

	include($link_to_public_template);
?>