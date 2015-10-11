<?php
	//------------------------------------------------A R T I C L E------------------------------------------------
	
	class Article implements IMultiLanguage {
		
		//--------Attributes--------
		
		private $id            = id_undef;
		private $author_id     = id_undef;
		public  $name          = undef;
		public  $annotation    = undef;
		public  $text_block    = undef;
		private $creating_date = time_undef;

		public  $path_to_image = undef;
		public 	$language = undef;
		
		public static $type = 'article';
		public static $table = 'articles';

		public function GetCreatingDateStr()
		{
			return date('d : m : Y - H : i', $this->creating_date);
		}

		public function GetAuthorID()
		{
			return $this->author_id;
		}

		public function GetID()
		{
			return $this->id;
		}

		public function GetName()
		{
			return $this->name;
		}

		public static function GetMaximalID()
		{
			global $languages;
			global $db_connection;
			$max_id = 0;
			foreach ($languages as $key => $value) {
				$from_table = self::$table;
				if ($key !== 'rus') $from_table .= '_'.$key;
				$res = $db_connection->query("SELECT MAX(id) FROM ".$from_table);
				if (!$res) {
					echo $db_connection->error;
					return Error::db_error;
				}
				$row = $res->fetch_row();
				$max_id = max($max_id, $row[0]);
			}
			return $max_id;
		}
		
		//---------------- IHTMLAuto implementation ----------------

		public function ToHTMLAutoFull($user_privileges)
		{
			switch ($user_privileges) {
				case admin_user_id: case simple_user_id:
					return $this->ToHTMLPrivateFull();
				case unauthorized_user_id:
					return $this->ToHTMLUserPublicFull();
				default:
					return html_undef;
			}
		}

		public function ToHTMLAutoShortForTable($user_privileges)
		{
			switch ($user_privileges) {
				case admin_user_id: case simple_user_id:
					return $this->ToHTMLUserPrivateShortInTable();
				case unauthorized_user_id:
					return $this->ToHTMLUserPublicShortInTable();
				default:
					return html_undef;
			}
		}

		public function ToHTMLPrivateFull()
		{
			$res = '';

			$res .= '<div class="form-horizontal">';

			$res .= 	'<div class="row">';
			$res .= 		'<label class="'.ColAllTypes(3).' vcenter control-label">'.Language::Word('creating date').'</label>';
			$res .= 		'<div class="'.ColAllTypes(5).' vcenter">';
			$res .= 			SimplePanel(date('d : m : Y - H : i', $this->creating_date));
			$res .= 		'</div>';
			$res .= 	'</div>';

			$res .= 	'<div class="row">';
			$res .= 		'<label class="'.ColAllTypes(3).' vcenter control-label">'.Language::Word('author').'</label>';
			$res .= 		'<div class="'.ColAllTypes(5).' vcenter">';
			$res .= 			SimplePanel(User::FetchByID($this->author_id)->LinkToThis());
			$res .= 		'</div>';
			$res .= 	'</div>';

			$res .= 	'<div class="row">';
			$res .= 		'<label class="'.ColAllTypes(3).' vcenter control-label">'.Language::Word('annotation').'</label>';
			$res .= 		'<div class="'.ColAllTypes(5).' vcenter">';
			$res .= 			SimplePanel(htmlspecialchars($this->annotation));
			$res .= 		'</div>';
			$res .= 	'</div>';

			$res .= 	'<div class="row">';
			$res .= 		'<label class="'.ColAllTypes(3).' vcenter control-label">'.Language::Word('cover').'</label>';
			$res .= 		'<div class="'.ColAllTypes(5).' vcenter">';
			$res .= 			'<img src="'.$this->path_to_image.'" class="img-article-cover">';
			$res .= 		'</div>';
			$res .= 	'</div>';

			$res .= '<hr>';

			$res .= 	'<div class="row" align="center">';
			$res .= 		'<label class="control-label">'.Language::Word('text').'</label>';
			$res .= 	'</div>';
			$res .= 	'<div class="row" align="left">';
			$res .= 		'<div class="'.ColAllTypes(8).' '.ColOffsetAllTypes(2).'">';
			$res .= 			SimplePanel($this->text_block);
			$res .= 		'</div>';
			$res .= 	'</div>';

			$res .= '<div class="row">';
			if ((GetUserLogin() === User::FetchByID($this->author_id)->login) || (GetUserLogin() == 'admin')) {
				$res .= 	'<div class="'.ColAllTypes(4).'" align="right">';
				$res .=			'<div class="margin-sm">'.$this->ToHTMLEdit().'</div>';
				$res .=		'</div>';
				$res .= 	'<div class="'.ColAllTypes(4).'" align="center">';
				$res .=			'<div class="margin-sm">'.$this->ToHTMLDel().'</div>';
				$res .=		'</div>';
				$res .= 	'<div class="'.ColAllTypes(4).'" align="left">';
			} else {
				$res .= 	'<div class="'.ColAllTypes(12).'" align="center">';
			}
			$res .=				'<div class="margin-sm">'.$this->ToHTMLAddLanguage().'</div>';
			$res .=			'</div>';
			$res .= '</div>';

			$res .= '</div>';
			return $res;
		}

		public function ToHTMLUserPublicFull() {
			$res = '';
			$res .= '<br><div class="row" align="center">';
			$res .= 	'<div class="'.ColAllTypes(3).'">'.$this->GetCreatingDateStr().'</div>';
			$res .= 	'<div class="'.ColAllTypes(4).'">'.User::FetchByID($this->GetAuthorID())->LinkToThis().'</div>';
			$res .= '</div>';
			$res .= '<br><hr>';
			$res .= '<div class="row"><div class="'.ColAllTypes(12).'">'.$this->text_block.'</div></div>';
			return $res;
		}

		public function ToHTMLUserPrivateShortInTable()
		{
			$res = '<tr>';
			$res .= '<td>'.htmlspecialchars($this->name).'</td>';
			$res .= '<td>'.User::FetchByID($this->author_id)->LinkToThis().'</td>';
			$res .= '<td>'.date('d : m : Y - H : i', $this->creating_date).'</td>';
			$res .= '<td>';
			$res .=		'<div class="row">';
			$author_login = User::FetchByID($this->author_id)->login;
			if ((GetUserLogin() === $author_login) || (GetUserLogin() === 'admin')) {
				$res .= 	'<div class="'.ColAllTypes(4).'">';
			} else {
				$res .= 	'<div class="'.ColAllTypes(12).'">';
			}
			$res .= 			$this->ToHTMLFullVers();
			$res .=			'</div>';
			if ((GetUserLogin() === $author_login) || (GetUserLogin() === 'admin')) {
				$res .=		'<div class="'.ColAllTypes(4).'">';
				$res .=			$this->ToHTMLEdit();
				$res .=		'</div>';
				$res .=		'<div class="'.ColAllTypes(4).'">';
				$res .=			$this->ToHTMLDel();
				$res .=		'</div>';
			}
			$res .= 	'</div>';
			$res .= '</td>';
			$res .= '</tr>';
			return $res;
		}

		public function ToHTMLUserPublicShortInTable()
		{
			$res = '<div class="row" style="color: grey;">';
			$res .= 	'<div class="'.ColAllTypes(4).'" style="padding-right: 0px;">';
			$res .= 		'<img class="img-article-cover" src="'.Link::Get($this->path_to_image).'">';
			$res .= 	'</div>';
			$res .= 	'<div class="'.ColAllTypes(8).'">';
			$res .= 		'<div class="row">';
			$res .= 		'<div class="'.ColAllTypes(12).'">';
			$res .= 			ToPageHeader($this->name, 'h5', 'grey', 'normal');
			$res .= 		'</div>';
			$res .= 		'</div>';

			$res .= 		'<hr>';

			$res .= 		'<div class="row" align="left">';
			$res .= 		'<div class="'.ColAllTypes(12).'">';
			$res .= 			htmlspecialchars($this->annotation);
			$res .= 		'</div>';
			$res .= 		'</div>';
			$res .= 	'</div>';
			$res .= '</div>';

			$res .= '<div class="row"><div class="'.ColAllTypes(12).'"><hr></div></div>';
			$res .= '<div class="row" style="font-size: 11px">';
			$res .= 	'<div class="'.ColAllTypes(4).'">';
			$res .= 		date('d : m : Y - H : i', $this->creating_date);
			$res .= 	'</div>';
			$res .= 	'<div class="'.ColAllTypes(4).'" align="left">';
			$res .= 		'<font color="black">Автор:</font> '.User::FetchByID($this->author_id)->LinkToThis('btn-sm');
			$res .= 	'</div>';
			$res .= 	'<div class="'.ColAllTypes(4).'" align="right" style="padding-right: 30px;">';
			$res .= 		$this->ToHTMLFullVers();
			$res .= 	'</div>';
			$res .= '</div>';
			return $res;
		}

		//---------------- IMultiLanguage implementation ----------------

		public function ToHTMLAddLanguage()
		{
			global $link_to_admin_article;
			$args = array(
				'action_link' => $link_to_admin_article,
				'action_type' => 'add_lang',
				'obj_type' => Article::$type,
				'id' => $this->id,
				'btn_color' => 'btn-primary',
			);
			return ActionButton($args);
		}

		//---------------- IActions implementation ----------------
		
		public function ToHTMLDel()
		{
			global $link_to_utility_interceptor;
			$args = array(
				'action_link' => $link_to_utility_interceptor,
				'action_type' => 'del',
				'obj_type' => Article::$type,
				'id' => $this->id,
				'info' => Language::Word('are you shure that you want to delete article with header').' '.htmlspecialchars($this->name).'?',
			);
			return ActionButton($args);
		}
		
		public function ToHTMLEdit()
		{
			global $link_to_admin_article;
			$args = array(
				'action_link' => $link_to_admin_article,
				'action_type' => 'edit',
				'obj_type' => Article::$type,
				'id' => $this->id,
			);
			return ActionButton($args);
		}

		public function ToHTMLFullVers($to_public = NULL)
		{
			global $link_to_admin_article;
			global $link_to_public_article;

			global $link_to_admin_manage_content;
			global $content_types_short;
			global $use_mod_rewrite;
			$args = array();
			if ($to_public === NULL) $to_public = IsSessionPublic();
			$mod_rewrite = 0;
			if (isset($use_mod_rewrite) && ($use_mod_rewrite === true)) {
				$mod_rewrite = 1;
			}
			if ($to_public) {
				$args = array(
					'action_link' => $link_to_public_article,
					'action_type' => 'full',
					'obj_type' => Article::$type,
					'id' => $this->id,
					'method' => 'get',
					'mod_rewrite' => $mod_rewrite,
				);
			} else {
				$args = array(
					'action_link' => $link_to_admin_article,
					'action_type' => 'full',
					'obj_type' => Article::$type,
					'id' => $this->id,
					'prev_page' => $link_to_admin_manage_content.'?content_type='.$content_types_short['articles'],
					'method' => 'get',
				);
			}
			return ActionButton($args);
		}

		//---------------- ILinkable implementation ----------------

		public function LinkToThis()
		{
			if (IsSessionPublic()) return Link::Get(Article::$type).'/'.$this->id;
			else return Link::Get('private_'.Article::$type).'/'.$this->id;
		}

		public static function LinkToThisUnsafe($id, $name, $link_size = 'btn-md', $kwargs = array())
		{
			global $link_to_admin_article;
			global $link_to_public_article;

			global $use_mod_rewrite;
			$args = array();
			$mod_rewrite = 0;
			if (isset($use_mod_rewrite) && ($use_mod_rewrite === true)) {
				$mod_rewrite = 1;
			}
			if (IsSessionPublic() === true) {
				$args = array(
					'action_link' => $link_to_public_article,
					'action_type' => 'full',
					'obj_type' => self::$type,
					'id' => $id,
					'lnk_text' => $name,
					'lnk_size' => $link_size,
					'method' => 'get',
					'mod_rewrite' => $mod_rewrite,
				);
			} else {
				$args = array(
					'action_link' => $link_to_admin_article,
					'action_type' => 'full',
					'obj_type' => self::$type,
					'id' => $id,
					'lnk_text' => $name,
					'lnk_size' => $link_size,
					'method' => 'get',
				);
			}
			extract($kwargs, EXTR_PREFIX_ALL, 't');
			if (isset($t_style)) $args['style'] = $t_style;
			return ActionLink($args);
		}

		//---------------- IFetches implementation ----------------

		public static function FetchFromAssoc($assoc)
		{
			global $link_to_article_images;
			global $link_to_service_images;

			$ob = new self();
			if (ArrayElemIsValidStr($assoc, 'id')) 			$ob->id = $assoc['id'];
			if (ArrayElemIsValidStr($assoc, 'author_id')) 	$ob->author_id = $assoc['author_id'];
			if (ArrayElemIsValidStr($assoc, 'name')) 		$ob->name = $assoc['name'];
			if (ArrayElemIsValidStr($assoc, 'annotation')) 	$ob->annotation = $assoc['annotation'];
			if (ArrayElemIsValidStr($assoc, 'text_block')) 	$ob->text_block = $assoc['text_block'];
			try {
				if (ArrayElemIsValidStr($assoc, 'creating_date')) $ob->creating_date = strtotime($assoc['creating_date']);
			} catch(Exception $e) {
				$ob->creating_date = $assoc['creating_date'];
			}
			if (ArrayElemIsValidStr($assoc, 'language')) {
				$ob->language = $assoc['language'];
				global $image_extensions;
				$ob->path_to_image = PathToImage($link_to_article_images.$ob->id, 'cover', $link_to_service_images.'Logo.png', $image_extensions, $ob->language);
			} else $ob->path_to_image = PathToImage($link_to_article_images.$ob->id, 'cover', $link_to_service_images.'Logo.png');

			return $ob;
		}

		public static function ArrayFromDBResult($result, $is_assoc = false)
		{
			$res = array();
			while ($row = $result->fetch_assoc()) {
				if ($is_assoc) array_push($res, $row);
				else array_push($res, self::FetchFromAssoc($row));
			}
			return $res;
		}

		public static function FetchBy($kwargs)
		{
			extract($kwargs, EXTR_PREFIX_ALL, 't');

			$select_list 	= '*';
			$eq_conds 		= array();
			$order_by 		= '';
			$limit 			= '';
			$offset 		= '';
			$lang 			= '';
			$where_addition = '';
			$is_assoc 		= false;

			if (isset($t_select_list)) 		$select_list = $t_select_list;
			if (isset($t_eq_conds)) 		$eq_conds = $t_eq_conds;
			if (isset($t_order_by)) 		$order_by = $t_order_by;
			if (isset($t_limit)) 			$limit = $t_limit;
			if (isset($t_offset)) 			$offset = $t_offset;
			if (isset($t_lang)) 			$lang = $t_lang;
			if (isset($t_where_addition)) 	$where_addition = $t_where_addition;
			if (isset($t_is_assoc)) 		$is_assoc = $t_is_assoc;

			global $db_connection;

			$where_clause = '';
			$i = 0;
			$size = count($eq_conds);
			$need_where_word = ($size !== 0) || StringNotEmpty($where_addition);
			foreach ($eq_conds as $key => $value) {
				$where_clause .= ' ('.$key.' = '.$value.') ';
				if ($i < $size - 1) $where_clause .= 'OR';
				++$i;
			}
			if ($need_where_word) $where_clause = "WHERE ".$where_clause.' '.$where_addition;

			if (StringNotEmpty($order_by)) {
				$where_clause .= ' ORDER BY '.$order_by;
			}

			if (StringNotEmpty($limit))
				$where_clause .= ' LIMIT '.$limit;
			if (StringNotEmpty($offset)) {
				$where_clause .= ' OFFSET '.$offset;
			}

			if (!StringNotEmpty($lang)) $lang = GetLanguage();

			$from_table = self::$table;
			if ($lang !== 'rus') $from_table .= '_'.$lang;

			$res = $db_connection->query("SELECT ".$select_list." FROM ".$from_table." ".$where_clause);
			if (!$res) {
				return new Error($db_connection->error, Error::db_error);
			}
			return self::ArrayFromDBResult($res, $is_assoc);
		}

		public static function FetchLike($what, $kwargs) {
			extract($kwargs, EXTR_PREFIX_ALL, 't');
			if (!isset($t_text)) return Error::arg_not_valid;
			$text = $t_text;
			$select_list = '*';
			$where_addition = 'LOWER('.$what.') LIKE LOWER("%'.$text.'%")';
			$special = array();
			$limit = '';
			$is_assoc = false;

			if (isset($t_limit)) $limit = $t_limit;
			if (isset($t_special)) {
				if (is_string($t_special)) $special = array($t_special);
				else $special = $t_special;
			}
			if (isset($t_select_list)) $select_list = $t_select_list;
			if (isset($t_is_assoc)) $is_assoc = $t_is_assoc;

			$obs = self::FetchBy(['select_list' => $select_list, 'where_addition' => $where_addition, 'order_by' => 'id DESC', 'limit' => $limit, 'is_assoc' => $is_assoc]);
			if (Error::IsError($obs)) return $obs;
			foreach ($special as $key) {
				switch ($key) {
					case 'link_to_full': {
						if (!$is_assoc) break;
						for ($i = 0, $size = count($obs); $i < $size; ++$i) {
							if (!isset($obs[$i]['id']) || !isset($obs[$i]['name'])) break;
							$obs[$i]['link_to_full'] = self::LinkToThisUnsafe($obs[$i]['id'], $obs[$i]['name'], 'btn-sm', array('style' => 'color: black;'));
						}
						break;
					}
					default: break;
				}
			}
			return $obs;
		}
		
		public static function FetchByID($id)
		{
			global $db_connection;
			$res = NULL;
			$lang = GetLanguage();
			$fetch_table = Article::$table;
			if ($lang != 'rus') $fetch_table .= '_'.$lang;
			$result = $db_connection->query("SELECT * FROM `".$fetch_table."` WHERE `id`=".$id);
			if ((!$result) || ($result->num_rows != 1)) {
				if (!$result) {
					echo $db_connection->error;
					return NULL;
				}
				$langs = Article::FetchLanguagesByID($id);
				if (count($langs) > 0) {
					return Error::no_translation;
				}
				return NULL;
			}
			$tmp = $result->fetch_assoc();
			$tmp['language'] = $lang;
			return Article::FetchFromAssoc($tmp);
		}

		public static function FetchByAuthorID($id)
		{
			global $db_connection;
			$res = array();
			$lang = GetLanguage();
			$fetch_table = Article::$table;
			if ($lang != 'rus') $fetch_table .= '_'.$lang;
			$result = $db_connection->query("SELECT * FROM `".$fetch_table."` WHERE author_id=\"".$id."\"");
			if (!$result) {
				return NULL;
			}
			while ($row = $result->fetch_assoc()) {
				$tmp = Article::FetchFromAssoc($row);
				$tmp->language = $lang;
				array_push($res, $tmp);
			}
			return $res;
		}

		public function ToJSON($needed = array('id', 'author_id', 'name', 'annotation', 'creating_date', 'path_to_image', 'text_block')) {
			$res = array();
			if (in_array('id', $needed)) $res['id'] = $this->id;
			if (in_array('author_id', $needed)) $res['author_id'] = $this->author_id;
			if (in_array('author_link', $needed)) $res['author_link'] = User::FetchByID($this->author_id)->LinkToThis('btn-sm');
			if (in_array('name', $needed)) $res['name'] = $this->name;
			if (in_array('annotation', $needed)) $res['annotation'] = $this->annotation;
			if (in_array('creating_date', $needed)) $res['creating_date'] = $this->creating_date;
			if (in_array('path_to_image', $needed)) $res['path_to_image'] = $this->path_to_image;
			if (in_array('text_block', $needed)) $res['text_block'] = $this->text_block;

			if (in_array('full_vers_link', $needed)) $res['full_vers_link'] = $this->ToHTMLFullVers(true);
			return json_encode($res);
		}

		public static function FetchFromPost()
		{
			return Article::FetchFromAssoc($_POST);
		}

		public static function FetchAll()
		{
			global $db_connection;
			$res = array();
			$from_table = Article::$table;
			$lang = GetLanguage();
			if ($lang !== 'rus') $from_table .= '_'.$lang;
			$result = $db_connection->query("SELECT * FROM `".$from_table."` ORDER BY creating_date DESC");
			if (!$result) {
				return NULL;
			}
			while ($row = $result->fetch_assoc()) {
				$row['language'] = $lang;
				array_push($res, Article::FetchFromAssoc($row));
			}
			return $res;
		}

		public function FetchLanguages()
		{
			return Article::FetchLanguagesByID($this->id);
		}

		public static function FetchLanguagesByID($id)
		{
			global $languages;
			global $db_connection;
			$res = array();
			foreach ($languages as $key => $value) {
				$from_table = Article::$table;
				if ($key !== 'rus') $from_table .= '_'.$key;
				$q = $db_connection->query("SELECT COUNT(*) FROM ".$from_table." WHERE id = ".$id);
				if ($q) {
					$cnt = $q->fetch_array()[0];
					if ($cnt > 0) $res[$key] = $value;
				}
			}
			return $res;
		}

		public static function InsertToDB($request, $lang_vers = 'rus', $glob_id = 0)
		{
			global $db_connection;
			global $link_to_article_images;
			global $languages;

			$author_id 	= $db_connection->real_escape_string($request->author_id);
			$name 		= $db_connection->real_escape_string($request->name);
			$annotation = $db_connection->real_escape_string($request->annotation);
			$insert_table = Article::$table;
			if ($lang_vers !== 'rus') {
				$insert_table .= '_'.$lang_vers;
			}
			$max_id = self::GetMaximalID() + 1;
			$insert_id = -1;
			if ($glob_id !== 0) $insert_id = $glob_id;
			else $insert_id = $max_id;
			$res = $db_connection->query("INSERT INTO `".$insert_table."` (`id`, `author_id`, `name`, `annotation`, `text_block`, `creating_date`) VALUES ('".$insert_id."', '".$author_id."', '".$name."', '".$annotation."', '', CURRENT_TIMESTAMP)");
			if (!$res) {
				return false;
			}
			$id = $db_connection->insert_id;

			if ($glob_id === 0) $request->text_block = preg_replace('/tmp_(\d+)\//', $id.'/', $request->text_block);
			$text_block = $db_connection->real_escape_string($request->text_block);
			$res = $db_connection->query("UPDATE `".$insert_table."` SET `text_block`=\"".$text_block."\" WHERE `id`=".$id);
			if (!$res) {
				echo $db_connection->error;
				$db_connection->query("DELETE FROM `".$insert_table."` WHERE `id` = ".$id);
				return false;
			}

			$request->id = $id;
			$upload_path = '';
			if ($glob_id === 0) recurse_copy($link_to_article_images.'tmp_'.User::GetIDByLogin(GetUserLogin()), $link_to_article_images.$id);
			if (is_uploaded_file($_FILES['cover']['tmp_name'])) {
				$img_name = 'cover';
				if ($lang_vers !== 'rus') $img_name .= '_'.$lang_vers;
				$sepext = explode('.', strtolower($_FILES['cover']['name']));
			    $type = end($sepext);
			    $img_name .= '.'.$type;
			    $upload_path = $link_to_article_images.$id.'/'.$img_name;
			    if (move_uploaded_file($_FILES['cover']['tmp_name'], $upload_path)) {
			    	$request->path_to_image = $upload_path;
			    }
			}
			return true;
		}

		public function FetchFromAssocEditing($assoc)
		{
			if (ArrayElemIsValidStr($assoc, 'name')) $this->name = $assoc['name'];
			if (ArrayElemIsValidStr($assoc, 'annotation')) $this->annotation = $assoc['annotation'];
			if (ArrayElemIsValidStr($assoc, 'text_block')) $this->text_block = $assoc['text_block'];
		}

		public function FetchCoverFromAssocEditing($assoc)
		{
			if (isset($assoc['cover']['name']) && (is_uploaded_file($assoc['cover']['tmp_name']))) {
				global $link_to_article_images;
				$img_name = 'cover';
				if ($this->language !== 'rus') $img_name .= '_'.$this->language;
				$old_im = $img_name;
				$sepext = explode('.', strtolower($assoc['cover']['name']));
			    $type = end($sepext);
			    $img_name .= '.'.$type;
			    $upload_path = $link_to_article_images.$this->id.'/'.$img_name;
			    if (!delete_image($link_to_article_images.$this->id.'/'.$old_im)) {
			    	return -1;
			    } else if (!move_uploaded_file($assoc['cover']['tmp_name'], $upload_path)) {
			    	return -1;
			    } else {
			    	return 1;
			    }
			}
			return 0;
		}

		//Methods for pushing
		public function Save()
		{
			global $db_connection;
			$from_table = Article::$table;
			if ($this->language !== 'rus') $from_table .= '_'.$this->language;
			$res = $db_connection->query("SELECT `id` FROM `".$from_table."` WHERE (`id`=".$this->id.")");
			if (!$res) {
				echo $db_connection->error;
				return false;
			} else {
				if ($res->num_rows == 0) {
					echo 'there are no article with id = '.$this->id;
					return false;
				}
			}
			$name_tmp 		= $db_connection->real_escape_string($this->name);
			$annotation_tmp = $db_connection->real_escape_string($this->annotation);
			$text_block_tmp = $db_connection->real_escape_string($this->text_block);
			$res = $db_connection->query("UPDATE `".$from_table."` SET `name`=\"".$name_tmp."\", `annotation`=\"".$annotation_tmp."\", `text_block`=\"".$text_block_tmp."\" WHERE `id`=".$this->id);
			if (!$res) {
				echo $db_connection->error;
				return false;
			}
			return true;
		}

		public static function Delete($id)
		{
			global $db_connection;
			global $link_to_article_images;
			global $link_to_logo;

			$article = Article::FetchByID($id);
			$langs = $article->FetchLanguages();

			$from_table = Article::$table;
			if ($article->language !== 'rus') $from_table .= '_'.$article->language;

			if (!$db_connection->query("DELETE FROM `".$from_table."` WHERE `id` = ".$id)) {
				return 0;
			} else {
				if (count($langs) < 2) removeDirectory($link_to_article_images.$id);
				else {
					if ($article->path_to_image !== $link_to_logo) unlink($article->path_to_image);
				}
				return 1;
			}
		}
	}
?>