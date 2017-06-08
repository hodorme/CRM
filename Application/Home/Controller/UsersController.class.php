<?php
namespace Home\Controller;
use Think\Controller;
use Think\Model;
class UsersController extends Controller {
	//人员选择列表
	public function toselect()
	{
		$this->assign('modular', '人员选择');
		$biao = D('Users');
		$Bumen_model = D('Bumen');
		$where= " 1=1 ";
		//获取传参变量
		$czid = $_REQUEST['czid'];
		$what = $_REQUEST['what'];
		$iname = $_REQUEST['iname'];
		$iid = $_REQUEST['iid'];
		$this->assign('czid', $czid);
		$this->assign('what', $what);
		$this->assign('iname', $iname);
		$sname=str_replace("text","",$iname);
		$this->assign('sname', $sname);
		$this->assign('iid', $iid);
		$sql="select * from Ww_bumen where parid=0 order by Sequence";
		$rlt=M('')->query($sql);
		$list="";
		foreach($rlt as $key=>$val) {
			$list.="<h2>".$val['classname']."</h2>";
			$list.="<ul>";
			$sqlu="select * from Ww_users where (bmid=".$val['id']." or bmid in (select id from Ww_bumen where charindex(',".$val['id']."',parpath)>0)) and ustatus='在职' order by usercode";
			$rlt1=M('')->query($sqlu);
		   foreach($rlt1 as $key=>$val1) {
			   $list.="<li><input type='".$what."' name='sid[]' value='".$val1['id']."' title='".$val1['username']."'></li>";
			}
			$list.="</ul><div class='clear'></div>";
		}
		$this->assign('list', $list);
//		if ($_REQUEST['show']) {
//			switch ($_REQUEST['show']) {
//				//输出dataTbale数据
//				case "showDataTbale":
//					$result = $biao->getFormatAllToSelect($what);
//					$this->ajaxReturn($result, 'json');
//					break;
//			}
//		}
		$this->display();
	}
	public function index(){
		$modular=D('Menu')->GetMenuTitle(CONTROLLER_NAME,ACTION_NAME);
		$this->assign('modular',$modular);
		$biao= D('Users');
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
				case "read":
					$result = $biao->where('id='.$czid)->find();
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
					if ($biao->mySave($_REQUEST)) {
						WriteLog("修改" . $modular . "信息");
						$this->ajaxreturn(array('code' => 1, 'msg' => 'Saved！'));
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
	//用户编辑
	public function profile(){
		$modular='个人资料';
		$this->assign('modular',$modular);
		$biao= D('Users');
		$czid=session('uid');
		if($_REQUEST['show']=='read') {
			$rlt=$biao->where('id='.$czid)->find();
			$this->ajaxReturn($rlt, 'json');
		}
		//操作数据
		if($_REQUEST['act']) {
			switch ($_REQUEST['act']) {
				//修改数据
				case "edit":
					//var_dump($_REQUEST);die;
					if($biao->mySave($_REQUEST)){
						WriteLog("修改".$modular."信息");
						$this->ajaxreturn(array('code'=>1,'msg'=>'Saved！'));
					}else{
						$this->ajaxreturn(array('code'=>2,'msg'=>'修改失败！'));
					}
					break;
			}
		}
		$this->display();
	}
	//用户编辑
	public function view(){
		$modular='查看用户信息';
		$this->assign('modular',$modular);
		$biao= D('Users');
		$czid= $_REQUEST['czid'];
		if(!$czid) {
			exit('参数不足');
		}else{
			$view=$biao->where('id='.$czid)->find();
			$view['hz_type']=$view['hz_type'];
			$this->assign('view', $view);
		}
		$this->display();
	}
}


