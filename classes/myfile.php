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

		
	}
?>

