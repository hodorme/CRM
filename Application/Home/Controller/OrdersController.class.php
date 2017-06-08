<?php
namespace Home\Controller;
use Think\Controller;
use Think\Model;
class OrdersController extends Controller
{
    public function index()
    {
        $modular=D('Menu')->GetMenuTitle(CONTROLLER_NAME,ACTION_NAME);
        $this->assign('modular',$modular);
        //获取传参变量
        $czid= $_REQUEST['czid'];
        $FullSearch = $_REQUEST['FullSearch'];
        $this->assign('FullSearch', $FullSearch);
        $biao= D('Orders');
        //输出数据
        //dump($_REQUEST);die;
        if($_REQUEST['show'] == 'showDataTbale') {
            //输出dataTbale数据
            $biao->getFormatAll();
            exit();
        }
        //操作数据
        if($_REQUEST['act']) {
            switch ($_REQUEST['act']) {
                //新增数据
                case "create":
                    if ($biao->myAdd($_REQUEST)) {
                        // WriteLog("添加" . $modular . "信息");
                        $this->ajaxreturn(array('code' => 1, 'msg' => 'Increase Success！'));
                    } else {
                        $this->ajaxreturn(array('code' => 2, 'msg' => 'Increase The Failure！'));
                    }
                    break;
                //修改数据
                case "edit":
                    if ($biao->mySave($_REQUEST)) {
                        // WriteLog("修改" . $modular . "信息");
                        $this->ajaxreturn(array('code' => 1, 'msg' => 'Successfully Modified！'));
                    } else {
                        $this->ajaxreturn(array('code' => 2, 'msg' => 'Fail To Edit！'));
                    }
                    break;
                //删除数据
                case "del":
                    if ($biao->delOrders($czid)) {
                        // WriteLog("删除" . $modular . "信息-" . $czid);
                        $this->ajaxreturn(array('code' => 1, 'msg' => 'Successfully Deleted！'));
                    } else {
                        $this->ajaxreturn(array('code' => 2, 'msg' => 'Failed To Delete!'));
                    }
                    break;
            }
        }
        $this->display();
    }

    //意向订单管理
    public function intent()
    {
        $modular = "意向管理";
        $this->assign('modular',$modular);
        //获取传参变量
        $czid= $_REQUEST['czid'];
        $showD= $_REQUEST['showD'];
        $this->assign('showD',$showD);
        $biao= D('Orders');
        $where=" and 1=1 ";
        $where.=$_REQUEST['company']?" and cid in (select id from AEG_company where title like '%".$_REQUEST['company']."%')":"";
        $where.=$_REQUEST['country']?" and cid in (select id from AEG_company where s2 in(select id from AEG_class where classname like '%".$_REQUEST['country']."%'))":"";
        $where.=$_REQUEST['expo']?" and expoid=".$_REQUEST['expo']:"";
        $where.=$_REQUEST['probability']?" and probability=".$_REQUEST['probability']:"";
        $where.=$_REQUEST['starttime']?" and estclose>='".$_REQUEST['starttime']."'":"";
        $where.=$_REQUEST['endtime']?" and estclose<='".$_REQUEST['endtime']."'":"";
        $where.=$_REQUEST['khuser']?" and userid=".$_REQUEST['khuser']:"";
        $where.=$_REQUEST['bumen']?" and userid in (select id from AEG_users where bmid=".$_REQUEST['bumen']." )":"";
        if($_REQUEST['show'] == 'showDataTbale') {
            if(!$showD){
                $where=" and userid=".session('uid');
            }else if($showD == 'allleads'){
                if(strpos(getUserCzqx(),"意向部门管理")>-1 || strpos(getUserCzqx(),"意向部门查看")>-1){
                    $where=" and userid in(select id from AEG_users where bmid=".session('bmid')." or bmid in (select id from AEG_bumen where parid=".session('bmid')."))";
                }else{
                    $where=" and userid=".session('uid');
                }
            }
            $biao->getFormatAllToYxd($where);
            exit();
        }
        //操作数据
        if($_REQUEST['act']) {
            switch ($_REQUEST['act']) {
                //删除意向单数据
                case "del":
                    if ($biao->yxDel()) {
                        WriteLog("删除" . $modular . "信息-" . $czid);
                        $this->ajaxreturn(array('code' => 1, 'msg' => 'Successfully Deleted！'));
                    } else {
                        $this->ajaxreturn(array('code' => 2, 'msg' => 'Failed To Delete!'));
                    }
                break;
            }
        }
        $this->display();
    }

