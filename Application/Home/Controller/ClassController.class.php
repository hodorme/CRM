<?php
namespace Home\Controller;
use Think\Controller;
use Think\Model;
class ClassController extends Controller {
    //系统配置-系统功能
	public function index(){
		$this->assign('modular','类别管理');
		$biao= D('Class');
		$this->assign('flagset',array(1=>'功能组',2=>'功能项'));
		//获取传参变量
		$czid= $_REQUEST['czid'];
		$parid= $_REQUEST['parid'];
		$this->assign('parid',$parid);
		if($parid){
			$where="parid=".$parid." or id=".$parid;
		}else{
			$where="parid=0 ";
		}
		$this->assign('czid',$czid);
		if($_REQUEST['show']=="showDataTbale"){
			$biao->getFormatAll($where);
			exit();
		}
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
	public function add(){
		$biao=D('Class');
		$this->assign('flid',$_REQUEST['flid']);
		if($_REQUEST['act']) {
			switch ($_REQUEST['act']) {
				//新增数据
				case "create":
					if($_REQUEST['flid']){
						$ariable=$_REQUEST['flid'];
						$res=$biao->field('parpath')->where('id='.$ariable)->find();
						if($ariable != 0){
							$_REQUEST['parpath'] = $res['parpath'].','.$ariable;
						}else{
							$_REQUEST['parpath'] = '0';
						}
						$_REQUEST['parid']=$_REQUEST['flid'];
						$_REQUEST['userid']=session('uid');
					}else{
						$_REQUEST['parid']=0;
						$_REQUEST['userid']=session('uid');
						$_REQUEST['parpath']=0;
					}
					if ($biao->add($_REQUEST)) {
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
	public function edit(){
		$biao=D('Class');
		$this->assign('czid',$_REQUEST['czid']);
		$res=$biao->where('id='.$_REQUEST['czid'])->find();
		$this->assign('res',$res);
		if($_REQUEST['act']) {
			switch ($_REQUEST['act']) {
				//修改数据
				case "edit":
					if ($biao->where("id=".$_REQUEST['czid'])->save($_REQUEST)) {
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



