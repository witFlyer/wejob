<?php
namespace Admin\Controller;
use Think\Controller;

class LoginController extends Controller{

	function index(){
		$this->assign("js_file","Login/js/index");
		$user_id = session("user_id");
		if(!isset($user_id)){
			$this->show();
		}else{
			header('Location: ' .__APP__);
		}
	}
	
	//检查登陆
	function check_login(){
		$data = $_POST;
//		if(empty($data['account'])){
//			$this->error("账号必须");
//		}
//		if(empty($data['password'])){
//			$this->error("密码必须");
//		}
		$map['account'] = $data['account'];
		$map['password'] = md5($data['password']);
		$map['is_lock'] = 0;
		$auth_info = M('Admin')->where($map)->find();
		if(false == $auth_info){
			$this->error("账号或密码错误");
		}else{
			session('user_id',$auth_info['id']);
			session('user_name',$auth_info['user_name']);
			session('face',$auth_info['face']);
			
			//保存登陆信息
			$model = M('Admin');
			$ip = get_client_ip();
			$time = time();
			$data = array();
			$data[id] = $auth_info['id'];
			$data['login_time'] = $time;
			$data['ip'] = $ip;
			$model->save($data);
			$this -> assign('jumpUrl', U("Index/index"));
			header('Location: ' .U("index/index"));
		}
	}

//登出
	function login_out(){
		$user_id = session('user_id');
		if(isset($user_id)){
			session('user_id',null);
			session('face',null);
			$this->assign('jumpUrl',U('login/index'));
			$this->success("成功登出");
		}else{
			$this->assign('jumpUrl',U('login/index'));
			$this->success("您已登出");
		}
	}
}
