<?php
//------------------------------------------------P R O J E C T------------------------------------------------
	
	class Project implements IAdminHTML, IUserHTML, IAutoHTML, IDelEdit, ISQLOps {
		//Methods and attributes for working with projects of directions of lgmis work.
		
		//--------Attributes--------
		
		public  $id           = id_undef;
		public  $direction_id = id_undef;
		private $author_id    = id_undef;
		public  $name         = undef;
		public  $text_block   = undef;
		private $creating_date = time_undef;
		
		public static $type = 'project';
		public static $table = 'projects';

		public function GetCreatingDateStr()
		{
			return date('d : m : Y - H : i', $this->creating_date);
		}

		public function GetAuthorID()
		{
			return $this->author_id;
		}

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
					return $this->ToHTMLUserPublicShortInTable();
				case simple_user_id:
					return $this->ToHTMLUserPrivateShortInTable();
				default:
					return html_undef;
			}
		}
		
		//html code of full representation of object in string
		public function ToHTMLAdminFull() {
			$res = '';

			$res .= '<div class="form-horizontal">';

			$res .= 	'<div class="row">';
			$res .= 		'<label class="'.ColAllTypes(3).' vcenter control-label">Дата создания</label>';
			$res .= 		'<div class="'.ColAllTypes(5).' vcenter">';
			$res .= 			SimplePanel(date('d : m : Y - H : i', $this->creating_date));
			$res .= 		'</div>';
			$res .= 	'</div>';

			$res .= 	'<div class="row">';
			$res .= 		'<label class="'.ColAllTypes(3).' vcenter control-label">Автор</label>';
			$res .= 		'<div class="'.ColAllTypes(5).' vcenter">';
			$res .= 			SimplePanel(User::FetchByID($this->author_id)->LinkToThis());
			$res .= 		'</div>';
			$res .= 	'</div>';

			$res .= 	'<div class="row">';
			$res .= 		'<label class="'.ColAllTypes(3).' vcenter control-label">Направление</label>';
			$res .= 		'<div class="'.ColAllTypes(5).' vcenter">';
			$res .= 			SimplePanel(Direction::FetchByID($this->direction_id)->LinkToThis());
			$res .= 		'</div>';
			$res .= 	'</div>';

			$res .= '<hr>';

			$res .= 	'<div class="row" align="center">';
			$res .= 		'<label class="control-label">Текст</label>';
			$res .= 	'</div>';
			$res .= 	'<div class="row" align="left">';
			$res .= 		'<div class="'.ColAllTypes(8).' '.ColOffsetAllTypes(2).'">';
			$res .= 			SimplePanel($this->text_block);
			$res .= 		'</div>';
			$res .= 	'</div>';

			$res .= 	'<div class="row">';
			$res .= 		'<div class="'.ColAllTypes(6).'" align="right">';
			$res .=				'<div class="margin-sm">'.$this->ToHTMLEdit().'</div>';
			$res .=			'</div>';
			$res .= 		'<div class="'.ColAllTypes(6).'" align="left">';
			$res .=				'<div class="margin-sm">'.$this->ToHTMLDel().'</div>';
			$res .=			'</div>';
			$res .= 	'</div>';

			$res .= '</div>';
			return $res;
		}
		//html code of short representation of object in string
		public function ToHTMLAdminShort()
		{
			$res = '';
			$res .= '<b>id</b>: '.$this->id.'; <b>direction_id</b>: '.$this->direction_id.'; <b>author_id</b>: '.$this->author_id.';<br>';
			$res .= '<b>name</b>: '.htmlspecialchars($this->name).';<br>';
			$res .= '<b>creating_date</b>: '.date('d : m : Y - H : i', $this->creating_date).';<br>';
			$res .= $this->ToHTMLDel().'<br>';
			$res .= $this->ToHTMLEdit().'<br>';
			$res .= $this->ToHTMLFullVers().'<br>';
			return $res;
		}

		public function ToHTMLAdminShortInTable()
		{
			$res = '<tr>';
			$res .= '<td>'.Direction::FetchByID($this->direction_id)->LinkToThis().'</td>';
			$res .= '<td>'.htmlspecialchars($this->name).'</td>';
			$res .= '<td>'.date('d : m : Y - H : i', $this->creating_date).'</td>';
			$res .= '<td>'.User::FetchByID($this->author_id)->LinkToThis().'</td>';
			$res .= '<td>';
			$res .=		'<div class="row">';
			$res .= 		'<div class="'.ColAllTypes(4).'">';
			$res .= 			$this->ToHTMLFullVers();
			$res .=			'</div>';
			$res .=			'<div class="'.ColAllTypes(4).'">';
			$res .=				$this->ToHTMLEdit();
			$res .=			'</div>';
			$res .=			'<div class="'.ColAllTypes(4).'">';
			$res .=				$this->ToHTMLDel();
			$res .=			'</div>';
			$res .= 	'</div>';
			$res .= '</td>';
			$res .= '</tr>';
			return $res;
		}

		//html code of full representation of object in string within internal pages of lgmis
		public function ToHTMLUserPrivateFull()
		{
			$res = '';

			$res .= '<div class="form-horizontal">';

			$res .= 	'<div class="row">';
			$res .= 		'<label class="'.ColAllTypes(3).' vcenter control-label">Дата создания</label>';
			$res .= 		'<div class="'.ColAllTypes(5).' vcenter">';
			$res .= 			SimplePanel(date('d : m : Y - H : i', $this->creating_date));
			$res .= 		'</div>';
			$res .= 	'</div>';

			$res .= 	'<div class="row">';
			$res .= 		'<label class="'.ColAllTypes(3).' vcenter control-label">Автор</label>';
			$res .= 		'<div class="'.ColAllTypes(5).' vcenter">';
			$res .= 			SimplePanel(User::FetchByID($this->author_id)->LinkToThis());
			$res .= 		'</div>';
			$res .= 	'</div>';

			$res .= 	'<div class="row">';
			$res .= 		'<label class="'.ColAllTypes(3).' vcenter control-label">Направление</label>';
			$res .= 		'<div class="'.ColAllTypes(5).' vcenter">';
			$res .= 			SimplePanel(Direction::FetchByID($this->direction_id)->LinkToThis());
			$res .= 		'</div>';
			$res .= 	'</div>';

			$res .= '<hr>';

			$res .= 	'<div class="row" align="center">';
			$res .= 		'<label class="control-label">Текст</label>';
			$res .= 	'</div>';
			$res .= 	'<div class="row" align="left">';
			$res .= 		'<div class="'.ColAllTypes(8).' '.ColOffsetAllTypes(2).'">';
			$res .= 			SimplePanel($this->text_block);
			$res .= 		'</div>';
			$res .= 	'</div>';

			if (GetUserLogin() === User::FetchByID($this->author_id)->login) {
				$res .= '<div class="row">';
				$res .= 	'<div class="'.ColAllTypes(6).'" align="right">';
				$res .=			'<div class="margin-sm">'.$this->ToHTMLEdit().'</div>';
				$res .=		'</div>';
				$res .= 	'<div class="'.ColAllTypes(6).'" align="left">';
				$res .=			'<div class="margin-sm">'.$this->ToHTMLDel().'</div>';
				$res .=		'</div>';
				$res .= '</div>';
			}

			$res .= '</div>';
			return $res;
		}
		//html code of short representation of object in string within internal pages of lgmis
		public function ToHTMLUserPrivateShort()
		{
			$res = '';
			$author_login = User::FetchByID($this->author_id)->login;
			if (GetUserLogin() == $author_login) $res .= '<b>id</b>: '.$this->id.'; ';
			$res .= '<b>direction_id</b>: '.$this->direction_id.'; <b>author_id</b>: '.$this->author_id.';<br>';
			$res .= '<b>name</b>: '.htmlspecialchars($this->name).';<br>';
			$res .= '<b>creating_date</b>: '.date('d : m : Y - H : i', $this->creating_date).';<br>';
			if (GetUserLogin() == $author_login) {
				$res .= $this->ToHTMLDel().'<br>';
				$res .= $this->ToHTMLEdit().'<br>';
			}
			$res .= $this->ToHTMLFullVers().'<br>';
			return $res;
		}

		public function ToHTMLUserPublicShortInTable()
		{
			$res = '';
			$res .= '<div class="row" align="center" style="padding: 15px;">';
			$res .= 	$this->LinkToThis();
			$res .= '</div>';
			return $res;
		}

		public function ToHTMLUserPrivateShortInTable()
		{
			$author = User::FetchByID($this->author_id);
			$res = '<tr>';
			$res .= '<td>'.Direction::FetchByID($this->direction_id)->LinkToThis().'</td>';
			$res .= '<td>'.htmlspecialchars($this->name).'</td>';
			$res .= '<td>'.date('d : m : Y - H : i', $this->creating_date).'</td>';
			$res .= '<td>'.$author->LinkToThis().'</td>';
			$res .= '<td>';
			$res .=		'<div class="row">';
			if (GetUserLogin() === $author->login) {
				$res .= 	'<div class="'.ColAllTypes(4).'">';
			} else {
				$res .= 	'<div class="'.ColAllTypes(12).'">';
			}
			$res .= 			$this->ToHTMLFullVers();
			$res .=			'</div>';
			if (GetUserLogin() === $author->login) {
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
				'obj_type' => Project::$type,
				'id' => $this->id,
				'info' => 'Вы уверены, что хотите удалить проект с заголовком '.$this->name.'?',
			);
			return ActionButton($args);
		}
		public function ToHTMLEdit()
		{
			global $link_to_admin_project;
			$args = array(
				'action_link' => $link_to_admin_project,
				'action_type' => 'edit',
				'obj_type' => Project::$type,
				'id' => $this->id,
			);
			return ActionButton($args);
		}

		public function ToHTMLFullVers()
		{
			global $link_to_admin_project;
			global $link_to_admin_manage_content;
			global $content_types_short;
			$args = array(
				'action_link' => $link_to_admin_project,
				'action_type' => 'full',
				'obj_type' => Project::$type,
				'id' => $this->id,
				'prev_page' => $link_to_admin_manage_content.'?content_type='.$content_types_short['projects'],
			);
			return ActionButton($args);
		}

		public static function FetchByDirectionID($id)
		{
			global $db_connection;
			$res = array();
			$result = $db_connection->query("SELECT * FROM `".Project::$table."` WHERE `direction_id`=".$id);
			if (!$result) {
				return NULL;
			}
			while ($row = $result->fetch_assoc()) {
				array_push($res, Project::FetchFromAssoc($row));
			}
			return $res;
		}

		//Methods for fetching
		public static function FetchByID($id)
		{
			global $db_connection;
			$res = NULL;
			$result = $db_connection->query("SELECT * FROM `".Project::$table."` WHERE `id`=".$id);
			if ((!$result) || ($result->num_rows != 1)) {
				return NULL;
			}
			return Project::FetchFromAssoc($result->fetch_assoc());
		}

		public static function InsertToDB($request)
		{
			global $db_connection;
			global $link_to_projects_images;

			$author_id 	  = $db_connection->real_escape_string($request->author_id);
			$direction_id = $db_connection->real_escape_string($request->direction_id);
			$name 		  = $db_connection->real_escape_string($request->name);
			$res = $db_connection->query("INSERT INTO `".Project::$table."` (`id`, `author_id`, `direction_id`, `name`, `text_block`, `creating_date`) VALUES ('0', '".$author_id."', '".$direction_id."', '".$name."', '', CURRENT_TIMESTAMP)");
			if (!$res) {
				return false;
			}
			$id = $db_connection->insert_id;

			$request->text_block = preg_replace('/tmp_(\d+)\//', $id.'/', $request->text_block);
			$text_block = $db_connection->real_escape_string($request->text_block);
			$res = $db_connection->query("UPDATE `".Project::$table."` SET `text_block`=\"".$text_block."\" WHERE `id`=".$id);
			if (!$res) {
				echo $db_connection->error;
				$db_connection->query("DELETE FROM `".Project::$table."` WHERE `id` = ".$id);
				return false;
			}
			recurse_copy($link_to_projects_images.'tmp_'.$request->author_id, $link_to_projects_images.$id);
			return true;
		}

		public static function FetchFromAssoc($assoc)
		{
			if ((!ArrayElemIsValidStr($assoc, 'author_id')) || (!ArrayElemIsValidStr($assoc, 'direction_id')) ||
				(!ArrayElemIsValidStr($assoc, 'name')) || (!ArrayElemIsValidStr($assoc, 'text_block'))) {
				return NULL;
			}
			$proj = new self();
			if (isset($assoc['id']) && (strlen($assoc['id']))) $proj->id = $assoc['id'];
			else $proj->id = id_undef;
			$proj->author_id = $assoc['author_id'];
			$proj->direction_id = $assoc['direction_id'];
			$proj->name = $assoc['name'];
			$proj->text_block = $assoc['text_block'];
			try {
				if (isset($assoc['creating_date']) && (strlen($assoc['creating_date'])))
					$proj->creating_date = strtotime($assoc['creating_date']);
				else $proj->creating_date = time_undef;
			} catch(Exception $e) {
				$proj->creating_date = time_undef;
			}
			return $proj;
		}

		public static function FetchFromPost()
		{
			return Project::FetchFromAssoc($_POST);
		}

		public static function FetchAll()
		{
			global $db_connection;
			$res = array();
			$result = $db_connection->query("SELECT * FROM `".Project::$table."` ORDER BY direction_id");
			if (!$result) {
				return NULL;
			}
			while ($row = $result->fetch_assoc()) {
				array_push($res, Project::FetchFromAssoc($row));
			}
			return $res;
		}

		public function FetchFromAssocEditing($assoc)
		{
			if (ArrayElemIsValidStr($assoc, 'name')) $this->name = $assoc['name'];
			if (ArrayElemIsValidStr($assoc, 'text_block')) $this->text_block = $assoc['text_block'];
			if (ArrayElemIsValidStr($assoc, 'direction_id')) $this->direction_id = $assoc['direction_id'];
		}
		
		//Methods for pushing
		public function Save()
		{
			global $db_connection;
			$res = $db_connection->query("SELECT `id` FROM `".Project::$table."` WHERE (`id`=".$this->id.")");
			if (!$res) {
				echo $db_connection->error;
				return false;
			} else {
				if ($res->num_rows == 0) {
					echo 'there are no project with id = '.$this->id;
					return false;
				}
			}
			$name_tmp 		= $db_connection->real_escape_string($this->name);
			$text_block_tmp = $db_connection->real_escape_string($this->text_block);
			$direction_id_tmp = $db_connection->real_escape_string($this->direction_id);
			$res = $db_connection->query("UPDATE `".Project::$table."` SET `name`=\"".$name_tmp."\", `direction_id`=\"".$direction_id_tmp."\", `text_block`=\"".$text_block_tmp."\" WHERE `id`=".$this->id);
			if (!$res) {
				echo $db_connection->error;
				return false;
			}
			return true;
		}

		public static function Delete($id)
		{
			global $db_connection;
			global $link_to_projects_images;

			if (!$db_connection->query("DELETE FROM `".Project::$table."` WHERE `id` = ".$id)) {
				return 0;
			} else {
				removeDirectory($link_to_projects_images.$id);
				return 1;
			}
		}

		public function LinkToThis()
		{
			global $link_to_admin_project;

			global $link_to_public_project;
			$args = array();

			if (IsSessionPublic()) {
				$args = array(
					'action_link' => $link_to_public_project,
					'action_type' => 'full',
					'obj_type' => Project::$type,
					'id' => $this->id,
					'lnk_text' => $this->name,
					'method' => 'get',
				);
			} else {
				$args = array(
					'action_link' => $link_to_admin_project,
					'action_type' => 'full',
					'obj_type' => Project::$type,
					'id' => $this->id,
					'lnk_text' => $this->name,
				);
			}
			return ActionLink($args);
		}
	}
?>