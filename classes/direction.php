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
				case admin_user_id:
					return $this->ToHTMLAdminFull();
				case unauthorized_user_id:
					return $this->ToHTMLUserPublicFull();
				case simple_user_id:
					return $this->ToHTMLUserPrivateFull();
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
		
		//html code of full representation of object in string
		public function ToHTMLAdminFull()
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

			$res .= 	'<div class="row">';
			$res .= 		'<div class="'.ColAllTypes(6).'" align="right">';
			$res .=				'<div class="margin-sm">'.$this->ToHTMLEdit().'</div>';
			$res .=			'</div>';
			$res .= 		'<div class="'.ColAllTypes(6).'" align="left">';
			$res .=				'<div class="margin-sm">'.$this->ToHTMLDel().'</div>';
			$res .=			'</div>';
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
			$res .= '<div class="row">'.ToPageHeader('Связанные проекты', 'h3').'</div>';
			$res .= '<div class="row">';
			$res .= 	'<div class="'.ColAllTypes(1).' center-block"></div>';
			$res .= 	'<div class="'.ColAllTypes(10).' center-block">';
			$res .= 		'<table class="table table-striped text-center">';
			$res .= 			'<thead>';
			$res .= 				'<tr>';
			$res .=						'<th class="text-center" style="width: 20% !important; white-space: normal;">Направление</th>';
			$res .=						'<th class="text-center" style="width: 20% !important; white-space: normal;>Название</th>';
			$res .=						'<th class="text-center">Дата</th>';
			$res .=						'<th class="text-center">Автор</th>';
			$res .=						'<th class="text-center">Действия</th>';
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

		public function ToHTMLAdminShortInTable()
		{
			$res = '<tr>';
			$res .= '<td>'.htmlspecialchars($this->name).'</td>';
			$res .= '<td>'.date('d : m : Y - H : i', $this->creating_date).'</td>';
			$res .= '<td>'.User::FetchByID($this->author_id)->LinkToThis().'</td>';
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

		//html code of full representation of object in string within internal pages of lgmis
		public function ToHTMLUserPrivateFull()
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

			if (GetUserLogin() == User::FetchByID($this->author_id)->login) {
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

			$needed_projs = array();
			global $projects_in_db;
			$size = count($projects_in_db);
			for ($i = 0; $i < $size; ++$i) {
				$project = Project::FetchByID($i);
				if ($project->direction_id != $this->id) continue;
				array_push($needed_projs, $project);
			}

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
			$res .= '<div class="row">'.ToPageHeader('Связанные проекты', 'h3').'</div>';
			$res .= '<div class="row">';
			$res .= 	'<div class="'.ColAllTypes(1).' center-block"></div>';
			$res .= 	'<div class="'.ColAllTypes(10).' center-block">';
			$res .= 		'<table class="table table-striped text-center">';
			$res .= 			'<thead>';
			$res .= 				'<tr>';
			$res .=						'<th class="text-center" width="20%">Направление</th>';
			$res .=						'<th class="text-center">Название</th>';
			$res .=						'<th class="text-center">Дата</th>';
			$res .=						'<th class="text-center">Автор</th>';
			$res .=						'<th class="text-center">Действия</th>';
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
			$res .= 	'<img class="img-direction-cover" src="'.$this->path_to_image.'">';
			$res .= 	$this->ToHTMLFullVersSpecialPublic();
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
			if (GetUserLogin() === $author->login) {
				$res .= 	'<div class="'.ColAllTypes(4).'">';
			} else {
				$res .= 	'<div class="'.ColAllTypes(12).'">';
			}
			$res .= 			$this->ToHTMLFullVers();
			$res .=			'</div>';
			if (GetUserLogin() === $author->login) {
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
				'obj_type' => Direction::$type,
				'id' => $this->id,
				'info' => 'Вы уверены, что хотите удалить направление с заголовком '.htmlspecialchars($this->name).'? (Все проекты по нему так же будут удалены)',
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
			global $content_types_short;
			$args = array(
				'action_link' => $link_to_admin_direction,
				'action_type' => 'full',
				'obj_type' => Direction::$type,
				'id' => $this->id,
				'prev_page' => $link_to_admin_manage_content.'?content_type='.$content_types_short['directions'],
			);
			return ActionButton($args);
		}

		public function ToHTMLFullVersSpecialPublic()
		{
			global $link_to_public_direction;
			global $link_to_public_content;
			global $content_types_short;
			$args = array(
				'action_link' => $link_to_public_direction,
				'action_type' => 'full',
				'obj_type' => Direction::$type,
				'id' => $this->id,
				'btn_text' => 'Узнать больше',
				'prev_page' => $link_to_public_content.'?content_type='.$content_types_short['directions'],
			);
			return ActionButton($args);
		}

		//Methods for fetching
		public static function FetchByID($id)
		{
			global $db_connection;
			$res = NULL;
			$result = $db_connection->query("SELECT * FROM `".Direction::$table."` WHERE `id`=".$id);
			if ((!$result) || ($result->num_rows != 1)) {
				return NULL;
			}
			return Direction::FetchFromAssoc($result->fetch_assoc());
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
			try {
				if (ArrayElemIsValidStr($assoc, 'creating_date'))
					$dir->creating_date = strtotime($assoc['creating_date']);
				else $dir->creating_date = time_undef;
			} catch(Exception $e) {
				$dir->creating_date = time_undef;
			}
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
			$result = $db_connection->query("SELECT * FROM `".Direction::$table."`");
			if (!$result) {
				return NULL;
			}
			while ($row = $result->fetch_assoc()) {
				array_push($res, Direction::FetchFromAssoc($row));
			}
			return $res;
		}

		public static function InsertToDB($request)
		{
			global $db_connection;
			global $link_to_direction_images;

			$author_id 	= $db_connection->real_escape_string($request->author_id);
			$name 		= $db_connection->real_escape_string($request->name);
			$res = $db_connection->query("INSERT INTO `".Direction::$table."` (`id`, `author_id`, `name`, `text_block`, `creating_date`) VALUES ('0', '".$author_id."', '".$name."', '', CURRENT_TIMESTAMP)");
			if (!$res) {
				return false;
			}
			$id = $db_connection->insert_id;

			$request->text_block = preg_replace('/tmp_(\d+)\//', $id.'/', $request->text_block);
			$text_block = $db_connection->real_escape_string($request->text_block);
			$res = $db_connection->query("UPDATE `".Direction::$table."` SET `text_block`=\"".$text_block."\" WHERE `id`=".$id);
			if (!$res) {
				echo $db_connection->error;
				$db_connection->query("DELETE FROM `".Direction::$table."` WHERE `id` = ".$id);
				return false;
			}

			$request->id = $id;
			$upload_path = '';
			recurse_copy($link_to_direction_images.'tmp_'.User::GetIDByLogin(GetUserLogin()), $link_to_direction_images.$id);
			if (is_uploaded_file($_FILES['cover']['tmp_name'])) {
				$img_name = 'cover';
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
				$sepext = explode('.', strtolower($assoc['cover']['name']));
			    $type = end($sepext);
			    $img_name .= '.'.$type;
			    $upload_path = $link_to_direction_images.$this->id.'/'.$img_name;
			    if (!delete_image($link_to_direction_images.$this->id.'/cover')) {
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
			$res = $db_connection->query("SELECT `id` FROM `".Direction::$table."` WHERE (`id`=".$this->id.")");
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
			$res = $db_connection->query("UPDATE `".Direction::$table."` SET `name`=\"".$name_tmp."\", `text_block`=\"".$text_block_tmp."\" WHERE `id`=".$this->id);
			if (!$res) {
				echo $db_connection->error;
				return false;
			}
			return true;
		}

		public static function Delete($id)
		{
			global $db_connection;
			global $link_to_direction_images;

			$projs = Project::FetchByDirectionID($id);
			if ($projs != NULL) {
				for ($i = 0, $size = count($projs); $i < $size; ++$i) {
					if (!Project::Delete($projs[$i]->id)) {
						echo 'error while deleting projects on proj id: '.$projs[$i]->id;
						return 0;
					}
				}
			}
			if (!$db_connection->query("DELETE FROM `".Direction::$table."` WHERE `id` = ".$id)) {
				return 0;
			} else {
				removeDirectory($link_to_direction_images.$id);
				return 1;
			}
		}

		public function LinkToThis()
		{
			global $link_to_admin_direction;
			global $link_to_public_direction;
			$args = array();
			if (IsSessionPublic()) {
				$args = array(
					'action_link' => $link_to_public_direction,
					'action_type' => 'full',
					'obj_type' => Direction::$type,
					'id' => $this->id,
					'lnk_text' => $this->name,
				);
			} else {
				$args = array(
					'action_link' => $link_to_admin_direction,
					'action_type' => 'full',
					'obj_type' => Direction::$type,
					'id' => $this->id,
					'lnk_text' => $this->name,
				);
			}
			return ActionLink($args);
		}
	}
?>