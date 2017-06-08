<?php
namespace Home\Model;
class FullcustomerModel extends CommonModel {
    protected $tableName='company';
    /*输出重组列表*/
    public function getFormatAll($map){
        $uid = session('uid');
        $Class_model = D('Class');
        $Users_model = D('Users');
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
                case 1;$orderSql = " order by a.id ".$order_dir;break;
                case 2;$orderSql = " order by b.classname ".$order_dir;break;
                case 3;$orderSql = " order by j.classname ".$order_dir;break;
                case 4;$orderSql = " order by c.classname ".$order_dir;break;
                case 5;$orderSql = " order by v.yeji ".$order_dir;break;
                case 6;$orderSql = " order by n.jine ".$order_dir;break;
                case 7;$orderSql = " order by a.posttime ".$order_dir;break;
                case 8;$orderSql = " order by a.nexttime ".$order_dir;break;
                case 9;$orderSql = " order by a.lasttime ".$order_dir;break;
                case 10;$orderSql = " order by d.username ".$order_dir;break;
                case 11;$orderSql = " order by e.username ".$order_dir;break;
                case 12;$orderSql = " order by a.id ".$order_dir;break;
                default;$orderSql = '';
            }
        }
        //分页
        $start = $_GET['start'];//从多少开始
        $length = $_GET['length'];//数据长度
        $limitSql = '';
        $limitFlag = isset($_GET['start']) && $length != -1 ;
        if ($limitFlag ) {
            //$limitSql = " LIMIT ".intval($start).", ".intval($length);    //mysql语法
            $limitSql = " top ".intval($length);
        }
        $p=$start/10+1;
        //定义查询数据总记录数sql
        $recordsTotalsql= "select count(*)  from  AEG_company where 1=1 $map";
        $recordsTotal=$this->query($recordsTotalsql);
        if($recordsTotal[0][''] == '0'){
            $email=$_REQUEST['title'];
            $email = " and email like '%".$email."%' or email1 like '%".$email."%'";
            $recordsTotalsql= "select count(*)  from  AEG_member where 1=1 $email";
            $recordsTotal=$this->query($recordsTotalsql);
        }
        //条件过滤后记录数 必要
        $recordsFiltered = 0;
        $recordssql="select count(*)  from  AEG_company where 1=1 $map";
        $recordsFiltered=$this->query($recordssql);
        if($recordsFiltered[0][''] == '0'){
            $email=$_REQUEST['title'];
            $email = " and email like '%".$email."%' or email1 like '%".$email."%'";
            $recordssql= "select count(*)  from  AEG_member where 1=1 $email";
            $recordsFiltered=$this->query($recordssql);
        }
        $list = $this->table('AEG_company')->where('1=1'.$map)->page($p.','.$length)->select();
        if(!$list){
            $email=$_REQUEST['title'];
            $map = " and email like '%".$email."%' or email1 like '%".$email."%'";
            $list = $this->table('AEG_member')->where('1=1'.$map)->page($p.','.$length)->select();
        }

        $tb_data =array();
        $tb_row =array();
        foreach ($list as $key => $value)
        {

            if($value['cid']){
                $title = $this->where('id in (' . $value['cid'] . ')')->find();
                $type = $Class_model->getNameById($title['classid']);
                $xiangxi = '';
                if(strpos(getUserCzqx(),"客户部门管理")>-1 or $title['userid'] == $uid or $value['classid'] == 1859) {
                    $xiangxi = '<a href="' . U('Home/Customer/view') . '?czid=' . $title['id'] . '" target="_blank">' . "Detail" . '</a>';
                }
                $username = $Users_model->getUserName($title['userid']);
                $datetiem = date('Y-m-d',strtotime($title['posttime']));
                $id = $title['id'];
                $title = $title['title'];
            } else {
                $title = $value['title'];
                $type = $Class_model->getNameById($value['classid']);
                $xiangxi = '';
                if(strpos(getUserCzqx(),"客户部门管理")>-1 or $value['userid'] == $uid or $value['classid'] == 1859) {
                    $xiangxi = '<a href="' . U('Home/Customer/view') . '?czid=' . $value['id'] . '" target="_blank">' . "Detail" . '</a>';
                }
                $username = $Users_model->getUserName($value['userid']);
                $datetiem = date('Y-m-d',strtotime($value['posttime']));
                $id = $value['id'];
            }
            $tb_row=array(
                $key+1,
                $title,
                $type,
                $datetiem,
                $username,
                $xiangxi,
                $id);
            array_push($tb_data, $tb_row);
        }
        echo json_encode(array(
            "draw" => intval($draw),
            "recordsTotal" => intval($recordsTotal[0]['']),
            "recordsFiltered" => intval($recordsFiltered[0]['']),
            "data" => $tb_data
        ),JSON_UNESCAPED_UNICODE);
    }
}