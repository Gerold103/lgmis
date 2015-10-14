<?php
	//------------------------------------------------ M Y   F I L E ------------------------------------------------
	
	class MyFile {
		const perm_to_all_registered = 0x0;
		const perm_to_only_empls = 0x1;

		private $id = id_undef;
		private $owner_id = id_undef;
		private $name = undef;
		private $path_to_file = array();
		private $creating_date = time_undef;
		private $permissions = self::perm_to_only_empls;

		public static $type = 'myfile';
		public static $table = 'myfiles';

		public function GetID() 			{ return $this->id; }
		public function GetOwnerID() 		{ return $this->owner_id; }
		public function GetName() 			{ return $this->name; }
		public function GetPathToFile() 	{ return $this->path_to_file; }
		public function GetCreatingDate() 	{ return $this->creating_date; }
		public function GetPermissions() 	{ return $this->permissions; }

		public static function PermissionsFromString($str) {
			switch ($str) {
				case 'for_employees': return MyFile::perm_to_only_empls;
				case 'for_registered': return MyFile::perm_to_all_registered;
				default: return -1;
			}
		}

		public static function FetchFromAssoc($assoc) {
			$ob = new self();
			if (ArrayElemIsValidStr($assoc, 'id')) 			$ob->id = $assoc['id'];
			if (ArrayElemIsValidStr($assoc, 'owner_id')) 	$ob->owner_id = $assoc['owner_id'];
			if (ArrayElemIsValidStr($assoc, 'name')) 		$ob->name = $assoc['name'];
			if (isset($assoc['path_to_file'])) 				$ob->path_to_file = $assoc['path_to_file'];
			if (ArrayElemIsValidStr($assoc, 'permissions'))	$ob->permissions = $assoc['permissions'];
			try {
				if (ArrayElemIsValidStr($assoc, 'creating_date')) $ob->creating_date = strtotime($assoc['creating_date']);
			} catch(Exception $e) {
				$ob->creating_date = $assoc['creating_date'];
			}
			return $ob;
		}
		
	}
?>

