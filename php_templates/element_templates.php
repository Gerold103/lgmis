<?php
	$act_type_to_text = array(
		'del' => 'Удалить',
		'add' => 'Добавить',
		'edit' => 'Редактировать',
		'full' => 'Подробнее',
	);

	$act_type_to_css_class = array(
		'del' => 'btn btn-danger',
		'full' => 'btn btn-info',
		'add' => 'btn btn-primary',
		'edit' => 'btn btn-default',
		'def' => 'btn btn-default',
		'succ' => 'btn btn-success',
	);

	function WrapToHiddenInputs($names_and_vals)
	{
		$res = '';
		foreach ($names_and_vals as $name => $val){
			$res .= '<input type="hidden" name="'.$name.'" value="'.$val.'">';
		}
		return $res;
	}

	function WrapToGetVariables($names_and_vals)
	{
		$res = '';
		$i = 0;
		$size = count($names_and_vals);
		foreach ($names_and_vals as $name => $val){
			$res .= $name.'='.$val;
			if ($i < $size - 1) {
				$res .= '&';
			}
			++$i;
		}
		return $res;
	}

	//here must be 'action_link', 'action_type', 'obj_type', 'id'
	//'btn_text', 'prev_page', 'info' is optional
	function ActionButton($args)
	{
		//Errors cheking
		if (!isset($args['action_link'])) {
			return "<font color=".'red'.">Error: action_link isn't set</font>";
		}
		if (!isset($args['action_type'])) {
			return "<font color=".'red'.">Error: action_type isn't set</font>";	
		}
		if (!isset($args['obj_type'])) {
			return "<font color=".'red'.">Error: obj_type isn't set</font>";
		}
		if (!isset($args['id'])) {
			return "<font color=".'red'.">Error: id isn't set</font>";
		}

		//Add other fields
		if (!isset($args['btn_text'])) {
			global $act_type_to_text;
			$args['btn_text'] = $act_type_to_text[$args['action_type']];
		}
		if (!isset($args['prev_page'])) {
			$args['prev_page'] = $_SERVER['REQUEST_URI'];
		}
		if (!isset($args['btn_size'])) {
			$args['btn_size'] = 'btn-sm';
		}
		$method = 'post';
		if (isset($args['method'])) {
			$method = $args['method'];
		} 

		global $act_type_to_css_class;

		$res = '';

		if ($method === 'post') {
			$res .= '<form class="form-inline" action="'.$args['action_link'].'" method="'.$method.'">';
			$res .= 	'<div class="form-group">';
			$res .= 		'<input class="'.($act_type_to_css_class[$args['action_type']]).' '.($args['btn_size']).' '.($args['btn_color']).'" name="'.$args['action_type'].'" type="submit" value="'.$args['btn_text'].'">';
			$res .= 		WrapToHiddenInputs(array('type' => $args['obj_type'], 'id' => $args['id'], 'prev_page' => $args['prev_page']));
			if (isset($args['info']))
				$res .= 	'<input type="hidden" name="info" value="'.$args['info'].'">';
			$res .= 	'</div>';
			$res .= '</form>';
		} else if ($method === 'get') {
			$res .= '<div><a href="'.$args['action_link'].'?'.WrapToGetVariables(array('type' => $args['obj_type'], 'id' => $args['id'], $args['action_type'] => '1')).'" class="'.($act_type_to_css_class[$args['action_type']]).' '.($args['btn_size']).' '.($args['btn_color']).'">'.$args['btn_text'].'</a></div>';
		}
		return $res;
	}

	//here must be 'action_link', 'action_type', 'obj_type', 'id'
	//'lnk_text', 'prev_page', 'info' is optional
	function ActionLink($args)
	{
		//Errors cheking
		if (!isset($args['action_link'])) {
			return "<font color=".'red'.">Error: action_link isn't set</font>";
		}
		if (!isset($args['action_type'])) {
			return "<font color=".'red'.">Error: action_type isn't set</font>";	
		}
		if (!isset($args['obj_type'])) {
			return "<font color=".'red'.">Error: obj_type isn't set</font>";
		}
		if (!isset($args['id'])) {
			return "<font color=".'red'.">Error: id isn't set</font>";
		}

		//Add other fields
		if (!isset($args['lnk_text'])) {
			global $act_type_to_text;
			$args['lnk_text'] = $act_type_to_text[$args['action_type']];
		}
		if (!isset($args['prev_page'])) {
			$args['prev_page'] = $_SERVER['REQUEST_URI'];
		}
		$method = 'post';
		if (isset($args['method'])) {
			$method = $args['method'];
		}

		global $act_type_to_css_class;

		$res = '';
		if ($method === 'post') {
			$res .= '<form class="form-inline" action="'.$args['action_link'].'" method="post" style="display: inline !important;">';
			$res .= '	<input class="btn btn-link '.$args['lnk_size'].'" style="margin: 0; padding: 0; white-space: normal !important;" name="'.$args['action_type'].'" type="submit" value="'.$args['lnk_text'].'">';
			$res .= 	WrapToHiddenInputs(array('type' => $args['obj_type'], 'id' => $args['id'], 'prev_page' => $args['prev_page']));		
			if (isset($args['info']))
				$res .= '<input type="hidden" name="info" value="'.$args['info'].'">';
			$res .= '</form>';
		} else if ($method === 'get') {
			$res .= '<a href="'.$args['action_link'].'?'.WrapToGetVariables(array('type' => $args['obj_type'], 'id' => $args['id'], $args['action_type'] => '1')).'" class="btn btn-link '.($args['lnk_size']).'">'.$args['lnk_text'].'</a>';
		}
		return $res;
	}

	function DialogInputsYesNo($action_type, $object_type, $id_, $val_yes = 'Да', $val_no = 'Нет', $need_prev_page = true)
	{
		$res = '';
		$res .= '<input class="btn btn-primary margin-sm" type="submit" name="yes" value="'.$val_yes.'">';
		$res .= '<input class="btn btn-danger margin-sm" type="submit" name="no" value="'.$val_no.'">';
		$res .= WrapToHiddenInputs(array($action_type => '', 'type' => $object_type, 'id' => $id_));
		if (($need_prev_page) && (isset($_POST['prev_page']))) {
			$res .= '<input type="hidden" name="prev_page" value="'.$_POST['prev_page'].'">';
		}
		return $res;
	}

	function DialogFormYesNo($action_link, $action_type, $object_type, $id_, $val_yes = 'Да', $val_no = 'Нет', $need_prev_page = true)
	{
		$res = '';
		$res .= '<form action="'.$action_link.'" method="post">';
		$res .= DialogInputsYesNo($action_type, $object_type, $id_, $val_yes, $val_no, $need_prev_page);
		$res .= '</form><br>';
		return $res;
	}
	
	function OnStartAdminPage()
	{
		global $link_to_admin;
		return '<a href="'.$link_to_admin.'">На главную страницу</a>';
	}

	function OnPreviousPage($path_to)
	{
		return '<a href="'.$path_to.'">Предыдущая страница</a>';
	}

	function PathToImage($start_path, $image_name, $default_ans = '#default#', $available = array('jpg', 'png', 'gif'))
	{
		$res = $start_path.'/'.$image_name.'.';
		for ($i = 0, $size = count($available); $i < $size; ++$i) {
			if (file_exists($res.$available[$i])) {
				return $res.$available[$i];
			}
		}
		return $default_ans;
	}

	//------------------------B O O T S T R A P------------------------

	function ColAllTypes($width)
	{
		return 'col-xs-'.$width.' col-sm-'.$width.' col-md-'.$width.' col-lg-'.$width;
	}

	function ColOffsetAllTypes($width)
	{
		return 'col-xs-offset-'.$width.' col-sm-offset-'.$width.' col-md-offset-'.$width.' col-lg-offset-'.$width;
	}

	function ToPageHeader($text, $header_type = 'h1', $color = "grey", $font_weight = "lighter")
	{
		return '<font color="'.$color.'"><'.$header_type.' style="margin: 10px; font-weight: '.$font_weight.'">'.$text.'</'.$header_type.'></font>';
	}

	function SimplePanel($body_content, $your_classes = 'padding-sm margin-sm')
	{
		$res = '';
		$res .= '<div class="panel panel-default '.$your_classes.'"><div class="panel-body '.$your_classes.'">';
		$res .= 	$body_content;
		$res .= '</div></div>';
		return $res;
	}

	function MenuButton($text, $action, $class = 'btn-default', $name = '')
	{
		$res = '';
		$res .= '<div class="row top-buffer20">';
		$res .= 	'<div class="'.ColAllTypes(12).'">';
		$res .= 		'<form method="post" class="form-inline" action="'.$action.'">';
		$res .=				'<div class="form-group">';
		$res .= 				'<input type="submit" name="'.$name.'" class="btn '.$class.' btn-lg btn-block" value="'.$text.'">';
		$res .=				'</div>';
		$res .= 		'</form>';
		$res .=		'</div>';
		$res .=	'</div>';
		return $res;
	}

	function PopOverButton($pop_text, $btn_text, $classes = 'btn-default', $side = 'top')
	{
		$res = '';
		$res .=	'<a type="button" class="btn '.$classes.'"'; 
		$res .=		'role="button" ';
		$res .= 	'tabindex="0" ';
		$res .=		'data-trigger="focus" ';
		$res .=		'data-container="body" ';
		$res .=		'data-toggle="popover" ';
		$res .=		'data-placement="'.$side.'" ';
		$res .=		'data-content="'.$pop_text.'">';
		$res .=			$btn_text;
		$res .=	'</a>';
		return $res;
	}

	function PairLabelAndPanel($labes_width, $fields_width, $label, $field)
	{
		$res = '';
		$res .= '<div class="row">';
		$res .=		'<div class="'.ColAllTypes($labes_width).' vcenter" align="right">';
		$res .= 		'<b>'.$label.'</b>';
		$res .= 	'</div>';
		$res .= 	'<div class="'.ColAllTypes($fields_width).' vcenter" align="center">';
		$res .= 		SimplePanel($field);
		$res .= 	'</div>';
		$res .= '</div>';
		return $res;
	}

	function PairLabelAndInput($labes_width, $input_width, $label, $input_name, $placeholder = '', $input_value = '')
	{
		$res = '';
		$res .= '<div class="row">';
		$res .=		'<div class="'.ColAllTypes($labes_width).' vcenter" align="right">';
		$res .= 		'<b>'.$label.'</b>';
		$res .= 	'</div>';
		$res .= 	'<div class="'.ColAllTypes($input_width).' vcenter" align="center">';
		$res .= 		'<input class="form-control margin-sm" placeholder="'.$placeholder.'" name="'.$input_name.'" value="'.$input_value.'">';
		$res .= 	'</div>';
		$res .= '</div>';
		return $res;
	}

	function PairLabelAndPassword($labes_width, $input_width, $label, $input_name, $placeholder = '', $input_value = '')
	{
		$res = '';
		$res .= '<div class="row">';
		$res .=		'<div class="'.ColAllTypes($labes_width).' vcenter" align="right">';
		$res .= 		'<b>'.$label.'</b>';
		$res .= 	'</div>';
		$res .= 	'<div class="'.ColAllTypes($input_width).' vcenter" align="center">';
		$res .= 		'<input type="password" class="form-control margin-sm" placeholder="'.$placeholder.'" name="'.$input_name.'" value="'.$input_value.'">';
		$res .= 	'</div>';
		$res .= '</div>';
		return $res;
	}

	function PairLabelAndTextarea($labes_width, $textarea_width, $label, $textarea_name, $placeholder = '', $text_value = '')
	{
		$res = '';
		$res .= '<div class="row">';
		$res .=		'<div class="'.ColAllTypes($labes_width).' vcenter" align="right">';
		$res .= 		'<b>'.$label.'</b>';
		$res .= 	'</div>';
		$res .= 	'<div class="'.ColAllTypes($textarea_width).' vcenter" align="center">';
		$res .= 		'<textarea style="resize: vertical;" class="form-control" placeholder="'.$placeholder.'" name="'.$textarea_name.'">'.$text_value.'</textarea>';
		$res .= 	'</div>';
		$res .= '</div>';
		return $res;
	}

	function PairLabelAndInputFile($labes_width, $file_width, $label, $file_name)
	{
		$res = '';
		$res .= '<div class="row">';
		$res .=		'<div class="'.ColAllTypes($labes_width).' vcenter" align="right">';
		$res .= 		'<b>'.$label.'</b>';
		$res .= 	'</div>';
		$res .= 	'<div class="'.ColAllTypes($file_width).' vcenter" align="center">';
		$res .= 		'<input type="file" name="'.$file_name.'">';
		$res .= 	'</div>';
		$res .= '</div>';
		return $res;	
	}

	function PairLabelAndSelect($labes_width, $select_width, $label, $select_name, $select_fields, $selected_field = array())
	{
		$res = '';
		$res .= '<div class="row">';
		$res .=		'<div class="'.ColAllTypes($labes_width).' vcenter" align="right">';
		$res .= 		'<b>'.$label.'</b>';
		$res .= 	'</div>';
		$res .= 	'<div class="'.ColAllTypes($select_width).' vcenter" align="center">';
		$res .= 		'<select class="form-control" name="'.$select_name.'">';
		if (count($selected_field) === 2) {
			$res .= 		'<option value='.$selected_field[0].' selected="selected">'.$selected_field[1].'</option>';
		}
		foreach ($select_fields as $key => $value) {
			if ((count($selected_field) != 2) || ($selected_field[0] != $key)) 
				$res .= 	'<option value="'.$key.'">'.$value.'</option>';
		}
		$res .= 		'</select>';
		$res .= 	'</div>';
		$res .= '</div>';
		return $res;	
	}

	function PairLabelAndImage($labes_width, $img_width, $image_attrs, $label)
	{
		$res = '';
		$res .= '<div class="row">';
		$res .=		'<div class="'.ColAllTypes($labes_width).' vcenter" align="right">';
		$res .= 		'<b>'.$label.'</b>';
		$res .= 	'</div>';
		$res .= 	'<div class="'.ColAllTypes($img_width).' vcenter" align="center">';
		$res .= 		'<img '.$image_attrs.'>';
		$res .= 	'</div>';
		$res .= '</div>';
		return $res;	
	}

	function AlertMessage($alert_type, $alert_text)
	{
		$res = '';
		$res .= '<div class="alert '.$alert_type.'">';
		$res .= 	$alert_text;
		$res .= '</div>';
		return $res;
	}
?>