<?php
namespace Home\Controller;
use Think\Controller;
use Think\Model;
class FeedbackController extends Controller {
    //反馈
	public function index(){
		$biao= D('Feedback');
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
//	添加项目
	public function add(){
		$biao=D('Feedback');
		if($_REQUEST['act']=="create") {
			$_REQUEST['userid'] = session('uid');
			$_REQUEST['posttime'] = date("Y-m-d H:i:s");
			if ($a=$biao->add($_REQUEST)) {
				$this->ajaxreturn(array('code' => 1, 'msg' => 'Saved!'));
			} else {
				$this->ajaxreturn(array('code' => 2, 'msg' => 'Add failure！'));
			}
		}
		$this->display();
	}

}


