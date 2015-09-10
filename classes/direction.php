<?php
	//------------------------------------------------D I R E C T I O N------------------------------------------------
	
	class Direction implements IAdminHTML, IUserHTML, IAutoHTML, IDelEdit, ISQLOps {
		//Methods and attributes for working with directions of lgmis work.
		
		//--------Attributes--------
		
		public  $id            = id_undef;
		private $author_id     = id_undef;
		public  $name          = undef;
		public  $text_block    = undef;
		private $creating_date = time_undef;

		public  $path_to_image = undef;
		public  $language = undef;

		public static $type = 'direction';
		public static $table = 'directions';

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
					return $this->ToHTMLUserPrivateFull();
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
				case admin_user_id: case simple_user_id:
					return $this->ToHTMLUserPrivateShortInTable();
				case unauthorized_user_id:
					return $this->ToHTMLUserPublicShortInTable();
				default:
					return html_undef;
			}
		}
		
		//html code of short representation of object in string
		public function ToHTMLAdminShort()
		{
			$res = '';
			$res .= '<b>id</b>: '.$this->id.'; <b>author_id</b>: '.$this->author_id.';<br>';
			$res .= '<b>name</b>: '.htmlspecialchars($this->name).';<br>';
			$res .= '<b>creating_date</b>: '.date('d : m : Y - H : i', $this->creating_date).';<br>';
			$res .= $this->ToHTMLDel().'<br>';
			$res .= $this->ToHTMLEdit().'<br>';
			$res .= $this->ToHTMLFullVers().'<br>';
			return $res;	
		}

		//html code of full representation of object in string within internal pages of lgmis
		public function ToHTMLUserPrivateFull()
		{
			$res = '';

			$res .= '<div class="form-horizontal">';

			$res .= 	'<div class="row">';
			$res .= 		'<label class="'.ColAllTypes(3).' vcenter control-label">'.Language::Word('creating date').'</label>';
			$res .= 		'<div class="'.ColAllTypes(5).' vcenter">';
			$res .= 			SimplePanel(date('d : m : Y - H : i', $this->creating_date));
			$res .= 		'</div>';
			$res .= 	'</div>';

			$res .= 	'<div class="row">';
			$res .= 		'<label class="'.ColAllTypes(3).' vcenter control-label">'.Language::Word('author').'</label>';
			$res .= 		'<div class="'.ColAllTypes(5).' vcenter">';
			$res .= 			SimplePanel(User::FetchByID($this->author_id)->LinkToThis());
			$res .= 		'</div>';
			$res .= 	'</div>';

			$res .= 	'<div class="row">';
			$res .= 		'<label class="'.ColAllTypes(3).' vcenter control-label">'.Language::Word('cover').'</label>';
			$res .= 		'<div class="'.ColAllTypes(5).' vcenter">';
			$res .= 			'<img src="'.$this->path_to_image.'" class="img-article-cover">';
			$res .= 		'</div>';
			$res .= 	'</div>';

			$res .= '<hr>';

			$res .= 	'<div class="row" align="center">';
			$res .= 		'<label class="control-label">'.Language::Word('text').'</label>';
			$res .= 	'</div>';
			$res .= 	'<div class="row" align="left">';
			$res .= 		'<div class="'.ColAllTypes(8).' '.ColOffsetAllTypes(2).'">';
			$res .= 			SimplePanel($this->text_block);
			$res .= 		'</div>';
			$res .= 	'</div>';

			$res .= 	'<div class="row">';
			if ((GetUserLogin() == User::FetchByID($this->author_id)->login) || (GetUserLogin() == 'admin')) {
				$res .= 	'<div class="'.ColAllTypes(4).'" align="right">';
				$res .=			'<div class="margin-sm">'.$this->ToHTMLEdit().'</div>';
				$res .=		'</div>';
				$res .= 	'<div class="'.ColAllTypes(4).'" align="center">';
				$res .=			'<div class="margin-sm">'.$this->ToHTMLDel().'</div>';
				$res .=		'</div>';
				$res .= 	'<div class="'.ColAllTypes(4).'" align="left">';
			} else {
				$res .= 	'<div class="'.ColAllTypes(12).'" align="center">';
			}
			$res .=				'<div class="margin-sm">'.$this->ToHTMLAddLanguage().'</div>';
			$res .= 	'</div>';
			$res .= '</div>';

			$needed_projs = Project::FetchByDirectionID($this->id);

			$size = count($needed_projs);
			if ($size === 0) {
				return $res;
			}
			$page = 1;
			$cur_page = 1;
			$from = -1;
			$to = -1;
			global $link_to_pagination_init_template;
			require($link_to_pagination_init_template);

			$res .= '<hr>';
			$res .= '<div class="row">'.ToPageHeader(Language::Word('linked projects'), 'h3').'</div>';
			$res .= '<div class="row">';
			$res .= 	'<div class="'.ColAllTypes(1).' center-block"></div>';
			$res .= 	'<div class="'.ColAllTypes(10).' center-block">';
			$res .= 		'<table class="table table-striped text-center">';
			$res .= 			'<thead>';
			$res .= 				'<tr>';
			$res .=						'<th class="text-center" width="20%">'.Language::Word('direction').'</th>';
			$res .=						'<th class="text-center">'.Language::Word('object name').'</th>';
			$res .=						'<th class="text-center">'.Language::Word('date').'</th>';
			$res .=						'<th class="text-center">'.Language::Word('author').'</th>';
			$res .=						'<th class="text-center">'.Language::Word('actions').'</th>';
			$res .=					'</tr>';
			$res .=				'</thead>';
			$res .=				'<tbody>';
			for ($i = $from; $i <= $to; ++$i) {
				$res .= $needed_projs[$i]->ToHTMLAutoShortForTable(GetUserPrivileges());
			}
			$res .= 			'</tbody>';
			$res .= 		'</table>';
			$res .= 	'</div>';
			$res .= '</div>';

			$pagination = '';
			global $link_to_pagination_show_template;
			require($link_to_pagination_show_template);
			$res .= $pagination;
			return $res;
		}
		//html code of short representation of object in string within internal pages of lgmis
		public function ToHTMLUserPrivateShort()
		{
			$res = '';
			$author_login = User::FetchByID($this->author_id)->login;
			if (GetUserLogin() == $author_login) $res .= '<b>id</b>: '.$this->id.'; ';
			$res .= '<b>author_id</b>: '.$this->author_id.';<br>';
			$res .= '<b>name</b>: '.htmlspecialchars($this->name).';<br>';
			$res .= '<b>creating_date</b>: '.date('d : m : Y - H : i', $this->creating_date).';<br>';
			if (GetUserLogin() == $author_login) {
				$res .= $this->ToHTMLDel().'<br>';
				$res .= $this->ToHTMLEdit().'<br>';
			}
			$res .= $this->ToHTMLFullVers().'<br>';
			return $res;
		}

		public function ToHTMLUserPublicShortInTable()
		{
			$res = '';
			$res .= '<div class="row">';
			$res .= 	ToPageHeader($this->name, 'h4', 'black');
			$res .= 	'<img class="img-direction-cover" src="'.Link::Get($this->path_to_image).'">';
			$res .= 	$this->ToHTMLFullVers();
			$res .= '</div>';
			return $res;
		}

		public function ToHTMLUserPrivateShortInTable()
		{
			$author = User::FetchByID($this->author_id);
			$res = '<tr>';
			$res .= '<td>'.htmlspecialchars($this->name).'</td>';
			$res .= '<td>'.date('d : m : Y - H : i', $this->creating_date).'</td>';
			$res .= '<td>'.$author->LinkToThis().'</td>';
			$res .= '<td>';
			$res .=		'<div class="row">';
			if ((GetUserLogin() === $author->login) || (GetUserLogin() === 'admin')) {
				$res .= 	'<div class="'.ColAllTypes(4).'">';
			} else {
				$res .= 	'<div class="'.ColAllTypes(12).'">';
			}
			$res .= 			$this->ToHTMLFullVers();
			$res .=			'</div>';
			if ((GetUserLogin() === $author->login) || (GetUserLogin() === 'admin')) {
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

		public function ToHTMLAddLanguage()
		{
			global $link_to_admin_direction;
			$args = array(
				'action_link' => $link_to_admin_direction,
				'action_type' => 'add_lang',
				'obj_type' => Direction::$type,
				'id' => $this->id,
				'btn_color' => 'btn-primary',
			);
			return ActionButton($args);
		}

		public function ToHTMLDel()
		{
			global $link_to_utility_interceptor;
			$args = array(
				'action_link' => $link_to_utility_interceptor,
				'action_type' => 'del',
				'obj_type' => Direction::$type,
				'id' => $this->id,
				'info' => Language::Word('are you shure that yuo want to delete direction with header').' '.htmlspecialchars($this->name).'? ('.Language::Word('all linked projects also will be deleted').')',
			);
			return ActionButton($args);
		}
		public function ToHTMLEdit()
		{
			global $link_to_admin_direction;
			$args = array(
				'action_link' => $link_to_admin_direction,
				'action_type' => 'edit',
				'obj_type' => Direction::$type,
				'id' => $this->id,
			);
			return ActionButton($args);
		}

		public function ToHTMLFullVers()
		{
			global $link_to_admin_direction;
			global $link_to_admin_manage_content;
			global $link_to_public_direction;
			global $content_types_short;
			global $link_to_public_content;
			global $use_mod_rewrite;
			$mod_rewrite = 0;
			if (isset($use_mod_rewrite) && ($use_mod_rewrite === true)) {
				$mod_rewrite = 1;
			}
			$args = array();

			if (IsSessionPublic()) {
				$args = array(
					'action_link' => $link_to_public_direction,
					'action_type' => 'full',
					'obj_type' => Direction::$type,
					'id' => $this->id,
					'btn_text' => Language::Word('learn more'),
					'method' => 'get',
					'mod_rewrite' => $mod_rewrite,
					'prev_page' => $link_to_public_content.'?content_type='.$content_types_short['directions'],
				);
			} else {
				$args = array(
					'action_link' => $link_to_admin_direction,
					'action_type' => 'full',
					'obj_type' => Direction::$type,
					'id' => $this->id,
					'prev_page' => $link_to_admin_manage_content.'?content_type='.$content_types_short['directions'],
					'method' => 'get',
				);
			}
			return ActionButton($args);
		}

		//Methods for fetching
		public static function FetchByID($id)
		{
			global $db_connection;
			$res = NULL;
			$from_table = Direction::$table;
			$lang = GetLanguage();
			if ($lang != 'rus') $from_table .= '_'.$lang;
			$result = $db_connection->query("SELECT * FROM `".$from_table."` WHERE `id`=".$id);
			if ((!$result) || ($result->num_rows != 1)) {
				return NULL;
			}
			$tmp = $result->fetch_assoc();
			$tmp['language'] = $lang;
			return Direction::FetchFromAssoc($tmp);
		}

		public static function FetchFromAssoc($assoc)
		{
			global $link_to_direction_images;
			global $link_to_service_images;
			if ((!ArrayElemIsValidStr($assoc, 'author_id')) || (!ArrayElemIsValidStr($assoc, 'name')) ||
				(!ArrayElemIsValidStr($assoc, 'text_block'))) {
				return NULL;
			}
			$dir = new self();
			if (ArrayElemIsValidStr($assoc, 'id')) $dir->id = $assoc['id'];
			else $dir->id = id_undef;

			$dir->author_id = $assoc['author_id'];
			$dir->name = $assoc['name'];
			$dir->text_block = $assoc['text_block'];
			if (ArrayElemIsValidStr($assoc, 'language')) $dir->language = $assoc['language'];
			try {
				if (ArrayElemIsValidStr($assoc, 'creating_date'))
					$dir->creating_date = strtotime($assoc['creating_date']);
				else $dir->creating_date = time_undef;
			} catch(Exception $e) {
				$dir->creating_date = time_undef;
			}
			if (ArrayElemIsValidStr($assoc, 'language')) {
				global $image_extensions;
				$dir->path_to_image = PathToImage($link_to_direction_images.$dir->id, 'cover', $link_to_service_images.'Logo.png', $image_extensions, $dir->language);
			} else
				$dir->path_to_image = PathToImage($link_to_direction_images.$dir->id, 'cover', $link_to_service_images.'Logo.png');
			return $dir;
		}

		public static function FetchFromPost()
		{
			return FetchFromAssoc($_POST);
		}

		public static function FetchAll()
		{
			global $db_connection;
			$res = array();
			$from_table = Direction::$table;
			$lang = GetLanguage();
			if ($lang != 'rus') $from_table .= '_'.$lang;
			$result = $db_connection->query("SELECT * FROM `".$from_table."` ORDER BY id DESC");
			if (!$result) {
				return NULL;
			}
			while ($row = $result->fetch_assoc()) {
				$row['language'] = $lang;
				array_push($res, Direction::FetchFromAssoc($row));
			}
			return $res;
		}

		public static function InsertToDB($request, $lang_vers = 'rus', $glob_id = 0)
		{
			global $db_connection;
			global $link_to_direction_images;

			$author_id 	= $db_connection->real_escape_string($request->author_id);
			$name 		= $db_connection->real_escape_string($request->name);
			$insert_table = Direction::$table;
			if ($lang_vers !== 'rus') {
				$insert_table .= '_'.$lang_vers;
			}
			$res = $db_connection->query("INSERT INTO `".$insert_table."` (`id`, `author_id`, `name`, `text_block`, `creating_date`) VALUES ('".$glob_id."', '".$author_id."', '".$name."', '', CURRENT_TIMESTAMP)");
			if (!$res) {
				return false;
			}
			$id = $db_connection->insert_id;

			if ($glob_id === 0) $request->text_block = preg_replace('/tmp_(\d+)\//', $id.'/', $request->text_block);
			$text_block = $db_connection->real_escape_string($request->text_block);
			$res = $db_connection->query("UPDATE `".$insert_table."` SET `text_block`=\"".$text_block."\" WHERE `id`=".$id);
			if (!$res) {
				echo $db_connection->error;
				$db_connection->query("DELETE FROM `".$insert_table."` WHERE `id` = ".$id);
				return false;
			}

			$request->id = $id;
			$upload_path = '';
			if ($glob_id === 0) recurse_copy($link_to_direction_images.'tmp_'.User::GetIDByLogin(GetUserLogin()), $link_to_direction_images.$id);
			if (is_uploaded_file($_FILES['cover']['tmp_name'])) {
				$img_name = 'cover';
				if ($lang_vers !== 'rus') $img_name .= '_'.$lang_vers;
				$sepext = explode('.', strtolower($_FILES['cover']['name']));
			    $type = end($sepext);
			    $img_name .= '.'.$type;
			    $upload_path = $link_to_direction_images.$id.'/'.$img_name;
			    if (move_uploaded_file($_FILES['cover']['tmp_name'], $upload_path)) {
			    	$request->path_to_image = $upload_path;
			    }
			}
			return true;
		}

		public function FetchFromAssocEditing($assoc)
		{
			if (ArrayElemIsValidStr($assoc, 'name')) $this->name = $assoc['name'];
			if (ArrayElemIsValidStr($assoc, 'text_block')) $this->text_block = $assoc['text_block'];
		}

		public function FetchCoverFromAssocEditing($assoc)
		{
			if (isset($assoc['cover']['name']) && (is_uploaded_file($assoc['cover']['tmp_name']))) {
				global $link_to_direction_images;
				$img_name = 'cover';
				if ($this->language !== 'rus') $img_name .= '_'.$this->language;
				$old_im = $img_name;
				$sepext = explode('.', strtolower($assoc['cover']['name']));
			    $type = end($sepext);
			    $img_name .= '.'.$type;
			    $upload_path = $link_to_direction_images.$this->id.'/'.$img_name;
			    if (!delete_image($link_to_direction_images.$this->id.'/'.$old_im)) {
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
			$from_table = Direction::$table;
			if ($this->language !== 'rus') $from_table .= '_'.$this->language;
			$res = $db_connection->query("SELECT `id` FROM `".$from_table."` WHERE (`id`=".$this->id.")");
			if (!$res) {
				echo $db_connection->error;
				return false;
			} else {
				if ($res->num_rows == 0) {
					echo 'there are no direction with id = '.$this->id;
					return false;
				}
			}
			$name_tmp 		= $db_connection->real_escape_string($this->name);
			$text_block_tmp = $db_connection->real_escape_string($this->text_block);
			$res = $db_connection->query("UPDATE `".$from_table."` SET `name`=\"".$name_tmp."\", `text_block`=\"".$text_block_tmp."\" WHERE `id`=".$this->id);
			if (!$res) {
				echo $db_connection->error;
				return false;
			}
			return true;
		}

		public function FetchLanguages()
		{
			global $languages;
			global $db_connection;
			$res = array();
			foreach ($languages as $key => $value) {
				$from_table = Direction::$table;
				if ($key !== 'rus') $from_table .= '_'.$key;
				$q = $db_connection->query("SELECT COUNT(*) FROM ".$from_table." WHERE id = ".$this->id);
				if ($q) {
					$cnt = $q->fetch_array()[0];
					if ($cnt > 0) $res[$key] = $value;
				}
			}
			return $res;
		}

		public static function Delete($id)
		{
			global $db_connection;
			global $link_to_direction_images;
			global $link_to_logo;

			$direction = Direction::FetchByID($id);
			$langs = $direction->FetchLanguages();
			$from_table = Direction::$table;
			if ($direction->language !== 'rus') $from_table .= '_'.$direction->language;

			if (!$db_connection->query("DELETE FROM `".$from_table."` WHERE `id` = ".$id)) {
				return 0;
			} else {
				if (count($langs) < 2) {
					$projs = Project::FetchByDirectionID($id, array('all',));
					if ($projs != NULL) {
						for ($i = 0, $size = count($projs); $i < $size; ++$i) {
							if (!($projs[$i]->DeleteThis())) {
								echo 'error while deleting projects on proj id: '.$projs[$i]->id;
								return 0;
							}
						}
					}
					removeDirectory($link_to_direction_images.$id);
				} else {
					if ($direction->path_to_image !== $link_to_logo) unlink($direction->path_to_image);
				}
				return 1;
			}
		}

		public function LinkToThis()
		{
			global $link_to_admin_direction;
			global $link_to_public_direction;
			global $use_mod_rewrite;
			$args = array();

			$mod_rewrite = 0;
			if (isset($use_mod_rewrite) && ($use_mod_rewrite === true)) {
				$mod_rewrite = 1;
			}
			if (IsSessionPublic()) {
				$args = array(
					'action_link' => $link_to_public_direction,
					'action_type' => 'full',
					'obj_type' => Direction::$type,
					'id' => $this->id,
					'lnk_text' => $this->name,
					'mod_rewrite' => $mod_rewrite,
					'method' => 'get',
				);
			} else {
				$args = array(
					'action_link' => $link_to_admin_direction,
					'action_type' => 'full',
					'obj_type' => Direction::$type,
					'id' => $this->id,
					'lnk_text' => $this->name,
					'method' => 'get',
				);
			}
			return ActionLink($args);
		}
	}
?>