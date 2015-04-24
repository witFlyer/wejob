<?php

namespace Admin\Model;
use Think\Model;
class CommonModel extends Model{
	
	function get_user_id(){
		$user_id = session('user_id');
		return isset($user_id) ? $user_id : 0;
	}

	function get_user_name(){
		$user_name = session('user_name');
		return isset($user_name) ? $user_name : 0;
	}
}
