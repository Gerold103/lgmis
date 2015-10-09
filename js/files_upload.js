var files_uploaded = 0;
var files_type = '';
var author_id = -1;
var max_files = 15;

function removeUploadedFile(btn) {
	var id = btn.id.split('-')[1];
	var row = elem("filerow" + id);
	row.parentElement.removeChild(row);
	var data = "remove=true&file=true&type=" + files_type + "&fileid=" + id;
	var local_server = getXmlHttp();
	local_server.open("POST", link_prefix + link_to_admin_ajax_interceptor);
	local_server.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
	local_server.send(data);
}

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
        	if (files_uploaded > 0) {
        		alert('Already maximal count of files');
        		return;
        	}
            if (files[i].size > max_file_size) {
                alert('File with name ' + files[i].name + ' has too large size');
                return;
            }
            var local_server = getXmlHttp();
            local_server.upload.addEventListener('progress', (function(id, file) {
                return function(event) {
                    var percent = parseInt(event.loaded / event.total * 100);
                    if (elem('file' + id) != null) {
                    	elem('file' + id).setAttribute('aria-valuenow', percent);
                    	elem('file' + id).style.width = percent + '%';
                    }
                };
            })(files_uploaded, files[i]), false);
            local_server.onreadystatechange = (function(id, file) {
                return function(event) {
                    if (event.target.readyState == 4) {
                        if (event.target.status == 200) {
                        } else {
                            console.log('Произошла ' + file.name + ' ошибка!');
                        }
                    }
                };
            })(files_uploaded, files[i]);
            local_server.open("POST", link_prefix + link_to_admin_ajax_interceptor);
            local_server.setRequestHeader('x-filename', encodeURIComponent(files[i].name));
            var fd = new FormData();
            fd.append("file", files[i]);
            fd.append("type", files_type);
            fd.append("upload", true);
            var progress = document.createElement('li');
	        progress.innerHTML = '<div id="filerow' + files_uploaded + '" class="row">' +
	            '<div class="' + ColAllTypes(8) + ' vcenter">' +
	                '<div class="progress" style="margin: 0;">' +
	                    '<div id="file' + files_uploaded + '" class="progress-bar progress-bar-info progress-bar-striped" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width: 0%"></div>' +
	                '</div>' +
	            '</div>' +
	            '<div class="' + ColAllTypes(4) + ' vcenter">' +
	                '<button type="button" id="btnfile-' + files_uploaded + '" onclick="removeUploadedFile(this);" class="btn btn-default btn-sm"><span class="glyphicon glyphicon-remove" aria-hidden="true"></span></button>' +
	            '</div>' +
	        '</div>';
	        elem('progress_bars').appendChild(progress);
            local_server.send(fd);
            files_uploaded++;
        };
    };
});