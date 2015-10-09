var server = null;

var window_bottom_callbacks = [
]

function changeLanguage(lang) {
	var data = 'lang=' + lang;
	server = getXmlHttp();
    server.open("POST", link_prefix + link_to_utility_language_change, true);
    server.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    server.onreadystatechange = refreshPage;
    server.send(data);
}

function hideUsers() {
	var ulist = elem("users_list");
	ulist.style.display = 'none';
}

function hideElem(ob) {
	ob.style.display = 'none';
}

function chooseUser(link) {
	elem("recipient_id").value = link.getAttribute("id");
	elem("recipient_input").value = link.innerHTML;
	hideUsers();
}

function showUsersList() {
	if (server.readyState == 4) {
		var ulist = elem("users_list");
		ulist.style.display = 'block';
		var users = JSON.parse(server.responseText);
		deleteChilds(ulist);
		if (users.length == 0) {
			hideUsers();
			return;
		}
		for (var i = 0; i < users.length; ++i) {
			var link = document.createElement('li');
			link.innerHTML = '<a onclick="chooseUser(this);" id="' + users[i].id + '">' + users[i].name + ' ' + users[i].surname + '</a>';
			ulist.appendChild(link);
		}
	}
}

function appendGlobalResults(ulist, json_res, list_name, extraction_f)
{
	var oblist = json_res[list_name];
	if (typeof oblist == 'string') oblist = JSON.parse(oblist);
	if (oblist.length > 0) {
		var header = document.createElement('li');
		header.className = 'dropdown-header';
		header.textContent = json_res[list_name + '_name'];
		ulist.appendChild(header);
		for (var i = 0; i < oblist.length; ++i) {
			var link = document.createElement('li');
			link.innerHTML = oblist[i].link_to_full;
			ulist.appendChild(link);
		}
		var divider = document.createElement('li');
		divider.className = 'divider';
		ulist.appendChild(divider);
	}
}

function loadGlobalResults(local_server) {
	if (local_server.readyState == 4) {
		//alert(local_server.responseText);
		var ulist = elem("glob_search_list");
		ulist.style.display = 'block';
		var res = JSON.parse(local_server.responseText);
		deleteChilds(ulist);
		if (res.length == 0) {
			hideElem(elem("glob_search_list"));
			return;
		}
		if (res.hasOwnProperty('users')) {
			appendGlobalResults(ulist, res, 'users', function(ob) { return ob.name + ' ' + ob.surname; });
		}
		if (res.hasOwnProperty('articles')) {
			appendGlobalResults(ulist, res, 'articles', function(ob) { return ob.name; });
		}
		if (res.hasOwnProperty('directions')) {
			appendGlobalResults(ulist, res, 'directions', function(ob) { return ob.name; });
		}
		if (res.hasOwnProperty('projects')) {
			appendGlobalResults(ulist, res, 'projects', function(ob) { return ob.name; });
		}
	}
}

function showUsers(input) {
	elem("recipient_id").value = '';
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

function hideGlobSearch() {
	var glob_list = elem("glob_search_list");
	glob_list.style.display = "none";
}

function showGlobalSearch(glob_input) {
	if (glob_input.value == '') {
		hideGlobSearch();
		return;
	}
	var s_text = glob_input.value;
	var local_server = getXmlHttp();
	var data = 'search=global&text=' + s_text;
	local_server.open("POST", link_prefix + link_to_admin_ajax_interceptor, true);
	local_server.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
	local_server.onreadystatechange = function() { loadGlobalResults(local_server); };
	local_server.send(data);
}

$(window).load(function(){
    $(window).scroll(function() {   
        if($(window).scrollTop() + $(window).height() == $(document).height()) {
            for (var i = 0; i < window_bottom_callbacks.length; ++i) {
            	window_bottom_callbacks[i]();
            }
            window_bottom_called = true;
        }
    });
});