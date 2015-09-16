<?php
	if (isset($_REQUEST['look_for'])) {
		echo json_encode(array('message' => 'new message'));
	} else {
		$answer = array('message' => $_POST['message'], 'author' => 'bla bla bla');
		echo json_encode($answer);
	}
?>