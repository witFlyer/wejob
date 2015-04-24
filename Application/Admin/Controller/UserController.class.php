<?php
namespace Admin\Controller;
use Think\Controller;

class UserController extends CommonController{
	
	public function index(){
		$count = M("Admin")->count();
		$page = new \Think\Page($count,12);
		$show = $page->show();
		$list = M("Admin")->order("id ASC")->limit($page->firstRow.','.$page->listRows)->select();
		$this->assign('list',$list);
		$this->assign('page',$show);
		$this->show();
	}
}
