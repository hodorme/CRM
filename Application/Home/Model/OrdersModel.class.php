<?php
namespace Home\Model;
class OrdersModel extends CommonModel
{
    protected $tableName='orders';
    //查询probability字段
    public function getProbability($id){
        $map['id']=$id;
        $result = $this->where($map)->find();
        return $result['probability'];
    }
    //添加意向订单
    public function myAdd($param=array()){
        $stop=M('Orders_stop');
        $customer=D('Customer');
        if($param['cdcb'] && !$param['actprice']){
            $param['actprice']=$param['cdcb'];
        }
        if($param['status']=="open"){
            $param['orderstatus']='有效意向单';
            $map['orderstatus']='Open';
        }else if($param['status']=="close-won"){
            $param['qydate']=$param['posttime'];
            $param['orderstatus']='有效订单';
            $map['orderstatus']='Close-Won';
        }else if($param['status']=="close-lost"){
            $param['orderstatus']='已挂单';
            $map['orderstatus']='Close-Lost';
            $result=$this->add($param);
            if($result){
                $where['oid']=$result;
                $where['posttime']=$param['posttime'];
                $where['userid']=session('uid');
                $where['why']=1861;
                if($customer->where('id='.$param['cid'])->save($map)){
                    $stop->add($where);
                    return $result;
                }
            }
        }
        if($customer->where('id='.$param['cid'])->save($map)){
            return $this->add($param);
        }
    }
//    获取订单展会id
    public function getExpoById($Id)
    {
        $map['id'] =$Id;
        $data =$this->where($map)->find();
        return $data['expoid'];
    }
//    获取订单公司id
    public function getCidById($Id)
    {
        $map['id'] =$Id;
        $data =$this->where($map)->find();
        return $data['cid'];
    }
//    修改意向订单
    public function mySave($param=array()){
        $stop=M('Orders_stop');
        $customer=D('Customer');
        if($param['cdcb'] && (!$param['actprice'] || $param['actprice']==0)){
            $param['actprice']=$param['cdcb'];
        }
        if($param['status']=="open"){
            $param['orderstatus']='有效意向单';
            $map['orderstatus']='Open';
        }else if($param['status']=="close-won"){
            $param['orderstatus']='有效订单';
            $map['orderstatus']='Close-Won';
        }else if($param['status']=="close-lost"){
            $param['orderstatus']='close-lost';
            $map['orderstatus']='Close-Lost';
            if($this->where('id='. $param['czid'])->save($param)) {
                $where['oid'] = $param['czid'];
                $where['posttime'] = $param['uptime'];
                $where['userid'] = session('uid');
                $where['why'] = 1861;
                if($customer->where('id='.$param['cid'])->save($map)){
                    return $stop->add($where);
                }
            }
        }
        if($customer->where('id='.$param['cid'])->save($map)){
            return $this->where('id='. $param['czid'])->save($param);
        }
    }
    //挂单添加
    public function myAddGd(){
        $customer=D('Customer');
        $cid=D('Orders')->field('cid')->where("id=".$_REQUEST['oid'])->find();
        $orderstop=M('Orders_stop');
        $where['orderstatus']='已挂单';
        $map['orderstatus']='Close-Lost';
        $where['uptime']=$_REQUEST['posttime'];
        $where['upuserid']=session('uid');
        if($this->where("id=".$_REQUEST['oid'])->save($where)){
            $_REQUEST['userid']=session('uid');
            if($customer->where('id='.$cid['cid'])->save($map)){
                return $orderstop->add($_REQUEST);
            }
        }else{
            return false;
        }
    }
    //挂单删除
    public function myDel($id){
        $arr = explode(',',$id);
        $stop = D('Orders_stop');
        if(count($arr)>1){
            if($stop->where('oid in ('.$id . ')')->delete()){
                return $this->where('id in ('.$id . ')')->delete();
            }
        } else {
            if($stop->where('oid = '.$id)->delete()){
                return $this->where('id = '.$id)->delete();
            }
        }
    }
    //意向单单删除
    public function yxDel(){
        $arr = explode(',',$_REQUEST['czid']);
        if(count($arr)>1){
            return $this->where('id in ('.$_REQUEST['czid'] . ')')->delete();
        } else {
            return $this->where('id = '.$_REQUEST['czid'])->delete();
        }
    }
    /*订单删除*/
    public function delOrders($id){
        $arr = explode(',',$id);
        if(count($arr)>1){
            return $this->where('id in ('.$id . ')')->delete();
        } else {
            return $this->where('id = '.$id)->delete();
        }
    }
    /*输出重组列表*/
    public function getFormatAll($where){
        $company_model=D('Customer');
        $class_model=D('Class');
        $expo_model=D('Expo');
        $user_model=D('Users');
        $orderstatus = " orderstatus = '有效订单'";
        /*筛选开始*/
        if(strpos(getUserCzqx(),"订单部门管理")>-1 || strpos(getUserCzqx(),"订单部门查看")>-1){
            $qx="  userid in(select id from AEG_users where bmid=".session('bmid')." or bmid in (select id from AEG_bumen where parid=".session('bmid')."))";
        }else{
            $qx="  userid=".session('uid');
        }
        //公司模糊查询
        $search_company = $_REQUEST['ctitle'];
        $search = $_REQUEST['ctitle'] ? " and cid in (select id from AEG_company where title like '%$search_company%')" : '';
        //展会模糊查询
        $search_expo = $_REQUEST['etitle'];
        $search .= $_REQUEST['etitle'] ? " and expoid in (select id from AEG_expo where title like '%$search_expo%')" : '';
        //国家筛选
        $search .=$_REQUEST['expocon']?" and cid in (select id from AEG_company where s2 in(select id from AEG_class where classname like '%".$_REQUEST['expocon']."%'))" : '';
        //客户经理
        $search .= $_REQUEST['customer'] ? " and userid=".$_REQUEST['customer']:"";
        //部门筛选
        $search .= $_REQUEST['bumen'] ? " and userid in (select id from AEG_users where bmid=".$_REQUEST['bumen']." )":"";
        //展位类型
        $search .= $_REQUEST['expocat'] ? " and boothtype=".$_REQUEST['expocat']:"";
        //年份筛选
        $search .=$_REQUEST['starttime']?" and qydate>='".$_REQUEST['starttime']."'":"";
        $search .=$_REQUEST['end']?" and qydate<='".$_REQUEST['end']."'":"";
        /*筛选结束*/
        $draw = $_GET['draw'];//这个值作者会直接返回给前台
        $order_dir = $_GET['order']['0']['dir'];//ase desc 升序或者降序
        $start = $_GET['start'];//从多少开始
        $length = $_GET['length'];//数据长度
        $order_column = $_GET['order']['0']['column'];//那一列排序，从0开始
        $p=$start/10+1;
        if (isset($order_column)) {
            $i = intval($order_column);
            switch ($i) {
                case 4;$orderSql = " posttime " . $order_dir;break;
                case 5;$orderSql = " price " . $order_dir;break;
                case 6;$orderSql = " acreage " . $order_dir;break;
                case 8;$orderSql = " qydate " . $order_dir;break;
                default;$orderSql = '';
            }
        }
        /*统计*/
        $sum1 = $this->where( $qx ." and ". $orderstatus . $where . $search )->count('distinct cid');
        $sum2 = $this->where( $qx ." and ".$orderstatus . $where . $search )->sum('acreage');
        $sum2 = is_null($sum2) ? '0' : round($sum2,2);
        $sum5 = $this->where( $qx ." and ".$orderstatus . $where . $search )->sum('actprice');
        $sum5 = is_null($sum5) ? '0' : round($sum5,2);
        /*统计结束*/
        $recordsTotal = $this->where($qx ." and ".$orderstatus . $where . $search)->count('id');
        $recordsFiltered = $this->where($qx ." and ".$orderstatus . $where . $search)->count('id');
        $list = $this->where($qx ." and ".$orderstatus . $where . $search)->page($p.','.$length)->order($orderSql)->select();
        $infos=array();
        foreach ($list as $key => $value)
        {
            $del='';
            $edit='';
            if(strpos(getUserCzqx(),"订单删除")>-1){
                $del="<li><a href='javascript:;' class='deldd' czid='".$value['id']."'>Delete</a></li>";
            }
            if(strpos(getUserCzqx(),"订单编辑")>-1){
                $edit="<li><a href='javascript:;' class='editdd' czid='".$value['id']."'>Edit</a></li>";
            }
            $select="";
            $cid=$company_model->getNameById($value['cid']);
            $oid=$value['id'];
            if(strpos(getUserCzqx(),"订单部门管理")>-1 || $value['userid']==session('uid')){
                $cid='<a href="/CRM/index.php/Home/Customer/view?czid='.$value['cid'].'" target="_blank">'.$company_model->getNameById($value['cid']).'</a>';
                $oid='<a href="/CRM/index.php/Home/Orders/view?czid='.$value['id'].'" target="_blank">'.$value['id'].'</a>';
                $select="<div class='form-inline pull-center'>
            <div class='btn-group'>
                <button type='button' class='btn btn-primary dropdown-toggle btn-xs' data-toggle='dropdown'>Operation <span class='caret'></span></button>
                <ul class='dropdown-menu' role='menu'>$del $edit
                </ul>
            </div>
            </div>";
            }
            $obj=array(
                $key+1,
                "<input type=checkbox name=id[] value=".$value['id'].">",
                $cid,
                '<a href="/CRM/index.php/Home/Expo/view?czid='.$value['expoid'].'" target="_blank">'.$expo_model->getExpoById($value['expoid']).'</a>',
                $class_model->getNameById($company_model->getCountryById($value['cid'])),
                "$".round($value['actprice'],2),
                $value['acreage']."㎡",
                $class_model->getNameById($value['boothtype']),
                $value['qydate'],
                $user_model->getUserName($value['userid']),
                $select,
                $oid
            );
            array_push($infos, $obj);
        }
        $allTotal[1]=$sum1;
        $allTotal[2]=$sum2;
        $allTotal[5]=$sum5;
        echo json_encode(array(
            "draw" => intval($draw),
            "allTotal" => $allTotal,
            "recordsTotal" => intval($recordsTotal),
            "recordsFiltered" => intval($recordsFiltered),
            "data" => $infos
        ), JSON_UNESCAPED_UNICODE);
    }

