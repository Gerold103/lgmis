<?php
	$pagination = '';
	$get_sym = '?';
	if ($pages >= 2) { 

		$pagination .= '<div class="row" align="center">';
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
			$params = array_merge($_GET, array("page" => ($cur_page - 1)));
	      	$pagination .= 	'<a href="?'.http_build_query($params).'" aria-label="Previous">';
	        $pagination .= 		'<span aria-hidden="true">&laquo;</span>';
	      	$pagination .= 	'</a>';
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
				$pagination .=		'<a href="?'.http_build_query($params).'">'.$i.'</a>';
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
			$params = array_merge($_GET, array("page" => ($cur_page + 1)));
	      	$pagination .= 	'<a href="?'.http_build_query($params).'" aria-label="Next">';
	        $pagination .= 		'<span aria-hidden="true">&raquo;</span>';
	      	$pagination .= 	'</a>';
	    	$pagination .= '</li>';
		}

		$pagination .=				'</ul>';
		$pagination .=			'</nav>';
		$pagination .= '</div>';
	}
?>