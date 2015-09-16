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

		public static function InsertToDB($request, $lang_vers = 'rus', $glob_id = 0)
		{

		}

		public function Save()
		{

		}

		public static function Delete($id)
		{
			
		}
	}

?>