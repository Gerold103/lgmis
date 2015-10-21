function Article() {
	this.id = -1;
	this.author_link = '';
	this.full_vers_link = '';
	this.name = '';
	this.annotation = '';
	this.creating_date = '';
	this.path_to_image = '';
}

Article.type = 'article';
Article.all_loaded = false;

Article.WindowBottomCallback = function() {
	if ((elem('loadingMain') != null) || Article.all_loaded) return;
	var childs = $("#articles_list").children(".pbl_article").length;
	var local_server = getXmlHttp();
	var data = "download=more&type=" + Article.type + "&offset=" + childs;

	local_server.open("POST", link_prefix + link_to_admin_ajax_interceptor, true);
	local_server.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
	local_server.onreadystatechange = function() { Article.AppendToBottom(local_server); }
	local_server.send(data);
	if (Article.all_loaded == false) if (elem('loadingMain') == null) elem('articles_list').appendChild(LoadWaiter());
}

Article.AppendToBottom = function(local_server) {
	if (local_server.readyState == 4) {
		$('#loadingMain').remove();
		var objs = JSON.parse(local_server.responseText);
		var objs_list = elem("articles_list");
		if (objs.length < records_on_page) Article.all_loaded = true;
		for (var i = 0; i < objs.length; ++i) {
			var cur_ob = document.createElement('div');
			cur_ob.className = 'pbl_article';
			var innerHTML = '';

			var ob = new Article();
			ob.id = objs[i].id;
			ob.author_link = objs[i].author_link;
			ob.full_vers_link = objs[i].full_vers_link;
			ob.name = objs[i].name;
			ob.annotation = objs[i].annotation;
			ob.creating_date = objs[i].creating_date;
			ob.path_to_image = objs[i].path_to_image;

			innerHTML += '<hr><div style="background-color: #eeeeee;"><br></div><hr>';
			innerHTML += ob.ToHTMLUserPublicShortInTable();
			cur_ob.innerHTML = innerHTML;
			objs_list.appendChild(cur_ob);
		}
	}
}

Article.prototype.GetID = function() { return this.id; };

Article.prototype.GetAuthorLink = function() { return this.author_link; };

Article.prototype.GetCreatingDateStr = function() {
	var date = new Date(this.creating_date * 1000);
	var hours = date.getHours();
	var minutes = date.getMinutes();
	var year = date.getFullYear();
	var month = date.getMonth() + 1;
	var day = date.getDate();
	if (day < 10) day = "0" + day;
	if (month < 10) month = "0" + month;
	if (minutes < 10) minutes = "0" + minutes;
	if (hours < 10) hours = "0" + hours;
	return day + " : " + month + " : " + year + " - " + hours + " : " + minutes;
};

Article.prototype.ToHTMLUserPublicShortInTable = function() {
	var res = '';
	res += '<div class="row" style="color: grey;">';
	res += 	'<div class="' + ColAllTypes(4) + '" style="padding-right: 0px;">';
	res += 		'<img class="img-article-cover" src="' + link_prefix + this.path_to_image + '">';
	res += 	'</div>';
	res += 	'<div class="' + ColAllTypes(8) + '">';
	res += 		'<div class="row">';
	res += 		'<div class="' + ColAllTypes(12) + '">';
	res += 			ToPageHeader(this.name, 'h5', 'grey', 'normal');
	res += 		'</div>';
	res += 		'</div>';

	res += 		'<hr>';

	res += 		'<div class="row" align="left">';
	res += 		'<div class="' + ColAllTypes(12) + '">';
	res += 			this.annotation;
	res += 		'</div>';
	res += 		'</div>';
	res += 	'</div>';
	res += '</div>';

	res += '<div class="row"><div class="' + ColAllTypes(12) + '"><hr></div></div>';
	res += '<div class="row" style="font-size: 11px">';
	res += 	'<div class="' + ColAllTypes(4) + '">';
	res += 		this.GetCreatingDateStr();
	res += 	'</div>';
	res += 	'<div class="' + ColAllTypes(4) + '" align="left">';
	res += 		'<font color="black">Автор:</font> ' + this.author_link;
	res += 	'</div>';
	res += 	'<div class="' + ColAllTypes(4) + '" align="right" style="padding-right: 30px;">';
	res += 		this.full_vers_link;
	res += 	'</div>';
	res += '</div>';
	return res;
};