<?php
namespace Home\Controller;
use Think\Controller;
use Think\Model;
class FullcustomerController extends Controller {
	//全库客户管理
	public function index(){
		$module='Find all clients';
		// $modular=D('Menu')->GetMenuTitle(CONTROLLER_NAME,ACTION_NAME);
		$this->assign('modular',$module);
		//获取传参变量
		$showD= $_REQUEST['showD'];
		$biao= D('Fullcustomer');
		$title=$_REQUEST['title'];
		//我的客户当前条件下企业统计
		$this->assign('showD',$showD);
		$this->assign('title',$title);
		//输出数据
		if($_REQUEST['show'] == 'showDataTbale') {
			//输出dataTbale数据
			$title=$_REQUEST['title'];
			$where=" and title like '%".$title."%' or website like '%".$title."%'";
			$biao->getFormatAll($where);
			exit();
		}
		$this->display();
	}
	//全库查找联系记录
	public function record(){
		$cid=$_REQUEST['czid'];
		$ContactRecord_model=D('ContactRecord');
		$list=$ContactRecord_model->where('cid = '.$cid)->limit(3)->select();
		$this->ajaxReturn($list, 'json');
	}
}


