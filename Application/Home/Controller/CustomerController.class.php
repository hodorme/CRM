<?php
namespace Home\Controller;
use Think\Controller;
use Think\Model;
class CustomerController extends Controller {
	//会展服务客户管理

	public function index(){
		$module='Accounts';
		// $modular=D('Menu')->GetMenuTitle(CONTROLLER_NAME,ACTION_NAME);
		$this->assign('modular',$module);
		//获取传参变量
		$czid= $_REQUEST['czid'];
		$showD= $_REQUEST['showD'];
		$biao= D('Customer');
		//我的客户当前条件下企业统计
		$userid=$_SESSION['uid'];
		$bmid['bmid']=$_SESSION['bmid'];
		$ThisM=$_REQUEST['ThisM'];
		if($ThisM == 'month'){
			$BeginDate = date('Y-m-01', strtotime(date("Y-m-d")));
			$_REQUEST['posttime'] = $BeginDate;
			$BeginDate1 = date('Y-m-d', strtotime("$BeginDate +1 month -1 day"));
			$_REQUEST['posttime1'] = $BeginDate1;
			$this->assign('BeginDate',$BeginDate);
			$this->assign('BeginDate1',$BeginDate1);
		}
		$this->assign('showD',$showD);
		$this->assign('bmid',$bmid);
		$FullSearch = $_REQUEST['FullSearch'];
		$this->assign('FullSearch', $FullSearch);
		//客户关键字
		$sumSqlWhere = " ";
		$sumSqlWhere .=$_REQUEST['company']?" and title LIKE '%".$_REQUEST['company']."%'":"";

		//国家
		$sumSqlWhere .=$_REQUEST['country']?" and s2 in(select id from AEG_class where classname like '%".$_REQUEST['country']."%')":"";

		//客户状态
		$sumSqlWhere .=$_REQUEST['classid']?" and orderstatus = '".$_REQUEST['classid']."'":"";

		//性质
		$sumSqlWhere .=$_REQUEST['type']?" and type = ".$_REQUEST['type']."":"";

		//行业
		$sumSqlWhere .=$_REQUEST['industry']?" and industry = ".$_REQUEST['industry']."":"";

		//联系人
		$sumSqlWhere .=$_REQUEST['fullname']?" and id in(select cid from AEG_member where fullname LIKE '%".$_REQUEST['fullname']."%')":"";

		//手机
		$sumSqlWhere .=$_REQUEST['mobile']?" and id in(select cid from AEG_member where mobile LIKE '%".$_REQUEST['mobile']."%')":"";

		//客户经理
		$sumSqlWhere .=$_REQUEST['userid']?" and userid = ".$_REQUEST['userid']."":"";

		//部门
		$sumSqlWhere .=$_REQUEST['bumen']?" and userid in (select id from AEG_users where bmid=".$_REQUEST['bumen']." )":"";

		//网站关键字
		$sumSqlWhere .=$_REQUEST['website']?" and website LIKE '%".$_REQUEST['website']."%'":"";

		//邮箱关键字
		$sumSqlWhere .=$_REQUEST['email']?" and id in (select cid from AEG_member where email LIKE '%".$_REQUEST['email']."%')":"";

		//添加开始时间
		$sumSqlWhere .=$_REQUEST['posttime']?" and posttime >= '".$_REQUEST['posttime']."'":"";

		//添加结束时间
		$sumSqlWhere .=$_REQUEST['posttime1']?" and posttime <= '".$_REQUEST['posttime1']."'":"";
		//输出数据
		if($_REQUEST['show'] == 'showDataTbale') {
			//输出dataTbale数据
			if(!$showD){
				$where['progress'] = 1;
			}else if($showD == 'bmkh'){
				$where['progress'] = 2;
			}else if($showD == 'gxkh'){
				$where['progress'] = 4;
			}else if($showD == 'jxlkh'){
				$where['progress'] = 5;
			}else if($showD == 'wajlkh'){
				$where['progress'] = 6;
			}else if($showD == 'c15wlxkh'){
				$where['progress'] = 8;
			}
			$biao->getFormatAll($where,$sumSqlWhere);
			exit();
		}
		//操作数据
		if($_REQUEST['act']) {
			switch ($_REQUEST['act']) {
				//新增数据
				case "create":
					if ($biao->myAdd($_REQUEST)) {
						// WriteLog("添加" . $modular . "信息");
						$this->ajaxreturn(array('code' => 1, 'msg' => 'Saved!！'));
					} else {
						$this->ajaxreturn(array('code' => 2, 'msg' => 'Increase the failure！'));
					}
					break;
				//修改数据
				case "edit":
					if ($biao->mySave($_REQUEST)) {
						// WriteLog("修改" . $modular . "信息");
						$this->ajaxreturn(array('code' => 1, 'msg' => 'Successfully modified！'));
					} else {
						$this->ajaxreturn(array('code' => 2, 'msg' => 'fail to edit！'));
					}
					break;
				//删除数据
				case "del":
					if ($biao->myDel($czid)) {
						// WriteLog("删除" . $modular . "信息-" . $czid);
						$this->ajaxreturn(array('code' => 1, 'msg' => 'Deleted！'));
					} else {
						$this->ajaxreturn(array('code' => 2, 'msg' => 'failed to delete!'));
					}
					break;
			}
		}
		$this->display();
	}
	//详细页面
	public function view(){
		$Customer_model=D('Customer');
		$Member_model=D('Member');
		$ContactRecord_model=D('ContactRecord');
		$Orders_model=D('Orders');
		$Class_model=D('Class');
		//获取传参变量
		$czid= $_REQUEST['czid'];
		$showD= $_REQUEST['showD'];
		$sql="select a.*,b.classname,c.classname as s1name,d.classname as s2name,
						e.classname as s3name,f.classname as industryname,
						g.classname as businessname,h.classname as typename,
						j.classname as languagename,k.classname as sourcename,
						l.username,q.classname
						from AEG_company a
						left join AEG_class b on a.classid = b.id
						left join AEG_class c on a.s1 = c.id
						left join AEG_class d on a.s2 = d.id
						left join AEG_class e on a.s3 = e.id
						left join AEG_class f on a.industry = f.id
						left join AEG_class g on a.business = g.id
						left join AEG_class h on a.type = h.id
						left join AEG_class j on a.language = j.id
						left join AEG_class k on a.source = k.id
						left join AEG_class q on a.classid = q.id
						left join AEG_users l on a.userid = l.id
						where a.id = $czid";
		$view=$Customer_model->query($sql);
		$view=$view[0];
		$product = explode(',',$view['product']);
		$products = '';
		foreach ($product as $key => $value)
		{
			if($products){
				$products .=',';
			}
			$products .= $Class_model->getNameById($value);
		}
		$view['product'] = $products;
		$view['updatedtime']=$view['updatedtime']?date('Y-m-d H:i:s',strtotime($view['updatedtime'])):'';
		$view['posttime']=$view['posttime']?date('Y-m-d H:i:s',strtotime($view['posttime'])):'';
		$islxr = $Member_model->where('cid = '.$czid)->find();
		$this->assign('view',$view);
		$this->assign('czid',$czid);
		$this->assign('showD',$showD);
		$this->assign('islxr',$islxr);
		// $modular=D('Menu')->GetMenuTitle(CONTROLLER_NAME,ACTION_NAME);
		$this->assign('modular',$view['title']);
		//输出显示数据
		if($_REQUEST['show']) {
			switch ($_REQUEST['show']) {
				case "showDataTbale":
					//$czid= $_REQUEST['czid'];
					//$map['cid']=$czid;
					//$result=$Orders_model->getFormatAllToYxd($map);
					//$this->ajaxReturn($result, 'json');
					break;
				//输出联系人数据
				case "showMemberDataTbale":
					$map['cid']=$czid;
					$result=$Member_model->getFormatAll($map);
					$this->ajaxReturn($result, 'json');
					break;
				//输出联系记录
				case "showLianxiJiluDataTbale":
					$map['cid']=$czid;
					$ContactRecord_model->getFormatAll($map);
					exit();
					break;
				//输出意向单
				case "showOrdersYxdDataTbale":
					$map= " and cid=$czid";
					$Orders_model->getFormatAllToYxd($map);
					exit();
					break;
				//输出有效订单
				case "showOrdersDataTbale":
					$map = " and cid=$czid";
					$Orders_model->getFormatAll($map);
					exit();
					break;
				//输出有效订单
				case "showStopDataTbale":
					$map['cid'] = $czid;
					$Orders_model->getFormatAllToGuaDan($map);
					exit();
					break;
			}
		}
		$this->display();
	}
	//添加编辑客户信息
	public function add(){
		$biao= D('Customer');
		//获取传参变量
		$czid = $_REQUEST['czid'];
		$cid = $_REQUEST['cid'];
		$table = $_REQUEST['table'];
		$this->assign('czid',$czid);
		$this->assign('cid',$cid);
		$this->assign('table',$table);
		if($czid){
			$edit = $biao->where('id = '.$czid)->find();
			$this->assign('edit',$edit);
		}
		$bmid = session('bmid');
		if($bmid == 52){
			$hangye = 1627;
		}else if($bmid == 53){
			$hangye = 1628;
		}else{
			$hangye = 0;
		}
		$this->assign('hangye',$hangye);
		//输出数据
		if($_REQUEST['show']) {
			switch ($_REQUEST['show']) {
				case "edit":
					$result = $biao->getAll('id='.$czid);
					$this->ajaxReturn($result, 'json');
					break;
				case "gysName":
					$title=trim($_REQUEST['vtitle']);
					$list =$biao->where("title = '".$title."'")->find();
					$this->ajaxReturn($list,'json');
					break;
			}
		}
		//操作数据
		if($_REQUEST['act']) {
			switch ($_REQUEST['act']) {
				//新增数据
				case "create":
					if ($a = $biao->myAdd($_REQUEST)){
//						WriteLog("添加" . $modular . "信息");
						$this->ajaxreturn(array('code' => 1, 'msg' => 'Saved!！', 'table' => $_REQUEST['table'], 'cid' => $a));
					} else {
						$this->ajaxreturn(array('code' => 2, 'msg' => 'Increase the failure！'));
					}
					break;
				//修改数据
				case "edit":
					if($_REQUEST['cfname']){
						$title=trim($_REQUEST['jtitle']);
						$list =$biao->where("title = '".$title."'")->find();
						if($list){
							$this->ajaxreturn(array('code' => 3));
						}else{
							if ($biao->mySave($_REQUEST)) {
								$this->ajaxreturn(array('code' => 1, 'msg' => 'Update success!', 'table' => $_REQUEST['table']));
							} else {
								$this->ajaxreturn(array('code' => 2, 'msg' => 'Increase the failure！'));
							}
						}
					}else{
						if ($biao->mySave($_REQUEST)) {
							$this->ajaxreturn(array('code' => 1, 'msg' => 'Update success!'));
						} else {
							$this->ajaxreturn(array('code' => 2, 'msg' => 'Increase the failure！'));
						}
					}
					break;
			}
		}
		$this->display();
	}
	//添加联系人信息
	public function addlianxiren(){
		$this->assign('modular','联系人信息');
		$biao = D('Member');
		//获取传参变量
		$czid= $_REQUEST['czid'];
		$cid= $_REQUEST['cid'];
		$this->assign('czid',$czid);
		$this->assign('cid',$cid);
		if($czid){
			$edit = $biao->where('id = '.$czid)->find();
			$this->assign('edit',$edit);
		}
		//输出数据
		if($_REQUEST['show']) {
			switch ($_REQUEST['show']) {
				case "edit":
					$result=$biao->getAll('id='.$czid);
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
						$this->ajaxreturn(array('code' => 1, 'msg' => 'Saved!！'));
					} else {
						$this->ajaxreturn(array('code' => 2, 'msg' => 'Increase the failure!'));
					}
					break;
				//修改数据
				case "edit":
					if ($biao->mySave($_REQUEST)) {
//						WriteLog("修改" . $modular . "信息");
						$this->ajaxreturn(array('code' => 1, 'msg' => 'Update success!'));
					} else {
						$this->ajaxreturn(array('code' => 2, 'msg' => 'fail to edit'));
					}
					break;
				//删除数据
				case "del":
					if ($biao->myDel($czid)) {
						WriteLog("删除" . $modular . "信息-" . $czid);
						$this->ajaxreturn(array('code' => 1, 'msg' => 'Deleted!', 'where' => 'zhanguan'));
					} else {
						$this->ajaxreturn(array('code' => 2, 'msg' => 'failed to delete!'));
					}
					break;
			}
		}
		$this->display();
	}
	//添加联系记录信息
	public function addlianxijilu(){
		$biao = D('ContactRecord');
		$Orders_model = D('Orders');
		$Customer_model = D('Customer');
		//获取传参变量
		$cid = $_REQUEST['cid'];
		$this->assign('cid',$cid);
		$info = $Orders_model->where("cid = ".$cid." and orderstatus='有效意向单'")->find();
		$data = $Customer_model->where("id = ".$cid)->find();
		$this->assign('info',$info);
		$this->assign('data',$data);
		//操作数据
		if($_REQUEST['act']) {
			switch ($_REQUEST['act']) {
				//新增数据
				case "create":
					if ($biao->myAdd($_REQUEST)){
						$this->ajaxreturn(array('code' => 1, 'msg' => 'Saved!！'));
					} else {
						$this->ajaxreturn(array('code' => 2, 'msg' => 'Increase failed!'));
					}
					break;
			}
		}
		$this->display();
	}
	//转为共享
	public function addgongxiang(){
		$this->assign('modular','转为共享');
		$biao= D('Customer');
		//获取传参变量
		$czid= $_REQUEST['cid'];
		$this->assign('czid',$czid);
		//操作数据
		if($_REQUEST['act']) {
			switch ($_REQUEST['act']) {
				//修改数据
				case "edit":
					if ($biao->gxSave($_REQUEST)) {
//						WriteLog("修改" . $modular . "信息");
						$this->ajaxreturn(array('code' => 1, 'msg' => 'Update success!'));
					} else {
						$this->ajaxreturn(array('code' => 2, 'msg' => 'fail to edit!'));
					}
					break;
			}
		}
		$this->display();
	}
	//批量转移
	public function piliangzy(){
		$biao= D('Customer');
		$id = explode(",", $_REQUEST['arr']);
		$count=count($id);
		$biao->startTrans();
		for($i=0;$i<$count;$i++){
			$cid=$id[$i];
			$map['classid']=1859;
			$map['updatedtime']=date("Y-m-d H:i:s");
			if($cid){
				$biao->where('id = '.$cid)->save($map);
			}else{
				$biao->rollback();
				return 0;
			}
		}
		$biao->commit();
		return 1;
	}
	//批量删除
	public function piliangdel(){
		$biao= D('Customer');
		$id = explode(",", $_REQUEST['arr']);
		$count=count($id);
		$biao->startTrans();
		for($i=0;$i<$count;$i++){
			$cid=$id[$i];
			if($cid){
				$biao->where('id = '.$cid)->delete();
			}else{
				$biao->rollback();
				return 0;
			}
		}
		$biao->commit();
		return 1;
	}
	//批量调配
	public function piliangtp(){
		$biao= D('Customer');
		$id = explode(",", $_REQUEST['arr']);
		$count=count($id);
		$biao->startTrans();
		for($i=0;$i<$count;$i++){
			$cid=$id[$i];
			$map['classid']=1860;
			$map['userid']=$_REQUEST['uid'];
			$map['updatedtime']=date("Y-m-d H:i:s");
			if($cid){
				$biao->where('id = '.$cid)->save($map);
			}else{
				$biao->rollback();
				return 0;
			}
		}
		$biao->commit();
		return 1;
	}

	//转为自己
	public function addziji(){
		$biao= D('Customer');
		$map['userid']=session('uid');
		$map['classid']=1860;
		if ($biao->where('id = '.$_REQUEST['cid'])->save($map)) {
//						WriteLog("修改" . $modular . "信息");
			$this->ajaxreturn(array('code' => 1, 'msg' => 'Turn yourself into success!'));
		} else {
			$this->ajaxreturn(array('code' => 2, 'msg' => 'Turn yourself into failure!'));
		}
	}
	//批量转为自己
	public function plziji(){
		$biao= D('Customer');
		$id = explode(",", $_REQUEST['arr']);
		$count=count($id);
		$biao->startTrans();
		for($i=0;$i<$count;$i++){
			$cid=$id[$i];
			$map['userid']=session('uid');
			$map['classid']=1860;
			if($cid){
				$biao->where('id = '.$cid)->save($map);
			}else{
				$biao->rollback();
				return 0;
			}
		}
		$biao->commit();
		return 1;
	}
	public function ismember(){
		$map['cid']=$_REQUEST['czid'];
		$Member_model=D('Member');
		if($Member_model->getAll($map)){
			$this->ajaxreturn(array('code' => 1));
		} else {
			$this->ajaxreturn(array('code' => 2));
		}
	}
	//添加意向信息
	public function addintention(){
		$this->assign('modular','意向管理');
		$biao= D('Orders');
		$Customer_model= D('Customer');
		$Member_model= D('Member');
		//获取传参变量
		$czid= $_REQUEST['czid'];
		$cid= $_REQUEST['cid'];
		if($cid){
			$request=$Customer_model->where('id = '.$cid)->find();
			$default=$Member_model->where('cid = '.$cid.' and setdefault = 1 ')->find();
		}
		$expo_model=D('Expo');
		$res=$expo_model->query("select top 1 title from AEG_expo where title like '%Expo F%' order by posttime desc");
		$res1=$expo_model->query("select top 1 title from AEG_expo where title like '%InterLumi Panama%' order by posttime desc");
		if(session('bmid')==52){
			$this->assign("res",$res1[0]);
		}else if(session('bmid')==53){
			$this->assign("res",$res[0]);
		}
		$this->assign('czid',$czid);
		$this->assign('cid',$cid);
		$this->assign('request',$request);
		$this->assign('default',$default);
		//输出数据
		if($_REQUEST['show']) {
			switch ($_REQUEST['show']) {
				case "read":
					$result=$biao->where('id='.$czid)->select();
					$result[0]['actprice']=round($result[0]['actprice'],2);
					$this->ajaxReturn($result, 'json');
					break;
			}
		}
		//操作数据
		if($_REQUEST['act']) {
			switch ($_REQUEST['act']) {
				//新增数据
				case "create":
					if ($a=$biao->myAdd($_REQUEST)){
//						WriteLog("添加" . $modular . "信息");
						$this->ajaxreturn(array('code' => 1, 'msg' => 'Saved!！','oid' => $a));
					} else {
						$this->ajaxreturn(array('code' => 2, 'msg' => 'Increase failed!'));
					}
					break;
				//修改数据
				case "edit":
					if ($biao->mySave($_REQUEST)) {
//						WriteLog("修改" . $modular . "信息");
						$this->ajaxreturn(array('code' => 1, 'msg' => 'Saved!','oid' => $_REQUEST['czid']));
					} else {
						$this->ajaxreturn(array('code' => 2, 'msg' => 'fail to edit!'));
					}
					break;
			}
		}
		$this->display();
	}
	//统计选择当天有多少客户
	public function nexttime(){
		$cid=$_REQUEST['cid'];
		$nexttime=$_REQUEST['nexttime'];
		$userid=$_SESSION['uid'];
		$bmid=$_SESSION['bmid'];
		$ContactRecord_model=D('ContactRecord');
		$sql="select a.id,a.cid,a.nexttime
                from  AEG_company_note a
                where a.nexttime='$nexttime' and a.cid in(select id from AEG_company b where b.userid=$userid and b.classid<>1859)";
		$list=$ContactRecord_model->query($sql);
		$count=count($list);
		$this->ajaxReturn($count, 'json');
	}
	public function moren(){
		$where=$_POST['where'];
		$czid=$_POST['czid'];
		$cid=$_POST['cid'];
			$czmodel=D('Member');
			$data['setdefault']=1;
			$param['setdefault']=0;
		$foin = $czmodel->where('cid='.$cid)->save($param);
		$info = $czmodel->where('cid='.$cid .'and id='.$czid)->save($data);
		if($info){
			echo 1;
		}else{
			echo $czid;
		}
	}
}


