<?php
namespace Home\Model;
class CustomerModel extends CommonModel {
    protected $tableName='company';
    //获取企业名by jn 2016-10-10
    public function getNameById($Id)
    {
        $map['id'] =$Id;
        $data =$this->where($map)->find();
        return $data['title'];
    }
//    获取最后一次联系时间
    public function getLastById($Id)
    {
        $map['id'] =$Id;
        $data =$this->where($map)->find();
        return $data['lasttime'];
    }
//    获取客户类型
    public function getTypeById($Id)
    {
        $map['id'] =$Id;
        $data =$this->where($map)->find();
        return $data['classid'];
    }
    public function getCountryById($Id)
    {
        $map['id'] =$Id;
        $data =$this->where($map)->find();
        return $data['s2'];
    }
    public function getAll($map)
    {
        $data =$this->where($map)->select();
        return $data;
    }
    //新增操作
    public function myAdd($param=array()){
        $param['userid']=session('uid');
        $param['classid'] = 1860;
        return $this->add($param);
    }
    //修改操作
    public function mySave($param=array()){
        $param['upuserid']=session('uid');
        return $this->where('id = '.(int)$param['czid'])->save($param);
    }
    //共享修改操作
    public function gxSave($param=array()){
        $param['classid']=1859;
        $param['updatedtime']=date("Y-m-d H:i:s");
        $param['upuserid']=session('uid');
        return $this->where('id = '.$param['czid'])->save($param);
    }
    //删除操作
    public function myDel($id){
        // var_dump($id);die;
        return $this->where('id = '.$id)->delete();
         return $this->delete($id);
    }
    /*输出重组列表*/
    public function getFormatAll($map,$sumSqlWhere){
        $bmid=session('bmid');
        $bmid1=session('bmid1');
        $bmid2=session('bmid2');
        $uid=session('uid');
        $Class_model=D('Class');
        $Users_model=D('Users');
        $Orders_model=D('Orders');
        $where = '1=1';
        if(strpos(getUserCzqx(),"客户部门管理")>-1 or strpos(getUserCzqx(),"客户部门查看")>-1){
            $qx="and (userid in(select id from AEG_users where bmid=$bmid or bmid in(select id from AEG_bumen where parid=$bmid)))";
        }else{
            $qx=" and userid=$uid";
        }
        if($map['progress'] == 1){
            $where .= " and userid=$uid and classid=1860";
        }else if($map['progress'] == 2){
            $where .=" and classid=1860".$qx;
        }else if($map['progress'] == 4){
            $where .=" and classid = 1859 and (userid in(select id from AEG_users where bmid=$bmid or bmid in(select id from AEG_bumen where parid=$bmid)))";
        }else if($map['progress'] == 5){
            $where .= " and classid=1860 and nexttime=CONVERT(varchar(100), GETDATE(), 23)".$qx;
        }else if($map['progress'] == 6){
            $where .= " and userid=$uid and classid=1860 and DATEDIFF(day,nexttime,GETDATE())>0";
        }else if($map['progress'] == 7){
            $where .= " and userid=$uid and classid=1860 and emailtime=CONVERT(varchar(100), GETDATE(), 23)";
        }else if($map['progress'] == 8){
            $where .= " and userid=$uid and classid=1860 and DATEDIFF(day,lasttime,GETDATE())>15";
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
                case 0;$orderSql = " id ".$order_dir;break;
                case 1;$orderSql = " id ".$order_dir;break;
                case 2;$orderSql = " title ".$order_dir;break;
                case 3;$orderSql = " type ".$order_dir;break;
                case 4;$orderSql = " orderstatus ".$order_dir;break;
                case 5;$orderSql = " s2 ".$order_dir;break;
                case 6;$orderSql = " id ".$order_dir;break;
                case 7;$orderSql = " id ".$order_dir;break;
                case 8;$orderSql = " id ".$order_dir;break;
                case 9;$orderSql = " website ".$order_dir;break;
                case 10;$orderSql = " userid ".$order_dir;break;
                case 11;$orderSql = " id ".$order_dir;break;
                case 12;$orderSql = " id ".$order_dir;break;
                case 13;$orderSql = " id ".$order_dir;break;
                case 14;$orderSql = " id ".$order_dir;break;
                default;$orderSql = '';
            }
        }
//        $search = $_GET['search']['value'];//获取前台传过来的过滤条件
        //分页
        $start = $_GET['start'];//从多少开始
        $length = $_GET['length'];//数据长度
        $limitSql = '';
        $limitFlag = isset($_GET['start']) && $length != -1 ;
        if ($limitFlag ) {
            //$limitSql = " LIMIT ".intval($start).", ".intval($length);    //mysql语法
            $limitSql = " top ".intval($length);
        }
        $p=$start/100+1;
        $recordsTotal = $this->table('AEG_company')->where($where)->count('id');
        $recordsFiltered = $this->table('AEG_company')->where($where.$sumSqlWhere)->count('id');
        $list = $this->table('AEG_company')->where($where.$sumSqlWhere)->order($orderSql)->page($p.','.$length)->select();
        $tb_data = array();
        $tb_row = array();
        foreach ($list as $key => $value)
        {
            $posttime = date('Y-m-d',strtotime($value['posttime']));
            if(strpos(getUserCzqx(),"客户部门管理")>-1 or $value['userid'] == $uid or $value['classid'] ==1859){
                $title = '<a href='.U('Home/Customer/view').'?czid='.$value['id'].' target="_blank">'.$value['title'].'</a>';
            }else{
                $title = $value['title'];
            }
            $lasttime = '';
            if($value['lasttime']){
                $lasttime=date('Y-m-d H:i',strtotime($value['lasttime']));
            }
            $nexttime = '';
            if($value['nexttime']){
                $nexttime = date('Y-m-d',strtotime($value['nexttime']));
            }
            $info = $this->table('AEG_member')->field('prefix,fullname,middlename,familyname,telarea,tel,fenji,email')->where('cid = '.$value['id'].' and setdefault = 1')->find();
            $fullname = '';
            $middlename = '';
            $familyname = '';
            $mobile = '';
            $email = '';
            $prefix = '';
            if($info){
                $fullname = $info['fullname'];
                $middlename = $info['middlename'];
                $familyname = $info['familyname'];
                $mobile = $info['telarea'].'-'.$info['tel'].'-'.$info['fenji'];
                $email = '<a href="mailto:'.$info['email'].'">'.$info['email'].'</a>';
                $prefix =$Class_model->getNameById($info['prefix']);
            }
            if($value['classid'] == 1859){
                $select="<div class='form-inline pull-right'>
                <div class='btn-group'>
                    <button type='button' class='btn btn-primary dropdown-toggle btn-xs' data-toggle='dropdown'>Operation<span class='caret'style='margin-left:5px;'></span></button>
                    <ul class='dropdown-menu' role='menu'>
                        <li><a href='javascript:;' class='editFun' czid='".$value['id']."'>Edit</a></li>
                        <li><a href='javascript:;' class='tjlxjl' czid='".$value['id']."'>Add a Contact</a></li>
                        <li><a href='javascript:;' class='tjlxr' czid='".$value['id']."'>Add contact record</a></li>
                        <li><a href='javascript:;' class='zrziji' czid='".$value['id']."'>Move to my account</a></li>
                    </ul>
                </div>
                </div>";
            }else if($value['classid'] == 1860 and (strpos(getUserCzqx(),"客户部门管理")>-1 or $value['userid'] == $uid)){
                $select="<div class='form-inline pull-right'>
                <div class='btn-group'>
                    <button type='button' class='btn btn-primary dropdown-toggle btn-xs' data-toggle='dropdown'>Operation<span class='caret'style='margin-left:5px;'></span></button>
                    <ul class='dropdown-menu' role='menu'>
                            <li><a href='javascript:;' class='editFun' czid='".$value['id']."'>Edit</a></li>
                        <li><a href='javascript:;' class='addintention' czid='".$value['id']."'>Turn to lead</a></li>
                        <li><a href='javascript:;' class='tjlxjl' czid='".$value['id']."'>Add a Contact</a></li>
                        <li><a href='javascript:;' class='tjlxr' czid='".$value['id']."'>Add contact record</a></li>
                    </ul>
                </div>
                </div>";
            }
            $tb_row=array(
                $key+1,
                "<input class='SelectAllId' type=checkbox name=id[] value=".$value['id'].">",
                $title,
                $Class_model->getNameById($value['type']),
                $value['orderstatus'],
                $Class_model->getNameById($value['s2']),
                $prefix.$fullname.'&nbsp;'.$middlename.'&nbsp;'.$familyname,
                $mobile,
                $email,
                '<a href="http://'.$value['website'].'" target="_blank">'.$value['website'].'</a>',
                $Users_model->getUserName($value['userid']),
                $nexttime,
                $lasttime,
                $posttime,
                $select,
                $value['id']);
            array_push($tb_data, $tb_row);
        }
        $allTotal[1]=$recordsFiltered;
        echo json_encode(array(
            "draw" => intval($draw),
            "allTotal" => $allTotal,
            "recordsTotal" => intval($recordsTotal),
            "recordsFiltered" => intval($recordsFiltered),
            "data" => $tb_data
        ),JSON_UNESCAPED_UNICODE);
    }
}