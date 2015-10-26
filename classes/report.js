function hideUsers() {
	var ulist = elem("users_list");
	ulist.style.display = 'none';
}

function removeRecipient(id) {
	var div = elem("recip_" + id);
	div.parentNode.removeChild(div);

	var ids = elem("recipient_ids");
	var decode = decodeURIComponent(ids.value);
	if (decode.length == 0) decode = "[]";
	var cur = JSON.parse(decode);
	var new_cur = [];
	for (i = 0; i < cur.length; ++i) {
		if (cur[i] != id) new_cur.push(cur[i]);
	}
	cur = JSON.stringify(new_cur);
	ids.value = encodeURIComponent(cur);
}

function chooseUser(link) {
	var div_recipients = elem("recipients");
	var new_div = document.createElement('div');
	new_div.style.display = "block";
	new_div.className = "label label-lgmis margin-sm";
	var id = link.getAttribute("id");
	new_div.setAttribute('id', 'recip_' + id);
	new_div.innerHTML = link.innerHTML + '<a onclick="removeRecipient(' + id + ');"><span style="float: right" class="glyphicon glyphicon-remove" aria-hidden="true"></span></a>';
	link.innerHTML = '';
	div_recipients.appendChild(new_div);
	elem("recipient_input").value = '';
	hideUsers();

	var ids = elem("recipient_ids");
	var decode = decodeURIComponent(ids.value);
	if (decode.length == 0) decode = "[]";
	var cur = JSON.parse(decode);
	cur.push(id);
	cur = JSON.stringify(cur);
	ids.value = encodeURIComponent(cur);
}

function showUsersList() {
	if (server.readyState == 4) {
		var cur_recs = elem("recipient_ids");
		cur_recs = decodeURIComponent(cur_recs.value);
		if (cur_recs.length == 0) cur_recs = "[]";
		cur_recs = JSON.parse(cur_recs);

		var ulist = elem("users_list");
		ulist.style.display = 'block';
		var users = JSON.parse(server.responseText);
		deleteChilds(ulist);
		if (users.length == 0) {
			hideUsers();
			return;
		}
		for (var i = 0; i < users.length; ++i) {
			if ((cur_recs.indexOf(users[i].id) != -1) || (cur_recs.indexOf(users[i].id + "") != -1)) {
				continue;
			}
			var link = document.createElement('li');
			link.innerHTML = '<a onclick="chooseUser(this);" id="' + users[i].id + '">' + users[i].name + ' ' + users[i].surname + '</a>';
			ulist.appendChild(link);
		}
	}
}

function showUsers(input) {
	if (input.value == '') {
		hideUsers();
		return;
	}
	var prefix = input.value;
	server = getXmlHttp();
	var data = 'load_users=true&prefix=' + prefix;
	server.open("POST", link_prefix + link_to_admin_ajax_interceptor, true);
	server.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
	server.onreadystatechange = showUsersList;
	server.send(data);
}