    //挂单管理
    public function stop()
    {
        $modular=D('Menu')->GetMenuTitle(CONTROLLER_NAME,ACTION_NAME);
        $this->assign('modular',$modular);
        $biao= D('Orders');
        //获取传参变量
        $czid= $_REQUEST['czid'];
        $this->assign('czid',$czid);
        //输出数据
        if($_REQUEST['show']) {
            switch ($_REQUEST['show']) {
                //输出dataTbale数据
                case "showDataTbaleToGuaDan":
                    $biao->getFormatAllToGuaDan();
                    exit();
                    break;
            }
        }
        //操作数据
        if($_REQUEST['act']) {
            switch ($_REQUEST['act']) {
                //删除数据
                case "del":
                    if ($biao->myDel($czid)) {
                        // WriteLog("删除" . $modular . "信息-" . $czid);
                        $this->ajaxreturn(array('code' => 1, 'msg' => 'Successfully Deleted！'));
                    } else {
                        $this->ajaxreturn(array('code' => 2, 'msg' => 'Failed To Delete!'));
                    }
                    break;
            }
        }
        $this->display();
    }
    public function view(){
        if( isset($_REQUEST['detil']) && $_REQUEST['detil'] == 'leads'){
            $this->assign('modular','leads details');
        } else {
            $this->assign('modular','Order details');
        }
        $ContactRecord_model=D('ContactRecord');
        $cid= $_REQUEST['cid'];
        $biao=D('Orders');
        $user_model=D('Users');
        $customer_model=D('Customer');
        $class_model=D('Class');
        $expo_model=D('Expo');
        $orderstop_model=M('orders_stop');
        $czid=$_REQUEST['czid'];
        $this->assign('czid',$czid);
        $view=$biao->where("id=".$czid)->find();
        $view['username']=$user_model->getUserName($view['userid']);
        $view['cname']=$customer_model->getNameById($view['cid']);
        $view['ename']=$expo_model->getExpoById($view['expoid']);
        $view['custype']=$class_model->getNameById($customer_model->getTypeById($view['cid']));
        $view['boothtype']=$class_model->getNameById($view['boothtype']);
        $view['probability']=$class_model->getNameById($view['probability']);
        $view['actprice']=round($view['actprice'],2);
        if($view['orderstatus']=="有效意向单"){
            $view['zhuangtai']='Leads';
        }else if($view['orderstatus']=="有效订单"){
            $view['zhuangtai']='Order';
        }else if($view['orderstatus']=="已挂单"){
            $view['zhuangtai']='Declined';
        }
        $this->assign('view',$view);
        $res=$orderstop_model->where('oid='.$czid)->find();
        $res['whya']=$class_model->getNameById($res['why']);
        $this->assign('res',$res);
        if($_REQUEST['show']) {
            switch ($_REQUEST['show']) {
                case "showLianxiJiluDataTbale":
                    $map['cid']=$cid;
                    $ContactRecord_model->getFormatAll($map);
                    exit();
                    break;
            }
        }
        $this->display();
    }
    public function zhuangd(){

        $biao=D('Orders');
        $this->assign('oid',$_REQUEST['czid']);

        if($_REQUEST['act']) {
            switch ($_REQUEST['act']) {
                //新增数据
                case "create":
                    if ($biao->myAddGd($_REQUEST)) {
                        // WriteLog("添加" . $modular . "信息");
                        $this->ajaxreturn(array('code' => 1, 'msg' => 'Increase success！'));
                    } else {
                        $this->ajaxreturn(array('code' => 2, 'msg' => 'Increase the failure！'));
                    }
                    break;
            }
        }
        $this->display();
    }
    public function zhuandd()
    {
        $Customer_model=D('Customer');
        $biao = D('Orders');
        $expo_model = D('Expo');
        $czid = $_REQUEST['czid'];
        $this->assign('czid',$czid);
        //输出数据
        $result=$biao->where('id='.$czid)->find();
        $this->assign('cid',$result['cid']);
        $request=$Customer_model->where('id = '.$result['cid'])->find();
        $this->assign('request',$request);
        $result['expo']=$expo_model->getExpoById($result['expoid']);
        $result['actprice']=round($result['actprice'],2);
        $this->assign('result',$result);
        //操作数据
        if($_REQUEST['act']) {
            switch ($_REQUEST['act']) {
                //修改数据
                case "edit":
                    $_REQUEST['orderstatus']='有效订单';
                    $where['orderstatus']='Close-Won';
                    if($_REQUEST['cdcb'] && (!$_REQUEST['actprice'] || $_REQUEST['actprice']==0)){
                        $_REQUEST['actprice']=$_REQUEST['cdcb'];
                    }
                    if ($biao->where("id=".$_REQUEST['czid'])->save($_REQUEST)) {
                        if($Customer_model->where("id=".$_REQUEST['cid'])->save($where)){
                            $this->ajaxreturn(array('code' => 1, 'msg' => 'Successfully modified！','oid' => $_REQUEST['czid']));
                        }
                    } else {
                        $this->ajaxreturn(array('code' => 2, 'msg' => 'fail to edit！'));
                    }
                    break;
            }
        }
        $this->display();
    }
    public function editdd()
    {
        $biao = D('Orders');
        $expo_model = D('Expo');
        $Customer_model=D('Customer');
        $this->assign('czid',$_REQUEST['czid']);
        $res=$biao->where("id=".$_REQUEST['czid'])->find();
        $res['expo']=$expo_model->getExpoById($res['expoid']);
        $res['actprice']=round($res['actprice'],2);
        $this->assign('cid',$res['cid']);
        $request=$Customer_model->where('id = '.$res['cid'])->find();
        $this->assign('request',$request);
        $this->assign('result',$res);
        if($_REQUEST['act']) {
            switch ($_REQUEST['act']) {
                //修改数据
                case "edit":
                    if ($biao->where("id=".$_REQUEST['czid'])->save($_REQUEST)) {
                        // WriteLog("修改" . $modular . "信息");
                        $this->ajaxreturn(array('code' => 1, 'msg' => 'Successfully modified！','oid' => $_REQUEST['czid']));
                    } else {
                        $this->ajaxreturn(array('code' => 2, 'msg' => 'fail to edit！'));
                    }
                    break;
            }
        }
        $this->display();
    }
}

?>