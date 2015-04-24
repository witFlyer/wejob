<?php

//获取系统配置
function get_system_config($code){
	$model = M('SystemConfig');
	$where['code'] = array('eq',$code);
	$count = $model->where($where)->count();
	if($count>1){
		return $model->where($where)->getField('val,name');
	}else{
		return $model->where($where)->getField('val');
	}
}

//搜索post 时，不过滤 0;修改——>Org/Page -> array_filter();
function filter_search_null($v1){
	if($v1 == '' || is_null($v1)){
		return false;
	}
	return true;
}
//过滤查询字段
function filter_search_field($v){
	if($v == 'keyword') return true;
	$prefix = substr($v, 0,3);
	$arr_key = array('be_','en_','li_','eq_','lt','gt');
	if(in_array($prefix, $arr_key)){
		return true;
	}else{
		return FALSE;
	}
}
//获取表字段
function get_model_fields($model){
	$arr_field = array();
	if(isset($model->viewFields)){
		foreach($model->viewFields as $k=>$v){
			unset($v['_on']);
			unset($v['_type']);
			if(!empty($v[0]) && $v[0]=="*"){
				$model = M($k);
				$fields = $model->getDbFields();
				$arr_field = array_merge($arr_field,array_values($fields));
			}else{
				$arr_field = array_merge($arr_field,array_values($v));
			}
		}
	}else{
		$arr_field = $model->getDbFields();
	}
	return $arr_field;
}
function rotate($a) {
	$b = array();
	if(is_array($a)){
		foreach($a as $val){
			foreach($val as $k=>$v){
				$b[$k][] = $v;
			}
		}
	}
	return $b;
}

function get_save_path(){
	$app_path=__APP__;
	$save_path=C('SAVE_PATH');
	$app_path=str_replace("/index.php?s=","",$app_path);
	$app_path=str_replace("/index.php","",$app_path);
	return C('SAVE_PATH');
}

function get_user_id(){
	$user_id = session('user_id');
	if(!empty($user_id)){
		return $user_id;
	}
}
function get_user_name(){
	$user_id = session('user_id');
	$name = M('Admin')->where("id=$user_id")->getField('user_name');
	return $name;
}
function get_return_url($level=null){
	if(empty($level)){
		$return_url = cookie('return_url');
	}else{
		$return_url = cookie('return_url_'.$level);
	}
	return $return_url;
}
//获取开发环境
function get_server_software(){
	return $_SERVER['SERVER_SOFTWARE'];
}
//设置select布局
function fill_option($list,$data){
	$html = '';
	foreach($list as $key=>$val){
		if(is_array($val)){
			$id = $val['id'];
			$name = $val['name'];
			if($id==$data){
				$selected = 'selected';
			}else{
				$selected = '';
			}
			$html = $html."<option value='{$id}' $selected>{$name}</option>";
		}else{
			if($key==$data){
				$selected = 'selected';
			}else{
				$selected = '';
			}
			$html = $html."<option value='{$key}' $selected>{$val}</option>";
		}
	}
	echo $html;
}

function get_tag_name($id){
	if(!empty($id)){
		$name = M('SystemTag')->where("id=$id")->getField("name");
		return $name;
	}else{
		return "-";
	}
}

function get_lock($lock){
	if($lock){
		return "禁用";
	}else{
		return "启用";
	}
}










