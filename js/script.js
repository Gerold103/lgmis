function elem(id)
{
	return document.getElementById(id);
}

function checkLoginField(field) {
	return /^[\w]+$/.test(field.value); 
}

function checkEmailField(field) {
	var re = /^([\w-]+(?:\.[\w-]+)*)@((?:[\w-]+\.)*\w[\w-]{0,66})\.([a-z]{2,6}(?:\.[a-z]{2})?)$/i;
	return re.test(field.value);
}

function checkPhoneField(field) {
	var re = /^[\d-]+$/;
	return re.test(field.value);
}

var server = null;

function getXmlHttp(){
	var xmlhttp;
	try {
		xmlhttp = new ActiveXObject("Msxml2.XMLHTTP");
	} catch (e) {
		try {
			xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
		} catch (E) {
			xmlhttp = false;
		}
	}
	if (!xmlhttp && typeof XMLHttpRequest!='undefined') {
		xmlhttp = new XMLHttpRequest();
	}
	return xmlhttp;
}

function refreshPage()
{
	if (server.readyState == 4) {
		location.reload();
	}
}

function changeLanguage(lang) {
	var data = 'lang=' + lang;
	server = getXmlHttp();
    server.open("POST", link_prefix + link_to_utility_language_change, true);
    server.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    server.onreadystatechange = refreshPage;
    server.send(data);
}

function showUsersList() {
	if (server.readyState == 4) {
		var ulist = elem("users_list");
		ulist.style.display = 'block';
		var users = JSON.parse(server.responseText);
		
	}
}

function hideUsers() {
	var ulist = elem("users_list");
	ulist.style.display = 'none';
}

function showUsers(input) {
	var prefix = input.value;
	server = getXmlHttp();
	var data = 'load_users=true&prefix=' + prefix;
	server.open("POST", link_prefix + link_to_admin_ajax_interceptor, true);
	server.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
	server.onreadystatechange = showUsersList;
	server.send(data);
}