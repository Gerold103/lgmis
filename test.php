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
        <script type="text/javascript" src="js/jquery-1.11.1.js"></script>
        <script type="text/javascript" src="js/utility_links.js"></script>
        <script type="text/javascript" src="js/script.js"></script>
        <link rel="stylesheet" type="text/css" href=<?php echo '"'.$link_to_bootstrap_styles.'"'; ?>>
        <script type="text/javascript" src="js/bootstrap.min.js"></script>
        <script type="text/javascript" src="ckeditor/ckeditor.js"></script>
        <link rel="stylesheet" type="text/css" href=<?php echo '"'.Link::Get($link_to_animations_styles).'"'; ?>>
        <script type="text/javascript">

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

            var files_uploaded = 0;
            $(document).ready(function() {
                var files_area = $("#files_area");
                max_file_size = 1024 * 1024 * 512;

                files_area[0].ondragover = function() {
                    files_area.addClass('files_area_hover');
                    return false;
                };
                files_area[0].ondragleave = function() {
                    files_area.removeClass('files_area_hover');
                    return false;
                };

                files_area[0].ondrop = function(event) {
                    event.preventDefault();
                    files_area.removeClass('files_area_hover');
                    files_area.addClass('files_area_drop');

                    var files = event.dataTransfer.files;
                    for (var i = files.length - 1; i >= 0; --i) {
                        if (files[i].size > max_file_size) {
                            alert('File with name ' + files[i].name + ' has too large size');
                            return;
                        }
                        var local_server = getXmlHttp();
                        local_server.upload.addEventListener('progress', (function(id, file) {
                            return function(event) {
                                var percent = parseInt(event.loaded / event.total * 100);
                                //console.log('Загрузка i = ' + file.name + ': ' + percent + '%');
                                elem('file' + id).setAttribute('aria-valuenow', percent);
                                elem('file' + id).style.width = percent + '%';
                            };
                        })(files_uploaded, files[i]), false);
                        local_server.onreadystatechange = (function(file) {
                            return function(event) {
                                if (event.target.readyState == 4) {
                                    if (event.target.status == 200) {
                                        console.log('Загрузка ' + file.name + ' успешно завершена!');
                                    } else {
                                        console.log('Произошла ' + file.name + ' ошибка!');
                                    }
                                }
                            };
                        })(files[i]);
                        local_server.open("POST", "test2.php");
                        console.log(files[i].name);
                        local_server.setRequestHeader('x-filename', encodeURIComponent(files[i].name));
                        var fd = new FormData();
                        fd.append("file", files[i]);
                        var progress = document.createElement('li');
                        progress.innerHTML = '<div class="row">' +
                            '<div class="' + ColAllTypes(8) + ' vcenter">' +
                                '<div class="progress" style="margin: 0;">' +
                                    '<div id="file' + files_uploaded + '" class="progress-bar progress-bar-info progress-bar-striped" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width: 0%"></div>' +
                                '</div>' +
                            '</div>' +
                            '<div class="' + ColAllTypes(4) + ' vcenter">' +
                                '<button class="btn btn-default btn-sm"><span class="glyphicon glyphicon-remove" aria-hidden="true"></span></button>' +
                            '</div>' +
                        '</div>';
                        elem('progress_bars').appendChild(progress);
                        local_server.send(fd);
                        files_uploaded++;
                    };
                };
            });
        </script>
        <style type="text/css">
            .files_area {
                color: #555;
                font-size: 18px;
                text-align: center;
                width: 400px;
                padding: 50px;
                border: 1px solid #ccc;
            }
            .files_area_hover {
                background: #ddd;
            }
            .files_area_drop {
                background: #eee;
            }
        </style>
    </head>

    <body>

    <!-- Button trigger modal -->
<button type="button"  class="btn btn-primary btn-lg" data-toggle="modal" data-target="#myModal">
  Launch demo modal
</button>

<!-- Modal -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Modal title</h4>
      </div>
      <div class="modal-body">
        ...
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary">Save changes</button>
      </div>
    </div>
  </div>
</div>

        

    </body>
</html>
