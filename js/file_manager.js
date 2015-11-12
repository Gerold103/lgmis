var cur_directory = [link_to_files_manager_dir];
optional_data = cur_directory;

var files_per_row = 4;
var cols_per_col = 3;
var cur_files = [];

var file_permissions = {0: 'for_registered', 15: 'for_employees'};
var file_permissions_reverse = {'for_registered': 0, 'for_employees': 15};

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
			var answer;
			try {
				answer = JSON.parse(local_server.responseText);
				console.log(answer);
			} catch(err) {
				alert("Error while parsnig answer from server");
				turnOffLoader();
				return;
			}
			if (answer.hasOwnProperty('error')) {
				alert("Error occured: " + answer.error);
				turnOffLoader();
				return;
			}
			deleteChilds(elem("progress_bars"));
			getListOfFiles();
		}
	}
}

function create_folder() {
	$('#folder_create').modal('show');
}

function do_create_folder() {
	$("#folder_create").modal('hide');
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
	$("#myModal").modal('hide');
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

function editFile(file_id) {
	var file = null;
	var i = 0;
	for (i = 0; i < cur_files.length; ++i) {
		if (cur_files[i].id == file_id) {
			file = cur_files[i];
			break;
		}
	}
	if (file == null) {
		alert('No file with id = ' + file_id);
		return;
	}
	$('#file_actions').modal('hide');
	var edit_modal = elem('edit_file');
	var name = findChildWithName(edit_modal, 'file_name');
	if (name == null) {
		alert('No field with name "file_name"');
		return;
	}
	name.value = customDecodeURIComponent(file.name);
	var tmp = findChildWithName(edit_modal, 'file_permissions');
	if (tmp == null) {
		alert('Not found element file_permissions');
		return;
	}
	for (var j = 0; j < tmp.childNodes.length; ++j) {
		tmp.childNodes[j].className = 'btn btn-primary';
	}

	var active_perm = findChildWithName(edit_modal, file_permissions[file.permissions]);
	if (active_perm == null) {
		alert('No field with permissions: ' + file.permissions);
		return;
	}
	active_perm = active_perm.parentNode;
	active_perm.className += ' active';

	var save = findChildWithName(edit_modal, 'save');
	if (save == null) {
		alert('Not found save');
		return;
	}
	save.setAttribute('onclick', 'editSave(' + i + ');');
	$('#edit_file').modal('show');
}

function editSave(file_no) {
	console.log(file_no);
	var file = cur_files[file_no];

	var edit_modal = elem('edit_file');
	var name = findChildWithName(edit_modal, 'file_name');
	if (name == null) {
		alert("Not found file_name input");
		return;
	}
	var perms = findChildWithName(edit_modal, 'file_permissions');
	if (perms == null) {
		alert("Not found file_permissions");
		return;
	}
	var txt_perms = null;
	for (var i = 0; i < perms.childNodes.length; ++i) {
		if (perms.childNodes[i].className.indexOf('active') != -1) {
			txt_perms = perms.childNodes[i].childNodes[0].getAttribute('name');
			break;
		}
	}
	if (txt_perms == null) {
		alert("No active perms");
		return;
	}

	var local_server = getXmlHttp();
	var fd = new FormData();
	fd.append("type", files_type);
	fd.append("edit", file.id);
	fd.append("name", name.value);
	fd.append("permissions", file_permissions_reverse[txt_perms]);
	local_server.onreadystatechange = function() { if (local_server.readyState == 4) { console.log(local_server.responseText); refresh_manager(null); } };
	local_server.open("POST", link_prefix + link_to_admin_ajax_interceptor);
	local_server.send(fd);
	$('#edit_file').modal('hide');
}

function deleteFile(file_id) {
	$("#file_actions").modal('hide');
	console.log(file_id);
	var local_server = getXmlHttp();
	var fd = new FormData();
	fd.append("type", files_type);
	fd.append("remove", file_id);
	fd.append("file", true);
	fd.append("files_action", "del");
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
			col1.className = ColAllTypes(4);
			col1.innerHTML = file.link_to_download;
			var col2 = document.createElement('div');
			col2.className = ColAllTypes(4);
			col2.innerHTML = file.link_to_edit;
			var col3 = document.createElement('div');
			col3.className = ColAllTypes(4);
			col3.innerHTML = file.link_to_delete;
			actions.appendChild(col1);
			actions.appendChild(col2);
			actions.appendChild(col3);
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
	if (customDecodeURIComponent(file.name).length != second.innerHTML.length) second.innerHTML += '...';
	second.setAttribute('data-toggle', 'tooltip');
	second.setAttribute('data-placement', 'bottom');
	second.setAttribute('title', customDecodeURIComponent(file.name));
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
		icon.setAttribute('file-type', file.file_type);
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
		$(function () {
            $('[data-toggle="tooltip"]').tooltip()
        });
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