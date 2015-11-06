<?php
	$is_public = true;

	include_once('utility_lgmis_lib.php');
	include_once($link_to_utility_authorization);

	
	if ((isset($_POST['id'])) && (isset($_GET['id'])) && ($_POST['id'] !== $_GET['id'])) {
		$content = AlertMessage('alert-danger', 'Неоднозначные id');
	} else {
		$user = User::FetchBy(['eq_conds' => ['id' => $_REQUEST['id']], 'is_unique' => true]);
		$header = '';
		$content = '';
		$footer = '';

		$header_type = 'h3';

		$title = Language::Translit($user->GetSurname().' '.$user->GetName().' '.$user->GetFathername());

		$header = htmlspecialchars(Language::Translit($user->GetSurname().' '.$user->GetName().' '.$user->GetFathername()));

		$content .= '<div class="row" align="center">';
		$content .= 	'<div class="'.ColAllTypes(4).'"><img src="'.Link::Get($user->GetPathToPhoto()).'" class="img-avatar"></div>';
		$content .= 	'<div class="'.ColAllTypes(8).'">';
		$content .= 		'<br><div class="row" align="center">';
		$content .= 			'<div class="'.ColAllTypes(6).'" align="right"><font color="grey">'.Language::Word('position').':</font></div>';
		$content .= 			'<div class="'.ColAllTypes(6).'" align="left">'.$user->GetPosition().'</div>';
		$content .= 		'</div>';

		$articles = Article::FetchCountOf(['where' => 'author_id = '.$user->GetID()]);
		$content .= 		'<div class="row" align="center">';
		$content .= 			'<div class="'.ColAllTypes(6).'" align="right"><font color="grey">'.Language::Word('news published').':</font></div>';
		$content .= 			'<div class="'.ColAllTypes(6).'" align="left">'.count($articles).'</div>';
		$content .= 		'</div>';
		$content .= 		'<hr>';
		$content .= 		ToPageHeader(Language::PublicMenu('contacts'), 'h4', 'grey');
		$content .= 		'<div class="row" align="center">';
		$content .= 			'<div class="'.ColAllTypes(6).'" align="right"><font color="grey">'.Language::Word('mail').':</font></div>';
		$content .= 			'<div class="'.ColAllTypes(6).'" align="left"><a href="mailto:'.$user->GetEmail().'">'.$user->GetEmail().'</a></div>';
		$content .= 		'</div>';
		$content .= 	'</div>';
		$content .= '</div>';
		$content .= '<hr>';

		$blocks = UserBlock::FetchAllByAuthorID($user->GetID());
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