<?php
	//------------------------------------------------U S E R   B L O C K------------------------------------------------
	
	class UserBlock implements IAdminHTML, IUserHTML, IAutoHTML, IDelEdit, ISQLOps {
		//Containing logic for actions with blocks on registered user page.
		
		//--------Attributes--------
		
		private $id            = id_undef;
		public  $author_id     = id_undef;
		public  $name          = undef;
		public  $text_block    = undef;
		public  $priority      = undef;
		public 	$creating_date = undef;

		public static $type = 'user_block';
		public static $table = 'user_blocks';
		
		//--------Methods--------
		
		public function ToHTMLAutoFull($user_privileges)
		{
			switch ($user_privileges) {
				case admin_user_id:
					return $this->ToHTMLAdminFull();
				case unauthorized_user_id:
					return $this->ToHTMLUserPublicFull();
				case simple_user_id:
					return $this->ToHTMLUserPrivateFull();
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
				case admin_user_id:
					return $this->ToHTMLAdminShortInTable();
				case unauthorized_user_id:
					return html_undef;
				case simple_user_id:
					return $this->ToHTMLUserPrivateShortInTable();
				default:
					return html_undef;
			}
		}

		//html code of full representation of object in string
		public function ToHTMLAdminFull()
		{
			$res = '';
			$res .= '<b>id</b>: '.$this->id.'; <b>author_id</b>: '.$this->author_id.';<br>';
			$res .= '<b>name</b>: '.htmlspecialchars($this->name).';<br>';
			$res .= '<b>text_block</b>: '.$this->text_block.';<br>';
			$res .= '<b>priority</b>: '.$this->priority.';<br>';
			$res .= $this->ToHTMLDel();
			$res .= $this->ToHTMLEdit();
			return $res;
		}
		//html code of short representation of object in string
		public function ToHTMLAdminShort()
		{
			$res = '';
			$res .= '<b>id</b>: '.$this->id.'; <b>author_id</b>: '.$this->author_id.';<br>';
			$res .= '<b>name</b>: '.htmlspecialchars($this->name).';<br>';
			$res .= $this->ToHTMLDel();
			$res .= $this->ToHTMLEdit();
			$res .= $this->ToHTMLFullVers();
			return $res;
		}

		public function ToHTMLAdminShortInTable()
		{
			$res = '';
			$res .= '<div class="row">';
			$res .= 	'<div class="'.ColAllTypes(1).'"></div>';
			$res .= 	'<div class="'.ColAllTypes(10).'">';
			$res .= 		'<div class="panel panel-default"><div class="panel-body">';
			$res .= 			'<div class="panel panel-default">';
			$res .=					'<div class="panel-heading" role="tab" id="'.$this->id.'">';
			$res .=						'<div class="panel-title">';
			$res .=							'<a data-toggle="collapse" data-parent="#accordion" href="#collapse'.$this->id.'" aria-expanded="false" aria-controls="collapse'.$this->id.'" class="collapsed">';
			$res .=								'<div class="row">';
			$res .=									'<div class="'.ColAllTypes(7).'">';
			$res .= 									ToPageHeader(htmlspecialchars($this->name), 'h3', 'black');
			$res .= 								'</div>';
			$res .= 								'<div class="'.ColAllTypes(5).'">';
			$res .= 									ToPageHeader('Ранг: '.$this->priority, 'h4', 'grey');
			$res .= 								'</div>';
			$res .= 							'</div>';
			$res .=							'</a>';
			$res .= 					'</div>';
			$res .= 				'</div>';

			$res .= 				'<div id="collapse'.$this->id.'" class="panel-collapse collapse" role="tabpanel" aria-labelledby="'.$this->id.'" style="height: 0px;" aria-expanded="false">';
			$res .=						'<div class="panel-body">';
			$res .= 						$this->text_block;
			$res .= 					'</div>';
			$res .=					'</div>';
			$res .=				'</div>';
			$res .= 			'<div class="row">';
			$res .=					'<div class="'.ColAllTypes(6).'" align="right">';
			$res .=						$this->ToHTMLEdit();
			$res .=					'</div>';
			$res .=					'<div class="'.ColAllTypes(6).'" align="left">';
			$res .=						$this->ToHTMLDel();
			$res .=					'</div>';
			$res .= 			'</div>';
			$res .=			'</div></div>';
			$res .= 	'</div>';
			$res .= '</div>';
			return $res;
		}

		//html code of full representation of object in string within internal pages of lgmis
		public function ToHTMLUserPrivateFull()
		{
			$res = '';
			$author_login = User::FetchByID($this->author_id)->login;
			if (GetUserLogin() == $author_login) $res .= '<b>id</b>: '.$this->id.'; ';
			$res .= '<b>author_id</b>: '.$this->author_id.';<br>';
			$res .= '<b>name</b>: '.htmlspecialchars($this->name).';<br>';
			$res .= '<b>priority</b>: '.$this->priority.';<br>';
			$res .= '<b>text_block</b>: '.$this->text_block.';<br>';
			if (GetUserLogin() == $author_login) { 
				$res .= $this->ToHTMLDel();
				$res .= $this->ToHTMLEdit();
			}
			return $res;
		}
		//html code of short representation of object in string within internal pages of lgmis
		public function ToHTMLUserPrivateShort()
		{
			$res = '';
			$author_login = User::FetchByID($this->author_id)->login;
			if (GetUserLogin() == $author_login) $res .= '<b>id</b>: '.$this->id.'; ';
			$res .= '<b>author_id</b>: '.$this->author_id.';<br>';
			$res .= '<b>name</b>: '.htmlspecialchars($this->name).';<br>';
			$res .= '<b>priority</b>: '.$this->priority.';<br>';
			if (GetUserLogin() == $author_login) {
				$res .= $this->ToHTMLDel();
				$res .= $this->ToHTMLEdit();
			}
			$res .= $this->ToHTMLFullVers();
			return $res;
		}

		public function ToHTMLUserPrivateShortInTable()
		{
			$author_login = User::FetchByID($this->author_id)->login;
			$res = '';
			$res .= '<div class="row">';
			$res .= 	'<div class="'.ColAllTypes(1).'"></div>';
			$res .= 	'<div class="'.ColAllTypes(10).'">';
			$res .= 		'<div class="panel panel-default"><div class="panel-body">';
			$res .= 			'<div class="panel panel-default">';
			$res .=					'<div class="panel-heading" role="tab" id="'.$this->id.'">';
			$res .=						'<div class="panel-title">';
			$res .=							'<a data-toggle="collapse" data-parent="#accordion" href="#collapse'.$this->id.'" aria-expanded="false" aria-controls="collapse'.$this->id.'" class="collapsed">';
			if (GetUserLogin() === $author_login) {
				$res .= 						'<div class="row">';
				$res .= 							'<div class="'.ColAllTypes(7).'">';
			}
			$res .=										ToPageHeader(htmlspecialchars($this->name), 'h3', 'black');
			if (GetUserLogin() === $author_login) {
				$res .= 							'</div>';
				$res .= 							'<div class="'.ColAllTypes(5).'">';
				$res .= 								ToPageHeader('Ранг: '.$this->priority, 'h4', 'grey');
				$res .= 							'</div>';
				$res .= 						'</div>';
			}
			$res .=							'</a>';
			$res .= 					'</div>';
			$res .= 				'</div>';

			$res .= 				'<div id="collapse'.$this->id.'" class="panel-collapse collapse" role="tabpanel" aria-labelledby="'.$this->id.'" style="height: 0px;" aria-expanded="false">';
			$res .=						'<div class="panel-body">';
			$res .= 						$this->text_block;
			$res .= 					'</div>';
			$res .=					'</div>';
			$res .=				'</div>';
			if (GetUserLogin() === $author_login) {
				$res .= 		'<div class="row">';
				$res .=				'<div class="'.ColAllTypes(6).'" align="right">';
				$res .=					$this->ToHTMLEdit();
				$res .=				'</div>';
				$res .=				'<div class="'.ColAllTypes(6).'" align="left">';
				$res .=					$this->ToHTMLDel();
				$res .=				'</div>';
				$res .= 		'</div>';
			}
			$res .=			'</div></div>';
			$res .= 	'</div>';
			$res .= '</div>';
			return $res;
		}
		
		//html code of full representation of object in string within public pages of lgmis
		public function ToHTMLUserPublicFull()
		{
			$res = '';
			$res .= '<div align="left">'.ToPageHeader($this->name, 'h4', 'grey').'</div>';
			$res .= '<div class="row"><div class="'.ColAllTypes(12).'">';
			$res .= 	$this->text_block;
			$res .= '</div></div>';
			return $res;
		}
		//html code of short representation of object in string within public pages of lgmis
		public function ToHTMLUserPublicShort() { return html_undef; }

		public function ToHTMLDel()
		{
			global $link_to_utility_interceptor;
			$args = array(
				'action_link' => $link_to_utility_interceptor,
				'action_type' => 'del',
				'obj_type' => UserBlock::$type,
				'id' => $this->id,
				'info' => 'Вы уверены, что хотите удалить блок '.$this->name.'?',
			);
			return ActionButton($args);
		}
		public function ToHTMLEdit()
		{
			global $link_to_admin_user_block;
			$args = array(
				'action_link' => $link_to_admin_user_block,
				'action_type' => 'edit',
				'obj_type' => UserBlock::$type,
				'id' => $this->id,
			);
			return ActionButton($args);
		}
		public function ToHTMLFullVers()
		{
			global $link_to_admin_user_block;
			global $link_to_admin_manage_staff;
			$args = array(
				'action_link' => $link_to_admin_user_block,
				'action_type' => 'full',
				'obj_type' => UserBlock::$type,
				'id' => $this->id,
			);
			return ActionButton($args);
		}

		public static function FetchFromAssoc($assoc)
		{
			if ((!ArrayElemIsValidStr($assoc, 'author_id')) || (!ArrayElemIsValidStr($assoc, 'name')) ||
				(!ArrayElemIsValidStr($assoc, 'text_block')) || (!ArrayElemIsValidStr($assoc, 'priority'))) {
				return NULL;
			}
			$usr_blck = new self();
			if (ArrayElemIsValidStr($assoc, 'id')) $usr_blck->id = $assoc['id'];
			else $usr_blck->id = id_undef;
			$usr_blck->author_id = $assoc['author_id'];
			$usr_blck->name = $assoc['name'];
			$usr_blck->text_block = $assoc['text_block'];
			$usr_blck->priority = $assoc['priority'];
			try {
				if (ArrayElemIsValidStr($assoc, 'creating_date'))
					$usr_blck->creating_date = strtotime($assoc['creating_date']);
			} catch(Exception $e) {
				$usr_blck->creating_date = time_undef;
			}
			return $usr_blck;
		}

		public function FetchFromAssocEditing($assoc)
		{
			if (ArrayElemIsValidStr($assoc, 'name')) $this->name = $assoc['name'];
			if (ArrayElemIsValidStr($assoc, 'priority')) $this->priority = $assoc['priority'];
			if (ArrayElemIsValidStr($assoc, 'text_block')) $this->text_block = $assoc['text_block'];
		}

		//Methods for fetching
		public static function FetchByID($id)
		{
			global $db_connection;
			$result = $db_connection->query("SELECT * FROM `".UserBlock::$table."` WHERE id='".$id."'");
			if ($result->num_rows != 1) {
				return NULL;
			}
			return UserBlock::FetchFromAssoc($result->fetch_assoc());
		}

		public static function FetchFromPost() { return html_undef; }

		public static function FetchAll() { return html_undef; }

		public static function InsertToDB($request)
		{
			global $db_connection;
			global $link_to_users_images;
			$author_id 	= $db_connection->real_escape_string($request->author_id);
			$name 		= $db_connection->real_escape_string($request->name);
			$text_block = $db_connection->real_escape_string($request->text_block);
			$priority   = $db_connection->real_escape_string($request->priority);
			$res = $db_connection->query("INSERT INTO `".UserBlock::$table."` (`id`, `author_id`, `name`, `text_block`, `priority`, `creating_date`) VALUES ('0', '".$author_id."', '".$name."', '".$text_block."', '".$priority."', CURRENT_TIMESTAMP)");
			if (!$res) {
				return false;
			}
			$id = $db_connection->insert_id;

			$request->text_block = preg_replace('/tmp_(\d+)\//', $id.'/', $request->text_block);
			$text_block = $db_connection->real_escape_string($request->text_block);
			$res = $db_connection->query("UPDATE `".UserBlock::$table."` SET `text_block`=\"".$text_block."\" WHERE `id`=".$id);
			if (!$res) {
				echo $db_connection->error;
				$db_connection->query("DELETE FROM `".UserBlock::$table."` WHERE `id` = ".$id);
				return false;
			}

			$request->id = $id;
			$upload_path = '';
			recurse_copy($link_to_users_images.$request->author_id.'/blocks/tmp_'.User::GetIDByLogin(GetUserLogin()), $link_to_users_images.$request->author_id.'/blocks/'.$id);
			return true;
		}

		public static function FetchAllByAuthorID($id)
		{
			global $db_connection;
			$result = $db_connection->query("SELECT * FROM `".UserBlock::$table."` WHERE author_id='".$id."' ORDER BY priority DESC, creating_date DESC;");
			if ($result->num_rows < 1) {
				return NULL;
			}
			$res = array();
			for ($i = 0; $i < $result->num_rows; ++$i) {
				array_push($res, UserBlock::FetchFromAssoc($result->fetch_assoc()));
			}
			return $res;
		}

		public function __construct($id = id_undef, $author_id = id_undef, $name = undef, $text_block = undef)
		{
			$this->id = $id;
			$this->author_id = $author_id;
			$this->name = $name;
			$this->text_block = $text_block;
		}
		
		//Methods for pushing
		public function Save()
		{
			global $db_connection;
			$res = $db_connection->query("SELECT `id` FROM `".UserBlock::$table."` WHERE (`id`=".$this->id.")");
			if (!$res) {
				echo $db_connection->error;
				return false;
			} else {
				if ($res->num_rows == 0) {
					echo 'there are no block with id = '.$this->id;
					return false;
				}
			}
			$name_tmp 		= $db_connection->real_escape_string($this->name);
			$priority_tmp   = $db_connection->real_escape_string($this->priority);
			$text_block_tmp = $db_connection->real_escape_string($this->text_block);
			$res = $db_connection->query("UPDATE `".UserBlock::$table."` SET `name`=\"".$name_tmp."\", `priority`=\"".$priority_tmp."\", `text_block`=\"".$text_block_tmp."\" WHERE `id`=".$this->id);
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

			$usr_blck = UserBlock::FetchByID($id);
			if ($usr_blck == NULL) return 0;
			$author_id = $usr_blck->author_id;

			if (!$db_connection->query("DELETE FROM `".UserBlock::$table."` WHERE `id` = ".$id)) {
				return 0;
			} else {
				removeDirectory($link_to_users_images.$author_id.'/blocks/'.$id);
				return 1;
			}
		}
	}
?>