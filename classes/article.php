<?php
	//------------------------------------------------A R T I C L E------------------------------------------------
	
	class Article implements IAdminHTML, IUserHTML, IAutoHTML, IDelEdit, ISQLOps {
		//Methods and attributes for working with articles of lgmis.
		
		//--------Attributes--------
		
		private $id            = id_undef;
		private $author_id     = id_undef;
		public  $name          = undef;
		public  $annotation    = undef;
		public  $text_block    = undef;
		private $creating_date = time_undef;

		public  $path_to_image = undef;
		
		public static $type = 'article';
		public static $table = 'articles';

		public function GetCreatingDateStr()
		{
			return date('d : m : Y - H : i', $this->creating_date);
		}

		public function GetAuthorID()
		{
			return $this->author_id;
		}
		
		//--------Methods--------

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

		public function ToHTMLAutoShort($user_privileges)
		{
			switch ($user_privileges) {
				case admin_user_id:
					return $this->ToHTMLAdminShort();
				case unauthorized_user_id:
					return $this->ToHTMLUserPublicShort();
				case simple_user_id:
					return $this->ToHTMLUserPrivateShort();
				default:
					return html_undef;
			}
		}

		public function ToHTMLAutoShortForTable($user_privileges)
		{
			switch ($user_privileges) {
				case admin_user_id:
					return $this->ToHTMLAdminShortInTable();
				case unauthorized_user_id:
					return $this->ToHTMLUserPublicShortInTable();
				case simple_user_id:
					return $this->ToHTMLUserPrivateShortInTable();
				default:
					return html_undef;
			}
		}

		public function ToHTMLPrivateFull()
		{
			$res = '';

			$res .= '<div class="form-horizontal">';

			$res .= 	'<div class="row">';
			$res .= 		'<label class="'.ColAllTypes(3).' vcenter control-label">Дата создания</label>';
			$res .= 		'<div class="'.ColAllTypes(5).' vcenter">';
			$res .= 			SimplePanel(date('d : m : Y - H : i', $this->creating_date));
			$res .= 		'</div>';
			$res .= 	'</div>';

			$res .= 	'<div class="row">';
			$res .= 		'<label class="'.ColAllTypes(3).' vcenter control-label">Автор</label>';
			$res .= 		'<div class="'.ColAllTypes(5).' vcenter">';
			$res .= 			SimplePanel(User::FetchByID($this->author_id)->LinkToThis());
			$res .= 		'</div>';
			$res .= 	'</div>';

			$res .= 	'<div class="row">';
			$res .= 		'<label class="'.ColAllTypes(3).' vcenter control-label">Аннотация</label>';
			$res .= 		'<div class="'.ColAllTypes(5).' vcenter">';
			$res .= 			SimplePanel(htmlspecialchars($this->annotation));
			$res .= 		'</div>';
			$res .= 	'</div>';

			$res .= 	'<div class="row">';
			$res .= 		'<label class="'.ColAllTypes(3).' vcenter control-label">Обложка</label>';
			$res .= 		'<div class="'.ColAllTypes(5).' vcenter">';
			$res .= 			'<img src="'.$this->path_to_image.'" class="img-article-cover">';
			$res .= 		'</div>';
			$res .= 	'</div>';

			$res .= '<hr>';

			$res .= 	'<div class="row" align="center">';
			$res .= 		'<label class="control-label">Текст</label>';
			$res .= 	'</div>';
			$res .= 	'<div class="row" align="left">';
			$res .= 		'<div class="'.ColAllTypes(8).' '.ColOffsetAllTypes(2).'">';
			$res .= 			SimplePanel($this->text_block);
			$res .= 		'</div>';
			$res .= 	'</div>';

			if ((GetUserLogin() === User::FetchByID($this->author_id)->login) || (GetUserLogin() == 'admin')) {
				$res .= '<div class="row">';
				$res .= 	'<div class="'.ColAllTypes(6).'" align="right">';
				$res .=			'<div class="margin-sm">'.$this->ToHTMLEdit().'</div>';
				$res .=		'</div>';
				$res .= 	'<div class="'.ColAllTypes(6).'" align="left">';
				$res .=			'<div class="margin-sm">'.$this->ToHTMLDel().'</div>';
				$res .=		'</div>';
				$res .= '</div>';
			}

			$res .= '</div>';
			return $res;
		}
		
		
		//html code of short representation of object in string
		public function ToHTMLAdminShort()
		{
			$res = '';
			$res .= '<b>id</b>: '.$this->id.'; <b>author_id</b>: '.$this->author_id.'; <b>name</b>: '.htmlspecialchars($this->name).';<br>';
			$res .= '<b>creating_date</b>: '.date('d : m : Y - H : i', $this->creating_date);
			$res .= $this->ToHTMLDel().'<br>';
			$res .= $this->ToHTMLEdit().'<br>';
			$res .= $this->ToHTMLFullVers().'<br>';
			return $res;
		}

		public function ToHTMLAdminShortInTable()
		{
			$res = '<tr>';
			$res .= '<td>'.htmlspecialchars($this->name).'</td>';
			$res .= '<td>'.User::FetchByID($this->author_id)->LinkToThis().'</td>';
			$res .= '<td>'.date('d : m : Y - H : i', $this->creating_date).'</td>';
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

		public function ToHTMLUserPublicShortInTable()
		{
			$res = '<div class="row" style="color: grey;">';
			$res .= 	'<div class="'.ColAllTypes(4).'" style="padding-right: 0px;">';
			$res .= 		'<img class="img-article-cover" src="'.$this->path_to_image.'">';
			$res .= 	'</div>';
			$res .= 	'<div class="'.ColAllTypes(8).'">';
			$res .= 		'<div class="row">';
			$res .= 		'<div class="'.ColAllTypes(12).'">';
			$res .= 			ToPageHeader($this->name, 'h5', 'grey', 'normal');
			$res .= 		'</div>';
			$res .= 		'</div>';

			$res .= 		'<hr>';

			$res .= 		'<div class="row" align="left">';
			$res .= 		'<div class="'.ColAllTypes(12).'">';
			$res .= 			htmlspecialchars($this->annotation);
			$res .= 		'</div>';
			$res .= 		'</div>';
			$res .= 	'</div>';
			$res .= '</div>';

			$res .= '<div class="row"><div class="'.ColAllTypes(12).'"><hr></div></div>';
			$res .= '<div class="row" style="font-size: 11px">';
			$res .= 	'<div class="'.ColAllTypes(4).'">';
			$res .= 		date('d : m : Y - H : i', $this->creating_date);
			$res .= 	'</div>';
			$res .= 	'<div class="'.ColAllTypes(4).'" align="left">';
			$res .= 		'<font color="black">Автор:</font> '.User::FetchByID($this->author_id)->LinkToThis('btn-sm');
			$res .= 	'</div>';
			$res .= 	'<div class="'.ColAllTypes(4).'" align="right" style="padding-right: 30px;">';
			$res .= 		$this->ToHTMLFullVers();
			$res .= 	'</div>';
			$res .= '</div>';
			return $res;
		}

		//html code of short representation of object in string within internal pages of lgmis
		public function ToHTMLUserPrivateShort()
		{
			$res = '';
			$author_login = User::FetchByID($this->author_id)->login;
			if (GetUserLogin() == $author_login) $res .= '<b>id</b>: '.$this->id.'; ';
			$res .= '<b>author_id</b>: '.$this->author_id.'; <b>name</b>: '.htmlspecialchars($this->name).';<br>';
			if (GetUserLogin() == $author_login) {
				$res .= $this->ToHTMLDel().'<br>';
				$res .= $this->ToHTMLEdit().'<br>';
			}
			$res .= $this->ToHTMLFullVers().'<br>';
			return $res;
		}

		public function ToHTMLUserPrivateShortInTable()
		{
			$res = '<tr>';
			$res .= '<td>'.htmlspecialchars($this->name).'</td>';
			$res .= '<td>'.User::FetchByID($this->author_id)->LinkToThis().'</td>';
			$res .= '<td>'.date('d : m : Y - H : i', $this->creating_date).'</td>';
			$res .= '<td>';
			$res .=		'<div class="row">';
			$author_login = User::FetchByID($this->author_id)->login;
			if (GetUserLogin() === $author_login) {
				$res .= 	'<div class="'.ColAllTypes(4).'">';
			} else {
				$res .= 	'<div class="'.ColAllTypes(12).'">';
			}
			$res .= 			$this->ToHTMLFullVers();
			$res .=			'</div>';
			if (GetUserLogin() === $author_login) {
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
		
		//html code of full representation of object in string within public pages of lgmis
		public function ToHTMLUserPublicFull() { return html_undef; }
		//html code of short representation of object in string within public pages of lgmis
		public function ToHTMLUserPublicShort() { return html_undef; }
		
		public function ToHTMLDel()
		{
			global $link_to_utility_interceptor;
			$args = array(
				'action_link' => $link_to_utility_interceptor,
				'action_type' => 'del',
				'obj_type' => Article::$type,
				'id' => $this->id,
				'info' => 'Вы уверены, что хотите удалить статью с заголовком '.htmlspecialchars($this->name).'?',
			);
			return ActionButton($args);
		}
		
		public function ToHTMLEdit()
		{
			global $link_to_admin_article;
			$args = array(
				'action_link' => $link_to_admin_article,
				'action_type' => 'edit',
				'obj_type' => Article::$type,
				'id' => $this->id,
			);
			return ActionButton($args);
		}

		public function ToHTMLFullVers()
		{
			global $link_to_admin_article;
			global $link_to_public_article;

			global $link_to_admin_manage_content;
			global $content_types_short;
			$args = array();
			if (IsSessionPublic()) {
				$args = array(
					'action_link' => $link_to_public_article,
					'action_type' => 'full',
					'obj_type' => Article::$type,
					'id' => $this->id,
				);
			} else {
				$args = array(
					'action_link' => $link_to_admin_article,
					'action_type' => 'full',
					'obj_type' => Article::$type,
					'id' => $this->id,
					'prev_page' => $link_to_admin_manage_content.'?content_type='.$content_types_short['articles'],
				);
			}
			return ActionButton($args);
		}
		
		//Methods for fetching
		public static function FetchByID($id)
		{
			global $db_connection;
			$res = NULL;
			$result = $db_connection->query("SELECT * FROM `".Article::$table."` WHERE `id`=".$id);
			if ((!$result) || ($result->num_rows != 1)) {
				return NULL;
			}
			return Article::FetchFromAssoc($result->fetch_assoc());
		}

		public static function FetchByAuthorID($id)
		{
			global $db_connection;
			$res = array();
			$result = $db_connection->query("SELECT * FROM `".Article::$table."` WHERE author_id=\"".$id."\"");
			if (!$result) {
				return NULL;
			}
			while ($row = $result->fetch_assoc()) {
				array_push($res, Article::FetchFromAssoc($row));
			}
			return $res;
		}

		public static function FetchFromAssoc($assoc)
		{
			global $link_to_article_images;
			global $link_to_service_images;
			if ((!ArrayElemIsValidStr($assoc, 'author_id')) || (!ArrayElemIsValidStr($assoc, 'name')) ||
				(!ArrayElemIsValidStr($assoc, 'text_block'))) {
				return NULL;
			}
			$art = new self();
			if (isset($assoc['id']) && (strlen($assoc['id']))) $art->id = $assoc['id'];
			else $art->id = id_undef;
			if (isset($assoc['annotation']) && (strlen($assoc['annotation']))) $art->annotation = $assoc['annotation'];
			else $art->annotation = 'Нет аннотации';
			$art->author_id = $assoc['author_id'];
			$art->name = $assoc['name'];
			$art->text_block = $assoc['text_block'];
			try {
				if (isset($assoc['creating_date']) && (strlen($assoc['creating_date'])))
					$art->creating_date = strtotime($assoc['creating_date']);
				else $art->creating_date = time_undef;
			} catch(Exception $e) {
				$art->creating_date = time_undef;
			}
			$art->path_to_image = PathToImage($link_to_article_images.$art->id, 'cover', $link_to_service_images.'Logo.png');
			return $art;
		}

		public static function FetchFromPost()
		{
			return Article::FetchFromAssoc($_POST);
		}

		public static function FetchAll()
		{
			global $db_connection;
			$res = array();
			$result = $db_connection->query("SELECT * FROM `".Article::$table."` ORDER BY creating_date DESC");
			if (!$result) {
				return NULL;
			}
			while ($row = $result->fetch_assoc()) {
				array_push($res, Article::FetchFromAssoc($row));
			}
			return $res;
		}

		public static function InsertToDB($request)
		{
			global $db_connection;
			global $link_to_article_images;

			$author_id 	= $db_connection->real_escape_string($request->author_id);
			$name 		= $db_connection->real_escape_string($request->name);
			$annotation = $db_connection->real_escape_string($request->annotation);
			$res = $db_connection->query("INSERT INTO `".Article::$table."` (`id`, `author_id`, `name`, `annotation`, `text_block`, `creating_date`) VALUES ('0', '".$author_id."', '".$name."', '".$annotation."', '', CURRENT_TIMESTAMP)");
			if (!$res) {
				return false;
			}
			$id = $db_connection->insert_id;

			$request->text_block = preg_replace('/tmp_(\d+)\//', $id.'/', $request->text_block);
			$text_block = $db_connection->real_escape_string($request->text_block);
			$res = $db_connection->query("UPDATE `".Article::$table."` SET `text_block`=\"".$text_block."\" WHERE `id`=".$id);
			if (!$res) {
				echo $db_connection->error;
				$db_connection->query("DELETE FROM `".Article::$table."` WHERE `id` = ".$id);
				return false;
			}

			$request->id = $id;
			$upload_path = '';
			recurse_copy($link_to_article_images.'tmp_'.User::GetIDByLogin(GetUserLogin()), $link_to_article_images.$id);
			if (is_uploaded_file($_FILES['cover']['tmp_name'])) {
				$img_name = 'cover';
				$sepext = explode('.', strtolower($_FILES['cover']['name']));
			    $type = end($sepext);
			    $img_name .= '.'.$type;
			    $upload_path = $link_to_article_images.$id.'/'.$img_name;
			    if (move_uploaded_file($_FILES['cover']['tmp_name'], $upload_path)) {
			    	$request->path_to_image = $upload_path;
			    }
			}
			return true;
		}

		public function FetchFromAssocEditing($assoc)
		{
			if (ArrayElemIsValidStr($assoc, 'name')) $this->name = $assoc['name'];
			if (ArrayElemIsValidStr($assoc, 'annotation')) $this->annotation = $assoc['annotation'];
			if (ArrayElemIsValidStr($assoc, 'text_block')) $this->text_block = $assoc['text_block'];
		}

		public function FetchCoverFromAssocEditing($assoc)
		{
			if (isset($assoc['cover']['name']) && (is_uploaded_file($assoc['cover']['tmp_name']))) {
				global $link_to_article_images;
				$img_name = 'cover';
				$sepext = explode('.', strtolower($assoc['cover']['name']));
			    $type = end($sepext);
			    $img_name .= '.'.$type;
			    $upload_path = $link_to_article_images.$this->id.'/'.$img_name;
			    if (!delete_image($link_to_article_images.$this->id.'/cover')) {
			    	return -1;
			    } else if (!move_uploaded_file($assoc['cover']['tmp_name'], $upload_path)) {
			    	return -1;
			    } else {
			    	return 1;
			    }
			}
			return 0;
		}

		//Methods for pushing
		public function Save()
		{
			global $db_connection;
			$res = $db_connection->query("SELECT `id` FROM `".Article::$table."` WHERE (`id`=".$this->id.")");
			if (!$res) {
				echo $db_connection->error;
				return false;
			} else {
				if ($res->num_rows == 0) {
					echo 'there are no article with id = '.$this->id;
					return false;
				}
			}
			$name_tmp 		= $db_connection->real_escape_string($this->name);
			$annotation_tmp = $db_connection->real_escape_string($this->annotation);
			$text_block_tmp = $db_connection->real_escape_string($this->text_block);
			$res = $db_connection->query("UPDATE `".Article::$table."` SET `name`=\"".$name_tmp."\", `annotation`=\"".$annotation_tmp."\", `text_block`=\"".$text_block_tmp."\" WHERE `id`=".$this->id);
			if (!$res) {
				echo $db_connection->error;
				return false;
			}
			return true;
		}

		public static function Delete($id)
		{
			global $db_connection;
			global $link_to_article_images;

			if (!$db_connection->query("DELETE FROM `".Article::$table."` WHERE `id` = ".$id)) {
				return 0;
			} else {
				removeDirectory($link_to_article_images.$id);
				return 1;
			}
		}
	}
?>