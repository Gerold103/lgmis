<?php
	//------------------------------------------------R E Q U E S T   O N   R E G I S T E R------------------------------------------------
	
	class RequestOnRegister implements IAdminHTML, IAutoHTML, IDelEdit, ISQLOps {
		//Methods and attributes for working with requests on register from new users.
		
		//--------Attributes--------
		
		public $id           = id_undef;
		public $name         = undef;
		public $surname      = undef;
		public $fathername   = undef;
		public $login 		  = undef;
		public $password 	  = undef;
		public $request_time = time_undef;
		public $email        = undef;
		public $telephone    = undef;
		public $text 		  = undef;
		
		public static $type = 'req_on_reg';
		public static $table = 'register_requests';

		public static $last_error = '';
		
		//--------Methods--------

		//html code of full representation of object in string
		public function ToHTMLAutoFull($user_privileges)
		{
			switch ($user_privileges) {
				case admin_user_id:
					return $this->ToHTMLAdminFull();
				default:
					return html_undef;
			}
		}

		public function ToHTMLAutoShort($user_privileges)
		{
			switch ($user_privileges) {
				case admin_user_id:
					return $this->ToHTMLAdminShort();
				default:
					return html_undef;
			}
		}

		public function ToHTMLAutoShortForTable($user_privileges)
		{
			switch ($user_privileges) {
				case admin_user_id:
					return $this->ToHTMLAdminShortInTable();
				default:
					return html_undef;
			}
		}
		
		//html code of full representation of object in string
		public function ToHTMLAdminFull() { return html_undef; }

		//html code of short representation of object in string
		public function ToHTMLAdminShort()
		{
			return $this->ToHTMLAdminFull();
		}

		public function ToHTMLAdminShortInTable()
		{
			$res = '<tr>';
			$res .= '<td>'.htmlspecialchars($this->surname).' '.htmlspecialchars($this->name).'</td>';
			$res .= '<td>'.date('d : m : Y - H : i', $this->creating_date).'</td>';
			$res .= '<td>';
			$res .= 	PopOverButton($this->text, 'Посмотреть', 'btn-info btn-sm');
			$res .= '</td>';
			$res .= '<td>'.htmlspecialchars($this->email).'</td>';
			$res .=	'<td>'.htmlspecialchars($this->telephone).'</td>';
			$res .= '<td>';
			$res .=	$this->ToHTMLDel();
			$res .= '</td>';
			$res .= '</tr>';
			return $res;
		}
		
		public function ToHTMLDel()
		{
			global $link_to_utility_interceptor;
			$res = '<div class="row">';
			$res .=	'<div class="'.ColAllTypes(6).'">';
			$argsdel = array(
				'action_link' => $link_to_utility_interceptor,
				'action_type' => 'del',
				'obj_type' => RequestOnRegister::$type,
				'id' => $this->id,
				'btn_text' => 'Отклонить',
				'info' => 'Вы уверены, что хотите отклонить запрос пользователя '.$this->name.'?',
				'method' => 'get',
			);
			$res .= ActionButton($argsdel);
			$res .=	'</div>';
			$res .=	'<div class="'.ColAllTypes(6).'">';
			
			$argsadd = array(
				'action_link' => $link_to_utility_interceptor,
				'action_type' => 'add',
				'obj_type' => RequestOnRegister::$type,
				'id' => $this->id,
				'btn_text' => 'Принять',
				'info' => 'Вы уверены, что хотите принять запрос пользователя '.$this->name.'?',
				'method' => 'get',
			);
			return $res.ActionButton($argsadd).'</div></div>';
		}
		
		public function ToHTMLEdit() { return html_undef; }

		public function ToHTMLFullVers() { return html_undef; }

		public static function FetchFromAssoc($assoc)
		{
			if (!ArrayElemIsValidStr($assoc, 'name')) {
				RequestOnRegister::$last_error = 'Поле "Имя" не заполнено';
				return NULL;
			}
			if (!ArrayElemIsValidStr($assoc, 'surname')) {
				RequestOnRegister::$last_error = 'Поле "Фамилия" не заполнено';
				return NULL;
			}
			if (!ArrayElemIsValidStr($assoc, 'fathername')) {
				RequestOnRegister::$last_error = 'Поле "Отчество" не заполнено';
				return NULL;
			}
			if (!ArrayElemIsValidStr($assoc, 'login')) {
				RequestOnRegister::$last_error = 'Поле "Логин" не заполнено';
				return NULL;
			}
			if (!ArrayElemIsValidStr($assoc, 'password')) {
				RequestOnRegister::$last_error = 'Поле "Пароль" не заполнено';
				return NULL;
			}
			if (!ArrayElemIsValidStr($assoc, 'email')) {
				RequestOnRegister::$last_error = 'Поле "Email" не заполнено';
				return NULL;
			}
			if (!ArrayElemIsValidStr($assoc, 'telephone')) {
				RequestOnRegister::$last_error = 'Поле "Телефон" не заполнено';
				return NULL;
			}
			$req = new self();
			if (isset($assoc['id']) && (strlen($assoc['id']))) $req->id = $assoc['id'];
			else $req->id = id_undef;
			$req->name = $assoc['name'];
			$req->surname = $assoc['surname'];
			$req->fathername = $assoc['fathername'];
			$req->login = $assoc['login'];
			$req->password = $assoc['password'];
			$req->email = $assoc['email'];
			$req->telephone = $assoc['telephone'];
			if (!isset($assoc['text'])) $req->text = '';
			else $req->text = $assoc['text'];
			return $req;
		}

		public static function FetchFromPost()
		{
			return RequestOnRegister::FetchFromAssoc($_POST);
		}
		
		public static function FetchByID($id)
		{
			global $db_connection;
			$res = NULL;
			$result = $db_connection->query("SELECT * FROM `".RequestOnRegister::$table."` WHERE `id`=".$id);
			if ((!$result) || ($result->num_rows != 1)) {
				return NULL;
			}
			return RequestOnRegister::FetchFromAssoc($result->fetch_assoc());
		}

		public static function FetchAll()
		{
			global $db_connection;
			$res = array();
			$result = $db_connection->query("SELECT * FROM `".RequestOnRegister::$table."`");
			if (!$result) {
				return NULL;
			}
			while ($row = $result->fetch_assoc()) {
				array_push($res, RequestOnRegister::FetchFromAssoc($row));
			}
			return $res;
		}

		public static function FormForCreating()
		{
			global $link_to_utility_sql_worker;
			$res = '';
			$res .= '<form method="post" action="'.$link_to_utility_sql_worker.'">';
			$res .= 	WrapToHiddenInputs(array('type' => RequestOnRegister::$type));
			$res .= 	PairLabelAndInput(4, 5, 'Ваше имя', 'name', 'Имя').'<br>';
			$res .= 	PairLabelAndInput(4, 5, 'Ваша фамилия', 'surname', 'Фамилия').'<br>';
			$res .= 	PairLabelAndInput(4, 5, 'Ваше отчество', 'fathername', 'Отчество').'<br>';
			$res .= 	PairLabelAndInput(4, 5, 'Ваш логин', 'login', 'Логин').'<br>';
			$res .= 	PairLabelAndPassword(4, 5, 'Введите пароль', 'password', 'Пароль').'<br>';
			$res .= 	PairLabelAndInput(4, 5, 'Ваш адрес электронной почты', 'email', 'example@mail.ru').'<br>';
			$res .= 	PairLabelAndInput(4, 5, 'Ваш телефон', 'telephone', '8-123-456-78-90').'<br>';
			$res .= 	PairLabelAndTextarea(4, 5, 'Комментарий к заявке', 'text').'<br>';
			$res .= 	'<div class="row">';
			$res .= 		'<input type="submit" class="btn btn-primary btn-lg" name="new" value="Отправить заявку">';
			$res .= 	'</div>';
			$res .= '</form>';
			return $res;
		}

		public function InsertToDB()
		{
			global $db_connection;


			$res = User::FetchByLogin($this->login);
			if ($res !== NULL) {
				RequestOnRegister::$last_error = 'Пользователь с таким логином уже существует в системе';
				return false;
			}

			$name_tmp 		= $db_connection->real_escape_string($this->name);
			$surname_tmp 	= $db_connection->real_escape_string($this->surname);
			$fathername_tmp = $db_connection->real_escape_string($this->fathername);
			$login_tmp 		= $db_connection->real_escape_string($this->login);
			$email_tmp 		= $db_connection->real_escape_string($this->email);
			$telephone_tmp 	= $db_connection->real_escape_string($this->telephone);
			$text_tmp 		= $db_connection->real_escape_string($this->text);
			$res = $db_connection->query("INSERT INTO `register_requests`
				(`name`, `surname`, `fathername`, `login`, `password`, `request_time`, `email`, `telephone`, `text`)
				VALUES
				('".$name_tmp."', '".$surname_tmp."', '".$fathername_tmp."',
					'".$login_tmp."', '".password_hash($this->password, PASSWORD_DEFAULT)."', CURRENT_TIMESTAMP, '".$email_tmp."', '".$telephone_tmp."',
					'".$text_tmp."')");
			if (!$res) {
				RequestOnRegister::$last_error = $db_connection->error;
				return false;
			}
			return true;
		}
		
		public function Save() { return sql_error; }

		public static function Delete($id)
		{
			global $db_connection;
			if (!$db_connection->query("DELETE FROM `".RequestOnRegister::$table."` WHERE `id` = ".$id)) {
				return 0;
			} else {
				return 1;
			}
		}
	}
?>