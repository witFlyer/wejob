<?php
namespace Home\Controller;
use Think\Controller;

class CommonController extends Controller{
	
	protected function _initialize(){
		//分配文件下的js文件
		$this->assign('js_file',CONTROLLER_NAME.'/js/'.ACTION_NAME);
	}
}
