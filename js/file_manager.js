var cur_directory = [link_to_files_manager_dir];
optional_data = cur_directory;

function refresh_manager(local_server) {
	if (local_server.readyState == 4) {
		console.log(local_server.responseText);
	}
}

function saveFiles() {
	if (files_uploaded < 1) { alert("No files to uploading"); return; }
	var perms = elem("options_permissions");
	var opt_perm = null;
	for (var i = 0; i < perms.childNodes.length; ++i) {
		if (perms.childNodes[i].className.indexOf("active") > -1) {
			opt_perm = perms.childNodes[i].childNodes[0].id;
			break;
		}
	}
	optional_data = {permissions: opt_perm, cur_directory: cur_directory};
	var fd = new FormData();
    fd.append("type", files_type);
    fd.append("save", true);
    if (optional_data != null) {
    	fd.append("optional_data", JSON.stringify(optional_data));
    }
    var local_server = getXmlHttp();
    local_server.onreadystatechange = function() { refresh_manager(local_server); };
    local_server.open("POST", link_prefix + link_to_admin_ajax_interceptor);
    local_server.send(fd);
}

function goToDir(link) {
	
}

function showListOfFiles(local_server) {
	if (local_server.readyState == 4) {
		console.log(local_server.responseText);
	}
}

function getListOfFiles() {
	optional_data = {cur_directory: cur_directory};
	var fd = new FormData();
	fd.append("type", files_type);
	fd.append("download", "info");
	if (optional_data != null) {
		fd.append("optional_data", JSON.stringify(optional_data));
	}
	var local_server = getXmlHttp();
	local_server.onreadystatechange = function() { showListOfFiles(local_server); };
	local_server.open("POST", link_prefix + link_to_admin_ajax_interceptor);
	local_server.send(fd);
}

$(document).ready(function() {

});