<?php
	
	//------------------------------------------------S E C R E T   L I N K------------------------------------------------

	class SecretLink {
		//--------Attributes--------

		private $id            = id_undef;
		private $author_id     = id_undef;
		private $public_link   = undef;
		private $actual_link   = undef;
		private $creating_date = time_undef;
		private $deleting_date = time_undef;

		const cachable = false;
		const translated = false;

		public static $type = 'SecretLink';
		public static $table = 'secret_links';

		public static function CreateForActualLink($link) {
			$ob = new self();
			$ob->SetAuthorID(GetUserID());
			$ob->SetActualLink($link);
			$random_link = SecretLink::GenerateRandomLink();
			do {
				$old = SecretLink::FetchBy(['select_list' => 'id', 'eq_conds' => ['public_link' => $random_link]]);
				if (count($old) != 0) {
					$random_link = SecretLink::GenerateRandomLink();
				} else {
					break;
				}
			} while(1);
			$ob->SetPublicLink($random_link);
			$res = SecretLink::InsertToDB($ob);
			if (Error::IsError($res)) {
				return $res;
			}
			return $ob;
		}

		public static function GenerateRandomLink() {
			return random_str(mt_rand(10, 20));
		}

		public static function WrapLinkToButton($link, $text = NULL) {
			if ($text === NULL) $text = Language::Word('get download link');
			$link = 'http://'.$_SERVER["HTTP_HOST"].$link;
			return '<button class="btn btn-info" onclick="get_temporary_link(\''.urlencode($link).'\');">'.$text.'</button>';
		}

		public function GetID() 		{ return $this->id; }
		public function GetAutorID() 	{ return $this->author_id; }
		public function GetPublicLink()	{ return $this->public_link; }
		public function GetActualLink()	{ return $this->actual_link; }
		public function GetCreatingDateStr() { return date('d : m : Y - H : i', $this->creating_date); }
		public function GetDeletingDateStr()    { return date('d : m : Y - H : i', $this->deleting_date); }

		public function SetID($n)			{ $this->id = $n; }
		public function SetAuthorID($n)		{ $this->author_id = $n; }
		public function SetPublicLink($n)	{ $this->public_link = $n; }
		public function SetActualLink($n)	{ $this->actual_link = $n; }
		public function SetCreatingDate($n)	{ $this->creating_date = $n; }
		public function SetDeletingDate($n)	{ $this->deleting_date = $n; }

		//---------------- IFetches implementation ----------------

		public static function FetchFromAssoc($assoc)
		{
			$ob = new self();
			if (ArrayElemIsValidStr($assoc, 'id')) 			$ob->SetID($assoc['id']);
			if (ArrayElemIsValidStr($assoc, 'author_id')) 	$ob->SetAuthorID($assoc['author_id']);
			if (ArrayElemIsValidStr($assoc, 'public_link')) $ob->SetPublicLink($assoc['public_link']);
			if (ArrayElemIsValidStr($assoc, 'actual_link')) 	$ob->SetActualLink($assoc['actual_link']);
			try {
				if (ArrayElemIsValidStr($assoc, 'creating_date')) {
					$ob->SetCreatingDate(strtotime($assoc['creating_date']));
				}
				if (ArrayElemIsValidStr($assoc, 'deleting_date')) {
					$ob->SetDeletingDate(strtotime($assoc['deleting_date']));
				}
			} catch(Exception $e) {
				$ob->SetCreatingDate($assoc['creating_date']);
				$ob->SetDeletingDate($assoc['deleting_date']);
			}
			return $ob;
		}

		public static function ArrayFromDBResult($result, $is_assoc = false)
		{
			$res = array();
			while ($row = $result->fetch_assoc()) {
				if ($is_assoc) {
					$row['creating_date'] = strtotime($row['creating_date']);
					$row['deleting_date'] = strtotime($row['deleting_date']);
					array_push($res, $row);
				}
				else array_push($res, self::FetchFromAssoc($row));
			}
			return $res;
		}

		public static function FetchBy($kwargs)
		{
			function is_unique_callback($kw, $rc) {
				$res_count = count($rc);
				$eq_conds = array();
				if (isset($kw['eq_conds'])) $eq_conds = $kw['eq_conds'];
				if ($res_count > 1) {
					return new Error('', Error::ambiguously);
				}
				if ($res_count === 0) {
					return new Error('', Error::not_found);
				}
				return true;
			}

			$tmp = $kwargs;
			$tmp['is_unique_callback'] = function($kw, $rc) { return is_unique_callback($kw, $rc); };
			$tmp['class_parent'] = new SecretLink;
			return FetchBy($tmp);
		}

		public static function InsertToDB($request)
		{
			global $db_connection;
			$author_id 	= $db_connection->real_escape_string($request->author_id);
			$public_link = $db_connection->real_escape_string($request->public_link);
			$actual_link = $db_connection->real_escape_string($request->actual_link);
			$res = $db_connection->query('INSERT INTO '.self::$table.' (author_id, public_link, actual_link, deleting_date) VALUES ('.$author_id.', "'.$public_link.'", "'.$actual_link.'", TIMESTAMP(date_add(NOW(), INTERVAL 1 day)))');
			if (!$res) {
				return new Error($db_connection->error, Error::db_error);
			}
			return true;
		}

		public static function Delete($id)
		{
			global $db_connection;
			$res = $db_connection->query('DELETE FROM '.self::$table.' WHERE id = '.$id);
			if (!$res) {
				return new Error($db_connection->error, Error::db_error);
			}
			return true;
		}

		public static function ClearOldLinks() {
			global $db_connection;
			$res = $db_connection->query('DELETE FROM '.self::$table.' WHERE creating_date < (NOW() - INTERVAL 1 DAY);');
			if (!$res) {
				return new Error($db_connection->error, Error::db_error);
			}
			return true;
		}
	}
	
?>