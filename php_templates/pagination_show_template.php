<?php
	if (!isset($need_pagination) || ($need_pagination == true)) {
		$pagination = '';
		$get_sym = '?';
		if ($pages >= 2) { 

			$res_uri = NULL;
			if (($use_mod_rewrite === true) && (IsSessionPublic())) {
				$tmp = explode('/', $_SERVER['REQUEST_URI']);
				$uri = array();
				for ($_i = 0, $_size = count($tmp); $_i < $_size; ++$_i) {
					if (!empty($tmp[$_i])) array_push($uri, $tmp[$_i]);
				}
				$_last = count($uri) - 1;
				if (preg_match('/^page-[0-9]+/', $uri[$_last]) === 1) {
					unset($uri[$_last]);
				}
				$res_uri = '';
				for ($_i = 0, $_size = count($uri); $_i < $_size; ++$_i) {
					$res_uri .= '/'.$uri[$_i];
				}
			}

			$pagination .= '<div class="row" align="center" id="pagination_row">';
			$pagination .= 		'<nav>';
			$pagination .=				'<ul class="pagination">';

			if ($cur_page == 1) {
				$pagination .=	'<li class="disabled">';
				$pagination .=		'<a href="#" aria-label="Previous">';
				$pagination .=			'<span aria-hidden="true">«</span>';
				$pagination .=		'</a>';
				$pagination .= '</li>';
			} else {
				$pagination .= '<li>';
				if (($use_mod_rewrite === true) && (IsSessionPublic())) {
					$pagination .= '<a href="'.$res_uri.'/page-'.($cur_page - 1).'" aria-label="Previous"><span aria-hidden="true">&laquo;</span></a>';
				} else {
					$params = array_merge($_GET, array("page" => ($cur_page - 1)));
			      	$pagination .= 	'<a href="?'.http_build_query($params).'" aria-label="Previous">';
			        $pagination .= 		'<span aria-hidden="true">&laquo;</span>';
			      	$pagination .= 	'</a>';
			    }
		    	$pagination .= '</li>';
			}

			global $page_numbers_on_page;
			$start = max(1, $cur_page - intval($page_numbers_on_page / 2));
			$end = min($pages, $cur_page + intval($page_numbers_on_page / 2));

			if ($end - $start + 1 < $page_numbers_on_page) {
				if ($start == 1) {
					while ($end - $start + 1 < $page_numbers_on_page) {
						++$end;
					}
					$end = min($end, $pages);
				} else if ($end == $pages) {
					while ($end - $start + 1 < $page_numbers_on_page) {
						--$start;
					}
					$start = max($start, 1);
				}
			} 

			for ($i = $start; $i <= $end; ++$i) {
				if ($i != $cur_page) {
					$pagination .= '<li>';
					$params = array_merge($_GET, array("page" => $i));
					if (($use_mod_rewrite === true) && (IsSessionPublic())) {
						$pagination .=		'<a href="'.$res_uri.'/page-'.$i.'">'.$i.'</a>';
					} else {
						$pagination .=		'<a href="?'.http_build_query($params).'">'.$i.'</a>';
					}
					$pagination .=	'</li>';
					continue;
				}
				$pagination .= '<li class="active">';
				$pagination .=		'<a href="#">'.$i.'<span class="sr-only">(current)</span></a>';
				$pagination .= '</li>';
			}

			if ($cur_page == $pages) {
				$pagination .=	'<li class="disabled">';
				$pagination .=		'<a href="#" aria-label="Next">';
				$pagination .=			'<span aria-hidden="true">»</span>';
				$pagination .=		'</a>';
				$pagination .= '</li>';
			} else {
				$pagination .= '<li>';
				if (($use_mod_rewrite === true) && (IsSessionPublic())) {
					$pagination .= '<a href="'.$res_uri.'/page-'.($cur_page + 1).'" aria-label="Next"><span aria-hidden="true">&raquo;</span></a>';
				} else {
					$params = array_merge($_GET, array("page" => ($cur_page + 1)));
			      	$pagination .= 	'<a href="?'.http_build_query($params).'" aria-label="Next">';
			        $pagination .= 		'<span aria-hidden="true">&raquo;</span>';
			      	$pagination .= 	'</a>';
			    }
		    	$pagination .= '</li>';
			}

			$pagination .=				'</ul>';
			$pagination .=			'</nav>';
			$pagination .= '</div>';
		}
	}
?>