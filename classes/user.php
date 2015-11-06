<?php

	//------------------------------------------------U S E R------------------------------------------------
	
	class User {
		
		//--------Attributes--------
		
		private $id               = id_undef;
		private $name             = undef;
		private $surname          = undef;
		private $fathername       = undef;
		private $login            = undef;
		private $password		  = undef;
		private $position         = undef;
		private $received_reports = undef;
		private $sended_reports	  = undef;
		private $email            = undef;
		private $telephone        = undef;
		private $register_time    = time_undef;
		private $last_visit_time  = time_undef;
		private $birthday         = time_undef;

		private $path_to_photo   = undef;

		const cachable = true;
		const translated = false;

		private $setted_fields  = [];
		
		public static $type = 'user';
		public static $table = 'users';

		public static function GetAllColumns() { return ['id', 'name', 'surname', 'fathername', 'login', 'password',
			'position', 'received_reports', 'sended_reports', 'email', 'telephone', 'register_time', 'last_visit_time',
			'birthday']; }

		public static function CacheKey($id, $kwargs = []) { return self::$type.$id; }

		public static function RemoveFromCacheMeta($kwargs = []) {
			global $my_cache;
		}

		public function RemoveFromCache() {
			if (!isset($this->setted_fields['id'])) return;
			global $my_cache;
			$my_cache->add_key(self::CacheKey($this->id), NULL);
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
		// 	$key = self::CacheKey($this->id);
		// 	if (!($my_cache->key_exists($key))) {
		// 		$this->UpdateCacheObject();
		// 	}
		// 	$ob = $my_cache->get_val($key);

		// 	$this->__update_ob_from_cache('id', $ob, true);
		// 	$this->__update_ob_from_cache('name', $ob);
		// 	$this->__update_ob_from_cache('surname', $ob);
		// 	$this->__update_ob_from_cache('fathername', $ob);
		// 	$this->__update_ob_from_cache('login', $ob);
		// 	$this->__update_ob_from_cache('password', $ob);
		// 	$this->__update_ob_from_cache('position', $ob);
		// 	$this->__update_ob_from_cache('received_reports', $ob);
		// 	$this->__update_ob_from_cache('sended_reports', $ob);
		// 	$this->__update_ob_from_cache('email', $ob);
		// 	$this->__update_ob_from_cache('telephone', $ob);
		// 	$this->__update_ob_from_cache('register_time', $ob, true);
		// 	$this->__update_ob_from_cache('last_visit_time', $ob);
		// 	$this->__update_ob_from_cache('birthday', $ob);
		// 	$this->__update_ob_from_cache('path_to_photo', $ob);
		// }

		// public function UpdateCacheObject() {
		// 	global $my_cache;

		// 	if (!isset($this->setted_fields['id'])) return;
		// 	$key = self::CacheKey($this->id);
		// 	if ($my_cache->key_exists($key)) {
		// 		$ob = $my_cache->get_val($key);

		// 		//key = Self<ID><lang>, value = ['name' => ['value'=>val, 'age'=>val], ...]
		// 		$this->__update_ob_in_cache('id', $ob, true);
		// 		$this->__update_ob_in_cache('name', $ob);
		// 		$this->__update_ob_in_cache('surname', $ob);
		// 		$this->__update_ob_in_cache('fathername', $ob);
		// 		$this->__update_ob_in_cache('login', $ob);
		// 		$this->__update_ob_in_cache('password', $ob);
		// 		$this->__update_ob_in_cache('position', $ob);
		// 		$this->__update_ob_in_cache('received_reports', $ob);
		// 		$this->__update_ob_in_cache('sended_reports', $ob);
		// 		$this->__update_ob_in_cache('email', $ob);
		// 		$this->__update_ob_in_cache('telephone', $ob);
		// 		$this->__update_ob_in_cache('register_time', $ob, true);
		// 		$this->__update_ob_in_cache('last_visit_time', $ob);
		// 		$this->__update_ob_in_cache('birthday', $ob);
		// 		$this->__update_ob_in_cache('path_to_photo', $ob);
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

		public function SetName($n) {
			$this->setted_fields['name'] = 1;
			$this->name = $n;
		}

		public function SetSurname($n) {
			$this->setted_fields['surname'] = 1;
			$this->surname = $n;
		}

		public function SetFathername($n) {
			$this->setted_fields['fathername'] = 1;
			$this->fathername = $n;
		}

		public function SetLogin($n) {
			$this->setted_fields['login'] = 1;
			$this->login = $n;
		}

		public function SetPassword($n) {
			$this->setted_fields['password'] = 1;
			$this->password = $n;
		}

		public function SetPosition($n) {
			$this->setted_fields['position'] = 1;
			$this->position = $n;
		}

		public function SetReceivedReports($n) {
			$this->setted_fields['received_reports'] = 1;
			$this->received_reports = $n;
		}

		public function SetSendedReports($n) {
			$this->setted_fields['sended_reports'] = 1;
			$this->sended_reports = $n;
		}

		public function SetEmail($n) {
			$this->setted_fields['email'] = 1;
			$this->email = $n;
		}

		public function SetTelephone($n) {
			$this->setted_fields['telephone'] = 1;
			$this->telephone = $n;
		}

		public function SetRegisterTime($n) {
			$this->setted_fields['register_time'] = 1;
			$this->register_time = $n;
		}

		public function SetLastVisitTime($n) {
			$this->setted_fields['last_visit_time'] = 1;
			$this->last_visit_time = $n;
		}

		public function SetBirthday($n) {
			$this->setted_fields['birthday'] = 1;
			$this->birthday = $n;
		}

		public function SetPathToPhoto($n) {
			$this->setted_fields['path_to_photo'] = 1;
			$this->path_to_photo = $n;
		}


		public function GetID() { return $this->id; }

		public function GetName() { return $this->name; }

		public function GetSurname() { return $this->surname; }

		public function GetFathername() { return $this->fathername; }

		public function GetLogin() { return $this->login; }

		public function GetPassword() { return $this->password; }

		public function GetCount()
		{
			global $db_connection;
			$res = $db_connection->query("SELECT COUNT(*) FROM ".self::$table);
			if ($res) {
				if ($res->num_rows > 0) {
					return $res->fetch_row()[0];
				}
				return 0;
			}
			return 0;
		}

		public function GetPositionNum() { return $this->position; }

		public function GetReceivedReports() { return $this->received_reports; }

		public function GetSendedReports() { return $this->sended_reports; }

		public function GetPosition()
		{
			global $positions;
			return Language::Position($this->position);
		}

		public function GetLastVisitTime() { return date('d : m : Y - H : i', $this->last_visit_time); }

		public function GetRegisterTime() { return date('d : m : Y - H : i', $this->register_time); }

		public function GetBirthday() { return date('d : m : Y', $this->birthday); }

		public function GetEmail() { return $this->email; }

		public function GetTelephone() { return $this->telephone; }

		public static function GetIDByLogin($login)
		{
			$user = self::FetchBy(['select_list' => 'id', 'eq_conds' => ['login' => $login], 'is_unique' => true]);
			if (Error::IsError($user)) {
				echo Error::ToString($user);
				return NULL;
			}
			return $user->id;
		}

		public function GetPathToPhoto() { return $this->path_to_photo; }
		
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
					return $this->ToHTMLPrivateShortInTable();
				case unauthorized_user_id:
					return $this->ToHTMLUserPublicShortInTable();
				default:
					return html_undef;
			}
		}

		public function ToHTMLPrivateFull()
		{
			global $user_blocks_in_db;
			global $link_to_admin_user_block;
			global $link_to_admin_bookkeeping;
			global $positions;

			$res = '';
			$res .= '<div class="row">';
			$res .= 	'<div class="'.ColAllTypes(1).'"></div>';
			$res .= 	'<div class="'.ColAllTypes(5).' vcenter" align="right">';
			$res .=			'<img src="'.($this->path_to_photo).'" class="img-rounded img-avatar">';
			$res .= 	'</div>';
			$res .= 	'<div class="'.ColAllTypes(5).' vcenter" align="left">';

			$res .= PairLabelAndPanel(2, 10, Language::Word('full name'), Language::Translit(htmlspecialchars($this->surname.' '.$this->name.' '.$this->fathername)));
			$res .= PairLabelAndPanel(2, 10, Language::Word('position'), htmlspecialchars(Language::Position($this->position)));
			$res .= PairLabelAndPanel(2, 10, Language::Word('mail'), htmlspecialchars($this->email));
			$res .= PairLabelAndPanel(2, 10, Language::Word('telephone'), htmlspecialchars($this->telephone));
			$res .= PairLabelAndPanel(2, 10, Language::Word('birthday'), htmlspecialchars($this->GetBirthday()));
			if ((GetUserLogin() === $this->login) || (GetUserLogin() === 'admin')) {
				$actions = '<div class="row">';
				$actions .= 	'<div class="'.ColAllTypes(6).'">'.$this->ToHTMLDel().'</div>';
				$actions .= 	'<div class="'.ColAllTypes(6).'">'.$this->ToHTMLEdit().'</div>';
				$actions .= '</div>';
				$res .= PairLabelAndPanel(2, 10, Language::Word('actions'), $actions);
			}

			$res .= 	'</div>';
			$res .= '</div>';

			if ((GetUserLogin() === $this->login) || (GetUserLogin() === 'admin')) {
				$res .= '<div class="row" align="center">';
				$res .= 	'<div class="'.ColAllTypes(1).'"></div>';
				$res .= 	'<div class="'.ColAllTypes(10).'">';
					$args = array(
						'action_link' => $link_to_admin_user_block,
						'action_type' => 'add',
						'obj_type' => UserBlock::$type,
						'id' => $this->id,
						'btn_text' => Language::Word('add block'),
						'btn_size' => 'btn-lg',
					);
				$res .= 		'<span style="margin: 3px;">'.ActionButton($args).'</span>';
				$res .= 	'</div>';
				$res .= '</div>';
			}

			$my_blocks = UserBlock::FetchAllByAuthorID($this->id);

			$size = count($my_blocks);
			if ($size === 0) {
				return $res;
			}
			$from = -1;
			$to = -1;
			global $link_to_pagination_init_template;
			require($link_to_pagination_init_template);

			for ($i = $from; $i <= $to; ++$i) {
				$res .= ($my_blocks[$i]->ToHTMLAutoShortForTable(GetUserPrivileges()));
			}

			$pagination = '';
			global $link_to_pagination_show_template;
			require($link_to_pagination_show_template);
			$res .= $pagination;

			return $res;
		}

		public function ToHTMLUserPublicFull() { return html_undef; }

		public function ToHTMLPrivateShortInTable()
		{
			global $positions;
			$res = '<tr>';
			$res .= '<td>'.htmlspecialchars(Language::Translit($this->name)).'</td>';
			$res .= '<td>'.htmlspecialchars(Language::Translit($this->surname)).'</td>';
			$res .= '<td>'.htmlspecialchars(Language::Position($this->position)).'</td>';
			$res .= '<td>';
			$res .=		'<div class="row">';
			if ((GetUserLogin() != $this->login) && (GetUserLogin() != 'admin')) {
				$res .= 	'<div class="'.ColAllTypes(12).'">';
			} else {
				$res .= 	'<div class="'.ColAllTypes(4).'">';
			}
			$res .= 			$this->ToHTMLFullVers();
			$res .=			'</div>';
			if ((GetUserLogin() == $this->login) || (GetUserLogin() == 'admin')) {
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
			global $positions;
			$res = '';
			$res .= '<div class="row" style="display: table; width: 100%;" align="center">';
			$res .= 	'<div class="'.ColAllTypes(4).'" style="float: none; display: table-cell; vertical-align: middle;">';
			$res .= 		'<img src="'.Link::Get($this->path_to_photo).'" class="img-rounded img-avatar-sm">';
			$res .= 	'</div>';

			$res .= 	'<div class="'.ColAllTypes(5).'" style="float: none; display: table-cell; vertical-align: middle;">';
			$res .= 		ToPageHeader(Language::Translit($this->surname.' '.$this->name), 'h4', 'black');
			$res .= 		'<u>'.Language::Position($this->position).'</u><br>';
			$res .= 		'<a href="mailto:'.$this->email.'">'.$this->email.'</a><br>';
			$res .= 	'</div>';

			$res .= 	'<div class="'.ColAllTypes(3).'" style="float: none; display: table-cell; vertical-align: middle;">';
			$res .= 		$this->ToHTMLFullVers();
			$res .= 	'</div>';
			$res .= '</div>';
			return $res;
		}

		//---------------- IActions implementation ----------------

		public function ToHTMLDel()
		{
			global $link_to_utility_interceptor;
			$args = array(
				'action_link' => $link_to_utility_interceptor,
				'action_type' => 'del',
				'obj_type' => User::$type,
				'id' => $this->id,
				'info' => Language::Word('are you sure that you want to delete user').' '.Language::Translit(htmlspecialchars($this->name)).'?',
			);
			return ActionButton($args);
		}
		
		public function ToHTMLEdit()
		{
			global $link_to_admin_user;
			$args = array(
				'action_link' => $link_to_admin_user,
				'action_type' => 'edit',
				'obj_type' => User::$type,
				'id' => $this->id,
			);
			return ActionButton($args);
		}

		public static function ToHTMLFullVersUnsafe($id)
		{
			global $link_to_admin_user;
			global $link_to_public_user;
			global $link_to_contacts;
			global $link_to_admin_manage_staff;
			global $use_mod_rewrite;
			$mod_rewrite = 0;
			if (isset($use_mod_rewrite) && ($use_mod_rewrite === true)) {
				$mod_rewrite = 1;
			}
			if (IsSessionPublic()) {
				$args = array(
					'action_link' => $link_to_public_user,
					'action_type' => 'full',
					'obj_type' => self::$type,
					'id' => $id,
					'prev_page' => $link_to_contacts,
					'btn_text' => Language::Word('open profile'),
					'method' => 'get',
					'mod_rewrite' => $mod_rewrite,
				);
			} else {
				$args = array(
					'action_link' => $link_to_admin_user,
					'action_type' => 'full',
					'obj_type' => self::$type,
					'id' => $id,
					'prev_page' => $link_to_admin_manage_staff,
					'method' => 'get',
				);
			}
			return ActionButton($args);
		}

		public function ToHTMLFullVers()
		{
			return self::ToHTMLFullVersUnsafe($this->id);
		}

		//---------------- ILinkable implementation ----------------

		public static function LinkToThisUnsafe($id, $name, $surname, $link_size = 'btn-md', $args2 = array())
		{
			global $link_to_admin_user;
			global $link_to_public_user;
			global $use_mod_rewrite;
			$args = array();
			$mod_rewrite = 0;
			if (isset($use_mod_rewrite) && ($use_mod_rewrite === true)) {
				$mod_rewrite = 1;
			}
			if (IsSessionPublic() === true) {
				$args = array(
					'action_link' => $link_to_public_user,
					'action_type' => 'full',
					'obj_type' => self::$type,
					'id' => $id,
					'lnk_text' => Language::Translit(($surname).' '.($name)),
					'lnk_size' => $link_size,
					'method' => 'get',
					'mod_rewrite' => $mod_rewrite,
				);
			} else {
				$args = array(
					'action_link' => $link_to_admin_user,
					'action_type' => 'full',
					'obj_type' => self::$type,
					'id' => $id,
					'lnk_text' => Language::Translit(($surname).' '.($name)),
					'lnk_size' => $link_size,
					'method' => 'get',
				);
			}
			if (isset($args2['style'])) $args['style'] = $args2['style'];
			return ActionLink($args);
		}

		public function LinkToThis($link_size = 'btn-md')
		{
			return self::LinkToThisUnsafe($this->id, $this->name, $this->surname, $link_size);
		}

		//---------------- IFetches implementation ----------------

		public function PushToAssoc() {
			$assoc = [];
			foreach ($this->setted_fields as $fld => $i) {
				$assoc[$fld] = $this->$fld;
			}
			return $assoc;
		}

		public static function FetchFromAssoc($assoc)
		{
			global $link_to_users_images;
			$ob = new self();
			if (ArrayElemIsValidStr($assoc, 'id')) $ob->SetID($assoc['id']);
			if (ArrayElemIsValidStr($assoc, 'name')) $ob->SetName($assoc['name']);
			if (ArrayElemIsValidStr($assoc, 'surname')) $ob->SetSurname($assoc['surname']);
			if (ArrayElemIsValidStr($assoc, 'fathername')) $ob->SetFathername($assoc['fathername']);
			if (ArrayElemIsValidStr($assoc, 'login')) $ob->SetLogin($assoc['login']);
			if (ArrayElemIsValidStr($assoc, 'password')) $ob->SetPassword($assoc['password']);
			if (ArrayElemIsValidStr($assoc, 'position')) $ob->SetPosition($assoc['position']);
			if (isset($assoc['received_reports'])) {
				if (is_string($assoc['received_reports'])) {
					if ($assoc['received_reports'] === '') $ob->received_reports = [];
					else $ob->SetReceivedReports(json_decode($assoc['received_reports']));
				} else if ($assoc['received_reports'] != NULL) {
					$ob->SetReceivedReports($assoc['received_reports']);
				} else {
					$ob->received_reports = [];
				}
			} else {
				$ob->received_reports = [];
			}
			if (isset($assoc['sended_reports'])) {
				if (is_string($assoc['sended_reports'])) {
					if ($assoc['sended_reports'] === '') $ob->sended_reports = [];
					else $ob->SetSendedReports(json_decode($assoc['sended_reports']));
				} else if ($assoc['sended_reports'] != NULL) {
					$ob->SetSendedReports($assoc['sended_reports']);
				} else {
					$ob->sended_reports = [];
				}
			} else {
				$ob->sended_reports = [];
			}
			if (ArrayElemIsValidStr($assoc, 'email')) $ob->SetEmail($assoc['email']);
			if (ArrayElemIsValidStr($assoc, 'telephone')) $ob->SetTelephone($assoc['telephone']);
			try {
				if (ArrayElemIsValidStr($assoc, 'last_visit_time')) $ob->SetLastVisitTime(strtotime($assoc['last_visit_time']));
				if (ArrayElemIsValidStr($assoc, 'register_time')) $ob->SetRegisterTime(strtotime($assoc['register_time']));
				if (ArrayElemIsValidStr($assoc, 'birthday')) $ob->SetBirthday(strtotime($assoc['birthday']));
			} catch(Exception $e) {
				$ob->last_visit_time = time_undef;
				$ob->register_time = time_undef;
				$ob->birthday = time_undef;
			}
			if (ArrayElemIsValidStr($assoc, 'id')) $ob->SetPathToPhoto(PathToImage($link_to_users_images.$ob->id, 'avatar', $link_to_users_images.'common/default_avatar.png'));
			return $ob;
		}

		public static function FetchBy($kwargs)
		{
			$unique_call = function($kw, $rc) {
				$res_count = count($rc);
				if ($res_count > 1) return new Error('', Error::ambiguously);
				if ($res_count === 0) return new Error('', Error::not_found);
				return true;
			};

			$special_call = function($kw, $rc) {
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
						case 'link_to_full': {
							if ($is_assoc === false) break;
							for ($j = 0; $j < $res_count; ++$j) {
								if (isset($rc[$j]['id']) && isset($rc[$j]['name']) && isset($rc[$j]['surname'])) {
									$rc[$j]['link_to_full'] = self::LinkToThisUnsafe($rc[$j]['id'], $rc[$j]['name'], $rc[$j]['surname'], 'btn-sm', array('style' => 'color: black;'));
								}
							}
							break;
						}
						default: break;
					}
				}
				return $rc;
			};

			$tmp = $kwargs;
			$tmp['is_unique_callback'] = $unique_call;
			$tmp['class_parent'] = new User;
			$tmp['special_callback'] = $special_call;
			return FetchBy($tmp);
		}

		public static function ArrayFromDBResult($result, $is_assoc = false)
		{
			$res = array();
			while ($row = $result->fetch_assoc()) {
				if ($is_assoc) {
					array_push($res, $row);
				}
				else array_push($res, self::FetchFromAssoc($row));
			}
			return $res;
		}

		public static function FetchLike($prefix, $kwargs = array())
		{
			global $db_connection;

			$parts = array_map('trim', preg_split('/\s+/', $prefix));
			array_filter($parts);
			$where_clause = '';
			for ($i = 0, $size = count($parts); $i < $size; ++$i) if ($parts[$i] === '') unset($parts[$i]);
			$parts = array_values($parts);

			for ($i = 0, $size = count($parts); $i < $size; ++$i) {
				$where_clause .= ' (LOWER(name) LIKE LOWER("'.$parts[$i].'%")) OR (LOWER(surname) LIKE LOWER("'.$parts[$i].'%")) OR (translit(LOWER(name)) LIKE LOWER("'.$parts[$i].'%")) OR (translit(LOWER(surname)) LIKE LOWER("'.$parts[$i].'%")) ';
				if ($i < $size - 1) $where_clause .= 'OR';
			}
			$select_list = '*';
			$kwargs['where_addition'] = $where_clause;

			return self::FetchBy($kwargs);
		}

		public static function FetchAllEmployes()
		{
			global $db_connection;
			$result = $db_connection->query("SELECT * FROM `".User::$table."` WHERE position<>".NotEmployeeNum." AND position<>0 ORDER BY position DESC, surname, name, fathername");
			if (!$result) {
				return NULL;
			}
			return User::ArrayFromDBResult($result);
		}

		public function FetchFromAssocEditing($assoc)
		{
			if (ArrayElemIsValidStr($assoc, 'name')) $this->name = $assoc['name'];
			if (ArrayElemIsValidStr($assoc, 'surname')) $this->surname = $assoc['surname'];
			if (ArrayElemIsValidStr($assoc, 'fathername')) $this->fathername = $assoc['fathername'];
			if (ArrayElemIsValidStr($assoc, 'login')) $this->login = $assoc['login'];
			if (ArrayElemIsValidStr($assoc, 'position')) $this->position = $assoc['position'];
			if (ArrayElemIsValidStr($assoc, 'email')) $this->email = $assoc['email'];
			if (ArrayElemIsValidStr($assoc, 'telephone')) $this->telephone = $assoc['telephone'];
			if (ArrayElemIsValidStr($assoc, 'birth_day') && (ArrayElemIsValidStr($assoc, 'birth_month')) && (ArrayElemIsValidStr($assoc, 'birth_year'))) {
				$this->birthday = strtotime($assoc['birth_month'].'/'.$assoc['birth_day'].'/'.$assoc['birth_year']);
			}

			if (ArrayElemIsValidStr($assoc, 'password_old')) {
				if (!password_verify($assoc['password_old'], $this->password)) {
					return -1;
				}
				if ((!ArrayElemIsValidStr($assoc, 'password_new1'))
					|| (!ArrayElemIsValidStr($assoc, 'password_new2')) ||
					($assoc['password_new1'] != $assoc['password_new2'])) {
					return -1;
				}
				$this->password = password_hash($assoc['password_new1'], PASSWORD_DEFAULT);
			}
		}

		public function FetchPhotoFromAssocEditing($assoc)
		{
			if (isset($assoc['img']['name']) && (is_uploaded_file($assoc['img']['tmp_name']))) {
				global $link_to_users_images;
				$img_name = 'avatar';
				$sepext = explode('.', strtolower($assoc['img']['name']));
			    $type = end($sepext);
			    $img_name .= '.'.$type;
			    $upload_path = $link_to_users_images.$this->id.'/'.$img_name;
			    if (!delete_image($link_to_users_images.$this->id.'/avatar')) {
			    	return -1;
			    } else if (!move_uploaded_file($assoc['img']['tmp_name'], $upload_path)) {
			    	return -1;
			    } else {
			    	return 1;
			    }
			}
			return 0;
		}

		public static function InsertToDB($request)
		{
			global $db_connection;
			global $link_to_users_images;
			$name = $db_connection->real_escape_string($request->name);
			$surname = $db_connection->real_escape_string($request->surname);
			$fathername = $db_connection->real_escape_string($request->fathername);
			$login = $db_connection->real_escape_string($request->login);
			$email = $db_connection->real_escape_string($request->email);
			$telephone = $db_connection->real_escape_string($request->telephone);
			$res = $db_connection->query("INSERT INTO `".User::$table."` (`id`, `name`, `surname`, `fathername`, `login`, `password`, `position`, `email`, `telephone`, `register_time`, `last_visit_time`) VALUES ('0', '".$name."', '".$surname."', '".$fathername."', '".$login."', '".$request->password."', ".NewEmployeeNum.", '".$email."', '".$telephone."', CURRENT_TIMESTAMP, CURRENT_TIMESTAMP)");
			@mkdir($link_to_users_images.($db_connection->insert_id));
			@mkdir($link_to_users_images.($db_connection->insert_id).'/blocks');
			if (!$res) {
				return false;
			}
			$request->id = $db_connection->insert_id;
			return true;
		}


		public function ToHTMLEditing()
		{
			global $user_blocks_in_db;
			global $link_to_admin_user_block;
			global $positions;
			global $link_to_utility_sql_worker;
			$positions = Language::GetPositions();

			$res = '';
			$res .= '<form method="post" action="'.$link_to_utility_sql_worker.'" enctype="multipart/form-data">';
			$res .= 	'<div class="row">';
			$res .= 		'<div class="'.ColAllTypes(1).'"></div>';
			$res .= 		'<div class="'.ColAllTypes(5).' vcenter" align="right">';
			$res .= 			'<div class="row">';
			$res .=					'<img src="'.($this->path_to_photo).'" class="img-rounded img-avatar">';
			$res .= 			'</div>';
			$res .= 			'<div class="row">';
			$res .= 				PairLabelAndInputFile(3, 5, Language::Word('upload image'), 'img');
			$res .= 			'</div>';
			$res .= 		'</div>';
			$res .= 		'<div class="'.ColAllTypes(5).' vcenter" align="left">';
			$res .= 			PairLabelAndInput(2, 10, Language::Word('name'), 'name', Language::Word('insert name'), $this->name);
			$res .= 			PairLabelAndInput(2, 10, Language::Word('surname'), 'surname', Language::Word('insert surname'), $this->surname);
			$res .= 			PairLabelAndInput(2, 10, Language::Word('fathername'), 'fathername', Language::Word('insert fathername'), $this->fathername);
			if (($this->login != 'admin') && (GetUserLogin() == 'admin')) {
				$tmp = User::FetchAllByPosition(DirectorPositionNum);
				if ((($tmp != NULL) || (GetUserLogin() != 'admin')) && ($this->position != DirectorPositionNum)) {
					unset($positions[DirectorPositionNum]);
				}

				$res .= 		PairLabelAndSelect(2, 10, Language::Word('position'), 'position', 
									$positions, $selected_field = array($this->position,
									$positions[$this->position]));
			} else {
				$res .= 		PairLabelAndPanel(2, 10, Language::Word('position'), htmlspecialchars(Language::Position($this->position)));
			}
			$res .= 			PairLabelAndInput(2, 10, Language::Word('mail'), 'email', Language::Word('insert mail'), $this->email);
			$res .= 			PairLabelAndInput(2, 10, Language::Word('telephone'), 'telephone', Language::Word('insert telephone'), $this->telephone);
			if (($this->login == GetUserLogin()) && ($this->login != 'admin')) {
				$res .= 		PairLabelAndInput(2, 10, Language::Word('login'), 'login', Language::Word('insert login'), $this->login);
			} else {
				$res .= 		PairLabelAndPanel(2, 10, Language::Word('login'), $this->login);
			}
			$res .= 			PairLabelAndInput(2, 10, Language::Word('birthday'), 'birth_day', 'dd', date('j', $this->birthday));
			$res .= 			PairLabelAndInput(2, 10, Language::Word('birthmonth'), 'birth_month', 'mm', date('n', $this->birthday));
			$res .= 			PairLabelAndInput(2, 10, Language::Word('birthyear'), 'birth_year', 'yyyy', date('Y', $this->birthday));	

			if ($this->login == GetUserLogin()) {
				$res .= 		PairLabelAndPassword(4, 8, Language::Word('old password'), 'password_old', Language::Word('only for password changing'));
				$res .= 		PairLabelAndPassword(4, 8, Language::Word('new password'), 'password_new1', Language::Word('only for password changing'));
				$res .= 		PairLabelAndPassword(4, 8, Language::Word('repeat new password'), 'password_new2', Language::Word('only for password changing'));
			}

			$res .= 		'</div>';
			$res .= 	'</div>';
			$res .= 	DialogInputsYesNo('edit', $_POST['type'], $_POST['id'], Language::Word('save'), Language::Word('cancel'));
			$res .= '</form>';
			return $res;
		}
		
		public function Save()
		{
			global $db_connection;
			$res = $db_connection->query("SELECT `id` FROM `".User::$table."` WHERE (`login`=\"".$this->login."\") AND (`id`!=".$this->id.")");
			if (!$res) {
				echo $db_connection->error;
				return false;
			} else {
				if ($res->num_rows > 0) {
					echo 'already exist';
					return false;
				}
			}
			$name_tmp 		= $db_connection->real_escape_string($this->name);
			$surname_tmp 	= $db_connection->real_escape_string($this->surname);
			$fathername_tmp = $db_connection->real_escape_string($this->fathername);
			$login_tmp 		= $db_connection->real_escape_string($this->login);
			$position_tmp 	= $db_connection->real_escape_string($this->position);
			$email_tmp 		= $db_connection->real_escape_string($this->email);
			$telephone_tmp 	= $db_connection->real_escape_string($this->telephone);
			$birth_day_tmp  = $db_connection->real_escape_string($this->birthday);
			$res = $db_connection->query("UPDATE `".User::$table."` SET `name`=\"".$name_tmp."\", `surname`=\"".$surname_tmp."\", `fathername`=\"".$fathername_tmp."\", `login`=\"".$login_tmp."\", `password` = \"".$this->password."\", `position`=\"".$position_tmp."\", `email`=\"".$email_tmp."\", `telephone`=\"".$telephone_tmp."\", `last_visit_time`= NOW(), `birthday`=\"".date('Y-m-d H:i:s', $birth_day_tmp)."\" WHERE `id`=".$this->id);
			if (!$res) {
				echo $db_connection->error;
				return false;
			}
			return true;
		}

		public static function Delete($id)
		{
			global $db_connection;
			global $link_to_users_images;
			global $languages;

			if (!$db_connection->query("DELETE FROM `".User::$table."` WHERE `id` = ".$id)) {
				echo $db_connection->error;
				return 0;
			} else {
				foreach ($languages as $key => $value) {
					$from_table = UserBlock::$table;
					if ($key !== 'rus') $from_table .= '_'.$key;
					if (!$db_connection->query("DELETE FROM `".$from_table."` WHERE `author_id` = ".$id)) {
						echo $db_connection->error;
						return 0;
					}
				}
				removeDirectory($link_to_users_images.$id);
				return 1;
			}
		}

	}
?>