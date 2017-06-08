<?php
namespace Home\Controller;
use Think\Controller;
use Think\Model;
class ExpoController extends Controller {
//	展会管理
	public function index(){
		$this->assign('modular','展会管理');
		$biao= D('Expo');
		//获取传参变量
		$czid= $_REQUEST['czid'];
		$this->assign('czid',$czid);
		//输出数据
		if($_REQUEST['show']=='showDataTbale') {
			//输出dataTbale数据
			$biao->getFormatAll();
			exit();
		}
		//操作数据
		if($_REQUEST['act']) {
			switch ($_REQUEST['act']) {
				//删除数据
				case "del":
					if ($biao->myDel()) {
						// WriteLog("删除" . $modular . "信息-" . $czid);
						$this->ajaxreturn(array('code' => 1, 'msg' => '删除成功！'));
					} else {
						$this->ajaxreturn(array('code' => 2, 'msg' => '删除失败!'));
					}
					break;
			}
		}
		$this->display();
	}
//	添加展会信息
	public function add(){
		$pid=$_REQUEST['czid'];
		$this->assign('pid',$pid);
		if($pid){
			$project=D('Project')->field('title')->where('id='.$pid)->find();
			$this->assign('project',$project['title']);
		}
		$biao=D('Expo');
		if($_REQUEST['act']=="create") {
			$_REQUEST['userid']=session('uid');
			$_REQUEST['title']=$_REQUEST['title']." ".date('Y',strtotime($_REQUEST['starttime']));
			if ($a=$biao->add($_REQUEST)) {
				$this->ajaxreturn(array('code' => 1, 'msg' => '增加成功！','expoid'=>$a));
			} else {
				$this->ajaxreturn(array('code' => 2, 'msg' => '增加失败！'));
			}
		}
		$this->display();
	}
//	展会详细信息
	public function view(){
		$czid=$_REQUEST['czid'];
		$this->assign('czid',$czid);
		$biao=D('Expo');
		$orders_model=D('Orders');
		$project_model=D('Project');
		$class_model=D('Class');
		$res=$biao->where("id=".$czid)->find();
		$info=$project_model->where("id=".$res['pid'])->find();
		$res['zhouqi']=$class_model->getNameById($info['zhouqi']);
		$res['hangye']=$class_model->getNameById($info['hangye']);
		$res['s1']=$class_model->getNameById($info['s1']);
		$res['s2']=$class_model->getNameById($info['s2']);
		$res['s3']=$class_model->getNameById($info['s3']);
		$res['starttime']=date("Y-m-d",strtotime($res['starttime']));
		$res['endtime']=date("Y-m-d",strtotime($res['endtime']));
		$this->assign('res',$res);
		$modular='Details of the expo-'.$res['title'];
		$this->assign('modular',$modular);
		if($_REQUEST['show']=="showDataTbale") {
			$where=" and expoid=$czid";
			$orders_model->getFormatAllToYxd($where);
			exit();
		}
		if($_REQUEST['show']=="showDataTbale1") {
			$where=" and expoid=$czid";
			$orders_model->getFormatAll($where);
			exit();
		}
		if($_REQUEST['show']=="showDataTbale2") {
			$where['expo']='expo';
			$where['expoid']=$czid;
			$orders_model->getFormatAllToGuaDan($where);
			exit();
		}
		$this->display();
	}
//	修改展会信息
	public function edit(){
		$biao=D('Expo');
		$project_model=D('Project');
		$this->assign('czid',$_REQUEST['czid']);
		$from=$_REQUEST['from'];
		$this->assign('from',$from);
		$res=$biao->where("id=".$_REQUEST['czid'])->find();
		$res['project']=$project_model->field('title')->where("id=".$res['pid'])->find();
		$this->assign('res',$res);
		if($_REQUEST['act']=="edit") {
			$_REQUEST['upuserid']=session('uid');
			if ($biao->where("id=".$_REQUEST['czid'])->save($_REQUEST)) {
				$this->ajaxreturn(array('code' => 1, 'msg' => '修改成功！','from'=>$from));
			} else {
				$this->ajaxreturn(array('code' => 2, 'msg' => '修改失败！'));
			}
		}
		$this->display();
	}
}