    /*输出重组列表->意向单*/
    public function getFormatAllToYxd($where){
        $map = "orderstatus='有效意向单'".$where;
        $draw = $_GET['draw'];//这个值作者会直接返回给前台
        $start = $_GET['start'];//从多少开始
        $length = $_GET['length'];//数据长度
        $p=$start/10+1;
        $order_column = $_GET['order']['0']['column'];//那一列排序，从0开始
        $order_dir = $_GET['order']['0']['dir'];//ase desc 升序或者降序
        if (isset($order_column)) {
            $i = intval($order_column);
            switch ($i) {
                case 4;$orderSql = " posttime " . $order_dir;break;
                case 5;$orderSql = " probability " . $order_dir;break;
                case 6;$orderSql = " estclose " . $order_dir;break;
                case 7;$orderSql = " acreage " . $order_dir;break;
                default;$orderSql = '';
            }
        }
        $recordsTotal= $this->where($map)->count('id');
        $recordsFiltered=$this->where($map)->count('id');
        $list=$this->where($map)->page($p.','.$length)->order($orderSql)->select();
        $sum=$this->where($map)->sum('acreage');
        $sum = is_null($sum) ? '0' : $sum;
        $tb_data =array();
        $company_model=D('Customer');
        $class_model=D('Class');
        $expo_model=D('Expo');
        $user_model=D('Users');
        foreach ($list as $key => $value)
        {
            if($value['orderstatus']=='有效意向单'){
                $status='open';
            }else if($value['orderstatus']=='有效订单'){
                $status='close-won';
            }else if($value['orderstatus']=='已挂单'){
                $status='close-lost';
            }
            $cid=$company_model->getNameById($value['cid']);
            $oid=$value['id'];
            $select="";
            if(strpos(getUserCzqx(),"意向部门管理")>-1 || $value['userid']==session('uid')){
                $cid='<a href="/CRM/index.php/Home/Customer/view?czid='.$value['cid'].'" target="_blank">'.$company_model->getNameById($value['cid']).'</a>';
                $oid='<a class="view" href="/CRM/index.php/Home/Orders/view?detil=leads&czid='.$value['id'].'" target="_blank">'.$value['id'].'</a>';
                $select="<div class='form-inline pull-center'>
            <div class='btn-group'>
                <button type='button' class='btn btn-primary dropdown-toggle btn-xs' data-toggle='dropdown'>Operation <span class='caret'></span></button>
                <ul class='dropdown-menu' role='menu'>
                    <li><a href='javascript:;' class='edityxd' cid='".$value['cid']."' czid='".$value['id']."'>Edit</a></li>
                    <li><a href='javascript:;' class='zdd' czid='".$value['id']."'>Turn to order</a></li>
                    <li><a href='javascript:;' class='zgd' czid='".$value['id']."'>Move to lost</a></li>
                    <li><a href='javascript:;' id='tjlxr' czid='".$value['cid']."'>Add contact record</a></li>
                </ul>
            </div>
            </div>";
            }
            $tb_row=array(
                $key+1,
                "<input type=checkbox name=yxid[] value=".$value['id'].">",
                $cid,
                $class_model->getNameById($company_model->getCountryById($value['cid'])),
                '<a href="/CRM/index.php/Home/Expo/view?czid='.$value['expoid'].'" target="_blank">'.$expo_model->getExpoById($value['expoid']).'</a>',
                $class_model->getNameById($value['probability']),
                $value['estclose'],
                $value['acreage']."㎡",
                $company_model->getLastById($value['cid'])?date('Y-m-d H:i:s',strtotime($company_model->getLastById($value['cid']))):'',
                $user_model->getUserName($value['userid']),
                $status,
                $select,
                $oid
            );
            array_push($tb_data, $tb_row);
        }
        echo json_encode(array(
            "draw" => intval($draw),
            "sum" => $sum,
            "recordsTotal" => intval($recordsTotal),
            "recordsFiltered" => intval($recordsFiltered),
            "data" => $tb_data
        ),JSON_UNESCAPED_UNICODE);
    }
    //获取挂单列表
    public function getFormatAllToGuaDan($map)
    {
        if(strpos(getUserCzqx(),"挂单部门管理")>-1 || strpos(getUserCzqx(),"挂单部门查看")>-1){
            $qx="  userid in(select id from AEG_users where bmid=".session('bmid')." or bmid in (select id from AEG_bumen where parid=".session('bmid')."))";
        }else{
            $qx="  userid=".session('uid');
        }
        $user_model=D('Users');
        $orderstatus = " orderstatus = '已挂单'";
        $expo_model=D('Expo');
        $company_model=D('Customer');
        $class_model=D('Class');
        $where='';
        if($map['cid']){
            $where=" and cid=".$map['cid'];
        }else if($map['expo']=='expo'){
            $where="  and expoid=".$map['expoid'];
        }
        $draw = $_GET['draw'];//这个值作者会直接返回给前台
        $order_dir = $_GET['order']['0']['dir'];//ase desc 升序或者降序
        $start = $_GET['start'];//从多少开始
        $length = $_GET['length'];//数据长度
        $order_column = $_GET['order']['0']['column'];//那一列排序，从0开始
        $p=$start/10+1;
        if (isset($order_column)) {
            $i = intval($order_column);
            switch ($i) {
                case 5;$orderSql = " posttime " . $order_dir;break;
                case 6;$orderSql = " posttime " . $order_dir;break;
                default;$orderSql = '';
            }
        }
        /*筛选开始*/
        //公司模糊查询
        $search_company = $_REQUEST['ctitle'];
        $search = $_REQUEST['ctitle'] ? " and cid in (select id from AEG_company where title like '%$search_company%')" : '';
        //展会模糊查询
        $search_expo = $_REQUEST['etitle'];
        $search .= $_REQUEST['etitle'] ? " and expoid in (select id from AEG_expo where title like '%$search_expo%')" : '';
        //客户经理
        $search .= $_REQUEST['customer'] ? " and userid=".$_REQUEST['customer']:"";
        //挂单原因筛选
        $search .= $_REQUEST['reson'] ? " and id in (select oid from AEG_orders_stop where why=".$_REQUEST['reson'].")":"";
        //年份筛选
        $search .= $_REQUEST['starttime']?" and id in (select oid from AEG_orders_stop where posttime>= '".$_REQUEST['starttime']."')" :"";
        $search .= $_REQUEST['end']?" and id in (select oid from AEG_orders_stop where posttime<= '".$_REQUEST['end']." 23:59:59')" :"";
        /*筛选结束*/
        /*统计*/
        $sum1 = $this->where( $qx." and ".$orderstatus . $where . $search )->sum('acreage');
        $sum1 = is_null($sum1) ? '0' : $sum1;
        /*统计结束*/
        $recordsTotal = $this->where($qx." and ".$orderstatus)->count('id');
        $recordsFiltered = $this->where($qx." and ".$orderstatus)->count('id');
        $list = $this->where($qx." and ".$orderstatus . $where . $search )->page($p.','.$length)->order($orderSql)->select();
        $infos=array();
        foreach ($list as $key => $value)
        {
            $del='';
            if(strpos(getUserCzqx(),"挂单删除")>-1){
                $del="<li><a href='javascript:;' class='delgd' czid='".$value['id']."'>Delete</a></li>";
            }
            $select="";
            $cid=$company_model->getNameById($value['cid']);
            $oid=$value['id'];
            if(strpos(getUserCzqx(),"挂单部门管理")>-1 || $value['userid']==session('uid')){
                $cid='<a href="/CRM/index.php/Home/Customer/view?czid='.$value['cid'].'" target="_blank">'.$company_model->getNameById($value['cid']).'</a>';
                $oid='<a href="/CRM/index.php/Home/Orders/view?czid='.$value['id'].'" target="_blank">'.$value['id'].'</a>';
                $select="<div class='form-inline pull-center'>
            <div class='btn-group'>
                <button type='button' class='btn btn-primary dropdown-toggle btn-xs' data-toggle='dropdown'>Operation<span class='caret'></span></button>
                <ul class='dropdown-menu' role='menu'>
                    $del
                </ul>
            </div>
            </div>";
            }
            $stop=M('orders_stop')->where("oid =".$value['id'])->find();
            $obj=array(
                $key+1,
                "<input type=checkbox name=id[] value=".$value['id'].">",
                '<a href="/CRM/index.php/Home/Expo/view?czid='.$value['expoid'].'" target="_blank">'.$expo_model->getExpoById($value['expoid']).'</a>',
                $cid,
                $class_model->getNameById($stop['why']),
                $stop['memo'],
                $stop['posttime']?date('Y-m-d',strtotime($stop['posttime'])):"",
                $user_model->getUserName($value['userid']),
                $select,
                $oid
            );
            array_push($infos, $obj);
        }
        $allTotal[1]=$sum1;
        echo json_encode(array(
            "draw" => intval($draw),
            "allTotal" => $allTotal,
            "recordsTotal" => intval($recordsTotal),
            "recordsFiltered" => intval($recordsFiltered),
            "data" => $infos
        ), JSON_UNESCAPED_UNICODE);
    }
}