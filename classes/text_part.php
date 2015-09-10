<?php
//------------------------------------------------T E X T   P A R T------------------------------------------------
	
	class TextPart implements IAutoHTML, ISQLOps, IAdminHTML, IDelEdit {
		//--------Attributes--------

		private $id;
		private $link_id;
		private $author_id;
		private $name;
		private $priority;
		private $role;
		private $text_block;
		private $creating_date;

		public  $language;

		public static $type = 'text_part';
		public static $table = 'text_parts';

		public function GetID() 			{ return $this->id; }
		public function GetLinkID() 		{ return $this->link_id; }
		public function GetAuthorID() 		{ return $this->author_id; }
		public function GetName()			{ return $this->name; }
		public function GetPriority()		{ return $this->priority; }
		public function GetRole() 			{ return $this->role; }
		public function GetTextBlock() 		{ return $this->text_block; }
		public function GetCreatingDate() 	{ return date('d : m : Y - H : i', $this->creating_date); }

		public function ToHTMLAutoFull($user_privileges)
		{
			switch ($user_privileges) {
				case admin_user_id:
					return $this->ToHTMLAdminFull();
				case unauthorized_user_id:
					return $this->ToHTMLUserPublicFull();
				default:
					return html_undef;
			}
		}

		public function ToHTMLAutoShort($user_privileges)
		{
			return html_undef;
		}

		public function ToHTMLAutoShortForTable($user_privileges)
		{
			switch ($user_privileges) {
				case admin_user_id:
					return $this->ToHTMLUserPrivateShortInTable();
				case unauthorized_user_id:
					return $this->ToHTMLUserPublicShortInTable();
				default:
					return html_undef;
			}
		}

		//html code of full representation of object in string
		public function ToHTMLAdminFull()
		{
			global $content_types_full;
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
			$res .= 		'<label class="'.ColAllTypes(3).' vcenter control-label">'.Language::Word('role').'</label>';
			$res .= 		'<div class="'.ColAllTypes(5).' vcenter">';
			$res .= 			SimplePanel(htmlspecialchars($content_types_full[$this->role]));
			$res .= 		'</div>';
			$res .= 	'</div>';

			$res .= 	'<div class="row">';
			$res .= 		'<label class="'.ColAllTypes(3).' vcenter control-label">'.Language::Word('priority').'</label>';
			$res .= 		'<div class="'.ColAllTypes(5).' vcenter">';
			$res .= 			SimplePanel(htmlspecialchars($this->priority));
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
			$res .= 		'<div class="'.ColAllTypes(4).'" align="right">';
			$res .=				'<div class="margin-sm">'.$this->ToHTMLEdit().'</div>';
			$res .=			'</div>';
			$res .= 		'<div class="'.ColAllTypes(4).'" align="center">';
			$res .=				'<div class="margin-sm">'.$this->ToHTMLDel().'</div>';
			$res .=			'</div>';
			$res .= 		'<div class="'.ColAllTypes(4).'" align="left">';
			$res .=				'<div class="margin-sm">'.$this->ToHTMLAddLanguage().'</div>';
			$res .=			'</div>';
			$res .= 	'</div>';

			$res .= '</div>';
			return $res;
		}

		public function ToHTMLUserPublicFull() { return html_undef; }

		//html code of short representation of object in string
		public function ToHTMLAdminShort()
		{
			return html_undef;
		}

		public function ToHTMLUserPublicShortInTable()
		{
			return html_undef;
		}

		public function ToHTMLUserPrivateShortInTable()
		{
			global $content_types_full;
			$res = '<tr>';
			$res .= '<td>'.htmlspecialchars($this->name).'</td>';
			$res .= '<td>'.User::FetchByID($this->author_id)->LinkToThis().'</td>';
			$res .= '<td>'.date('d : m : Y - H : i', $this->creating_date).'</td>';
			$res .= '<td>'.htmlspecialchars($content_types_full[$this->role]).'</td>';
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

		//Methods for fetching
		public static function FetchByID($id)
		{
			global $db_connection;
			$res = NULL;
			$lang = GetLanguage();
			$fetch_table = TextPart::$table;
			if ($lang != 'rus') $fetch_table .= '_'.$lang;
			$result = $db_connection->query("SELECT * FROM `".$fetch_table."` WHERE `id`=".$id." ORDER BY priority DESC");
			if ((!$result) || ($result->num_rows != 1)) {
				echo $db_connection->error;
				return NULL;
			}
			$tmp = $result->fetch_assoc();
			$tmp['language'] = $lang;
			return TextPart::FetchFromAssoc($tmp);
		}

		public static function FetchFromAssoc($assoc)
		{
			if ((!ArrayElemIsValidStr($assoc, 'author_id')) || (!ArrayElemIsValidStr($assoc, 'priority')) ||
				(!ArrayElemIsValidStr($assoc, 'role')) || (!ArrayElemIsValidStr($assoc, 'text_block')) || 
				(!ArrayElemIsValidStr($assoc, 'name'))) {
				return NULL;
			}
			$txt_part = new self();
			if (isset($assoc['id']) && (strlen($assoc['id']))) $txt_part->id = $assoc['id'];
			else $txt_part->id = id_undef;

			if (isset($assoc['link_id']) && (strlen($assoc['link_id']))) $txt_part->link_id = $assoc['link_id'];
			else $txt_part->link_id = id_undef;

			$txt_part->author_id = $assoc['author_id'];
			$txt_part->priority = $assoc['priority'];
			$txt_part->role = $assoc['role'];
			$txt_part->text_block = $assoc['text_block'];
			$txt_part->name = $assoc['name'];
			if (ArrayElemIsValidStr($assoc, 'language')) $txt_part->language = $assoc['language'];
			try {
				if (isset($assoc['creating_date']) && (strlen($assoc['creating_date'])))
					$txt_part->creating_date = strtotime($assoc['creating_date']);
				else $txt_part->creating_date = time_undef;
			} catch(Exception $e) {
				$txt_part->creating_date = time_undef;
			}
			return $txt_part;
		}

		public function FetchFromAssocEditing($assoc)
		{
			if (ArrayElemIsValidStr($assoc, 'link_id')) $this->link_id = $assoc['link_id'];
			if (ArrayElemIsValidStr($assoc, 'name')) $this->name = $assoc['name'];
			if (ArrayElemIsValidStr($assoc, 'priority')) $this->priority = $assoc['priority'];
			if (ArrayElemIsValidStr($assoc, 'role')) $this->role = $assoc['role'];
			if (ArrayElemIsValidStr($assoc, 'text_block')) $this->text_block = $assoc['text_block'];
		}

		public static function FetchFromPost()
		{
			return TextPart::FetchFromAssoc($_POST);
		}

		public static function FetchAll()
		{
			global $db_connection;
			$res = array();
			$from_table = TextPart::$table;
			$lang = GetLanguage();
			if ($lang !== 'rus') $from_table .= '_'.$lang;
			$result = $db_connection->query("SELECT * FROM `".$from_table."`");
			if (!$result) {
				return NULL;
			}
			while ($row = $result->fetch_assoc()) {
				$row['language'] = $lang;
				array_push($res, TextPart::FetchFromAssoc($row));
			}
			return $res;
		}

		public static function FetchByRole($role)
		{
			global $db_connection;
			$res = array();
			$from_table = TextPart::$table;
			$lang = GetLanguage();
			if ($lang !== 'rus') $from_table .= '_'.$lang;
			$result = $db_connection->query("SELECT * FROM `".$from_table."` WHERE role=\"".htmlspecialchars($role)."\" ORDER BY priority DESC");
			if (!$result) {
				echo $db_connection->error;
				return NULL;
			}
			while ($row = $result->fetch_assoc()) {
				$row['language'] = $lang;
				array_push($res, TextPart::FetchFromAssoc($row));
			}
			return $res;
		}

		public function FetchLanguages()
		{
			global $languages;
			global $db_connection;
			$res = array();
			foreach ($languages as $key => $value) {
				$from_table = TextPart::$table;
				if ($key !== 'rus') $from_table .= '_'.$key;
				$q = $db_connection->query("SELECT COUNT(*) FROM ".$from_table." WHERE id = ".$this->id);
				if ($q) {
					$cnt = $q->fetch_array()[0];
					if ($cnt > 0) $res[$key] = $value;
				}
			}
			return $res;
		}

		public function ToHTMLAddLanguage()
		{
			global $link_to_admin_text_part;
			$args = array(
				'action_link' => $link_to_admin_text_part,
				'action_type' => 'add_lang',
				'obj_type' => TextPart::$type,
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
				'obj_type' => TextPart::$type,
				'id' => $this->id,
				'info' => Language::Word('are you shure that you want to delete text block with header').' '.htmlspecialchars($this->name).'?',
			);
			return ActionButton($args);
		}

		public function ToHTMLEdit()
		{
			global $link_to_admin_text_part;
			$args = array(
				'action_link' => $link_to_admin_text_part,
				'action_type' => 'edit',
				'obj_type' => TextPart::$type,
				'id' => $this->id,
			);
			return ActionButton($args);
		}

		public function ToHTMLFullVers()
		{
			global $link_to_admin_text_part;
			global $link_to_admin_manage_content;
			global $content_types_short;
			$args = array(
				'action_link' => $link_to_admin_text_part,
				'action_type' => 'full',
				'obj_type' => TextPart::$type,
				'id' => $this->id,
				'prev_page' => $link_to_admin_manage_content.'?content_type='.$content_types_short['about_us'],
				'method' => 'get',
			);
			return ActionButton($args);
		}

		public static function InsertToDB($request, $lang_vers = 'rus', $glob_id = 0)
		{
			global $db_connection;
			global $link_to_text_part_images;

			$link_id 	= $db_connection->real_escape_string($request->link_id);
			$author_id 	= $db_connection->real_escape_string($request->author_id);
			$name 		= $db_connection->real_escape_string($request->name);
			$priority 	= $db_connection->real_escape_string($request->priority);
			$role 		= $db_connection->real_escape_string($request->role);
			$insert_table = TextPart::$table;
			if ($lang_vers !== 'rus') {
				$insert_table .= '_'.$lang_vers;
			}
			$res = $db_connection->query("INSERT INTO `".$insert_table."` (`id`, `link_id`, `author_id`, `name`, `priority`, `role`, `text_block`, `creating_date`) VALUES ('".$glob_id."', '".$link_id."', '".$author_id."', '".$name."', '".$priority."', '".$role."', '', CURRENT_TIMESTAMP)");
			if (!$res) {
				echo $db_connection->error;
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
			if ($glob_id === 0) recurse_copy($link_to_text_part_images.'tmp_'.User::GetIDByLogin(GetUserLogin()), $link_to_text_part_images.$id);
			return true;
		}
		
		//Methods for pushing
		public function Save()
		{
			global $db_connection;
			$from_table = TextPart::$table;
			if ($this->language !== 'rus') $from_table .= '_'.$this->language;
			$res = $db_connection->query("SELECT `id` FROM `".$from_table."` WHERE (`id`=".$this->id.")");
			if (!$res) {
				echo $db_connection->error;
				return false;
			} else {
				if ($res->num_rows == 0) {
					echo 'there are no text_part with id = '.$this->id;
					return false;
				}
			}
			$link_id_tmp 		= $db_connection->real_escape_string($this->link_id);
			$text_block_tmp = $db_connection->real_escape_string($this->text_block);
			$priority_tmp = $db_connection->real_escape_string($this->priority);
			$role_tmp = $db_connection->real_escape_string($this->role);
			$name_tmp = $db_connection->real_escape_string($this->name);
			$res = $db_connection->query("UPDATE `".$from_table."` SET `name`=\"".$name_tmp."\", `link_id`=\"".$link_id_tmp."\", `priority`=\"".$priority_tmp."\", `text_block`=\"".$text_block_tmp."\", `role`=\"".$role_tmp."\" WHERE `id`=".$this->id);
			if (!$res) {
				echo $db_connection->error;
				return false;
			}
			return true;
		}

		public static function Delete($id)
		{
			global $db_connection;
			global $link_to_text_part_images;

			$txt_part = TextPart::FetchByID($id);
			$langs = $txt_part->FetchLanguages();

			$from_table = TextPart::$table;
			if ($txt_part->language !== 'rus') $from_table .= '_'.$txt_part->language;

			if (!$db_connection->query("DELETE FROM `".$from_table."` WHERE `id` = ".$id)) {
				return 0;
			} else {
				if (count($langs) < 2) removeDirectory($link_to_text_part_images.$id);
				return 1;
			}
		}
	}

?>