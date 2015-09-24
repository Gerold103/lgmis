<?php
	require_once('ulitity_lgmis_lib.php')

	$file_path = $_SERVER['DOCUMENT_ROOT'].$link_prefix;
	if (isset($_GET['file_path'])) {
		$file_path .= urldecode($_GET['file_path']);
	} else if (isset($_POST['file_path'])) {
		$file_path .= $_POST['file_path'];
	} else {
		exit();
	}

	if (file_exists($file_path)) {
	    header('Content-Description: File Transfer');
	    header('Content-Type: application/octet-stream');
	    header('Content-Disposition: attachment; filename="'.basename($file_path).'"');
	    header('Expires: 0');
	    header('Cache-Control: must-revalidate');
	    header('Pragma: public');
	    header('Content-Length: ' . filesize($file_path));
	    readfile($file_path);
	    exit;
	}

?>