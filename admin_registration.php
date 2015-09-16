<?php
	$is_public = true;

	require_once('utility_lgmis_lib.php');
	require_once($link_to_utility_authorization);

	$header = '';
	$content = '';
	$footer = '';
?>

<!doctype html>
<html>
	<head>
        <meta charset="utf-8">
        <title><?php echo Language::Word('registration'); ?></title>
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

            function processError(element, placeholder) {
                element.parentElement.parentElement.className += ' has-error';
                element.setAttribute('placeholder', placeholder);
            }

            function unsetError(element) {
                var parent = element.parentElement.parentElement;
                parent.className = parent.className.replace(/\bhas-error\b/, '');
            }

            function checkRegistrationForm(form) {
            	var error_flag = false;
            	var login_field = document.getElementsByName("login")[0];
            	if (checkLoginField(login_field) == false) {
            		error_flag = true;
                    processError(login_field, <?php echo '"'.Language::Word('incorrect login').'"'; ?>)
            	} else {
                    unsetError(login_field);
            	}

            	var email_field = document.getElementsByName("email")[0];
            	if (checkEmailField(email_field) == false) {
            		error_flag = true;
                    processError(email_field, <?php echo '"'.Language::Word('incorrect email').'"'; ?>);
            	} else {
                    unsetError(email_field);
            	}
            	var phone_field = document.getElementsByName("telephone")[0];
            	if (checkPhoneField(phone_field) == false) {
            		error_flag = true;
                    processError(phone_field, <?php echo '"'.Language::Word('incorrect phone').'"'; ?>);
            	} else {
                    unsetError(phone_field);
            	}

                var name_field = document.getElementsByName("name")[0];
                if (name_field.value.length == 0) {
                    error_flag = true;
                    processError(name_field, <?php echo '"'.Language::Word('incorrect name').'"' ?>);
                } else {
                    unsetError(name_field);
                }

                var surname_field = document.getElementsByName("surname")[0];
                if (surname_field.value.length == 0) {
                    error_flag = true;
                    processError(surname_field, <?php echo '"'.Language::Word('incorrect surname').'"' ?>);
                } else {
                    unsetError(surname_field);
                } 

                var fathername_field = document.getElementsByName("fathername")[0];
                if (fathername_field.value.length == 0) {
                    error_flag = true;
                    processError(fathername_field, <?php echo '"'.Language::Word('incorrect fathername').'"' ?>);
                } else {
                    unsetError(fathername_field);
                }

                var password_field = document.getElementsByName("password")[0];
                if (password_field.value.length == 0) {
                    error_flag = true;
                    processError(password_field, <?php echo '"'.Language::Word('incorrect password').'"' ?>);
                } else {
                    unsetError(password_field);
                }

            	return error_flag != true;
            }
        </script>
    </head>

    <body>
    	<?php
            echo '<div class="row">';
            echo    '<div class="'.ColAllTypes(12).'" align="center">';
			echo ToPageHeader(Language::Word('registration'));
            echo    '</div>';
            echo '</div>';
			
            echo '<div class="row">';
            if ($no_content_center) {
                echo '<div class="'.ColAllTypes(12).'">';   
            } else { 
                echo '<div class="'.ColAllTypes(12).'" align="center">';
            }
			echo RequestOnRegister::FormForCreating();
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