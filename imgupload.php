<?php
  require_once('utility_lgmis_lib.php');
  require_once($link_to_utility_authorization);
  // PHP Upload Script for CKEditor:  http://coursesweb.net/

  // HERE SET THE PATH TO THE FOLDER WITH IMAGES ON YOUR SERVER (RELATIVE TO THE ROOT OF YOUR WEBSITE ON SERVER)
  $dir_id = $_GET['id'];
  $author_id = User::GetIDByLogin($_SESSION['user_login']);
  $img_id = -1;
  $upload_dir = '123';
  if (isset($_GET['add'])) {
    switch ($_GET['type']) {
      case UserBlock::$type:
        if (isset($_GET['glob_id'])) $upload_dir = $link_to_users_images.$_GET['author_id'].'/blocks/'.$_GET['glob_id'];
        else $upload_dir = $link_to_users_images.$dir_id.'/blocks/tmp_'.$author_id;
        break;
      case Article::$type:
        if (isset($_GET['glob_id'])) $upload_dir = $link_to_article_images.$_GET['glob_id'];
        else $upload_dir = $link_to_article_images.'tmp_'.$author_id;
        break;
      case Direction::$type:
        if (isset($_GET['glob_id'])) $upload_dir = $link_to_direction_images.$_GET['glob_id'];
        else $upload_dir = $link_to_direction_images.'tmp_'.$author_id;
        break;
      case Project::$type:
        if (isset($_GET['glob_id'])) $upload_dir = $link_to_projects_images.$_GET['glob_id'];
        else $upload_dir = $link_to_projects_images.'tmp_'.$author_id;
        break;
      case TextPart::$type:
        file_put_contents('files/[debug].txt', 'in txt part = '.$_GET['glob_id']."\xA");
        if (isset($_GET['glob_id'])) $upload_dir = $link_to_text_part_images.$_GET['glob_id'];
        else $upload_dir = $link_to_text_part_images.'tmp_'.$author_id;
        break;
      case Report::$type:
        $upload_dir = $link_to_report_images.'tmp_'.$author_id;
        break;
      default:
        break;
    }
  } else if (isset($_GET['edit'])) {
    switch ($_GET['type']) {
      case UserBlock::$type:
        $upload_dir = $link_to_users_images.$_GET['author_id'].'/blocks/'.$dir_id;
        break;
      case Article::$type:
        $upload_dir = $link_to_article_images.$dir_id;
        break;
      case Report::$type:
        $upload_dir = $link_to_report_images.$dir_id;
        break;
      case Direction::$type:
        $upload_dir = $link_to_direction_images.$dir_id;
        break;
      case Project::$type:
        $upload_dir = $link_to_projects_images.$dir_id;
        break;
      case TextPart::$type:
        $upload_dir = $link_to_text_part_images.$dir_id;
        break;
      default:
        break;
    }
  }
  $request_buf = '';
  foreach($_REQUEST as $key => $val) {
    $request_buf .= $key.'; '.$val."\xA";
  }
  file_put_contents('files/[debug].txt', $upload_dir."\xA", FILE_APPEND);
  file_put_contents('files/[debug].txt', $request_buf, FILE_APPEND);
  file_put_contents('files/[debug].txt', 'Root: '.$_SERVER['DOCUMENT_ROOT'].$link_prefix.$upload_dir, FILE_APPEND);
  $img_id = countOfFilesInDir($link_prefix.$upload_dir) + 1;
  file_put_contents('files/[debug].txt', 'IMG_ID: '.$img_id."\xA", FILE_APPEND);
  file_put_contents('files/[debug].txt', $upload_dir."\xA", FILE_APPEND);

  // HERE PERMISSIONS FOR IMAGE
  $imgsets = array(
   'maxsize' => 2000,          // maximum file size, in KiloBytes (2 MB)
   'maxwidth' => 3000,          // maximum allowed width, in pixels
   'maxheight' => 2500,         // maximum allowed height, in pixels
   'minwidth' => 10,           // minimum allowed width, in pixels
   'minheight' => 10,          // minimum allowed height, in pixels
   'type' => array('bmp', 'gif', 'jpg', 'jpe', 'png', 'jpeg', 'svg')        // allowed extensions
  );

  $re = '';

  if(isset($_FILES['upload']) && strlen($_FILES['upload']['name']) >= 1) {
    $upload_dir = trim($upload_dir, '/') .'/';
    $img_name = basename($_FILES['upload']['name']);

    // get protocol and host name to send the absolute image path to CKEditor
    $protocol = !empty($_SERVER['HTTPS']) ? 'https://' : 'http://';
    $site = $protocol. $_SERVER['SERVER_NAME'] .'/';

    $uploadpath = $_SERVER['DOCUMENT_ROOT'] .$link_prefix. $upload_dir . $img_id;       // full file path
    $type = fileExtension($_FILES['upload']['name'])      // gets extension
    $uploadpath .= '.'.$type;
    list($width, $height) = getimagesize($_FILES['upload']['tmp_name']);     // gets image width and height
    $err = '';         // to store the errors

    // Checks if the file has allowed type, size, width and height (for images)
    if(!in_array($type, $imgsets['type'])) $err .= 'The file: '. $_FILES['upload']['name']. ' has not the allowed extension type.';
    if($_FILES['upload']['size'] > $imgsets['maxsize']*1024) $err .= '\\n Maximum file size must be: '. $imgsets['maxsize']. ' KB.';
    if(isset($width) && isset($height)) {
      if($width > $imgsets['maxwidth'] || $height > $imgsets['maxheight']) $err .= '\\n Width x Height = '. $width .' x '. $height .' \\n The maximum Width x Height must be: '. $imgsets['maxwidth']. ' x '. $imgsets['maxheight'];
      if($width < $imgsets['minwidth'] || $height < $imgsets['minheight']) $err .= '\\n Width x Height = '. $width .' x '. $height .'\\n The minimum Width x Height must be: '. $imgsets['minwidth']. ' x '. $imgsets['minheight'];
    }

    // If no errors, upload the image, else, output the errors
    if($err == '') {
      $re = 'alert("'.$_FILES['upload']['tmp_name'].'; '.$uploadpath.'");';
      file_put_contents('files/[debug].txt', $uploadpath."\xA", FILE_APPEND);
      if(move_uploaded_file($_FILES['upload']['tmp_name'], $uploadpath)) {
        $CKEditorFuncNum = $_GET['CKEditorFuncNum'];
        $url = $site.$link_prefix.$upload_dir.$img_id.'.'.$type;
        file_put_contents('files/[debug].txt', $url."\xA", FILE_APPEND);
        $message = $img_name .' successfully uploaded: \\n- Size: '. number_format($_FILES['upload']['size']/1024, 3, '.', '') .' KB \\n- Image Width x Height: '. $width. ' x '. $height;
        $re = "window.parent.CKEDITOR.tools.callFunction($CKEditorFuncNum, '$url', '$message')";
      }
      else {
        file_put_contents('files/[debug].txt', 'error: '.error_get_last()."\xA", FILE_APPEND);
        $re = 'alert("Unable to upload the file")';
      }
    }
    else $re = 'alert("'. $err .'")';
  }
  //file_put_contents($_SERVER['DOCUMENT_ROOT'] .'/'. $upload_dir.'[debug].txt', $request_buf, FILE_APPEND);
  //file_put_contents($_SERVER['DOCUMENT_ROOT'] .'/'. $upload_dir.'[debug].txt', $_SESSION, FILE_APPEND);
  echo "<script>".$re.";</script>";
?>
