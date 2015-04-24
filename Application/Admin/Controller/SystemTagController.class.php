<?php
namespace Admin\Controller;
use Think\Controller;

class SystemTagController extends CommonController{
	
	function index(){
//		dump($_POST);die;
		if ($_POST) {
			$opmode = $_POST["opmode"];
			$model = D("SystemTag");
			if (false === $model -> create()) {
				$this -> error($model -> getError());
			}
			if ($opmode == "add") {
				$model -> controller = CONTROLLER_NAME;
				$list = $model -> add();
			}
			if ($opmode == "edit") {
				$list = $model -> save();
			}
			if ($opmode == "del") {
				$tag_id = $model -> id;
				$model -> del_tag($tag_id);
			}
		}
		$model = D("SystemTag");
//		$tag_list = $model -> get_tag_list("id,pid,name");
//		$tree = list_to_tree($tag_list);
//		$this -> assign('menu',sub_tree_menu($tree));

		$tag_list = $model -> get_tag_list();
		$this -> assign("tag_list", $tag_list);
		$this -> assign('js_file',"SystemTag:js/index");
		$this -> display('SystemTag:index');
	}
}
