<?php
namespace Home\Controller;
use Think\Controller;
use User\Api\UserApi;
class IndexController extends Controller {
    public function baike()
    {
        $modular = '嘉智百科';
        $this->assign('modular', $modular);
        $this->display();
    }
    public function index(){
        //exit(session('uid'));
        if(!session('uid')){
            header('Location:/CRM/index.php/Home/Index/login');
            exit;
        }
		$this->assign('active0'," class='active'");
		$this->assign('buju','单栏');
		$this->assign('lanmu','AEG_CRM 1.0');
		$this->assign('modular',"AEG_CRM 1.0");
		$UsersModel=D('Users');
		$list=$UsersModel->where('id='.session('uid'))->find();
		$this->assign('mingzi',$list['username']);
        if(session('uid')){
            $biao= D('Users');
            $Class_model= D('Class');
            $BumenModel=D('Bumen');
            $ZhiweiModel=D('Zhiwei');
            $my=$biao->where('id='.session('uid'))->find();
            $my['bmidname']=$BumenModel->getName($my['bmid']);
            $my['zwidname']=$ZhiweiModel->getName($my['zwid']);
            $my['face']=($my['filename1'])?"http://101.68.69.28:8013".$my['filename1']:"/Img/none.jpg";
            $this->assign('my',$my);
            //统计数据
            //新增客户
            //输出数据
            if ($_REQUEST['show']) {
                switch ($_REQUEST['show']) {
                    //输出国家到select
                    case "searchCountry":
                        if($_REQUEST['s1']){
                            $s1=$_REQUEST['s1'];
                            $result=$Class_model->getAll("parid=".$s1);
                            $this->ajaxReturn($result, 'json');
                        }
                        break;
                    //输出城市到select
                    case "searchCity":
                        if($_REQUEST['s2']){
                            $s2=$_REQUEST['s2'];
                            $result=$Class_model->getAll("parid=".$s2);
                            $this->ajaxReturn($result, 'json');
                        }
                        break;
                    //输出员工信息
                    case "searchUsers":
                        $Users_model=D('Users');
                        $result=$Users_model->getAll();
                        $this->ajaxReturn($result, 'json');
                        break;
                }
            }
        }
        $this->display();
    }
    public function desk(){
        $this->assign('active0'," class='active'");
        $this->assign('buju','单栏');
        $this->assign('lanmu','首页');
        $this->assign('modular',"首页");
        $this->display();
    }
    //登录验证
    public function login(){
        if($_REQUEST['uno'] && $_REQUEST['password']){
            $uno=$_REQUEST['uno'];
            //$pwd=md5(I('post.password'));
            $pwd=$_REQUEST['password'];
            $Users=D('Users');
			$BumenModel=D('Bumen');
			$ZhiweiModel=D('Zhiwei');
            $list=$Users->getUserInfo($uno,$pwd);
            if($list['id']){//登录成功
                session('uno',$list['usercode']);
                session('uid',$list['id']);
                $parid=$BumenModel->getParid($list['bmid']);
                //session('mingzi',$list['username']);
                session('bmid',$list['bmid']);
                session('parid',$parid);
                session('bmid1',$list['bmid1']);
                session('bmid2',$list['bmid2']);
				session('zwid',$list['zwid']);
                //$omodel=D('Organization');
                //$orgname=$omodel->getName($list['orgid']);
                //session('orgname',$orgname);
                //session('data_scope',$list['data_scope']);
                header('Location:/CRM/index.php/Home/');
            }else {
                echo "<script>alert('帐号或者密码错误！');</script>";
                $this->display();
            }
        } else {
            //显示登录表单
            $this->display();
        }
    }
    /* 退出登录 */
    public function logout(){
        session('uno',null);
        session('uid',null);
        session('mingzi',null);
        session('[destroy]');
        header('Location:/CRM/index.php/Home/Index/login');
    }
    public function welcome(){
        $modular='欢迎页';
        $Customer_model = D('Customer');
        $utj="userid=".session('uid')."";
        $tj1=$Customer_model->where($utj." and classid<>1665 and DATEDIFF(day,lasttime,GETDATE())=0")->count();//今日已经联系客户
        $tj2=$Customer_model->where($utj." and classid<>1665 and DATEDIFF(day,nexttime,GETDATE())=0")->count();//今日需联系客户
        $tj3=$Customer_model->where($utj." and classid<>1665 and DATEDIFF(month,posttime,GETDATE())=0")->count();//本月新增客户数
        $tj4=$Customer_model->where($utj." and classid<>1665 and DATEDIFF(day,nexttime,GETDATE())>0")->count();//未按时联系客户
        $tj5=$Customer_model->where($utj." and DATEDIFF(day,lasttime,GETDATE())>15 and classid<>1665")->count();//超15天未联系客户
        $kehu=array('tj1' => $tj1, 'tj2' => $tj1+$tj2,'tj3' => $tj3, 'tj4' => $tj4,'tj5' => $tj5);
        $this->assign('kehu',$kehu);
        $this->assign('modular',$modular);
        if($_REQUEST['show']){
            switch ($_REQUEST['show']){
                case "gsTop";
                    $what=$_REQUEST['what'];
                    if($what=="month"){
                        $where="DateDiff(mm, qydate, GetDate()) = 0";
                    }
                    if($what=="premonth"){
                        $where="DateDiff(mm, qydate, GetDate()) = 1";
                    }
                    if($what=="year"){
                        $where="year(qydate)=2017";
                    }
                    if($what=="preyear"){
                        $where="year(qydate)=2016";
                    }
                    $sql="select top 10 ISNULL(sum(acreage),0) as aa,userid from AEG_orders
          where  $where and orderstatus='有效订单' and userid in(Select id from AEG_users where bmid in(52,53) )
          group by userid order by aa desc";
                    $rlt=D('Orders')->query($sql);
                    //dump($rlt);die;
//                    $rlt=D('Users')->where("bmid in (52,53)")->select();
                    $Users_model=D('Users');
                    for($i=0;$i<count($rlt);$i++)
                    {
//                        $res=D('Orders')->query(" select sum(acreage) as aa from AEG_orders where  $where and orderstatus='有效订单' and userid=".$rlt[$i]['id']);
                        $rlt[$i]['username']=$Users_model->getUserName($rlt[$i]['userid']);
                        $total[] = $rlt[$i]['aa'];
                    }
                    $alltotal = array_sum($total);
                    $alltotal = is_null($alltotal) ? '0' : $alltotal;
                    $result['categories']=array_column($rlt, 'username');
                    $result['data']=array_column($rlt, 'aa');
                    $result['alltotal'] = $alltotal;
                    $this->ajaxReturn($result, 'json');
                 break;
                case "leadTop":
                    $what=$_REQUEST['what'];
                    if($what=="month"){
                        $where="DateDiff(mm, posttime, GetDate()) = 0";
                    }
                    if($what=="premonth"){
                        $where="DateDiff(mm, posttime, GetDate()) = 1";
                    }
                    if($what=="year"){
                        $where="year(posttime)=2017";
                    }
                    if($what=="preyear"){
                        $where="year(posttime)=2016";
                    }
                    $sql="select top 10 ISNULL(sum(acreage),0) as aa,userid from AEG_orders
          where  $where and orderstatus='有效意向单' and userid in(Select id from AEG_users where bmid in(52,53) )
          group by userid order by aa desc";
                    $rlt=D('Orders')->query($sql);
                    //dump($rlt);die;
//                    $rlt=D('Users')->where("bmid in (52,53)")->select();
                    $Users_model=D('Users');
                    for($i=0;$i<count($rlt);$i++)
                    {
//                        $res=D('Orders')->query(" select sum(acreage) as aa from AEG_orders where  $where and orderstatus='有效订单' and userid=".$rlt[$i]['id']);
                        $rlt[$i]['username']=$Users_model->getUserName($rlt[$i]['userid']);
                        $total[] = $rlt[$i]['aa'];
                    }
                    $alltotal = array_sum($total);
                    $alltotal = is_null($alltotal) ? '0' : $alltotal;
                    $result['categories']=array_column($rlt, 'username');
                    $result['data']=array_column($rlt, 'aa');
                    $result['alltotal'] = $alltotal;
                    $this->ajaxReturn($result, 'json');
                    break;
                case "showCustomerDataTbale";
                        $where['progress'] = 5;
                        $sumSqlWhere = "";
                        $Customer_model->getFormatAll($where,$sumSqlWhere);
                        exit();
                    break;
            }

        }
        $this->display();
    }
    //全库搜索
    public function qksearch(){
        $biao = D('Customer');
        $member = D('Member');
        $title = trim($_REQUEST['searchtext']);
        $list = $biao->where("title like '%".$title."%' or website like '%".$title."%'")->select();
        if(!$list){
            $email=$_REQUEST['searchtext'];
            $map = " and email like '%".$email."%'";
            $list = $member->where('1=1'.$map)->select();
        }
        if ($list) {
            $sltitle=mb_substr($title, 0, 4, 'utf-8');
            $this->ajaxreturn(array('code' => 1,'title' => 'Key word【'.$sltitle.'…】Customer already exists!-->>>','searchact'=>'Check','searchid'=>'searchasee'));
        } else {
            $this->ajaxreturn(array('code' => 2,'title' => 'NOT Exist!-->>>','searchact'=>'Add','searchid'=>'searchadd'));
        }
    }
}



