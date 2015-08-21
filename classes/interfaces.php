<?php
	//----------------------------------------------------------------I N T E R F A C E S----------------------------------------------------------------
	
	//------------------------------------------------I N T E R F A C E   A D M I N   H T M L------------------------------------------------
	
	interface IAdminHTML {
		//Methods for representation objects in html code for admin using
		
		//html code of full representation of object in string
		//public function ToHTMLAdminFull();
		//html code of short representation of object in string
		//public function ToHTMLAdminShort();

		//public function ToHTMLAdminShortInTable();
	}
	
	//------------------------------------------------I N T E R F A C E   U S E R   H T M L------------------------------------------------
	
	interface IUserHTML {
		//Methods for representation objects in html code for users using
		
		//html code of full representation of object in string within internal pages of lgmis
		//public function ToHTMLUserPrivateFull();
		//html code of short representation of object in string within internal pages of lgmis
		//public function ToHTMLUserPrivateShort();
		
		//html code of full representation of object in string within public pages of lgmis
		//public function ToHTMLUserPublicFull();
		//html code of short representation of object in string within public pages of lgmis
		//public function ToHTMLUserPublicShort();
	}

	interface IAutoHTML {
		//Methods for auto defining view of current object on base of info in $user_privileges
		
		//public function ToHTMLAutoFull($user_privileges);
		//public function ToHTMLAutoShort($user_privileges);
		//public function ToHTMLAutoShortForTable($user_privileges);
	}
	
	//------------------------------------------------I N T E R F A C E   D E L E T E   E D I T   H T M L------------------------------------------------
	
	interface IDelEdit {
		//Methods for representation html forms of deleting and editing objects
		
		//public function ToHTMLDel();
		//public function ToHTMLEdit();
		//public function ToHTMLFullVers();
	}
	
	//------------------------------------------------I N T E R F A C E   S Q L   F E T C H I N G   A N D   P U S H I N G------------------------------------------------
	
	interface ISQLOps {
		//Methods for fetching
		//public static function FetchByID($id);

		//public static function FetchFromAssoc($assoc);

		//public static function FetchFromPost();

		//public static function FetchAll();
		
		//Methods for pushing
		//public function Save();
	}
?>