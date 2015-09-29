<?php
	//Requires variables:
	/*
		$size - count of objects for paginating
	*/

	//Result variables:
	/*
		$from - start number of object on current page
		$to - end number of object on current page
	*/
	global $records_on_page;

	if (!isset($need_pagination) || ($need_pagination == true)) {
		$pages = intval($size / $records_on_page);
		if ($size % $records_on_page) {
			++$pages;
		}
		$cur_page = 1;
		if (isset($_GET['page'])) {
			$cur_page = $_GET['page'];
		}
		if (($cur_page <= 0) || ($cur_page > $pages)) {
			echo '<font color="red">Incorrect page</font>';
			exit();
		}

		$from = ($cur_page - 1) * $records_on_page;
	} else {
		$from = 0;
	}
	$to = min($from + $records_on_page - 1, $size - 1);
	$count = $to - $from + 1;
?>