var link_prefix = '/';
var link_to_utility_language_change = 'utility_language_change.php';
var link_to_admin_ajax_interceptor = 'admin_ajax_interceptor.php';

var window_bottom_called = false;

var records_on_page = 6;

function ColAllTypes(width)
{
	return 'col-xs-' + width + ' col-sm-' + width + ' col-md-' + width + ' col-lg-' + width;
}

function ToPageHeader(text, header_type, color, font_weight)
{
	return '<font color="' + color + '"><' + header_type + ' style="margin: 10px; font-weight: ' + font_weight + '">' + text + '</' + header_type + '></font>';
}

function elem(id)
{
	return document.getElementById(id);
}

function deleteChilds(ob)
{
	while (ob.firstChild) {
	    ob.removeChild(ob.firstChild);
	}
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

function LoadWaiter()
{
	var loadingMain = document.createElement('div');
	loadingMain.style.marginBottom = "40px";
	loadingMain.id = 'loadingMain';
	var cssload_container = document.createElement('div');
	cssload_container.className = 'cssload-container';
	var cssload_wheel = document.createElement('div');
	cssload_wheel.className = 'cssload-speeding-wheel';
	loadingMain.appendChild(cssload_container);
	loadingMain.appendChild(cssload_wheel);
	return loadingMain;
}

function turnPagination() {
	var tmp = elem("pagination_row");
	tmp.style.display = (tmp.style.display == 'none') ? 'block' : 'none';
}
