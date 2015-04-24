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
    	$id = $_REQUEST['id'];
		$result = M('Article')->where("id=$id")->find();
		$pre = M('Article')->where("id<$id AND is_del=0")->order('id desc')->find(); //上一篇
		$next = M('Article')->where("id>$id AND is_del=0")->order('id asc')->find(); //下一篇
		$this->assign('pre',$pre);
		$this->assign('next',$next);
		$this->assign('result',$result);
    	$this->show();
    }
	public function tag_article(){
		$this->assign('js_file',CONTROLLER_NAME.'/js/index');
		
		$id = $_REQUEST['tag_id'];
		
		$tag_name = M('SystemTag')->where("id=$id")->getField('name');
		
		$count = M('Article')->where("tag=$id")->count();
		//分页
		$page = new \Think\Page($count,4);
		$page->setConfig('prev','上一页');
		$page->setConfig('next','下一页');
		$show = $page->show();
		
		$article_list = M('Article')->where("tag=$id")->order('create_time DESC')->limit($page->firstRow.','.$page->listRows)->select();	
		$tag_list = M('SystemTag')->where("controller='ArticleTag'")->field('id,name')->select();
		foreach($tag_list as $k=>$v){
			$where['tag'] = $v['id'];
			$where['is_del'] = 0;
			$count = M('Article')->where($where)->count();
			$tag_list[$k]['count'] = $count;
		}
		
		$this->assign('tag_list',$tag_list);
		$this->assign('article_list',$article_list);
		$this->assign('tag_name',$tag_name);
		$this->assign('count',$count);
		$this->assign('page',$show);
		$this->show();
	}
}