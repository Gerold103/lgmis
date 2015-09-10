<?php
	require_once('utility_lgmis_lib.php');
  	require_once($link_to_utility_authorization);

  	$funcNum = $_GET['CKEditorFuncNum'];
	$res = '<html>
	<head>
		<link rel="stylesheet" type="text/css" href="ckeditor/contents.css">
        <script type="text/javascript" src="js/script.js"></script>
        <script type="text/javascript" src="js/jquery-1.11.1.js"></script>
        <script type="text/javascript" src="ckeditor/ckeditor.js"></script>
		<script type="text/javascript">
			function GetUrlParam(paramName) {
				var oRegex = new RegExp( "[\?&]" + paramName + "=([^&]+)", "i" ) ;
				var oMatch = oRegex.exec( window.top.location.search ) ;
			 
				if ( oMatch && oMatch.length > 1 )
					return decodeURIComponent( oMatch[1] ) ;
				else
					return "" ;
			}
			function sendimg(a){
				funcNum = GetUrlParam("CKEditorFuncNum") ;
				window.opener.CKEDITOR.tools.callFunction(1, a.src);
				window.close();
			}
		</script>
	</head><body>';
	$dir_id = $_GET['id'];
	$upload_dir = '123';
	$author_id = User::GetIDByLogin($_SESSION['user_login']);
	if (isset($_GET['edit'])) {
	    switch ($_GET['type']) {
	      	case Article::$type:
	        	$upload_dir = $link_to_article_images.$dir_id;
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
	        case UserBlock::$type:
	        	$upload_dir = $link_to_users_images.$_GET['author_id'].'/blocks/'.$dir_id;
	        	break;
	      	default:
	        	break;
	    }
	}

	try{
      	$obdr = new DirectoryIterator($_SERVER['DOCUMENT_ROOT'].'/'.$link_prefix.$upload_dir);         // object of the dir
    }
    catch(Exception $e) {
      	return '<h2>ERROR from PHP:</h2><h3>'. $e->getMessage() .'</h3><h4>Check the dir value in imgbrowse.php to see if it is the correct path to the image folder; RELATIVE TO ROOT OF YOUR WEBSITE ON SERVER</h4>';
    }
    $protocol = !empty($_SERVER['HTTPS']) ? 'https://' : 'http://';
    $site = $protocol. $_SERVER['SERVER_NAME'] .'/';
    foreach($obdr as $fileobj) {
    	$name = $fileobj->getFilename();
    	if (startsWith($name, 'cover') === true) continue;
    	if ($fileobj->isFile()) $res .= '<span><img onClick="sendimg(this);" src="'.$site.$link_prefix.$upload_dir.'/'.$name .'" alt="'.$name.'" height="100" /></span>';
    }
    $res .= '</body></html>';

	echo $res;
?>