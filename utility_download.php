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
		if (!is_dir($file_path)) {
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
			$tmp_zip = tempnam('/tmp', hash('crc32', $file_path)).'.zip';
			HZip::zipDir($file_path, $tmp_zip);
			header('Content-Description: File Transfer');
		    header('Content-Type: application/octet-stream');
		    header('Content-Disposition: attachment; filename="'.urldecode(basename($file_path)).'.zip"');
		    header("Content-Transfer-Encoding: binary");
		    header('Content-Length: '.filesize($tmp_zip));
		    readfile($tmp_zip);
		    exit;
		}
	} else {
		echo $file_path;
		echo 'not exist';
	}

?>