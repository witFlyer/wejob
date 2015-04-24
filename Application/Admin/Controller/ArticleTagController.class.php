<?php
namespace Admin\Controller;
use Think\Controller;

class ArticleTagController extends SystemTagController{
	
	function index(){
		$this->_tag_manage("会议室管理",FALSE);
	}
}
