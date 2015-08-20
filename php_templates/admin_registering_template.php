<!doctype html>
<html>
	<head>
        <meta charset="utf-8">
        <title>Регистрация</title>
        <link rel="stylesheet" type="text/css" href=<?php echo '"'.$link_to_styles.'"'; ?>>
        <link rel="stylesheet" type="text/css" href="ckeditor/contents.css">
        <link rel="stylesheet" type="text/css" href=<?php echo '"'.$link_to_bootstrap_styles.'"'; ?>>
        <script type="text/javascript" src="js/script.js"></script>
        <script type="text/javascript" src="js/jquery-1.11.1.js"></script>
        <script type="text/javascript" src="js/bootstrap.min.js"></script>
        <script type="text/javascript" src="ckeditor/ckeditor.js"></script>
        <script type="text/javascript">
            $(function () {
              $('[data-toggle="popover"]').popover()
            })
        </script>
    </head>

    <body>
    	<?php
            echo '<div class="row">';
            echo    '<div class="'.ColAllTypes(12).'" align="center">';
			echo ToPageHeader($header);
            echo    '</div>';
            echo '</div>';
			
            echo '<div class="row">';
            if ($no_content_center) {
                echo '<div class="'.ColAllTypes(12).'">';   
            } else { 
                echo '<div class="'.ColAllTypes(12).'" align="center">';
            }
			echo $content;
            echo    '</div>';
            echo '</div>';
			
            echo '<div class="row">';
            echo    '<div class="'.ColAllTypes(12).'" align="center">';
			echo $footer;
            echo    '</div>';
            echo '</div>';
		?>
    </body>
</html>