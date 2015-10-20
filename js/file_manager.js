var cur_directory = [link_to_files_manager_dir];
optional_data = cur_directory;

var files_per_row = 4;
var cols_per_col = 3;
var cur_files = [];

function turnOffLoader() {
	var loader = elem("file_backdrop_area");
	loader.className = "";
	deleteChilds(loader);
}

function turnOnLoader() {
	var loader = elem("file_backdrop_area");
	loader.className = "file-backdrop in";
	deleteChilds(loader);
	waiter = LoadWaiter();
	waiter.style.opacity = "1";
	color = findChildWithClass(waiter, "cssload-speeding-wheel");
	color.className = "cssload-speeding-wheel-white";
	waiter.style.position = "absolute";
	waiter.style.top = "40%";
	waiter.style.width = "100%";
	waiter.setAttribute('align', 'center');
	loader.appendChild(waiter);
}

function refresh_manager(local_server) {
	turnOnLoader();
	if (local_server == null) {
		local_server = getXmlHttp();
		getListOfFiles();
	} else {
		if (local_server.readyState == 4) {
			console.log(local_server.responseText);
		}
	}
}

function create_folder() {
	$('#folder_create').modal('show');
}

function do_create_folder() {
	var folder = elem("folder_create");
	var tmp = findChildWithClass(folder, "modal-body");
	if (tmp == null) {
		alert("Not found modal-body");
		return;
	}
	var name = findChildWithName(tmp, "folder_name");
	if (name == null) {
		alert("Not found folder_name");
		return;
	}
	name = name.value;
	tmp = findChildWithName(folder, "folder_permissions");
	if (tmp == null) {
		alert("Not found folder_permissions");
		return;
	}
	var opt_perm = null;
	for (var i = 0; i < tmp.childNodes.length; ++i) {
		if (tmp.childNodes[i].className.indexOf("active") > -1) {
			opt_perm = tmp.childNodes[i].childNodes[0].getAttribute('name');
			break;
		}
	}
	var local_server = getXmlHttp();
	var fd = new FormData();
	fd.append("type", files_type);
	fd.append("save", "folder");
	optional_data = {permissions: opt_perm, cur_directory: cur_directory, folder_name: name};
	fd.append("optional_data", JSON.stringify(optional_data));
	local_server.onreadystatechange = function() { refresh_manager(local_server); };
	local_server.open("POST", link_prefix + link_to_admin_ajax_interceptor);
	local_server.send(fd);
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

var click_timer;
var click_status = 1;

function goDownDir(name) {
	clearTimeout(click_timer);
	click_status = 0;
	cur_directory.push(name);
	console.log(cur_directory);
	refresh_manager(null);
}

function goUpDir(num) {
	clearTimeout(click_timer);
	click_status = 0;
	cur_directory = cur_directory.slice(0, num + 1);
	console.log(cur_directory);
	refresh_manager(null);
}

function show_actions_for(id) {
	click_status = 1;
	click_timer = setTimeout(function() {
		if (click_status == 1) {
			var file = cur_files[id];
			var modal = elem('file_actions');
			var body = null;
			var tmp = findChildWithClass(modal, "modal-dialog");
			if (tmp == null) {
				alert("not found modal-dialog");
				return;
			}
			tmp = findChildWithClass(tmp, "modal-content");
			if (tmp == null) {
				alert("not found modal-content");
				return;
			}
			body = findChildWithClass(tmp, "modal-body");
			if (body == null) {
				alert("Not found modal-body");
				return;
			}
			tmp = findChildWithClass(tmp, "modal-header");
			if (tmp == null) {
				alert("Not found modal-header");
				return;
			}
			var header = findChildWithName(tmp, 'file_name');
			if (header == null) {
				alert("Not found modal-header: file_name");
				return;
			}
			header.innerHTML = customDecodeURIComponent(file.name);
			deleteChilds(body);
			var actions = document.createElement('div');
			actions.className = "row";
			var col1 = document.createElement('div');
			col1.className = ColAllTypes(12);
			col1.innerHTML = file.link_to_download;
			actions.appendChild(col1);
			body.appendChild(actions);
			$('#file_actions').modal('show');
		}
	}, 250);
}

function createFileElement(id) {
	var file = cur_files[id];
	var res = document.createElement('div');
	res.style.display = "table";
	res.style.margin = "20px";
	res.setAttribute('align', 'center');
	var first = document.createElement('span');
	var second = document.createElement('span');
	first.style.display = "table-row";
	second.style.display = "table-row";
	second.style.textAlign = "center";
	second.innerHTML = customDecodeURIComponent(file.name).substring(0, 20);
	var icon_container = document.createElement('div');
	var icon = document.createElement('div');
	if (file.is_directory != 0) {
		icon.className = "folder";
		icon_container.className = 'folder_container';
		var to_go = cur_directory.slice();
		to_go.push(file.name);
		icon_container.setAttribute('ondblclick', 'goDownDir(\'' + file.name + '\');');
	} else {
		icon.className = "file-icon file-icon-lg";
		icon.setAttribute('data-type', file.file_type);
	}
	icon_container.appendChild(icon);
	icon_container.setAttribute('onclick', "show_actions_for(" + id + ");");
	first.appendChild(icon_container);
	res.appendChild(first);
	res.appendChild(second);
	return res;
}

function showListOfFiles(local_server) {
	if (local_server.readyState == 4) {
		turnOffLoader();
		console.log(local_server.responseText);
		var files = JSON.parse(local_server.responseText);
		cur_files = files;
		var rows_cnt = Math.ceil(files.length / files_per_row);
		console.log(rows_cnt);
		var files_place = elem("files_place");
		deleteChilds(files_place);
		for (var i = 0; i < rows_cnt; ++i) {
			var row = document.createElement('div');
			row.className = "row";
			var f_from = i * files_per_row;
			var f_to = Math.min((i + 1) * files_per_row, files.length);
			for (var j = f_from; j < f_to; ++j) {
				var child = createFileElement(j);
				var col = document.createElement('div');
				col.className = ColAllTypes(cols_per_col);
				col.appendChild(child);
				row.appendChild(col);
			}
			files_place.appendChild(row);
			files_place.appendChild(document.createElement('br'));
			files_place.appendChild(document.createElement('br'));
		}

		var current_manager_path = elem("current_manager_path");
		deleteChilds(current_manager_path);
		for (i = 0; i < cur_directory.length; ++i) {
			var li = document.createElement('li');
			var a = document.createElement('a');
			a.setAttribute('href', '#');
			a.setAttribute('onclick', 'goUpDir(' + i + ');');
			if (i == 0) a.innerHTML = 'Home';
			else a.innerHTML = customDecodeURIComponent(cur_directory[i]);
			li.appendChild(a);
			current_manager_path.appendChild(li);
		}
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
	getListOfFiles();
});