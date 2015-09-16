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