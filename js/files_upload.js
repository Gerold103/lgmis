var files_uploaded = 0;
var files_id_iterator = 0;
var files_type = '';
var author_id = -1;
var max_files = 15;
var files_action = '';
var owner_id = -1;
var optional_data = null;

function removeUploadedFile(btn) {
	var id = btn.id.split('-')[1];
	var row = elem("filerow" + id);
	row.parentElement.removeChild(row);
    var name = elem("btnfilename-" + id).value;
	var data = "remove=true&file=true&type=" + files_type + "&fileid=" + id + "&files_action=" + files_action + "&owner_id=" + owner_id + "&author_id=" + author_id + "&filename=" + name;
	var local_server = getXmlHttp();
	local_server.open("POST", link_prefix + link_to_admin_ajax_interceptor);
	local_server.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
	local_server.send(data);
	--files_uploaded;
	if (files_uploaded == 0) {
		$("#files_area").removeClass('files_area_drop');
        if (elem("files_area_background_text") != null) {
            elem("files_area_background_text").style.display = "block";
        }
	}
    elem("files_count").setAttribute('value', files_uploaded);
}

function send_files(files_list) {
	var files_area = $("#files_area");
	function MyEvent() {
		this.preventDefault = function() { };
		function Files_() { this.files = files_list; }
		this.dataTransfer = new Files_();
	}
	files_area[0].ondrop(new MyEvent());
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
        if (elem("files_area_background_text") != null) {
            elem("files_area_background_text").style.display = "none";
        }

        var files = event.dataTransfer.files;
        for (var i = files.length - 1; i >= 0; --i) {
        	if (files_uploaded >= max_files) {
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
            })(files_id_iterator, files[i]), false);
            local_server.upload.addEventListener('load', (function(id) {
            	return function(event) {
            		$("#file" + id).removeClass("progress-bar-info");
            		$("#file" + id).addClass("progress-bar-success");

            	}
            })(files_id_iterator), false);
            local_server.onreadystatechange = (function(id, file, serv) {
                return function(event) {
                    if (event.target.readyState == 4) {
                        if (event.target.status == 200) {
                            console.log(serv.responseText);
                        } else {
                            console.log('Произошла ' + file.name + ' ошибка!');
                        }
                    }
                };
            })(files_id_iterator, files[i], local_server);
            local_server.open("POST", link_prefix + link_to_admin_ajax_interceptor);
            local_server.setRequestHeader('x-filename', encodeURIComponent(files[i].name));
            var fd = new FormData();
            fd.append("file", files[i]);
            fd.append("type", files_type);
            fd.append("upload", true);
            fd.append("files_action", files_action);
            fd.append("owner_id", owner_id);
            if (optional_data != null) fd.append("optional_data", JSON.stringify(optional_data));
            var progress = document.createElement('li');
	        progress.innerHTML = '<div id="filerow' + files_id_iterator + '" class="row">' +
	            '<div class="' + ColAllTypes(9) + ' vcenter" style="padding: 0px;">' +
	                '<div class="progress" style="margin: 0;">' +
	                    '<div id="file' + files_id_iterator + '" class="progress-bar progress-bar-info progress-bar-striped" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width: 0%"></div>' +
	                '</div>' +
	            '</div>' +
	            '<div class="' + ColAllTypes(3) + ' vcenter">' +
	                '<button type="button" id="btnfile-' + files_id_iterator + '" onclick="removeUploadedFile(this);" class="btn btn-default btn-sm"><span class="glyphicon glyphicon-remove" aria-hidden="true">' + files[i].name.substring(0, 15) + '</span></button>' +
                    '<input type="hidden" id="btnfilename-' + files_id_iterator + '" value="' + encodeURIComponent(files[i].name) + '">' +
                '</div>' +
	        '</div>';
            progress.style.margin = "15px";
	        elem('progress_bars').appendChild(progress);
            local_server.send(fd);
            files_uploaded++;
            files_id_iterator++;
            elem("files_count").setAttribute('value', files_uploaded);
        };
    };
});