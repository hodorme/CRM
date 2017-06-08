<?php
namespace Home\Controller;
use Think\Controller;
use Think\Model;
class RoleController extends Controller {
    //系统权限-系统角色
	public function index(){
		$modular=D('Menu')->GetMenuTitle(CONTROLLER_NAME,ACTION_NAME);
		$this->assign('modular',$modular);
		$biao= D('Role');
		//获取传参变量
		$czid= $_REQUEST['czid'];
		//输出数据
		if($_REQUEST['show']) {
			switch ($_REQUEST['show']) {
				//输出dataTbale数据
				case "showDataTbale":
					$result = $biao->getFormatAll($where);
					$this->ajaxReturn($result, 'json');
					break;
				case "edit":
					$result = $biao->getAll('id='.$czid);
					$this->ajaxReturn($result, 'json');
					break;
			}
		}
		//操作数据
		if($_REQUEST['act']) {
			switch ($_REQUEST['act']) {
				//新增数据
				case "create":
					if ($biao->myAdd($_REQUEST)) {
						WriteLog("添加" . $modular . "信息");
						$this->ajaxreturn(array('code' => 1, 'msg' => '增加成功！'));
					} else {
						$this->ajaxreturn(array('code' => 2, 'msg' => '增加失败！'));
					}
					break;
				//修改数据
				case "edit":
					//dump($_REQUEST);die;
					if ($biao->mySave($_REQUEST)) {
						WriteLog("修改" . $modular . "信息");
						$this->ajaxreturn(array('code' => 1, 'msg' => '修改成功！'));
					} else {
						$this->ajaxreturn(array('code' => 2, 'msg' => '修改失败！'));
					}
					break;
				//删除数据
				case "del":
					if ($biao->myDel($czid)) {
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
}


