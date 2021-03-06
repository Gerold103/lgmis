<!doctype html>
<html>
	<head>
        <meta charset="utf-8">
        <title>
        	<?php
        		if (!isset($title)) {
        			echo Админка;
        		} else {
        			echo $title;
        		}
        	?>
        </title>
        <link rel="stylesheet" type="text/css" href="ckeditor/contents.css">
        <script type="text/javascript" src="js/jquery.js"></script>
        <script type="text/javascript" src="js/jquery-ui.min.js"></script>
        <script type="text/javascript" src="js/utility_links.js"></script>
        <script type="text/javascript" src="js/script.js"></script>
        <script type="text/javascript" src="js/bootstrap.min.js"></script>
        <script type="text/javascript" src="ckeditor/ckeditor.js"></script>
        <link rel="stylesheet" type="text/css" href=<?php echo '"'.$link_to_bootstrap_styles.'"'; ?>>
        <link rel="stylesheet" type="text/css" href=<?php echo '"'.$link_to_styles.'"'; ?>>
        <link rel="stylesheet" type="text/css" href=<?php echo '"'.$link_to_files_styles.'"'; ?> >
        <link rel="stylesheet" type="text/css" href=<?php echo '"'.Link::Get($link_to_animations_styles).'"'; ?>>
        <script type="text/javascript">
            $(document).ready(function() {
                $(function () {
                    $('[data-toggle="tooltip"]').tooltip()
                });
                $(function () {
                    $('[data-toggle="popover"]').popover()
                });
            });
        </script>
        <?php if (isset($head_addition)) echo $head_addition;  ?>
    </head>

    <body>
    	<?php
			//Вывод основной страницы
			
            echo '<div class="row">';
            echo    '<div class="'.ColAllTypes(12).'" align="center">';
            require_once($link_to_admin_menu_template);
            echo    '</div>';
            echo '</div>';
			
            echo '<div class="row">';
            echo    '<div class="'.ColAllTypes(12).'" align="center">';
			echo ToPageHeader($header);
            echo    '</div>';
            echo '</div>';
			
            echo '<div class="row" style="height: 100%;">';
            if ($no_content_center) {
                echo '<div class="'.ColAllTypes(12).' style="height: 100%;>';   
            } else { 
                echo '<div class="'.ColAllTypes(12).'" align="center" style="height: 100%;">';
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