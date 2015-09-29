var server = null;

var window_bottom_callbacks = [
	Article.WindowBottomCallback
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