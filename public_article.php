<?php
	$is_public = true;

	include_once('utility_lgmis_lib.php');
	include_once($link_to_utility_authorization);

	$article = Article::FetchByID($_POST['id']);

	$header = '';
	$content = '';
	$footer = '';

	$header_type = 'h4';

	$title = $article->name;

	$header = htmlspecialchars($article->name);

	$content .= '<br><div class="row" align="center">';
	$content .= 	'<div class="'.ColAllTypes(3).'">'.$article->GetCreatingDateStr().'</div>';
	$content .= 	'<div class="'.ColAllTypes(4).'">'.User::FetchByID($article->GetAuthorID())->LinkToThis().'</div>';
	$content .= '</div>';
	$content .= '<br><hr>';
	$content .= '<div class="row"><div class="'.ColAllTypes(12).'">'.$article->text_block.'</div></div>';

	$no_content_center = true;

	include($link_to_public_template);
?>