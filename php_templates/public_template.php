<!doctype html>
<html>
	<head>
        <meta charset="utf-8">
        <title>
        	<?php
        		if (!isset($title)) {
        			echo Language::SiteName();
        		} else {
        			echo $title;
        		}
        	?>
        </title>
        <link rel="stylesheet" type="text/css" href=<?php echo '"'.Link::Get($link_to_ckeditor).'contents.css"'; ?> >
        <script type="text/javascript" src=<?php echo '"'.Link::Get($link_to_js).'script.js"'; ?> ></script>
        <script type="text/javascript" src=<?php echo '"'.Link::Get($link_to_js).'jquery-1.11.1.js"'; ?> ></script>
        <script type="text/javascript" src=<?php echo '"'.Link::Get($link_to_ckeditor).'ckeditor.js"'; ?> ></script>
        <script type="text/javascript" src=<?php echo '"'.Link::Get($link_to_js).'bootstrap.min.js"'; ?> ></script>
        <link rel="stylesheet" type="text/css" href=<?php echo '"'.Link::Get($link_to_bootstrap_styles).'"'; ?>>
        <link rel="stylesheet" type="text/css" href=<?php echo '"'.Link::Get($link_to_styles).'"'; ?>>
        <script type="text/javascript">
            $(function () {
              $('[data-toggle="popover"]').popover()
            })
        </script>
    </head>

    <body style="min-width: 850px;">
        <div id="wrap">
        	<?php
    			//Вывод основной страницы
    			
                echo '<div class="row">';
                echo    '<div class="'.ColAllTypes(12).'" align="center">';
                require_once($link_to_public_menu_template);
                echo    '</div>';
                echo '</div>';

            ?>

            <div style="height: 100%;">
                <div class="panel panel-default" style="margin-left: auto; margin-right: auto; width: 800px; padding: 5px; margin-top: -5px; margin-bottom: -5px;">
                    <div class="panel-body" style="padding: 0px; margin: 0px;">
                        <?php	
                            echo '<div class="row">';
                            echo    '<div class="'.ColAllTypes(12).'" align="center">';
                			if (!isset($header_type)) echo ToPageHeader($header);
                            else echo ToPageHeader($header, $header_type);
                            echo    '</div>';
                            echo '</div>';

                            echo '<hr>';
                			
                            echo '<div class="row">';
                            if ($no_content_center) {
                                echo '<div class="'.ColAllTypes(12).'">';   
                            } else { 
                                echo '<div class="'.ColAllTypes(12).'" align="center">';
                            }
                			echo $content;
                            echo    '</div>';
                            echo '</div>';
                        ?>
                    </div>
                </div>
            </div>


            <div id="push"></div>
        </div>
        <?php  
            echo '<div id="footer" align="center">';
            echo    '<div class="row">';
            echo        '<div class="'.ColAllTypes(12).'" align="center">';
            require_once($link_to_public_footer_template);
            echo        '</div>';
            echo    '</div>';
            echo '</div>';
        ?>
    </div>
    <div style="position: absolute; top: 20px; right: 50px;">
        <a href=<?php echo '"'.Link::Get('/lang/rus').'"'; ?> ><img class="lang_flag" src=<?php echo '"'.Link::Get($link_to_service_images).'rus_flag.png"'; ?> ></a><a href=<?php echo '"'.Link::Get('/lang/eng').'"'; ?>><img class="lang_flag" src=<?php echo '"'.Link::Get($link_to_service_images).'eng_flag.png"'; ?> ></a>
    </div>
    <div style="position: fixed; top: 20px; left: 50px;">
        <a class="btn btn" href=<?php echo '"'.$link_to_admin.'"'; ?> ><?php echo Language::Word('private office'); ?></a>
    </div>
    </body>
</html>