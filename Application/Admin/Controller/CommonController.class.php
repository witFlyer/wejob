<?php
namespace Admin\Controller;
use Think\Controller;

class CommonController extends Controller{
	
	protected function _initialize(){
		
		$user_id = session('user_id');
		if(!isset($user_id)){
			redirect(U('Login/index'));
		}
//		//分配文件下的js文件
		$this->assign('js_file',CONTROLLER_NAME.'/js/'.ACTION_NAME);
	}
	
	//生成查询条件
	protected function _search($name=null){
		//过滤非查询条件
		$map = array();
		$request = array_filter(array_keys(array_filter($_REQUEST,"filter_search_null")),"filter_search_field");
		if(empty($name)){
			$name = CONTROLLER_NAME;
		}
		$model = D($name);
		$fields = get_model_fields($model);
		foreach ($request as $val){
			$field = substr($val, 3);
			$prefix = substr($val, 0,3);
			if(in_array($field, $fields)){
				if($prefix=='be'){
					if(isset($_REQUEST['en_'.$field])){
						if(strpos($field, "time")){
							$map[$field] = array(array('egt',strtotime(trim($val))),array('elt',strtotime(trim('en_'.$field))));
						}
					}
				}
				if($prefix =='li_'){
					$map[$field] = array('like','%'.trim($_REQUEST[$val]).'%');
				}
				if($prefix =='eq_'){
					$map[$field] = array('eq',trim($_REQUEST[$val]));
				}
				if($prefix == 'lt_'){
					$map[$field] = array('elt',trim($_REQUEST[$val]));
				}
				if($prefix == 'gt_'){
					$map[$field] = array('egt',trim($_REQUEST[$val]));
				}
			}
		}
		return $map;
	}
	
	//标签管理
	protected function _tag_manage($tag_name,$has_pid=true){
		$this->assign('tag_name',$tag_name);
		$this->assign('has_pid',$has_pid);
		R('SystemTag/index');
		$this->assign('js_file',"SystemTag:js/index");
	}
	
	//查看页面
	function read(){
		$this->_edit();
	}
	
	function save(){
		$this->_save();
	}
	function del(){
		$this->_del();
	}
	protected function _edit($name=null,$id=null){
		if(empty($name)){
			$name = CONTROLLER_NAME;
		}
		
		$id = $_REQUEST["id"];
		$model = M($name);
		$vo = $model->find($id);
		if(IS_AJAX){
			if($vo !== FALSE){
				$this->ajaxReturn($vo);
			}else{
				$this->ajaxReturn(0);
				die;
			}
		}
		die;
		$this->assign("vo",$vo);
		$this->display();
	}
	
	protected function _save($name=null){
		$opmode = $_POST['opmode'];
		switch($opmode){
			case 'add':
				$this->_insert($name);
				break;
			case 'edit':
				$this->_update($name);
				break;
			case 'del':
				$this->_del($name);
				break;
			default:
				$this->error("非法操作");
				break;
		}
	}
	//添加数据
	protected function _insert($name=null){
		if(empty($name)){
			$name = CONTROLLER_NAME;
		}
		$model = D($name);
		if(FALSE === $model->create()){
			$this->error($model->getError());
		}
		$list = $model->add();
		if(FALSE !== $list){
			$this->assign('jumpUrl',get_return_url());
			$this->success("新增成功");
		}else{
			$this->error("新增失败");
		}
	}
	//更新数据
	protected function _update($name=null){
		if(empty($name)){
			$name = CONTROLLER_NAME;
		}
		$model = D($name);
		if(FALSE === $model->create()){
			$this->error($model->getError());
		}
		$list = $model->save();
		if(FALSE !== $list){
			$this->assign('jumpUrl',get_return_url());
			$this->success("编辑成功");
		}else{
			$this->error("编辑失败");
		}
	}
	//删除数据
	protected function _del($id=null,$name=null,$return_flag=null){
		if(empty($id)){
			$id=$_REQUEST['id'];
			if(empty($id)){
				$this->error("没有可删除的文章");
			}
		}
		if(empty($name)){
			$name = CONTROLLER_NAME;
		}
		$model = M($name);
		if(!empty($model)){
			if(isset($id)){
				$pk = $model->getPk();
				if(is_array($id)){
					$where[$pk] = array('in',array_filter($id));	
				}else{
					$where[$pk] = array('in',array_filter(explode(',', $id)));
				}
				$result = $model->where($where)->setField('is_del',1);
				if($return_flag){
					return $result;
				}
				if($result !== FALSE){
					$this->assign('jumpUrl',get_return_url());
					$this->success("成功删除{$result}条");
				}else{
					$this->error("删除失败!");
				}
			}else{
				$this->error("没有可删除的数据!");
			}
		}
	}
	
	
	
	
	
	
	
	
	
	
}