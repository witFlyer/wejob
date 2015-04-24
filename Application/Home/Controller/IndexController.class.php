<?php
namespace Home\Controller;
use Think\Controller;
class IndexController extends CommonController {
    public function index(){
    	$list = M('Article')->where("is_del=0")->order("create_time DESC")->select();
		$this->assign('list',$list);
		
		$tag_list = M('SystemTag')->where("controller='ArticleTag'")->field('id,name')->select();
		foreach($tag_list as $k=>$v){
			$where['tag'] = $v['id'];
			$where['is_del'] = 0;
			$count = M('Article')->where($where)->count();
			$tag_list[$k]['count'] = $count;
		}
		$this->assign('tag_list',$tag_list);
        $this->show();
    }
    public function read(){
    	$this->show();
    }
}