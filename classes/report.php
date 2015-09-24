<?php

	class Report {
		private $id;
		private $author_id;
		private $recipient_id;
		private $name;
		private $text_block;
		private $creating_date;

		private $path_to_file = unef;

		public static $type = 'report';
		public static $table = 'reports';

		public function GetID() 			{ return $this->id; }
		public function GetRecipientID() 	{ return $this->recipient_id; }
		public function GetAuthorID() 		{ return $this->author_id; }
		public function GetName()			{ return $this->name; }
		public function GetTextBlock() 		{ return $this->text_block; }
		public function GetCreatingDate() 	{ return date('d : m : Y - H : i', $this->creating_date); }
		public function GetPathToFile()		{ return $this->path_to_file; }
		public function GetLinkToFile()		{
			global $link_to_utility_download;

			$res = '<a class="btn btn-warning" href="'.$link_to_utility_download.'?file_path='.urlencode($this->path_to_file).'">'.Language::Word('download file').'</a>';
			return $res;
		}

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

		public function ToHTMLUserPrivateFull()
		{
			$res = '';

			$res .= '<div class="form-horizontal">';

			$res .= PairLabelAndPanel(3, 5, Language::Word('receiver'), User::FetchByID($this->recipient_id)->LinkToThis());
			$res .= PairLabelAndPanel(3, 5, Language::Word('creating date'), $this->GetCreatingDate());
			$res .= PairLabelAndPanel(3, 5, Language::Word('author'), User::FetchByID($this->author_id)->LinkToThis());
			$res .= PairLabelAndPanel(3, 5, Language::Word('file'), $this->GetLinkToFile());

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
				$res .= 	'<div class="'.ColAllTypes(6).'" align="right">';
				$res .=			'<div class="margin-sm">'.$this->ToHTMLEdit().'</div>';
				$res .=		'</div>';
				$res .= 	'<div class="'.ColAllTypes(6).'" align="left">';
				$res .=			'<div class="margin-sm">'.$this->ToHTMLDel().'</div>';
				$res .=		'</div>';
			}
			$res .= '</div>';

			$res .= '</div>';
			return $res;
		}	
		
		public function ToHTMLUserPublicFull()
		{
			
		}	

		public function ToHTMLUserPrivateShortInTable()
		{
			$res = '<tr>';
			$res .= '<td>'.User::FetchByID($this->author_id)->LinkToThis().'</td>';
			$res .= '<td>'.User::FetchByID($this->recipient_id)->LinkToThis().'</td>';
			$res .= '<td>'.htmlspecialchars($this->name).'</td>';
			$res .= '<td>'.$this->GetCreatingDate().'</td>';
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
			
		}

		private static function ArrayFromDBResult($result)
		{
			$res = array();
			while ($row = $result->fetch_assoc()) {
				array_push($res, self::FetchFromAssoc($row));
			}
			return $res;
		}

		public static function FetchBy($args)
		{
			global $db_connection;
			$where_clause = '';
			$i = 0;
			$size = count($args);
			foreach ($args as $key => $value) {
				$where_clause .= ' ('.$key.' = '.$value.') ';
				if ($i < $size - 1) $where_clause .= 'OR';
				++$i;
			}
			$res = $db_connection->query("SELECT * FROM ".self::$table." WHERE ".$where_clause);
			if (!$res) {
				echo $db_connection->error;
				return Error::db_error;
			}
			return self::ArrayFromDBResult($res);
		}

		public static function FetchByRecipientID($id)
		{
			return self::FetchBy(array('recipient_id' => $id));
		}

		public static function FetchByAuthorID($id)
		{
			return self::FetchBy(array('author_id' => $id));
		}

		public static function FetchByID($id)
		{
			$res = self::FetchBy(array('id' => $id));
			if (Error::IsError($res)) return $res;
			if (count($res) > 1) return Error::ambiguously;
			if (count($res) === 0) return Error::not_found;
			return $res[0];
		}	

		public static function FetchFromAssoc($assoc)
		{
			global $link_to_service_images;
			global $link_to_report_files;

			if (!ArrayElemIsValidStr($assoc, 'recipient_id')) {
				$users = User::FetchByPrefix($assoc['recipient_input']);
				if (Error::IsError($users)) return Error::arg_not_valid;
				if (count($users) > 1) return Error::ambiguously;
				if (count($users) === 0) return Error::not_found;
				$assoc['recipient_id'] = $users[0]->GetID();
			}

			if ((!ArrayElemIsValidStr($assoc, 'author_id')) || (!ArrayElemIsValidStr($assoc, 'recipient_id')) ||
				(!ArrayElemIsValidStr($assoc, 'name')) || (!ArrayElemIsValidStr($assoc, 'text_block'))) {
				return Error::arg_not_valid;
			}
			$ob = new self();
			if (ArrayElemIsValidStr($assoc, 'id')) $ob->id = $assoc['id'];
			else $ob->id = id_undef;
			$ob->recipient_id = $assoc['recipient_id'];
			$ob->author_id = $assoc['author_id'];
			$ob->name = $assoc['name'];
			$ob->text_block = $assoc['text_block'];
			try {
				if (ArrayElemIsValidStr($assoc, 'creating_date'))
					$ob->creating_date = strtotime($assoc['creating_date']);
				else $ob->creating_date = time_undef;
			} catch(Exception $e) {
				$ob->creating_date = time_undef;
			}
			$ob->path_to_file = PathToFile($link_to_report_files.$ob->id, 'file', $link_to_service_images.'Logo.png');
			return $ob;
		}

		public function FetchFromAssocEditing($assoc)
		{
			if (ArrayElemIsValidStr($assoc, 'name')) $this->name = $assoc['name'];
			if (ArrayElemIsValidStr($assoc, 'recipient_id')) $this->recipient_id = $assoc['recipient_id'];
			if (ArrayElemIsValidStr($assoc, 'text_block')) $this->text_block = $assoc['text_block'];
		}

		public function FetchFileFromAssocEditing($assoc)
		{
			if (isset($assoc['file']['name']) && (is_uploaded_file($assoc['file']['tmp_name']))) {
				global $link_to_report_files;
				$file_name = 'file';
				$old_im = $file_name;
				$sepext = explode('.', strtolower($assoc['file']['name']));
			    $type = end($sepext);
			    $file_name .= '.'.$type;
			    $upload_path = $link_to_report_files.$this->id.'/'.$file_name;
			    if (!delete_image($link_to_report_files.$this->id.'/'.$old_im)) {
			    	return -1;
			    } else if (!move_uploaded_file($assoc['file']['tmp_name'], $upload_path)) {
			    	return -1;
			    } else {
			    	return 1;
			    }
			}
			return 0;
		}

		public static function FetchAll()
		{

		}

		public function ToHTMLDel()
		{
			global $link_to_utility_interceptor;
			$args = array(
				'action_link' => $link_to_utility_interceptor,
				'action_type' => 'del',
				'obj_type' => self::$type,
				'id' => $this->id,
				'info' => Language::Word('are you shure that you want to delete report with header').' '.htmlspecialchars($this->name).'?',
			);
			return ActionButton($args);
		}

		public function ToHTMLEdit()
		{
			global $link_to_admin_report;
			$args = array(
				'action_link' => $link_to_admin_report,
				'action_type' => 'edit',
				'obj_type' => self::$type,
				'id' => $this->id,
			);
			return ActionButton($args);
		}

		public function ToHTMLFullVers()
		{
			global $link_to_admin_report;
			$args = array(
				'action_link' => $link_to_admin_report,
				'action_type' => 'full',
				'obj_type' => self::$type,
				'id' => $this->id,
				'method' => 'get',
			);
			return ActionButton($args);
		}

		public static function InsertToDB($request)
		{
			global $db_connection;
			global $link_to_report_images;
			global $link_to_report_files;

			$author_id 	= $db_connection->real_escape_string($request->author_id);
			$name 		= $db_connection->real_escape_string($request->name);
			$recipient_id = $db_connection->real_escape_string($request->recipient_id);
			$res = $db_connection->query("INSERT INTO `".self::$table."` (`author_id`, `name`, `recipient_id`) VALUES ('".$author_id."', '".$name."', '".$recipient_id."')");
			if (!$res) {
				echo $db_connection->error;
				return false;
			}
			$id = $db_connection->insert_id;

			$request->text_block = preg_replace('/tmp_(\d+)\//', $id.'/', $request->text_block);
			$text_block = $db_connection->real_escape_string($request->text_block);
			$res = $db_connection->query("UPDATE `".self::$table."` SET `text_block`=\"".$text_block."\" WHERE `id`=".$id);
			if (!$res) {
				echo $db_connection->error;
				$db_connection->query("DELETE FROM `".self::$table."` WHERE `id` = ".$id);
				return false;
			}

			$request->id = $id;
			$upload_path = '';
			recurse_copy($link_to_report_images.'tmp_'.User::GetIDByLogin(GetUserLogin()), $link_to_report_images.$id);
			if (is_uploaded_file($_FILES['file']['tmp_name'])) {
				create_dir($link_to_report_files.$id);
				$file_name = 'file';
				$sepext = explode('.', strtolower($_FILES['file']['name']));
			    $type = end($sepext);
			    $file_name .= '.'.$type;
			    $upload_path = $link_to_report_files.$id.'/'.$file_name;
			    if (move_uploaded_file($_FILES['file']['tmp_name'], $upload_path)) {
			    	$request->path_to_file = $upload_path;
			    }
			}
			return true;
		}

		public function Save()
		{
			global $db_connection;
			$res = self::FetchByID($this->id);
			if (Error::IsError($res)) return $res;
			$name 		= $db_connection->real_escape_string($this->name);
			$recipient_id = $db_connection->real_escape_string($this->recipient_id);
			$text_block = $db_connection->real_escape_string($this->text_block);
			$res = $db_connection->query("UPDATE `".self::$table."` SET `name`=\"".$name."\", `recipient_id`=\"".$recipient_id."\", `text_block`=\"".$text_block."\" WHERE `id`=".$this->id);
			if (!$res) {
				echo $db_connection->error;
				return Error::db_error;
			}
			return true;
		}

		public static function Delete($id)
		{
			global $db_connection;
			global $link_to_report_images;
			global $link_to_report_files;
			global $link_to_logo;

			$ob = Report::FetchByID($id);

			if (!$db_connection->query("DELETE FROM `".self::$table."` WHERE `id` = ".$id)) {
				echo $db_connection->error;
				return 0;
			} else {
				removeDirectory($link_to_report_images.$id);
				removeDirectory($link_to_report_files.$id);
				return 1;
			}
		}
	}

?>