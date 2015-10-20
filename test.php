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

            .folder {
                width: 100px;
                height: 70px;
                margin: 0 auto;
                margin-top: 33px;
                position: relative;
                background-color: #708090;
                border-radius: 0 4px 4px 4px;
                padding: 7px;
                color: white;
                font-size: 24px;
            }

            .folder:before {
                content: '';
                width: 50%;
                height: 12px;
                border-radius: 0 20px 0 0;
                background-color: #708090;
                position: absolute;
                top: -12px;
                left: 0px;
            }


            @charset "utf-8";
            /*! fileicon.css v1.0.0 | MIT License | github.com/picturepan2/fileicon.css */
            /* fileicon.basic */
            .file-icon {
              font-family: Arial, Tahoma, sans-serif;
              font-weight: 300;
              display: block;
              width: 24px;
              height: 32px;
              background: #018FEF;
              position: relative;
              border-radius: 2px;
              text-align: left;
              -webkit-font-smoothing: antialiased;
            }
            .file-icon::before {
              display: block;
              content: "";
              position: absolute;
              top: 0;
              right: 0;
              width: 0;
              height: 0;
              border-bottom-left-radius: 2px;
              border-width: 5px;
              border-style: solid;
              border-color: #FFF #FFF rgba(255,255,255,.35) rgba(255,255,255,.35);
            }
            .file-icon::after {
              display: block;
              content: attr(data-type);
              position: absolute;
              bottom: 0;
              left: 0;
              font-size: 10px;
              color: #fff;
              text-transform: lowercase;
              width: 100%;
              padding: 2px;
              white-space: nowrap;
              overflow: hidden;
            }
            /* fileicons */
            .file-icon-xs {
              width: 12px;
              height: 16px;
              border-radius: 2px;
            }
            .file-icon-xs::before {
              border-bottom-left-radius: 1px;
              border-width: 3px;
            }
            .file-icon-xs::after {
              content: "";
              border-bottom: 2px solid rgba(255,255,255,.45);
              width: auto;
              left: 2px;
              right: 2px;
              bottom: 3px;
            }
            .file-icon-sm {
              width: 18px;
              height: 24px;
              border-radius: 2px;
            }
            .file-icon-sm::before {
              border-bottom-left-radius: 2px;
              border-width: 4px;
            }
            .file-icon-sm::after {
              font-size: 7px;
              padding: 2px;
            }

            .file-icon-lg {
              width: 72px;
              height: 96px;
              border-radius: 4px;
            }
            .file-icon-lg::before {
              border-bottom-left-radius: 3px;
              border-width: 12px;
            }
            .file-icon-lg::after {
              font-size: 24px;
              padding: 4px 8px;
            }

            .file-icon-xl {
              width: 96px;
              height: 128px;
              border-radius: 4px;
            }
            .file-icon-xl::before {
              border-bottom-left-radius: 4px;
              border-width: 16px;
            }
            .file-icon-xl::after {
              font-size: 24px;
              padding: 4px 10px;
            }
            /* fileicon.types */
            .file-icon[data-type=zip],
            .file-icon[data-type=rar] {
              background: #ACACAC;
            }
            .file-icon[data-type^=doc] {
              background: #307CF1;
            }
            .file-icon[data-type^=xls] {
              background: #0F9D58;
            }
            .file-icon[data-type^=ppt] {
              background: #D24726;
            }
            .file-icon[data-type=pdf] {
              background: #E13D34;
            }
            .file-icon[data-type=txt] {
              background: #5EB533;
            }
            .file-icon[data-type=mp3],
            .file-icon[data-type=wma],
            .file-icon[data-type=m4a],
            .file-icon[data-type=flac] {
              background: #8E44AD;
            }
            .file-icon[data-type=mp4],
            .file-icon[data-type=wmv],
            .file-icon[data-type=mov],
            .file-icon[data-type=avi],
            .file-icon[data-type=mkv] {
              background: #7A3CE7;
            }
            .file-icon[data-type=bmp],
            .file-icon[data-type=jpg],
            .file-icon[data-type=jpeg],
            .file-icon[data-type=gif],
            .file-icon[data-type=png] {
              background: #F4B400;
            }
        </style>
    </head>

    <body>

<div class="folder">content</div>

<div style="display: table; margin: 20px;" align="center">
    <span style="display: table-row"><div class="file-icon file-icon-lg" data-type="bmp"></div></span>
    <span style="display: table-row">filename.bmp</span>
</div>
    </body>
</html>
