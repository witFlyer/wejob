<?php
namespace Admin\Model;
use Think\Model;

class SystemTagModel extends CommonModel{
	
	public function get_tag_list($field = "id,name",$controller = CONTROLLER_NAME){
		$where['controller'] = $controller;
		$where['is_del'] = 0;
		$list = $this->where($where)->field($field)->order('sort ASC')->select();
		return $list; 
	}
	
	//删除标签
	public function del_tag($id){
		//同时删除子标签
		$tag_ids = M('systemTag')->where("pid=$id")->field("id")->select();
		$tag_ids = rotate($tag_ids);
		$tag_ids = implode(",", $tag_ids['id']) . ",$id";
		$where['id'] = array("in",$tag_ids);
		$this->where($where)->delete();
	}
}
