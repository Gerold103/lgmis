<?php
	//------------------------------------------------A R T I C L E------------------------------------------------
	
	class Article {
		
		//--------Attributes--------
		
		private $id            = id_undef;
		private $author_id     = id_undef;
		private $name          = undef;
		private $annotation    = undef;
		private $text_block    = undef;
		private $creating_date = time_undef;

		private $setted_fields  = [];

		private $path_to_image = undef;
		private $language = 'rus';
		
		public static $type = 'article';
		public static $table = 'articles';

		const cachable = false;
		const translated = true;

		public static function CacheKey($id, $lang = '') { return self::$type.$id.$lang; }

		public static function GetAllColumns() { return ['id', 'author_id', 'name', 'annotation', 'text_block', 'creating_date']; }

		public static function RemoveFromCacheMeta($kwargs = []) {
			global $my_cache;
			if (count($kwargs) === 0) {
				array_push($kwargs, 'maxid');
			}
			foreach ($kwargs as $i => $val) {
				$my_cache->add_key(self::CacheKey($val), NULL);
			}
		}

		public function RemoveFromCache() {
			if (!isset($this->setted_fields['id'])) return;
			global $my_cache;
			$my_cache->add_key(self::CacheKey($this->id, $this->language), NULL);
		}

		// private function __update_ob_in_cache($field_name, $ob, $force = false) {
		// 	if (isset($this->setted_fields[$field_name])) {
		// 		if ($force) {
		// 			$ob[$field_name]['value'] = $this->$field_name;
		// 			$ob[$field_name]['age'] = $this->setted_fields[$field_name];
		// 			return;
		// 		}
		// 		if (!isset($ob[$field_name]) || (isset($ob[$field_name]) &&
		// 									$ob[$field_name]['age'] < $this->setted_fields[$field_name])) {
		// 			$ob[$field_name]['value'] = $this->$field_name;
		// 			$ob[$field_name]['age'] = $this->setted_fields[$field_name];
		// 		}
		// 	}
		// }

		// private function __update_ob_from_cache($field_name, $ob, $force = false) {
		// 	if (isset($ob[$field_name])) {
		// 		if ($force) {
		// 			$this->$field_name = $ob[$field_name]['value'];
		// 			$this->setted_fields[$field_name] = $ob[$field_name]['age'];
		// 			return;
		// 		}
		// 		if (!isset($this->setted_fields[$field_name]) || (isset($this->setted_fields[$field_name]) &&
		// 												($this->setted_fields[$field_name] < $ob[$field_name]['age']))) {
		// 			$this->$field_name = $ob[$field_name]['value'];
		// 			$this->setted_fields[$field_name] = $ob[$field_name]['age'];
		// 		}
		// 	}
		// }

		// public function UpdateObjectFromCache() {
		// 	if (!isset($this->setted_fields['id'])) return;
		// 	global $my_cache;
		// 	$key = self::CacheKey($this->id, $this->language);
		// 	if (!($my_cache->key_exists($key))) {
		// 		$this->UpdateCacheObject();
		// 	}
		// 	$ob = $my_cache->get_val($key);

		// 	$this->__update_ob_from_cache('id', $ob, true);
		// 	$this->__update_ob_from_cache('author_id', $ob, true);
		// 	$this->__update_ob_from_cache('name', $ob);
		// 	$this->__update_ob_from_cache('annotation', $ob);
		// 	$this->__update_ob_from_cache('text_block', $ob);
		// 	$this->__update_ob_from_cache('path_to_image', $ob);
		// 	$this->__update_ob_from_cache('creating_date', $ob);
		// }

		// public function UpdateCacheObject() {
		// 	global $my_cache;

		// 	if (!isset($this->setted_fields['id'])) return;
		// 	$key = self::CacheKey($this->id, $this->language);
		// 	if ($my_cache->key_exists($key)) {
		// 		$ob = $my_cache->get_val($key);

		// 		//key = Self<ID><lang>, value = ['name' => ['value'=>val, 'age'=>val], ...]

		// 		$this->__update_ob_in_cache('author_id', $ob, true);
		// 		$this->__update_ob_in_cache('creating_date', $ob, true);
		// 		$this->__update_ob_in_cache('name', $ob);
		// 		$this->__update_ob_in_cache('annotation', $ob);
		// 		$this->__update_ob_in_cache('text_block', $ob);
		// 		$this->__update_ob_in_cache('path_to_image', $ob);
		// 	} else {
		// 		$res = [];
		// 		foreach ($this->setted_fields as $field => $age) {
		// 			$res[$field] = ['value' => $this->$field, 'age' => $age];
		// 		}
		// 		$my_cache->add_key($key, $res);
		// 	}
		// }

		public function SetID($n) {
			$this->setted_fields['id'] = 1;
			$this->id = $n;
		}

		public function SetAuthorID($n) {
			$this->author_id = $n;
			$this->setted_fields['author_id'] = 1;
		} 

		public function SetName($n) {
			$this->name = $n;
			$this->setted_fields['name'] = 1;
		}

		public function SetAnnotation($n) {
			$this->annotation = $n;
			$this->setted_fields['annotation'] = 1;
		}

		public function SetTextBlock($n) {
			$this->text_block = $n;
			$this->setted_fields['text_block'] = 1;
		}

		public function SetCreatingDate($n) {
			$this->creating_date = $n;
			$this->setted_fields['creating_date'] = 1;
		}

		public function SetPathToImage($n) {
			$this->path_to_image = $n;
			$this->setted_fields['path_to_image'] = 1;
		}

		public function GetSettedFields() { return $this->setted_fields; }

		public function GetCreatingDateStr() { return date('d : m : Y - H : i', $this->creating_date); }

		public function GetID() { return $this->id; }

		public function GetAuthorID() { return $this->author_id; }

		public function GetName() { return $this->name; }

		public function GetAnnotation() { return $this->annotation; }

		public function GetTextBlock() { return $this->text_block; }

		public function GetPathToImage() { return $this->path_to_image; }

		public static function GetMaximalID()
		{
			global $my_cache;
			$max_id = $my_cache->get_val(self::CacheKey('maxid'));
			if ($max_id !== NULL) {
				return $max_id;
			}

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
			$my_cache->add_key(self::CacheKey('maxid'), $maxid);
			return $max_id;
		}

		public function SetLanguage($n) {
			$this->language = $n;
		}

		public function GetLanguage() { return $this->language; }
		
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
			$author = User::FetchBy(['eq_conds' => ['id' => $this->GetAuthorID()], 'select_list' => 'id, name, surname, login', 'is_unique' => true]);

			$res .= '<div class="form-horizontal">';

			$res .= 	'<div class="row">';
			$res .= 		'<label class="'.ColAllTypes(3).' vcenter control-label">'.Language::Word('creating date').'</label>';
			$res .= 		'<div class="'.ColAllTypes(5).' vcenter">';
			$res .= 			SimplePanel($this->GetCreatingDateStr());
			$res .= 		'</div>';
			$res .= 	'</div>';

			$res .= 	'<div class="row">';
			$res .= 		'<label class="'.ColAllTypes(3).' vcenter control-label">'.Language::Word('author').'</label>';
			$res .= 		'<div class="'.ColAllTypes(5).' vcenter">';
			$res .= 			SimplePanel($author->LinkToThis());
			$res .= 		'</div>';
			$res .= 	'</div>';

			$res .= 	'<div class="row">';
			$res .= 		'<label class="'.ColAllTypes(3).' vcenter control-label">'.Language::Word('annotation').'</label>';
			$res .= 		'<div class="'.ColAllTypes(5).' vcenter">';
			$res .= 			SimplePanel(htmlspecialchars($this->GetAnnotation()));
			$res .= 		'</div>';
			$res .= 	'</div>';

			$res .= 	'<div class="row">';
			$res .= 		'<label class="'.ColAllTypes(3).' vcenter control-label">'.Language::Word('cover').'</label>';
			$res .= 		'<div class="'.ColAllTypes(5).' vcenter">';
			$res .= 			'<img src="'.$this->GetPathToImage().'" class="img-article-cover">';
			$res .= 		'</div>';
			$res .= 	'</div>';

			$res .= '<hr>';

			$res .= 	'<div class="row" align="center">';
			$res .= 		'<label class="control-label">'.Language::Word('text').'</label>';
			$res .= 	'</div>';
			$res .= 	'<div class="row" align="left">';
			$res .= 		'<div class="'.ColAllTypes(8).' '.ColOffsetAllTypes(2).'">';
			$res .= 			SimplePanel($this->GetTextBlock());
			$res .= 		'</div>';
			$res .= 	'</div>';

			$res .= '<div class="row">';
			if ((GetUserLogin() === $author->GetLogin()) || (GetUserLogin() == 'admin')) {
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
			$res .= 	'<div class="'.ColAllTypes(4).'">'.User::FetchBy(['eq_conds' => ['id' => $this->GetAuthorID()], 'select_list' => 'id, name, surname', 'is_unique' => true])->LinkToThis().'</div>';
			$res .= '</div>';
			$res .= '<br><hr>';
			$res .= '<div class="row"><div class="'.ColAllTypes(12).'">'.$this->GetTextBlock().'</div></div>';
			return $res;
		}

		public function ToHTMLUserPrivateShortInTable()
		{
			$author = User::FetchBy(['select_list' => 'id, name, surname', 'is_unique' => true, 'eq_conds' => ['id' => $this->GetAuthorID()]]);
			$res = '<tr>';
			$res .= '<td>'.htmlspecialchars($this->GetName()).'</td>';
			$res .= '<td>'.$author->LinkToThis().'</td>';
			$res .= '<td>'.date('d : m : Y - H : i', $this->creating_date).'</td>';
			$res .= '<td>';
			$res .=		'<div class="row">';
			$author_login = $author->GetLogin();
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
			$res .= 		'<img class="img-article-cover" src="'.Link::Get($this->GetPathToImage()).'">';
			$res .= 	'</div>';
			$res .= 	'<div class="'.ColAllTypes(8).'">';
			$res .= 		'<div class="row">';
			$res .= 		'<div class="'.ColAllTypes(12).'">';
			$res .= 			ToPageHeader($this->GetName(), 'h5', 'grey', 'normal');
			$res .= 		'</div>';
			$res .= 		'</div>';

			$res .= 		'<hr>';

			$res .= 		'<div class="row" align="left">';
			$res .= 		'<div class="'.ColAllTypes(12).'">';
			$res .= 			htmlspecialchars($this->GetAnnotation());
			$res .= 		'</div>';
			$res .= 		'</div>';
			$res .= 	'</div>';
			$res .= '</div>';

			$author = User::FetchBy(['select_list' => 'id, name, surname', 'is_unique' => true, 'eq_conds' => ['id' => $this->GetAuthorID()]]);

			$res .= '<div class="row"><div class="'.ColAllTypes(12).'"><hr></div></div>';
			$res .= '<div class="row" style="font-size: 11px">';
			$res .= 	'<div class="'.ColAllTypes(4).'">';
			$res .= 		$this->GetCreatingDateStr();
			$res .= 	'</div>';
			$res .= 	'<div class="'.ColAllTypes(4).'" align="left">';
			$res .= 		'<font color="black">Автор:</font> '.$author->LinkToThis('btn-sm');
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
				'obj_type' => self::$type,
				'id' => $this->GetID(),
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
				'obj_type' => self::$type,
				'id' => $this->GetID(),
				'info' => Language::Word('are you shure that you want to delete article with header').' '.htmlspecialchars($this->GetName()).'?',
			);
			return ActionButton($args);
		}
		
		public function ToHTMLEdit()
		{
			global $link_to_admin_article;
			$args = array(
				'action_link' => $link_to_admin_article,
				'action_type' => 'edit',
				'obj_type' => self::$type,
				'id' => $this->GetID(),
			);
			return ActionButton($args);
		}

		public function ToHTMLFullVersUnsafe($id, $to_public = NULL) {
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
					'obj_type' => self::$type,
					'id' => $id,
					'method' => 'get',
					'mod_rewrite' => $mod_rewrite,
				);
			} else {
				$args = array(
					'action_link' => $link_to_admin_article,
					'action_type' => 'full',
					'obj_type' => self::$type,
					'id' => $id,
					'prev_page' => $link_to_admin_manage_content.'?content_type='.$content_types_short['articles'],
					'method' => 'get',
				);
			}
			return ActionButton($args);
		}

		public function ToHTMLFullVers($to_public = NULL)
		{
			return self::ToHTMLFullVersUnsafe($this->GetID(), $to_public);
		}

		//---------------- ILinkable implementation ----------------

		public function LinkToThis()
		{
			if (IsSessionPublic()) return Link::Get(Article::$type).'/'.$this->GetID();
			else return Link::Get('private_'.Article::$type).'/'.$this->GetID();
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
			global $my_cache;

			$ob = new self();
			if (ArrayElemIsValidStr($assoc, 'id')) 			$ob->SetID($assoc['id']);
			if (ArrayElemIsValidStr($assoc, 'author_id')) 	$ob->SetAuthorID($assoc['author_id']);
			if (ArrayElemIsValidStr($assoc, 'name')) 		$ob->SetName($assoc['name']);
			if (ArrayElemIsValidStr($assoc, 'annotation')) 	$ob->SetAnnotation($assoc['annotation']);
			if (ArrayElemIsValidStr($assoc, 'text_block')) 	$ob->SetTextBlock($assoc['text_block']);
			try {
				if (ArrayElemIsValidStr($assoc, 'creating_date')) {
					$ob->SetCreatingDate(strtotime($assoc['creating_date']));
				}
			} catch(Exception $e) {
				$ob->SetCreatingDate($assoc['creating_date']);
			}
			if (ArrayElemIsValidStr($assoc, 'language')) {
				$ob->SetLanguage($assoc['language']);
				global $image_extensions;
				$ob->SetPathToImage(PathToImage($link_to_article_images.$ob->GetID(), 'cover', $link_to_service_images.'Logo.png', $image_extensions, $assoc['language']));
			} else {
				$ob->SetLanguage(GetLanguage());
				$ob->SetPathToImage(PathToImage($link_to_article_images.$ob->GetID(), 'cover', $link_to_service_images.'Logo.png'));
			}

			return $ob;
		}

		public static function ArrayFromDBResult($result, $is_assoc = false)
		{
			$res = array();
			while ($row = $result->fetch_assoc()) {
				if ($is_assoc) {
					$row['creating_date'] = strtotime($row['creating_date']);
					array_push($res, $row);
				}
				else array_push($res, self::FetchFromAssoc($row));
			}
			return $res;
		}

		public static function FetchCountOf($kwargs = [])
		{
			global $db_connection;
			extract($kwargs, EXTR_PREFIX_ALL, 't');

			$where = '';
			$lang = GetLanguage();
			if (isset($t_where)) 	$where 	= $t_where;
			if (isset($t_lang))		$lang 	= $t_lang;

			if ($where != '') $where = 'WHERE '.$where;
			$from_table = self::$table;
			if ($lang != 'rus') $from_table .= '_'.$lang;
			$rc = $db_connection->query('SELECT COUNT(*) as tmp FROM '.$from_table.' '.$where);
			if (!$rc) {
				return new Error($db_connection->error, Error::db_error);
			}
			$tmp = $rc->fetch_assoc();
			return $tmp['tmp'];
		}

		public static function FetchBy($kwargs)
		{
			function is_unique_callback($kw, $rc) {
				$res_count = count($rc);
				$eq_conds 		= array();
				if (isset($kw['eq_conds'])) $eq_conds = $kw['eq_conds'];
				if ($res_count > 1) {
					return new Error('', Error::ambiguously);
				}
				if ($res_count === 0) {
					if (isset($eq_conds['id'])) {
						if (count(Article::FetchLanguagesByID($eq_conds['id'])) > 0) {
							return new Error('', Error::no_translation);
						}
					}
					return new Error('', Error::not_found);
				}
				return true;
			}

			function special_callback($kw, $rc) {
				extract($kw, EXTR_PREFIX_ALL, 't');
				$special 		= array();
				$is_assoc 		= false;
				$class_parent		= NULL;

				if (isset($t_special))			$special = $t_special;
				if (isset($t_is_assoc)) 		$is_assoc = $t_is_assoc;
				if (isset($t_class_parent))		$class_parent = $t_class_parent;
				$res_count = count($rc);

				for ($i = 0, $count = count($special); $i < $count; ++$i) {
					switch ($special[$i]) {
						case 'author_link': {
							if ($is_assoc === false) break;
							for ($j = 0; $j < $res_count; ++$j) {
								if (isset($rc[$j]['author_id'])) {
									$rc[$j]['author_link'] = User::FetchBy(['select_list' => 'id, name, surname', 'eq_conds' => ['id' => $rc[$j]['author_id']], 'is_unique' => true])->LinkToThis('btn-sm');
								}
							}
							break;
						}
						case 'link_to_full': {
							if ($is_assoc === false) break;
							for ($j = 0; $j < $res_count; ++$j) {
								if (isset($rc[$j]['id']) && isset($rc[$j]['name']))
									$rc[$j]['link_to_full'] = $class_parent::LinkToThisUnsafe($rc[$j]['id'], $rc[$j]['name'], 'btn-sm', array('style' => 'color: black;'));
							}
							break;
						}
						case 'full_vers_link': {
							if ($is_assoc === false) break;
							for ($j = 0; $j < $res_count; ++$j) {
								if (isset($rc[$j]['id']))
									$rc[$j]['full_vers_link'] = $class_parent::ToHTMLFullVersUnsafe($rc[$j]['id'], true);
							}
							break;
						}
						case 'path_to_image': {
							global $image_extensions;
							global $link_to_article_images;
							global $link_to_service_images;
							if ($is_assoc) {
								for ($j = 0; $j < $res_count; ++$j) {
									if (!isset($rc[$j]['id'])) continue;
									$path = PathToImage($link_to_article_images.$rc[$j]['id'], 'cover', $link_to_service_images.'Logo.png', $image_extensions, GetLanguage());
									$rc[$j]['path_to_image'] = $path;
								}
							} else {
								for ($j = 0; $j < $res_count; ++$j) {
									$path = PathToImage($link_to_article_images.$rc[$j]->GetID(), 'cover', $link_to_service_images.'Logo.png', $image_extensions, GetLanguage());
									$rc[$j]['path_to_image'] = $path;
								}
							}
							break;
						}
						default: break;
					}
				}
				return $rc;
			}

			$tmp = $kwargs;
			$tmp['is_unique_callback'] = function($kw, $rc) { return is_unique_callback($kw, $rc); };
			$tmp['class_parent'] = new Article;
			$tmp['special_callback'] = function($kw, $rc) { return special_callback($kw, $rc); };
			return FetchBy($tmp);
		}

		public static function FetchLike($what, $kwargs = []) {
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

			$obs = self::FetchBy(['select_list' => $select_list, 'where_addition' => $where_addition, 'order_by' => 'id DESC', 'limit' => $limit, 'is_assoc' => $is_assoc, 'special' => array('link_to_full')]);
			if (Error::IsError($obs)) return $obs;
			return $obs;
		}

		public function ToJSON($needed = array('id', 'author_id', 'name', 'annotation', 'creating_date', 'path_to_image', 'text_block')) {
			$res = array();
			if (in_array('id', $needed)) $res['id'] = $this->id;
			if (in_array('author_id', $needed)) $res['author_id'] = $this->author_id;
			if (in_array('author_link', $needed)) $res['author_link'] = User::FetchBy(['eq_conds' => ['id' => $this->author_id], 'select_list' => 'id, name, surname', 'is_unique' => true])->LinkToThis('btn-sm');
			if (in_array('name', $needed)) $res['name'] = $this->name;
			if (in_array('annotation', $needed)) $res['annotation'] = $this->annotation;
			if (in_array('creating_date', $needed)) $res['creating_date'] = $this->creating_date;
			if (in_array('path_to_image', $needed)) $res['path_to_image'] = $this->path_to_image;
			if (in_array('text_block', $needed)) $res['text_block'] = $this->text_block;

			if (in_array('full_vers_link', $needed)) $res['full_vers_link'] = $this->ToHTMLFullVers(true);
			return json_encode($res);
		}

		public function FetchLanguages()
		{
			return self::FetchLanguagesByID($this->id);
		}

		public static function FetchLanguagesByID($id)
		{
			global $languages;
			global $db_connection;
			$res = array();
			foreach ($languages as $key => $lang) {
				$cnt = self::FetchCountOf(['where' => 'id = '.$id, 'lang' => $lang]);
				if ($cnt > 0) $res[$key] = $value;
			}
			return $res;
		}

		public function FetchFromAssocEditing($assoc)
		{
			if (ArrayElemIsValidStr($assoc, 'name')) $this->SetName($assoc['name']);
			if (ArrayElemIsValidStr($assoc, 'annotation')) $this->SetAnnotation($assoc['annotation']);
			if (ArrayElemIsValidStr($assoc, 'text_block')) $this->SetTextBlock($assoc['text_block']);
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

		public static function InsertToDB($request, $lang_vers = 'rus', $glob_id = 0)
		{
			global $db_connection;
			global $link_to_article_images;
			global $languages;

			$author_id 	= $db_connection->real_escape_string($request->author_id);
			$name 		= $db_connection->real_escape_string($request->name);
			$annotation = $db_connection->real_escape_string($request->annotation);
			$insert_table = self::$table;
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

			if ($glob_id === 0) $request->SetTextBlock(preg_replace('/tmp_(\d+)\//', $id.'/', $request->text_block));
			$text_block = $db_connection->real_escape_string($request->text_block);
			$res = $db_connection->query("UPDATE `".$insert_table."` SET `text_block`=\"".$text_block."\" WHERE `id`=".$id);
			if (!$res) {
				echo $db_connection->error;
				$db_connection->query("DELETE FROM `".$insert_table."` WHERE `id` = ".$id);
				return false;
			}

			$request->SetID($id);
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
			    	$request->SetPathToImage($upload_path);
			    }
			}
			$request->RemoveFromCache();
			self::RemoveFromCacheMeta();
			return true;
		}

		//Methods for pushing
		public function Save()
		{
			global $db_connection;
			$from_table = self::$table;
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
			$this->RemoveFromCache();
			self::RemoveFromCacheMeta();
			return true;
		}

		public static function Delete($id)
		{
			global $db_connection;
			global $link_to_article_images;
			global $link_to_logo;

			$article = self::FetchBy(['select_list' => 'id', 'eq_conds' => ['id' => $id], 'is_unique' => true]);
			$langs = $article->FetchLanguages();

			$article->RemoveFromCache();
			self::RemoveFromCacheMeta();

			$from_table = self::$table;
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