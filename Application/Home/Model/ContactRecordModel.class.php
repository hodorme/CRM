<?php
namespace Home\Model;
class ContactRecordModel extends CommonModel {
    protected $tableName='company_note';
    public function getNextTime($cid){
        $bmid=$_SESSION['bmid'];
//        $data =$this->where($map)->order('id desc')->find();
        $model=M();
        $data=$model->table('AEG_company_note a,AEG_users b,AEG_bumen c')->field('a.nexttime')->where('a.cid='.$cid.' and a.userid=b.id and b.bmid='.$bmid)->order('nexttime desc')->find();
        return $data['nexttime'];
    }
    public function getLastTime($cid){
        $bmid=$_SESSION['bmid'];
        $map['cid'] =$cid;
        $model=M();
        $data=$model->table('AEG_company_note a,AEG_users b,AEG_bumen c')->field('a.posttime')->where('a.cid='.$cid.' and a.userid=b.id and b.bmid='.$bmid)->order('posttime desc')->find();
        return $data['posttime'];
    }
    public function getUserName($userId)
    {
        $map['id'] =$userId;
        $data =$this->where($map)->find();
        return $data['username'];
    }
    public function getUserInfo($uno,$pwd)
    {
        $map['usercode']=$uno;
        $map['password']=$pwd;
        $data =$this->where($map)->find();
        return $data;
    }
    public function getAll($map)
    {
        $Users_model=D('Users');
        $Member_model=D('Member');
        $data =$this->where($map)->select();
        foreach ($data as $k => $val) {
            $data[$k]['contact']=$Member_model->getFullName($data[$k]['contact']);
            $data[$k]['userid']=$Users_model->getUserName($data[$k]['userid']);
        }
        return $data;
    }
    //添加联系记录
    public function myAdd($param=array()){
        $Customer_model=D('Customer');
        $Orders_model=D('Orders');
        $Member_model=D('Member');
        $probability = $Orders_model->getProbability($param['oid']);
        if($probability != $param['probability']){
            $omap['probability']=$param['probability'];
            $omap['uptime']=$param['posttime'];
            $omap['upuserid']=session('uid');
            $Orders_model->where('id = '.$param['oid'])->save($omap);
        }
        $lxmap['cid']=$param['cid'];
        $lxmap['nexttime']=$param['nexttime'];
        $lxmap['contacting']=$param['contacting'];
        $lxmap['note']=$param['note'];
        $lxmap['contact']=$param['contact'];
        $lxmap['posttime']=$param['posttime'];
        $lxmap['userid']=session('uid');
        $mmap['id'] = $param['contact'];
        $mmap['updatedtime'] = $param['posttime'];
        $this->startTrans();
        if($this->add($lxmap)){
            $cmap['nexttime']=$param['nexttime'];
            $cmap['lasttime']=$param['posttime'];
            if(!$Customer_model->where('id = '.$param['cid'])->save($cmap)){
                $this->rollback();
                return 0;
            }
            if($Member_model->where('id = '.$param['contact'])->save($mmap)){

            }
        }else{
            $this->rollback();
            return 0;
        }
        $this->commit();
        return 1;
    }
    //删除操作
    public function myDel($id){
        return $this->delete($id);
    }
    /*输出处理后的列表*/
    public function getFormatAll($map){
        $bmid=session('bmid');
        $where='1=1';
        if($map['cid']){
            $cid=$map['cid'];
            $where.=" and a.cid=$cid";
        }
        $draw = $_GET['draw'];//这个值作者会直接返回给前台
        //排序
        $order_column = $_GET['order']['0']['column'];//那一列排序，从0开始
        $order_dir = $_GET['order']['0']['dir'];//ase desc 升序或者降序
        //拼接排序sql
        $orderSql = "";
        if(isset($order_column)){
            $i = intval($order_column);
            switch($i){
                case 0;$orderSql = " order by a.id ".$order_dir;break;
                case 1;$orderSql = " order by a.nexttime ".$order_dir;break;
                case 2;$orderSql = " order by a.note ".$order_dir;break;
                case 3;$orderSql = " order by a.contact ".$order_dir;break;
                case 4;$orderSql = " order by a.posttime ".$order_dir;break;
                case 5;$orderSql = " order by a.userid ".$order_dir;break;
                case 6;$orderSql = " order by a.id ".$order_dir;break;
                default;$orderSql = '';
            }
        }
//        $search = $_GET['search']['value'];//获取前台传过来的过滤条件
        $search_1 = $_GET['columns']['1']['search']['value'];
        $search_2 = $_GET['columns']['2']['search']['value'];
        //分页
        $start = $_GET['start'];//从多少开始
        $length = $_GET['length'];//数据长度
        $limitSql = '';
        $limitFlag = isset($_GET['start']) && $length != -1 ;
        if ($limitFlag ) {
            //$limitSql = " LIMIT ".intval($start).", ".intval($length);    //mysql语法
            $limitSql = " top ".intval($length);
        }
        //定义查询数据总记录数sql
        $recordsTotal= $this->where($map)->count();
        //条件过滤后记录数 必要
        $recordsFiltered = 0;
        //定义过滤条件查询过滤后的记录数sql
        $sumSqlWhere="";
        //if($search_1!=0){
        //    $sumSqlWhere .=" and a.userid = $search_1";
        //}
        //if($search_2 == null){
        //    $sumSqlWhere.=" and a.userid in(select id from AEG_users where bmid=$bmid or bmid in(select id from AEG_bumen where parid=$bmid))";
        //}else if($search_2 == 0){
        //    $sumSqlWhere.="";
        //}else{
        //    $sumSqlWhere .=" and a.userid in(select id from AEG_users where bmid=$search_2 or bmid in(select id from AEG_bumen where parid=$search_2))";
        //}
        $recordssql="select count(*)  from  AEG_company_note a where $where $sumSqlWhere";
        $recordsFiltered=$this->query($recordssql);
        $sql="select top ".intval($length)." a.* from AEG_company_note a WHERE $where $sumSqlWhere and a.id not in (
        select top ".intval($start)." id from AEG_company_note a where $where $sumSqlWhere $orderSql) $orderSql";
        //直接查询所有记录
        $list = $this->query($sql);
        $Users_model=D('Users');
        $Member_model=D('Member');
        $Class_model=D('Class');
        $tb_data =array();
        $tb_row =array();
        foreach ($list as $key => $value) {
            $note=$value['note'];
            $tb_row=array(
                '',
                date('Y-m-d',strtotime($value['nexttime'])),
                $note,
                $Class_model->getNameById($value['contacting']),
                $Member_model->getPosition($value['contact']),
                $Member_model->getFullName($value['contact']),
                date('Y-m-d H:i:s',strtotime($value['posttime'])),
                $Users_model->getUserName($value['userid']),
                $value['id']
            );
            array_push($tb_data, $tb_row);
        }
        echo json_encode(array(
            "draw" => intval($draw),
            "recordsTotal" => intval($recordsTotal),
            "recordsFiltered" => intval($recordsFiltered[0]['']),
            "data" => $tb_data
        ),JSON_UNESCAPED_UNICODE);
    }
}


