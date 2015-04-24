<?php
namespace Admin\Controller;
use Think\Controller;
class IndexController extends CommonController {
    public function index(){
    	$id = get_user_id();
		$login_time = M('Admin')->where("id=$id")->getField('login_time');
		$this->assign('login_time',$login_time);
    	$this->_new_article();
        $this->show();
    }
	//最新文章 显示
	private function _new_article(){
		$where = array();
		$model = M('Article');
		$where['is_del'] = 0;
		$where['user_id'] = get_user_id();
		$new_article = $model->where($where)->order('create_time DESC')->select();
		$this->assign('new_article',$new_article);
	}
}