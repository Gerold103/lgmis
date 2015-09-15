<?php
    include_once('utility_lgmis_lib.php');
?>

<!doctype html>
<html>
	<head>
        <meta charset="utf-8">
        <title>Тест</title>
        <link rel="stylesheet" type="text/css" href="ckeditor/contents.css">
        <link rel="stylesheet" type="text/css" href="css/styles.css">
        <script type="text/javascript" src="js/script.js"></script>
        <script type="text/javascript" src="js/jquery-1.11.1.js"></script>
        <!--<link rel="stylesheet" type="text/css" href=<?php echo '"'.$link_to_bootstrap_styles.'"'; ?>>
        <script type="text/javascript" src="js/bootstrap.min.js"></script>-->
        <script type="text/javascript" src="ckeditor/ckeditor.js"></script>
        <script type="text/javascript">
            function getXmlHttp(){
              var xmlhttp;
              try {
                xmlhttp = new ActiveXObject("Msxml2.XMLHTTP");
              } catch (e) {
                try {
                  xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
                } catch (E) {
                  xmlhttp = false;
                }
              }
              if (!xmlhttp && typeof XMLHttpRequest!='undefined') {
                xmlhttp = new XMLHttpRequest();
              }
              return xmlhttp;
            }
            var server = null;

            function lookForMessages() {
                var data = 'look_for=true';
                server = getXmlHttp();
                server.open("POST", "/lgmis2/lgmis/test2.php", true);
                server.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
                server.onreadystatechange = updatePage;
                server.send(data);
            }

            //var intervalID = setInterval(lookForMessages, 1000);

            function updatePage() {
                if (server.readyState == 4) {
                    var text = server.responseText;
                    var result = JSON.parse(text);
                    var chat = document.getElementById("mesList");
                    var message = document.createElement("li");
                    message.innerHTML = result.message;
                    chat.appendChild(message);
                    var chatWindow = document.getElementById("chatWindow");
                    chatWindow.scrollTop = chatWindow.scrollHeight;
                }
            }

            function sendText() {
                var data = 'message=' + encodeURIComponent(document.getElementById("message").value);
                server = getXmlHttp();
                server.open("POST", "/lgmis2/lgmis/test2.php", true);
                server.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
                server.onreadystatechange = updatePage;
                server.send(data);
            }

            function scrollProcess() {
                var chatWindow = document.getElementById("chatWindow");
                if (chatWindow.scrollTop == 0) alert('top');
            }
        </script>
    </head>

    <body>
        <div onscroll="scrollProcess();" style="overflow-y: scroll; height: 100px; width: 500px; border: 1px solid black;" id="chatWindow">
            <ul id="mesList">
            </ul>
        </div>
        <textarea id="message"></textarea>
        <button onClick="sendText();">Отправить</button>

    </body>
</html>
