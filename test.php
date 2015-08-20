<?php
    include_once('utility_lgmis_lib.php');
?>

<!doctype html>
<html>
	<head>
        <meta charset="utf-8">
        <title>Тест</title>
        <link rel="stylesheet" type="text/css" href="css/styles.css">
        <link rel="stylesheet" type="text/css" href="ckeditor/contents.css">
        <script type="text/javascript" src="js/script.js"></script>
        <script type="text/javascript" src="js/jquery-1.11.1.js"></script>
        <!--<link rel="stylesheet" type="text/css" href=<?php echo '"'.$link_to_bootstrap_styles.'"'; ?>>
        <script type="text/javascript" src="js/bootstrap.min.js"></script>-->
        <script type="text/javascript" src="ckeditor/ckeditor.js"></script>
        
    </head>

    <body>
        <?php
            $password = password_hash('123456p', PASSWORD_DEFAULT);
            if (!$db_connection->query("UPDATE `lgmis2`.`users` SET `password` = '".$password."' WHERE `users`.`id` = 8")) {
                echo 'error';
            } else {
                echo 'success';
            }
        ?>
    </body>
</html>
