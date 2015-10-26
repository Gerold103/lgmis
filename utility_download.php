<?php
	require_once('utility_lgmis_lib.php');
	include_once($link_to_utility_authorization);

	$file_path = $_SERVER['DOCUMENT_ROOT'].$link_prefix;
	if (isset($_GET['file_path'])) {
		$file_path .= $_GET['file_path'];
	} else if (isset($_POST['file_path'])) {
		$file_path .= $_POST['file_path'];
	} else {
		echo 'exit';
		exit();
	}

	if (file_exists($file_path)) {
	    header('Content-Description: File Transfer');
	    header('Content-Type: application/octet-stream');
	    header('Content-Disposition: attachment; filename="'.urldecode(basename($file_path)).'"');
	    header('Expires: 0');
	    header('Cache-Control: must-revalidate');
	    header('Pragma: public');
	    header('Content-Length: ' . filesize($file_path));
	    readfile($file_path);
	    exit;
	} else {
		echo $file_path;
		echo 'not exist';
	}

?>