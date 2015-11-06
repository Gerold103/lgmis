<?php

	class Report {
		private $id;
		private $author_id;
		private $name;
		private $text_block;
		private $creating_date;
		public 	$recipient_ids = [];

		private $path_to_file = unef;
		
		const cachable = false;
		const translated = false;

		public static $type = 'report';
		public static $table = 'reports';

		public static function GetCount($kwargs = [])
		{
			extract($kwargs, EXTR_PREFIX_ALL, 't');

			$where_addition = '';

			if (isset($t_where_addition)) $where_addition = $t_where_addition;

			if (StringNotEmpty($where_addition)) $where_addition = ' WHERE '.$where_addition;
			global $db_connection;
			$res = $db_connection->query("SELECT COUNT(*) FROM ".self::$table.$where_addition);
			if ($res) {
				if ($res->num_rows > 0) {
					return $res->fetch_row()[0];
				}
				return new Error('', Error::not_found);
			}
			return new Error($db_connection->error, Error::db_error);
		}
		public function GetID() 			{ return $this->id; }
		public function GetAuthorID() 		{ return $this->author_id; }
		public function GetName()			{ return $this->name; }
		public function GetTextBlock() 		{ return $this->text_block; }
		public function GetCreatingDate() 	{ return date('d : m : Y - H : i', $this->creating_date); }
		public function GetPathToFile()		{ return $this->path_to_file; }
		public function GetLinkToFile()		{
			global $link_to_utility_download;
			global $link_to_logo;

			if ($this->path_to_file === $link_to_logo) {
				$res = '<a class="btn btn-default">'.Language::Word('no file').'</a>';
			} else $res = '<a class="btn btn-warning" href="'.$link_to_utility_download.'?file_path='.urlencode($this->path_to_file).'">'.Language::Word('download file').'</a>';
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

			$users = '';
			$receivers = User::FetchBy(['select_list' => 'id, name, surname', 'where_addition' => '(received_reports LIKE "%\"'.$this->id.'\"%")']);
			foreach ($receivers as $key => $user) {
				$users .= '<div class="row">';
				$users .= 	'<div class="'.ColAllTypes(12).'">';
				$users .= 		$user->LinkToThis();
				$users .= 	'</div>';
				$users .= '</div>';
			}
			$author = User::FetchBy(['select_list' => 'id, name, surname', 'eq_conds' => ['id' => $this->author_id], 'is_unique' => true]);
			$link_to_author = '';
			if (Error::IsError($author)) {
				if (Error::IsType($author, Error::not_found)) {
					$link_to_author = Language::Word('not found');
				} else {
					return AlertMessage('Error while fethching author of report: '.Error::ToString($author));
				}
			} else {
				$link_to_author = $author->LinkToThis();
			}
			$res .= PairLabelAndPanel(3, 5, Language::Word('receivers'), $users);
			$res .= PairLabelAndPanel(3, 5, Language::Word('creating date'), $this->GetCreatingDate());
			$res .= PairLabelAndPanel(3, 5, Language::Word('author'), $link_to_author);
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
			$author_login = '';
			if (is_a($author, 'User')) $author_login = $author->GetLogin();
			else $author_login = '';
			if (GetUserLogin() == 'admin') {
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
			$author = User::FetchBy(['select_list' => 'id, name, surname, login', 'eq_conds' => ['id' => $this->author_id], 'is_unique' => true]);
			$link_to_author = '';
			if (Error::IsError($author)) {
				if (Error::IsType($author, Error::not_found)) {
					$link_to_author = Language::Word('not found');
				} else {
					return AlertMessage('Error while fethching author of report: '.Error::ToString($author));
				}
			} else {
				$link_to_author = $author->LinkToThis();
			}

			$users = '';
			$receivers = User::FetchBy(['select_list' => 'id, name, surname', 'where_addition' => '(received_reports LIKE "%\"'.$this->id.'\"%")']);
			foreach ($receivers as $key => $user) {
				$users .= '<div class="row">';
				$users .= 	'<div class="'.ColAllTypes(12).'">';
				$users .= 		$user->LinkToThis();
				$users .= 	'</div>';
				$users .= '</div>';
			}

			$res = '<tr>';
			$res .= '<td>'.$link_to_author.'</td>';
			$res .= '<td>'.$users.'</td>';
			$res .= '<td>'.htmlspecialchars($this->GetName()).'</td>';
			$res .= '<td>'.$this->GetCreatingDate().'</td>';
			$res .= '<td>';
			$res .=		'<div class="row">';
			$author_login = '';
			if (is_a($author, 'User')) $author_login = $author->GetLogin();
			else $author_login = '';
			if (GetUserLogin() === 'admin') {
				$res .= 	'<div class="'.ColAllTypes(4).'">';
			} else {
				$res .= 	'<div class="'.ColAllTypes(12).'">';
			}
			$res .= 			$this->ToHTMLFullVers();
			$res .=			'</div>';
			if (GetUserLogin() === 'admin') {
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

		public static function ArrayFromDBResult($result)
		{
			$res = array();
			while ($row = $result->fetch_assoc()) {
				array_push($res, self::FetchFromAssoc($row));
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
				if (is_string($value_tmp)) $value_tmp = '"'.$value_tmp.'"';
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
					default: break;
				}
			}

			if (!$is_unique) return $res;
			else return $res[0];
		}	

		public static function FetchFromAssoc($assoc)
		{
			global $link_to_service_images;
			global $link_to_report_files;
			$ob = new self();

			if (ArrayElemIsValidStr($assoc, 'id')) $ob->id = $assoc['id'];
			if (ArrayElemIsValidStr($assoc, 'author_id')) $ob->author_id = $assoc['author_id'];
			if (ArrayElemIsValidStr($assoc, 'recipient_id')) $ob->recipient_id = $assoc['recipient_id'];
			if (ArrayElemIsValidStr($assoc, 'name')) $ob->name = $assoc['name'];
			if (ArrayElemIsValidStr($assoc, 'text_block')) $ob->text_block = $assoc['text_block'];
			if (isset($assoc['recipient_ids'])) {
				if (is_string($assoc['recipient_ids'])) {
					$tmp = [];
					if (ArrayElemIsValidStr($assoc, 'recipient_ids')) $tmp = json_decode($assoc['recipient_ids']);
					$ob->recipient_ids = $tmp;
				} else {
					$ob->recipient_ids = $assoc['recipient_ids'];
				}
			}
			try {
				if (ArrayElemIsValidStr($assoc, 'creating_date'))
					$ob->creating_date = strtotime($assoc['creating_date']);
			} catch(Exception $e) {
				$ob->creating_date = $assoc['creating_date'];
			}
			if (ArrayElemIsValidStr($assoc, 'id'))
				$ob->path_to_file = PathToFile($link_to_report_files.$ob->id, 'file', $link_to_service_images.'Logo.png');
			return $ob;
		}

		public function FetchFromAssocEditing($assoc)
		{
			if (ArrayElemIsValidStr($assoc, 'name')) $this->name = $assoc['name'];
			if (ArrayElemIsValidStr($assoc, 'text_block')) $this->text_block = $assoc['text_block'];
			if (ArrayElemIsValidStr($assoc, 'files_count')) {
				$cnt = $assoc['files_count'];
				if ($cnt > 0) {
					global $link_to_report_files;
					global $link_prefix;
					delete_file($link_to_report_files.$this->id.'/file');
					recurse_copy($link_to_report_files.'tmp_'.GetUserID(), $link_to_report_files.$this->id);
				}
			}
			if (isset($assoc['recipient_ids'])) {
				if (is_string($assoc['recipient_ids'])) {
					if (ArrayElemIsValidStr($assoc, 'recipient_ids'))
						$this->recipient_ids = json_decode($assoc['recipient_ids']);
				} else {
					$this->recipient_ids = $assoc['recipient_ids'];
				}
			}
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

		public function ToHTMLFullVersLite()
		{
			global $link_to_admin_report;
			global $link_prefix;
			$protocol = !empty($_SERVER['HTTPS']) ? 'https://' : 'http://';
    		$site = $protocol. $_SERVER['SERVER_NAME'] .$link_prefix;
			return $site.$link_to_admin_report.'?id='.$this->id;
		}

		public static function InsertToDB($request)
		{
			global $db_connection;
			global $link_to_report_images;
			global $link_to_report_files;

			$author_id 	= $db_connection->real_escape_string($request->author_id);
			$name 		= $db_connection->real_escape_string($request->name);
			$res = $db_connection->query("INSERT INTO `".self::$table."` (`author_id`, `name`) VALUES ('".$author_id."', '".$name."')");
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
			recurse_copy($link_to_report_images.'tmp_'.GetUserID(), $link_to_report_images.$id);
			recurse_copy($link_to_report_files.'tmp_'.GetUserID(), $link_to_report_files.$id);
			$receiver_emails = [];

			foreach ($request->recipient_ids as $key => $aim) {
				$received = User::FetchBy(['select_list' => 'received_reports, email', 'is_unique' => true, 'eq_conds' => ['id' => $aim]]);
				if (Error::IsError($received)) {
					echo Error::ToString($received);
					return false;
				}
				$tmp = $received->GetReceivedReports();
				array_push($tmp, $id.'');
				$rc = $db_connection->query("UPDATE users SET received_reports = '".($db_connection->real_escape_string(json_encode($tmp)))."' WHERE id = ".$aim);
				if (!$rc) {
					echo $db_connection->error;
					return false;
				}
				array_push($receiver_emails, $received->GetEmail());
			}
			$sended = User::FetchBy(['select_list' => 'sended_reports', 'is_unique' => true, 'eq_conds' => ['id' => $request->GetAuthorID()]]);
			if (Error::IsError($sended)) {
				echo Error::ToString($sended);
				return false;
			}
			$tmp = $sended->GetSendedReports();
			array_push($tmp, $id.'');
			$rc = $db_connection->query("UPDATE users SET sended_reports = '".($db_connection->real_escape_string(json_encode($tmp)))."' WHERE id = ".$request->GetAuthorID());
			if (!$rc) {
				echo $db_connection->error;
				return false;
			}

			$receiver_emails = array_unique($receiver_emails);
			foreach ($receiver_emails as $key => $email) {
				$subject = 'New report on lgmis.cs.msu.ru';
				$message = '<html>';
				$message .= 	'<head><title>New report from on your name</title></head>';
				$message .= 	'<body>';
				$message .= 		'<table width="100%" align="center">';
				$message .= 			'<tr><td>You can see more information about this report: <a href="'.$request->ToHTMLFullVersLite().'">go on site</a></td></tr>';
				$message .= 		'</table>';
				$message .= 	'</body>';
				$message .= '</html>';
				$headers = 'From: LGMIS Admin <no-reply@lgmis.cs.msu.ru>'.PHP_EOL.
					'Reply-To: <no-reply@lgmis.cs.msu.ru>'.PHP_EOL.'X-Mailer: PHP/'.phpversion().'MIME-Version: 1.0'.PHP_EOL.
					'Content-type: text/html; charset=UTF-8'.PHP_EOL;
				if (!mail($email, $subject, $message, $headers, '-f no-reply@lgmis.cs.msu.ru')) {
					echo 'error:'.error_get_last();
					return false;
				}
			}

			return true;
		}

		public function Save()
		{
			global $db_connection;
			$res = self::FetchBy(['select_list' => 'id', 'eq_conds' => ['id' => $this->id], 'is_unique' => true]);
			if (Error::IsError($res)) return $res;
			$name 		= $db_connection->real_escape_string($this->name);
			$text_block = $db_connection->real_escape_string($this->text_block);
			$res = $db_connection->query("UPDATE `".self::$table."` SET `name`=\"".$name."\", `text_block`=\"".$text_block."\" WHERE `id`=".$this->id);
			if (!$res) {
				return new Error($db_connection->error, Error::db_error);
			}
			if (count($this->recipient_ids) === 0) return true;

			//delete from old receivers
			$old_receivers = User::FetchBy(['select_list' => 'received_reports, id', 'where_addition' => '(received_reports LIKE ("%\"'.$this->id.'\"%"))']);
			foreach ($old_receivers as $key => $user) {
				$tmp = [];
				foreach ($user->GetReceivedReports() as $key2 => $repid) {
					if ($repid != $this->id) array_push($tmp, $repid);
				}
				$rc = $db_connection->query('UPDATE '.User::$table.' SET received_reports = "'.$db_connection->real_escape_string(json_encode($tmp)).'" WHERE id = '.$user->GetID());
				if (!$rc) {
					return new Error($db_connection->error, Error::db_error);
				}
			}
			//add to new receivers
			foreach ($this->recipient_ids as $key => $user_id) {
				$user = User::FetchBy(['select_list' => 'received_reports', 'eq_conds' => ['id' => $user_id], 'is_unique' => true]);
				if (Error::IsError($user)) return $user;
				$tmp = $user->GetReceivedReports();
				array_push($tmp, $this->id);
				$rc = $db_connection->query('UPDATE '.User::$table.' SET received_reports = "'.$db_connection->real_escape_string(json_encode($tmp)).'" WHERE id = '.$user_id);
				if (!$rc) {
					return new Error($db_connection->error, Error::db_error);
				}
			}
			return true;
		}

		public static function Delete($id)
		{
			global $db_connection;
			global $link_to_report_images;
			global $link_to_report_files;
			global $link_to_logo;

			$ob = Report::FetchBy(['select_list' => 'id, author_id', 'eq_conds' => ['id' => $id], 'is_unique' => true]);
			if (Error::IsError($ob)) {
				return $ob;
			}
			if (!$db_connection->query("DELETE FROM `".self::$table."` WHERE `id` = ".$id)) {
				echo $db_connection->error;
				return 0;
			} else {
				removeDirectory($link_to_report_images.$id);
				removeDirectory($link_to_report_files.$id);

				$sended = User::FetchBy(['select_list' => 'sended_reports', 'eq_conds' => ['id' => $ob->GetAuthorID()], 'is_unique' => true]);
				$new_sended = [];
				foreach ($sended->GetSendedReports() as $key => $repid) {
					if ($repid != $id) array_push($new_sended, $repid);
				}
				$rc = $db_connection->query('UPDATE '.User::$table.' SET sended_reports = "'.$db_connection->real_escape_string(json_encode($new_sended)).'" WHERE id = '.$ob->GetAuthorID());
				if (!$rc) {
					return new Error($db_connection->error, Error::db_error);
				}
				$received = User::FetchBy(['select_list' => 'received_reports, id', 'where_addition' => '(received_reports LIKE ("%\"'.$id.'\"%"))']);
				if (Error::IsError($received)) {
					return $received;
				}
				foreach ($received as $key => $user) {
					$new_received = [];
					foreach ($user->GetReceivedReports() as $key => $repid) {
						if ($repid != $id) array_push($new_received, $repid);
					}
					$rc = $db_connection->query('UPDATE '.User::$table.' SET received_reports = "'.$db_connection->real_escape_string(json_encode($new_received)).'" WHERE id = '.$user->GetID());
					if (!$rc) {
						return new Error($db_connection->error, Error::db_error);
					}
				}
				return 0;
			}
		}
	}

?>