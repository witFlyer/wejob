<?php
namespace Admin\Widget;
use Think\Controller;

class PageHeaderWidget extends Controller{
	public function render($name,$search){
		
		if(empty($search)){
			$content = $this->assign("name",$name);
		}else{
			switch ($search) {
				case 'S':
					$this->assign("name",$name);
					$this->display("Widget:page_header_search");
					break;
				case 'M':
					$this->assign("name",$name);
					$this->display("Widget:page_header_adv_search");
					break;
				case 'L':
					$this->assign("name",$name);
					$this->display("Widget:page_header_local_search");
					break;
				default:
					$this->assign("name",$name);
					$this->display("Widget:page_header_simple");
					break;
			}
		}
	}
}