<?php
namespace Home\Controller;
use Think\Controller;
use Think\Model;
class MemberController extends Controller {
    //会员列表
	public function index(){
		$module='会员列表';
		$this->assign('modular',$module);
		$biao= D('Member');
		$this->display();
	}
	//操作
	public function add(){
		$biao= D('Member');
		$modular='人员信息';
		$this->assign('modular','人员信息');
		//获取传参变量
		$czid= $_REQUEST['czid'];
		$cid= $_REQUEST['cid'];
		$list= $_REQUEST['list'];
		$this->assign('czid',$czid);
		$this->assign('cid',$cid);
		$this->assign('list',$list);
		//输出数据
		if($_REQUEST['show']) {
			switch ($_REQUEST['show']) {
				case "edit":
					$result=$biao->getAll('id='.$czid);
					$Customer_model=D('Customer');
					$result[0]['cname']=$Customer_model->getNameById($result[0]['cid']);
					$this->ajaxReturn($result, 'json');
					break;
			}
		}
		//操作数据
		if($_REQUEST['act']) {
			switch ($_REQUEST['act']) {
				//新增数据
				case "create":
					if ($biao->myAdd($_REQUEST)){
						WriteLog("添加" . $modular . "信息");
						$this->ajaxreturn(array('code' => 1, 'msg' => '增加成功！'));
					} else {
						$this->ajaxreturn(array('code' => 2, 'msg' => '增加失败！'));
					}
					break;
				//修改数据
				case "edit":
					if ($biao->mySave($_REQUEST)) {
//						WriteLog("修改" . $modular . "信息");
						$this->ajaxreturn(array('code' => 1, 'msg' => '修改成功！','list'=>$_REQUEST['list']));
					} else {
						$this->ajaxreturn(array('code' => 2, 'msg' => '修改失败！'));
					}
					break;
				//删除数据
				case "del":
					if ($biao->myDel($czid)) {
						WriteLog("删除" . $modular . "信息-" . $czid);
						$this->ajaxreturn(array('code' => 1, 'msg' => '删除成功！', 'where' => 'zhanguan'));
					} else {
						$this->ajaxreturn(array('code' => 2, 'msg' => '删除失败!'));
					}
					break;
			}
		}
		$this->display();
	}
	//会员详情
	public function view(){
		$biao= D('Member');
		$this->display();
	}
}




