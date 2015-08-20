<?php
	$db_connection = mysqli_connect('localhost', 'root', 'goljaf');
	if (!$db_connection->ping()) {
		echo '<font color="red">Ошибка при подключении к базе</font>';
		exit();
	}
	if (!$db_connection->select_db('lgmis2')) {
		echo '<font color="red">Ошибка при выборе базы данных</font>';
		exit();
	}
	if (!$db_connection->query("SET CHARACTER SET 'utf8'")) {
		echo '<font color="red">Ошибка при установке кодировки</font>';
		exit();
	}

	require_once('utility_defines.php');
	require_once('php_lib/password_compat/lib/password.php');
	require_once($link_to_element_templates);
	require_once($link_to_interfaces);
	require_once($link_to_user_class);
	require_once($link_to_article_class);
	require_once($link_to_direction_class);
	require_once($link_to_request_on_register_class);
	require_once($link_to_project_class);
	require_once($link_to_user_block_class);
	require_once($link_to_text_part_class);
	//----------------------------------------------------------------C L A S S E S   F O R   D A T A B A S E    O B J E C T S----------------------------------------------------------------
	
	/*
	//------------------------------------------------M E S S A G E------------------------------------------------
	
	class Message implements IUserHTML, IDelEdit, ISQLOps {
		//Methods and attributes for working with private messsages of users.
		
		//--------Attributes--------
		
		private $id          = id_undef;
		private $author_id   = id_undef;
		private $addresse_id = id_undef;
		private $send_time   = time_undef;
		private $theme       = undef;
		private $text_block  = undef;
		
		//--------Methods--------
		
		
	}
	*/

	function removeDirectory($dir) {
		if ($objs = glob($dir."/*")) {
			foreach($objs as $obj) {
				is_dir($obj) ? removeDirectory($obj) : unlink($obj);
			}
		}
		rmdir($dir);
	}

	function delete_image($image_name_without_ext)
	{
		$files = glob($image_name_without_ext.'.*');
		if (count($files) > 1) {
			return 0;
		}
		if (count($files) == 0) {
			return 1;
		}
		unlink($files[0]);
		return 1;
	}

	function clear_tmp_images_dir($type_of_tmp_content, $dir_id)
	{
		global $link_to_users_images;
		global $link_to_article_images;
		global $link_to_direction_images;
		global $link_to_projects_images;
		global $link_to_text_part_images;

		$author_id = User::GetIDByLogin($_SESSION['user_login']);
		$dir = '';
		switch ($type_of_tmp_content) {
    		case UserBlock::$type: {
      			$dir = $link_to_users_images.$dir_id.'/blocks/tmp_'.$author_id;
      			break;
      		}
      		case Article::$type: {
      			$dir = $link_to_article_images.'tmp_'.$author_id;
      			break;
      		}
      		case Direction::$type: {
      			$dir = $link_to_direction_images.'tmp_'.$author_id;
      			break;
      		}

      		case Project::$type: {
      			$dir = $link_to_projects_images.'tmp_'.$author_id;
      			break;
      		}

      		case TextPart::$type: {
      			$dir = $link_to_text_part_images.'tmp_'.$author_id;
      			break;
      		}
    
    		default:
      		break;
		}
		if (file_exists($dir)) {
			removeDirectory($dir);
		}
		mkdir($dir);
	}

	function recurse_copy($src, $dst, $max_depth = 10) {
		if ($max_depth <= 0) return -1; 
	    $dir = opendir($src); 
	    @mkdir($dst); 
	    while(false !== ( $file = readdir($dir)) ) { 
	        if (( $file != '.' ) && ( $file != '..' )) { 
	            if ( is_dir($src . '/' . $file) ) { 
	                recurse_copy($src . '/' . $file,$dst . '/' . $file, $max_depth - 1); 
	            } 
	            else { 
	                copy($src . '/' . $file,$dst . '/' . $file); 
	            } 
	        } 
	    } 
	    closedir($dir); 
	}

	function ArrayElemIsValidStr($arr, $elem) {
		return isset($arr[$elem]) && strlen($arr[$elem]);
	}
?>