<?php
	//------------------------------------------------ M Y   F I L E ------------------------------------------------
	
	class MyFile {
		const perm_to_all_registered = 0;
		const perm_to_only_empls = 15;

		//--------Attributes--------

		private $id = id_undef;
		private $owner_id = id_undef;
		private $name = undef;
		private $path_to_file = array();
		private $creating_date = time_undef;
		private $permissions = self::perm_to_only_empls;
		private $is_directory = false;

		public static $type = 'myfile';
		public static $table = 'myfiles';

		public function GetID() 			{ return $this->id; }
		public function GetOwnerID() 		{ return $this->owner_id; }
		public function GetName() 			{ return $this->name; }
		public function GetPathToFile() 	{ return $this->path_to_file; }
		public function GetCreatingDate() 	{ return $this->creating_date; }
		public function GetPermissions() 	{ return $this->permissions; }
		public function IsDir()				{ return $this->is_directory; }

		public function GetLinkToDelete()	{ 
			$res = '<a class="btn btn-danger" href="#" onclick="deleteFile('.$this->id.');">'.Language::ActionTypeToText('del').'</a>';
			return $res;
		}

		public function GetLinkToFile()		{
			global $link_to_utility_download;
			global $link_to_logo;

			$path = '';
			for ($i = 0, $size = count($this->path_to_file); $i < $size; ++$i) {
				$path .= urlencode($this->path_to_file[$i]).urlencode('/');
			}
			$name = urlencode($this->name);
			if (!$this->is_directory) {
				$res = '<a class="btn btn-warning" href="'.$link_to_utility_download.'?file_path='.$path.$name.'">'.Language::Word('download file').'</a>';
				return $res;
			} else {
				//$res = '<a class="btn btn-warning" href="'.$link_to_utility_download.'?file_path='.urlencode($path).'">'.Language::
				return $res;
			}
		}

		public static function PermissionsFromString($str) {
			switch ($str) {
				case 'for_employees': return MyFile::perm_to_only_empls;
				case 'for_registered': return MyFile::perm_to_all_registered;
				default: return -1;
			}
		}

		//---------------- IHTMLAuto implementation ----------------

		public function ToHTMLAutoFull($user_privileges)
		{
			switch ($user_privileges) {
				case admin_user_id: case simple_user_id:
					return $this->ToHTMLPrivateFull();
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

		public function ToHTMLPrivateFull() { return html_undef; }

		public function ToHTMLUserPublicFull() { return html_undef; }

		public function ToHTMLUserPublicShortInTable() { return html_undef; }

		public function ToHTMLUserPrivateShortInTable() {

		}

		//---------------- IActions implementation ----------------

		public function ToHTMLDel() {

		}

		public function ToHTMLEdit() {

		}

		public function ToHTMLFullVers() { return html_undef; }

		//---------------- ILinkable implementation ----------------

		public function LinkToThis() {

		}

		//---------------- IFetches implementation ----------------

		public static function FetchFromAssoc($assoc) {
			$ob = new self();
			if (ArrayElemIsValidStr($assoc, 'id')) 			$ob->id = $assoc['id'];
			if (ArrayElemIsValidStr($assoc, 'owner_id')) 	$ob->owner_id = $assoc['owner_id'];
			if (ArrayElemIsValidStr($assoc, 'name')) 		$ob->name = $assoc['name'];
			if (isset($assoc['is_directory']))				$ob->is_directory = $assoc['is_directory'];
			if (isset($assoc['path_to_file'])) {
				if (is_string($assoc['path_to_file'])) $ob->path_to_file = json_decode($assoc['path_to_file']);
				else $ob->path_to_file = $assoc['path_to_file'];
			}
			if (ArrayElemIsValidStr($assoc, 'permissions'))	$ob->permissions = $assoc['permissions'];
			try {
				if (ArrayElemIsValidStr($assoc, 'creating_date')) $ob->creating_date = strtotime($assoc['creating_date']);
			} catch(Exception $e) {
				$ob->creating_date = $assoc['creating_date'];
			}
			return $ob;
		}

		public static function ArrayFromDBResult($result, $is_assoc = false)
		{
			$res = array();
			while ($row = $result->fetch_assoc()) {
				if ($is_assoc) {
					$row['creating_date'] = strtotime($row['creating_date']);
					array_push($res, $row);
				}
				else array_push($res, self::FetchFromAssoc($row));
			}
			return $res;
		}

		public static function FetchBy($kwargs)
		{
			extract($kwargs, EXTR_PREFIX_ALL, 't');

			$select_list 	= '*';
			$eq_conds 		= array();
			$order_by 		= '';
			$limit 			= '';
			$offset 		= '';
			$where_addition = '';
			$is_assoc 		= false;
			$is_unique		= false;
			$special 		= array();

			if (isset($t_select_list)) 		$select_list = $t_select_list;
			if (isset($t_eq_conds)) 		$eq_conds = $t_eq_conds;
			if (isset($t_order_by)) 		$order_by = $t_order_by;
			if (isset($t_limit)) 			$limit = $t_limit;
			if (isset($t_offset)) 			$offset = $t_offset;
			if (isset($t_where_addition)) 	$where_addition = $t_where_addition;
			if (isset($t_is_assoc)) 		$is_assoc = $t_is_assoc;
			if (isset($t_is_unique))		$is_unique = $t_is_unique;
			if (isset($t_special))			$special = $t_special;

			global $db_connection;

			$where_clause = '';
			$i = 0;
			$size = count($eq_conds);
			$need_where_word = ($size !== 0) || StringNotEmpty($where_addition);
			foreach ($eq_conds as $key => $value) {
				$value_tmp = $db_connection->real_escape_string($value);
				if (is_string($value)) $value_tmp = '"'.$value_tmp.'"';
				$where_clause .= ' ('.$key.' = '.$value_tmp.') ';
				if ($i < $size - 1) $where_clause .= 'OR';
				++$i;
			}
			if ($need_where_word) {
				if (StringNotEmpty($where_clause) && StringNotEmpty($where_addition)) {
					$where_clause = '('.$where_clause.') AND ';
					$where_addition = '('.$where_addition.')';
				}
				$where_clause = "WHERE ".$where_clause.' '.$where_addition;
			}

			if (StringNotEmpty($order_by)) {
				$where_clause .= ' ORDER BY '.$order_by;
			}

			if (StringNotEmpty($limit))
				$where_clause .= ' LIMIT '.$limit;
			if (StringNotEmpty($offset)) {
				$where_clause .= ' OFFSET '.$offset;
			}

			if (!StringNotEmpty($lang)) $lang = GetLanguage();

			$from_table = self::$table;

			$res = $db_connection->query("SELECT ".$select_list." FROM ".$from_table." ".$where_clause);
			if (!$res) {
				return new Error($db_connection->error, Error::db_error);
			}
			$res = self::ArrayFromDBResult($res, $is_assoc);
			$res_count = count($res);

			if ($is_unique) {
				if ($res_count > 1) return Error::ambiguously;
				if ($res_count === 0) return Error::not_found;
			}

			for ($i = 0, $count = count($special); $i < $count; ++$i) {
				switch ($special[$i]) {
					case 'file_type': {
						if ($is_assoc === false) break;
						global $valid_extensions;
						for ($j = 0; $j < $res_count; ++$j) {
							if (isset($res[$j]['name'])) {
								$type = fileExtension($res[$j]['name']);
								if (!in_array($type, $valid_extensions)) $type = 'file';
								$res[$j]['file_type'] = $type;
							}
						}
						break;
					}
					case 'link_to_download': {
						if ($is_assoc === false) break;
						for ($j = 0; $j < $res_count; ++$j) {
							if (isset($res[$j]['path_to_file']) && isset($res[$j]['name']) && isset($res[$j]['is_directory'])) {
								$tmp = self::FetchFromAssoc(['path_to_file' => $res[$j]['path_to_file'], 'name' => $res[$j]['name'],
									'is_directory' => $res[$j]['is_directory']]);
								$res[$j]['link_to_download'] = $tmp->GetLinkToFile();
							}
						}
						break;
					}
					case 'link_to_delete': {
						if ($is_assoc === false) break;
						for ($j = 0; $j < $res_count; ++$j) {
							if (isset($res[$j]['id'])) {
								$tmp = self::FetchFromAssoc(['id' => $res[$j]['id']]);
								$res[$j]['link_to_delete'] = $tmp->GetLinkToDelete();
							}
						}
						break;
					}
					default: break;
				}
			}

			if (!$is_unique) return $res;
			else return $res[0];
		}

		public function Delete()
		{
			global $db_connection;
			global $link_prefix;

			$file_path = '';
			foreach ($this->path_to_file as $key => $value) {
				$file_path .= $value.'/';
			}
			$file_path .= $this->name;
			$file_path = $_SERVER['DOCUMENT_ROOT'].$link_prefix.$file_path;

			if (!file_exists($file_path)) {
				return Error::not_found;
			}
			$res = NULL;
			if (!$this->is_directory) {
				unlink($file_path);
				$res = $db_connection->query("DELETE FROM ".self::$table." WHERE id = ".$this->id);
			} else {
				var_dump($file_path);
				//removeDirectory($file_path);
				$tmp = $this->path_to_file;
				array_push($tmp, $this->name);
				$tmp = json_encode($tmp);
				$tmp = $db_connection->real_escape_string(str_replace(']', ',', $tmp));
				var_dump($tmp);
				var_dump("DELETE FROM ".self::$table." WHERE path_to_file LIKE(\"".$tmp."%\")");
				//$res = $db_connection->query("DELETE FROM ".self::$table." WHERE path_to_file LIKE(\"".$tmp."%\")");
			}
			if (!$res) return new Error($db_connection->error, Error::db_error);
			return true;
		}

		public static function InsertToDB($request)
		{
			global $db_connection;

			$owner_id 	= $db_connection->real_escape_string($request->owner_id);
			$name 		= $db_connection->real_escape_string($request->name);
			$path_to_file = $db_connection->real_escape_string(json_encode($request->path_to_file));
			$permissions = $db_connection->real_escape_string($request->permissions);
			$is_directory = ($request->is_directory) ? 1 : 0;

			$insert_table = self::$table;
			$res = $db_connection->query("INSERT INTO `".$insert_table."` (`owner_id`, `name`, `path_to_file`, `permissions`, `is_directory`) VALUES ('".$owner_id."', '".$name."', '".$path_to_file."', '".$permissions."', '".$is_directory."')");
			if (!$res) {
				echo $db_connection->error;
				return new Error($db_connection->error, Error::db_error);
			}
			$request->id = $db_connection->insert_id;
			return true;
		}
	}
?>