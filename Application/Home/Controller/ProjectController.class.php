<?php
namespace Home\Controller;
use Think\Controller;
use Think\Model;
class ProjectController extends Controller {
    //项目管理
	public function index(){
		$modular=D('Menu')->GetMenuTitle(CONTROLLER_NAME,ACTION_NAME);
		$this->assign('modular',$modular);
		$biao= D('Project');
		//获取传参变量
		$czid= $_REQUEST['czid'];
		$this->assign('czid',$czid);
		//输出数据
		if($_REQUEST['show']=="showDataTbale") {
			$biao->getFormatAll();
			exit();
		}
		//操作数据
		if($_REQUEST['act']) {
			switch ($_REQUEST['act']) {
				//删除数据
				case "del":
					if ($a=$biao->myDel()) {
						WriteLog("删除" . $modular . "信息-" . $czid);
						$this->ajaxreturn(array('code' => 1, 'msg' => 'successfully deleted！','error' => $a));
					} else {
						$this->ajaxreturn(array('code' => 2, 'msg' => 'failed to delete!'));
					}
				break;
			}
		}
		$this->display();
	}
	//项目详情
	public function view(){
		$biao = M('Project');
		$expo_model= D('Expo');
		$classmodel= D('Class');
		$usersmodel= D('Users');
		$czid= $_REQUEST['czid'];
		$this->assign('czid',$czid);
		if($czid){
			$view=$biao->where('id='.$czid)->find();
		}
		$view['hangye']=$classmodel->getNameById($view['hangye']);
		$view['admin']=$usersmodel->getUserName($view['userid']);
		$view['zhouqi']=$classmodel->getNameById($view['zhouqi']);
		$view['s1']=$classmodel->getNameById($view['s1']);
		$view['s2']=$classmodel->getNameById($view['s2']);
		$view['s3']=$classmodel->getNameById($view['s3']);
		$view['posttime']=date("Y-m-d",strtotime($view['posttime']));
		$this->assign('view',$view);
		$modular="Project Details-".$view['title'];
		$this->assign('modular',$modular);
		$where=" pid=$czid";
		//输出数据
		if($_REQUEST['show']=="showExpo") {
			$expo_model->getFormatAll($where);
			exit();
		}
		if($_REQUEST['act']) {
			switch ($_REQUEST['act']) {
				case "del":
					if ($expo_model->where("id in (".$_REQUEST['delid'].")")->delete()) {
						$this->ajaxreturn(array('code' => 1, 'msg' => 'successfully deleted！'));
					} else {
						$this->ajaxreturn(array('code' => 2, 'msg' => 'failed to delete!'));
					}
				break;
			}
		}
		$this->display();
	}
//	添加项目
	public function add(){
		$biao=D('Project');
		if($_REQUEST['act']=="create") {
			$_REQUEST['userid']=session('uid');
			if ($a=$biao->add($_REQUEST)) {
				$this->ajaxreturn(array('code' => 1, 'msg' => 'Increase success！','hid' => $a));
			} else {
				$this->ajaxreturn(array('code' => 2, 'msg' => 'Increase the failure！'));
			}
		}
		$this->display();
	}
//	修改项目
	public function edit(){
		$biao=D('Project');
		$class_model=D('Class');
		$this->assign('czid',$_REQUEST['czid']);
		$res=$biao->where("id=".$_REQUEST['czid'])->find();
		$res['country']=$class_model->getNameById($res['s2']);
		$res['city']=$class_model->getNameById($res['s3']);
		$this->assign('res',$res);
		if($_REQUEST['act']=="edit") {
			$_REQUEST['upuserid']=session('uid');
			if ($biao->where('id='.$_REQUEST['czid'])->save($_REQUEST)) {
				$this->ajaxreturn(array('code' => 1, 'msg' => 'Successfully modified！'));
			} else {
				$this->ajaxreturn(array('code' => 2, 'msg' => 'fail to edit！'));
			}
		}
		$this->display();
	}
}


