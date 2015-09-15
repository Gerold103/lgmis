<?php

	//------------------------------------------------U S E R------------------------------------------------
	
	class User implements IAdminHTML, IUserHTML, IAutoHTML, IDelEdit, ISQLOps {
		//Describes logic of registered user. Implements methods for fetching users from DB, creating new users, 
		//deleting old ones, containing information about every concrete user.
		
		//--------Attributes--------
		
		public  $id              = id_undef;
		public  $name            = undef;
		public  $surname         = undef;
		public  $fathername      = undef;
		public  $login           = undef;
		public  $password		 = undef;
		private $position        = undef;
		private $email           = undef;
		private $telephone       = undef;
		private $register_time   = time_undef;
		private $last_visit_time = time_undef;
		private $birthday        = time_undef;

		public  $path_to_photo   = undef;
		
		public static $type = 'user';
		public static $table = 'users';

		public static $last_error = '';

		public function GetCount()
		{
			global $db_connection;
			$res = $db_connection->query("SELECT COUNT(*) FROM ".User::$table);
			if ($res) {
				if ($res->num_rows > 0) {
					return $res->fetch_row()[0];
				}
				User::$last_error = Language::Word('no users');
				return 0;
			}
			User::$last_error = $db_connection->error;
			return 0;
		}

		public function GetPosition()
		{
			global $positions;
			return Language::Position($this->position);
		}

		public function GetLastVisitTime()
		{
			return date('d : m : Y - H : i', $this->last_visit_time);
		}

		public function GetRegisterTime()
		{
			return date('d : m : Y - H : i', $this->register_time);
		}

		public function GetBirthday(){
			return date('d : m : Y', $this->birthday);
		}

		public function GetEmail()
		{
			return $this->email;
		}

		public function GetTelephone()
		{
			return $this->telephone;
		}
		
		//--------Methods--------
		
		//html code of full representation of object in string
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

		public function ToHTMLAutoShort($user_privileges)
		{
			switch ($user_privileges) {
				case admin_user_id:
					return $this->ToHTMLAdminShort();
				case unauthorized_user_id:
					return $this->ToHTMLUserPublicShort();
				case simple_user_id:
					return $this->ToHTMLUserPrivateShort();
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

		public function ToHTMLAdminFull() { return html_undef; }
		//html code of short representation of object in string
		public function ToHTMLAdminShort()
		{
			global $positions;

			$res = '';
			$res .= '<div class="row">';
			$res .=		'<div class="'.ColAllTypes(12).'">';
			$res .= 		'<b>name</b>: '.Language::Translit(htmlspecialchars($this->name).', <b>surname</b>: '.htmlspecialchars($this->surname).', <b>fathername</b>: '.htmlspecialchars($this->fathername)).';<br>';
			$res .= 		'<b>position</b>: '.htmlspecialchars($positions[$this->position]).'<br>';
			$res .=		'</div>';
			$res .= '</div>';
			$res .= '<div class="row">';
			$res .=		'<div class="'.ColOffsetAllTypes(3).' '.ColAllTypes(2).'" align="right">';
			$res .= 		$this->ToHTMLDel();
			$res .= 	'</div>';
			$res .=		'<div class="'.ColAllTypes(2).'" align="center">';
			$res .= 		$this->ToHTMLEdit();
			$res .= 	'</div>';
			$res .=		'<div class="'.ColAllTypes(2).'" align="left">';
			$res .= 		$this->ToHTMLFullVers();
			$res .=		'</div>';
			$res .= '</div>';
			return $res;
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
				// $res .= 	'<div class="'.ColAllTypes(5).'">';
				// 	$args = array(
				// 		'action_link' => $link_to_admin_bookkeeping,
				// 		'action_type' => 'full',
				// 		'obj_type' => Report::$type,
				// 		'id' => $this->id,
				// 		'btn_text' => Language::Word('bookkeeping'),
				// 		'btn_size' => 'btn-lg',
				// 		'method' => 'get',
				// 	);
				// $res .= 		'<span style="margin: 3px;">'.ActionButton($args).'</span>';
				// $res .= 	'</div>';
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
		
		//html code of full representation of object in string within internal pages of lgmis
		public function ToHTMLUserPrivateFull() { return html_undef; }

		//html code of short representation of object in string within internal pages of lgmis
		public function ToHTMLUserPrivateShort()
		{
			$res = '';
			$res .= '<b>name</b>: '.htmlspecialchars($this->name).', <b>surname</b>: '.htmlspecialchars($this->surname).', <b>fathername</b>: '.htmlspecialchars($this->fathername).';<br>';
			$res .= '<b>position</b>: '.htmlspecialchars($this->position).'<br>';
			if (GetUserLogin() == $this->login) {
				$res .= $this->ToHTMLDel();
				$res .= $this->ToHTMLEdit();
			}
			$res .= $this->ToHTMLFullVers();
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
			if ($this->login != 'admin') {
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
		
		//html code of full representation of object in string within public pages of lgmis
		public function ToHTMLUserPublicFull() { return html_undef; }
		//html code of short representation of object in string within public pages of lgmis
		public function ToHTMLUserPublicShort() { return html_undef; }
		
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

		public function ToHTMLFullVers()
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
					'obj_type' => User::$type,
					'id' => $this->id,
					'prev_page' => $link_to_contacts,
					'btn_text' => Language::Word('open profile'),
					'method' => 'get',
					'mod_rewrite' => $mod_rewrite,
				);
			} else {
				$args = array(
					'action_link' => $link_to_admin_user,
					'action_type' => 'full',
					'obj_type' => User::$type,
					'id' => $this->id,
					'prev_page' => $link_to_admin_manage_staff,
					'method' => 'get',
				);
			}
			return ActionButton($args);
		}

		public static function FetchFromAssoc($assoc)
		{
			global $link_to_users_images;
			if ((!ArrayElemIsValidStr($assoc, 'name')) || (!ArrayElemIsValidStr($assoc, 'surname')) || (!ArrayElemIsValidStr($assoc, 'fathername'))
				|| (!ArrayElemIsValidStr($assoc, 'login')) || (!ArrayElemIsValidStr($assoc, 'password')) || (!ArrayElemIsValidStr($assoc, 'position'))
				|| (!ArrayElemIsValidStr($assoc, 'email')) || (!ArrayElemIsValidStr($assoc, 'register_time'))
				|| (!ArrayElemIsValidStr($assoc, 'last_visit_time')) || (!ArrayElemIsValidStr($assoc, 'birthday'))) {
				return NULL;
			}
			$usr = new self();
			if (isset($assoc['id']) && (strlen($assoc['id']))) $usr->id = $assoc['id'];
			else $usr->id = id_undef;
			$usr->name = $assoc['name'];
			$usr->surname = $assoc['surname'];
			$usr->fathername = $assoc['fathername'];
			$usr->login = $assoc['login'];
			$usr->password = $assoc['password'];
			$usr->position = $assoc['position'];
			$usr->email = $assoc['email'];
			$usr->telephone = $assoc['telephone'];
			try {
				$usr->last_visit_time = strtotime($assoc['last_visit_time']);
				$usr->register_time = strtotime($assoc['register_time']);
				$usr->birthday = strtotime($assoc['birthday']);
			} catch(Exception $e) {
				$usr->last_visit_time = time_undef;
				$usr->register_time = time_undef;
				$usr->birthday = time_undef;
			}
			$usr->path_to_photo = PathToImage($link_to_users_images.$usr->id, 'avatar', $link_to_users_images.'common/default_avatar.png');
			return $usr;
		}

		public static function FetchFromPost()
		{
			return User::FetchFromAssoc($_POST);
		}

		private static function ArrayFromDBResult($result)
		{
			$res = array();
			while ($row = $result->fetch_assoc()) {
				array_push($res, User::FetchFromAssoc($row));
			}
			return $res;
		}

		public static function FetchAllByPosition($pos)
		{
			global $db_connection;
			$pos_tmp = $db_connection->real_escape_string($pos);

			$result = $db_connection->query("SELECT * FROM ".User::$table." WHERE position='".$pos_tmp."'");
			if ($result->num_rows < 1) {
				return NULL;
			}
			return User::ArrayFromDBResult($result);
		}
		
		public static function FetchByLogin($login)
		{
			global $db_connection;
			$login_tmp = $db_connection->real_escape_string($login);

			$result = $db_connection->query("SELECT * FROM users WHERE login='".$login_tmp."'");
			if ((!$result) || ($result->num_rows < 1)) {
				return NULL;
			}
			$row = $result->fetch_assoc();
			$user = User::FetchFromAssoc($row);

			if (!$db_connection->query("UPDATE ".User::$table." SET `last_visit_time` = NOW() WHERE `id` = ".$user->id.";")) {
				return AlertMessage('alert-danger', 'Ошибка при обновлении времени последнего визита пользователя');
			}
			return $user;
		}
		
		public static function FetchByID($id)
		{
			global $db_connection;
			$res = NULL;
			$result = $db_connection->query("SELECT * FROM `".User::$table."` WHERE `id`=".$id);
			if ((!$result) || ($result->num_rows != 1)) {
				return NULL;
			}
			return User::FetchFromAssoc($result->fetch_assoc());
		}

		public static function Fetch($from, $count)
		{
			global $db_connection;
			$res = array();
			$result = $db_connection->query("SELECT * FROM ".User::$table." ORDER BY position DESC, surname, name, fathername LIMIT ".$from.", ".$count);
			if (!$result) {
				return NULL;
			}
			while ($row = $result->fetch_assoc()) {
				array_push($res, User::FetchFromAssoc($row));
			}
			return $res;
		}

		public static function FetchAll()
		{
			global $db_connection;
			$result = $db_connection->query("SELECT * FROM `".User::$table."` ORDER BY position DESC, surname, name, fathername");
			if (!$result) {
				return NULL;
			}
			return User::ArrayFromDBResult($result);
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

		public static function GetIDByLogin($login)
		{
			$user = User::FetchByLogin($login);
			if ($user == NULL) return NULL;
			return $user->id;
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

		public function LinkToThis($link_size = 'btn-md')
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
					'obj_type' => User::$type,
					'id' => $this->id,
					'lnk_text' => Language::Translit(($this->surname).' '.($this->name)),
					'lnk_size' => $link_size,
					'method' => 'get',
					'mod_rewrite' => $mod_rewrite,
				);
			} else {
				$args = array(
					'action_link' => $link_to_admin_user,
					'action_type' => 'full',
					'obj_type' => User::$type,
					'id' => $this->id,
					'lnk_text' => Language::Translit(($this->surname).' '.($this->name)),
					'lnk_size' => $link_size,
					'method' => 'get',
				);
			}
			return ActionLink($args);
		}
	}
?>