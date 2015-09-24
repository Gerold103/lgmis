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
		}

		public function ToHTMLAutoFull($user_privileges)
		{
			switch ($user_privileges) {
				case admin_user_id:
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
				case admin_user_id:
					return $this->ToHTMLUserPrivateShortInTable();
				case unauthorized_user_id:
					return $this->ToHTMLUserPublicShortInTable();
				default:
					return html_undef;
			}
		}

		public function ToHTMLUserPrivateFull()
		{

		}	
		
		public function ToHTMLUserPublicFull()
		{
			
		}	

		public function ToHTMLUserPrivateShortInTable()
		{
			
		}	

		public function ToHTMLUserPublicShortInTable()
		{
			
		}

		public static function FetchByID($id)
		{

		}	

		public static function FetchFromAssoc($assoc)
		{
			global $link_to_service_images;
			global $link_to_report_images;

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

		}

		public static function FetchAll()
		{

		}

		public function ToHTMLDel()
		{

		}

		public function ToHTMLEdit()
		{

		}

		public function ToHTMLFullVers()
		{

		}

		public static function InsertToDB($request)
		{
			global $db_connection;
			global $link_to_report_images;

			$author_id 	= $db_connection->real_escape_string($request->author_id);
			$name 		= $db_connection->real_escape_string($request->name);
			$annotation = $db_connection->real_escape_string($request->recipient_id);
			$res = $db_connection->query("INSERT INTO `".self::$table."` (`author_id`, `name`, `recipient_id`) VALUES ('".$author_id."', '".$name."', '".$recipient_id."')");
			if (!$res) {
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
				$file_name = 'file';
				$sepext = explode('.', strtolower($_FILES['file']['name']));
			    $type = end($sepext);
			    $file_name .= '.'.$type;
			    $upload_path = $link_to_report_images.$id.'/'.$file_name;
			    if (move_uploaded_file($_FILES['file']['tmp_name'], $upload_path)) {
			    	$request->path_to_file = $upload_path;
			    }
			}
			return true;
		}

		public function Save()
		{

		}

		public static function Delete($id)
		{
			
		}
	}

?>