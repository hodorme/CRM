<?php
namespace Home\Controller;
use Think\Controller;
use Think\Model;
class BumenController extends Controller {
	public function index(){
		$modular=D('Menu')->GetMenuTitle(CONTROLLER_NAME,ACTION_NAME);
		$this->assign('modular',$modular);
		$biao= D('Bumen');
		//获取传参变量
		$czid= $_REQUEST['czid'];
		//输出数据
		if($_REQUEST['show']) {
			switch ($_REQUEST['show']) {
				//输出dataTbale数据
				case "showDataTbale":
					$where['bmid']=$_REQUEST['bmid'];
					$where['parid']=$_REQUEST['parid'];
					$result = $biao->getFormatAll($where);
					$this->ajaxReturn($result, 'json');
					break;
			}
		}
		//操作数据
		if($_REQUEST['act']) {
			switch ($_REQUEST['act']) {
				//删除数据
				case "del":
					if ($biao->myDel($_REQUEST['czid'])) {
						WriteLog("删除" . $modular . "信息-" . $czid);
						$this->ajaxreturn(array('code' => 1, 'msg' => '删除成功！'));
					} else {
						$this->ajaxreturn(array('code' => 2, 'msg' => '删除失败!'));
					}
					break;
			}
		}
		$this->display();
	}
	public function add(){
		$biao = D('Bumen');
		$czid = $_REQUEST['czid'];
		$djid = $_REQUEST['djid'];
		if(!$djid){
			$djid = 0;
		}
		$this->assign('djid',$djid);
		$this->assign('czid',$czid);
		//输出数据
		if($_REQUEST['show']) {
			switch ($_REQUEST['show']) {
				//输出dataTbale数据
				case "edit":
					$result = $biao->getAll('id='.$czid);
					$this->ajaxReturn($result,'json');
					break;
			}
		}
		//操作数据
		if($_REQUEST['act']) {
			switch ($_REQUEST['act']) {
				//新增数据
				case "create":
					if ($biao->myAdd($_REQUEST)) {
						$this->ajaxreturn(array('code' => 1, 'msg' => '增加成功！'));
					} else {
						$this->ajaxreturn(array('code' => 2, 'msg' => '增加失败！'));
					}
					break;
				//修改数据
				case "edit":
					if ($biao->mySave($_REQUEST)) {
						$this->ajaxreturn(array('code' => 1, 'msg' => '修改成功！'));
					} else {
						$this->ajaxreturn(array('code' => 2, 'msg' => '修改失败！'));
					}
					break;
			}
		}
		$this->display();
	}
}


