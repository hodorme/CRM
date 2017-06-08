<?php
namespace Home\Controller;
use Think\Controller;
use Think\Model;
class DaochuController extends Controller {
	public function index(){
		$modular=D('Menu')->GetMenuTitle(CONTROLLER_NAME,ACTION_NAME);
		$this->assign('modular',$modular);
		$biao= D('Daochu');
		//获取传参变量
		$czid= $_REQUEST['czid'];
		//输出数据
		if($_REQUEST['show']) {
			switch ($_REQUEST['show']) {
				//输出dataTbale数据
				case "showDataTbale":
					$where = "1=1";
					$where .= $_REQUEST['keyword']?" and cid in(select id from AEG_company where title like '%".$_REQUEST['keyword']."%')":'';
					$where .= $_REQUEST['ssid']?" and cid in(select id from AEG_company where userid in(select id from AEG_users where bmid = ".$_REQUEST['ssid']."))":'';
					$where .= $_REQUEST['userid']?" and cid in(select id from AEG_company where userid= ".$_REQUEST['userid'].")":'';
					$result = $biao->getFormatAll($where);
					$this->ajaxReturn($result, 'json');
					break;
			}
		}
		$this->display();
	}
}


