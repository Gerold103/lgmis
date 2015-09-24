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

		public  $language = undef;
		
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

		//--------Methods--------

		public function ToHTMLAutoFull($user_privileges)
		{
			switch ($user_privileges) {
				case admin_user_id: case simple_user_id:
					return $this->ToHTMLUserPrivateFull();
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
					return $this->ToHTMLUserPrivateShortInTable();
				case unauthorized_user_id:
					return $this->ToHTMLUserPublicShortInTable();
				default:
					return html_undef;
			}
		}
		
		//html code of full representation of object in string
		public function ToHTMLAdminFull() {
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
			$res .= 		'<label class="'.ColAllTypes(3).' vcenter control-label">'.Language::Word('direction').'</label>';
			$res .= 		'<div class="'.ColAllTypes(5).' vcenter">';
			$res .= 			SimplePanel(Direction::FetchByID($this->direction_id)->LinkToThis());
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

		//html code of full representation of object in string within internal pages of lgmis
		public function ToHTMLUserPrivateFull()
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
			$res .= 		'<label class="'.ColAllTypes(3).' vcenter control-label">'.Language::Word('direction').'</label>';
			$res .= 		'<div class="'.ColAllTypes(5).' vcenter">';
			$res .= 			SimplePanel(Direction::FetchByID($this->direction_id)->LinkToThis());
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

			$res .= 	'<div class="row">';
			if ((GetUserLogin() === User::FetchByID($this->author_id)->login) || (GetUserLogin() === 'admin')) {
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
			$res .= 	'</div>';

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
			if ((GetUserLogin() === $author->login) || (GetUserLogin() === 'admin')) {
				$res .= 	'<div class="'.ColAllTypes(4).'">';
			} else {
				$res .= 	'<div class="'.ColAllTypes(12).'">';
			}
			$res .= 			$this->ToHTMLFullVers();
			$res .=			'</div>';
			if ((GetUserLogin() === $author->login) || (GetUserLogin() === 'admin')) {
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

		public function ToHTMLAddLanguage()
		{
			global $link_to_admin_project;
			$args = array(
				'action_link' => $link_to_admin_project,
				'action_type' => 'add_lang',
				'obj_type' => Project::$type,
				'id' => $this->id,
				'btn_color' => 'btn-primary',
			);
			return ActionButton($args);
		}

		public function ToHTMLDel()
		{
			global $link_to_utility_interceptor;
			$args = array(
				'action_link' => $link_to_utility_interceptor,
				'action_type' => 'del',
				'obj_type' => Project::$type,
				'id' => $this->id,
				'info' => Language::Word('are you shure that you want to delete project with header').' '.$this->name.'?',
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
				'method' => 'get',
			);
			return ActionButton($args);
		}

		public static function FetchByDirectionID($id, $kwargs = array())
		{
			global $db_connection;
			global $languages;
			$res = array();
			if (!isset($kwargs['all'])) {
				$lang = '';
				if (isset($kwargs['lang'])) $lang = $kwargs['lang'];
				else $lang = GetLanguage();
				$fetch_table = Project::$table;
				if ($lang != 'rus') $fetch_table .= '_'.$lang;
				$result = $db_connection->query("SELECT * FROM `".$fetch_table."` WHERE `direction_id`=".$id);
				if (!$result) {
					echo $db_connection->error;
					return NULL;
				}
				while ($row = $result->fetch_assoc()) {
					$row['language'] = $lang;
					$tmp = Project::FetchFromAssoc($row);
					array_push($res, $tmp);
				}
			} else {
				foreach ($languages as $key => $value) {
					$tmp = $this->FetchByDirectionID($id, array('lang' => $key));
					if (($tmp !== NULL) && (count($tmp) > 0))
						$res = array_merge($res, $tmp);
				}
			}
			return $res;
		}

		//Methods for fetching
		public static function FetchByID($id)
		{
			global $db_connection;
			$res = NULL;
			$lang = GetLanguage();
			$fetch_table = Project::$table;
			if ($lang != 'rus') $fetch_table .= '_'.$lang;
			$result = $db_connection->query("SELECT * FROM `".$fetch_table."` WHERE `id`=".$id);
			if ((!$result) || ($result->num_rows != 1)) {
				if (!$result) {
					echo $db_connection->error;
					return NULL;
				}
				$langs = Project::FetchLanguagesByID($id);
				if (count($langs) > 0) {
					return Error::no_translation;
				}
				return NULL;
			}
			$tmp = $result->fetch_assoc();
			$tmp['language'] = $lang;
			return Project::FetchFromAssoc($tmp);
		}

		public static function InsertToDB($request, $lang_vers = 'rus', $glob_id = 0)
		{
			global $db_connection;
			global $link_to_projects_images;

			$author_id 	  = $db_connection->real_escape_string($request->author_id);
			$direction_id = $db_connection->real_escape_string($request->direction_id);
			$name 		  = $db_connection->real_escape_string($request->name);
			$insert_table = Project::$table;
			if ($lang_vers !== 'rus') {
				$insert_table .= '_'.$lang_vers;
			}
			$max_id = self::GetMaximalID() + 1;
			$insert_id = -1;
			if ($glob_id !== 0) $insert_id = $glob_id;
			else $insert_id = $max_id;
			$res = $db_connection->query("INSERT INTO `".$insert_table."` (`id`, `author_id`, `direction_id`, `name`, `text_block`, `creating_date`) VALUES ('".$insert_id."', '".$author_id."', '".$direction_id."', '".$name."', '', CURRENT_TIMESTAMP)");
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
			if ($glob_id === 0) recurse_copy($link_to_projects_images.'tmp_'.$request->author_id, $link_to_projects_images.$id);
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
			if (ArrayElemIsValidStr($assoc, 'language')) $proj->language = $assoc['language'];
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
			$from_table = Project::$table;
			$lang = GetLanguage();
			if ($lang !== 'rus') $from_table .= '_'.$lang;
			$result = $db_connection->query("SELECT * FROM `".$from_table."` ORDER BY direction_id DESC, id DESC");
			if (!$result) {
				return NULL;
			}
			while ($row = $result->fetch_assoc()) {
				$row['language'] = $lang;
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
			$from_table = Project::$table;
			if ($this->language !== 'rus') $from_table .= '_'.$this->language;
			$res = $db_connection->query("SELECT `id` FROM `".$from_table."` WHERE (`id`=".$this->id.")");
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
			$res = $db_connection->query("UPDATE `".$from_table."` SET `name`=\"".$name_tmp."\", `direction_id`=\"".$direction_id_tmp."\", `text_block`=\"".$text_block_tmp."\" WHERE `id`=".$this->id);
			if (!$res) {
				echo $db_connection->error;
				return false;
			}
			return true;
		}

		public function FetchLanguages()
		{
			return Project::FetchLanguagesByID($this->id);
		}

		public static function FetchLanguagesByID($id)
		{
			global $languages;
			global $db_connection;
			$res = array();
			foreach ($languages as $key => $value) {
				$from_table = Project::$table;
				if ($key !== 'rus') $from_table .= '_'.$key;
				$q = $db_connection->query("SELECT COUNT(*) FROM ".$from_table." WHERE id = ".$id);
				if ($q) {
					$cnt = $q->fetch_array()[0];
					if ($cnt > 0) $res[$key] = $value;
				}
			}
			return $res;
		}		

		public static function Delete($id)
		{
			global $db_connection;
			global $link_to_projects_images;

			$project = Project::FetchByID($id);
			$langs = $project->FetchLanguages();

			$from_table = Project::$table;
			if ($project->language !== 'rus') $from_table .= '_'.$project->language;

			if (!$db_connection->query("DELETE FROM `".$from_table."` WHERE `id` = ".$id)) {
				return 0;
			} else {
				if (count($langs) < 2) removeDirectory($link_to_projects_images.$id);
				return 1;
			}
		}

		public function DeleteThis()
		{
			global $db_connection;
			global $link_to_projects_images;

			$langs = $this->FetchLanguages();
			$from_table = Project::$table;
			if ($this->language !== 'rus') $from_table .= '_'.$this->language;
			if (!$db_connection->query("DELETE FROM `".$from_table."` WHERE id = ".$this->id)) {
				return 0;
			} else {
				if (count($langs) < 2) removeDirectory($link_to_projects_images.$this->id);
				return 1;
			}
		}

		public function LinkToThis()
		{
			global $link_to_admin_project;
			global $use_mod_rewrite;
			global $link_to_public_project;
			$args = array();

			$mod_rewrite = 0;
			if (isset($use_mod_rewrite) && ($use_mod_rewrite === true)) {
				$mod_rewrite = 1;
			}
			if (IsSessionPublic()) {
				$args = array(
					'action_link' => $link_to_public_project,
					'action_type' => 'full',
					'obj_type' => Project::$type,
					'id' => $this->id,
					'lnk_text' => $this->name,
					'method' => 'get',
					'mod_rewrite' => $mod_rewrite,
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