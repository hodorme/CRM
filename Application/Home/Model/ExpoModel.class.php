<?php
namespace Home\Model;
class ExpoModel extends CommonModel {
    protected $tableName='expo';
//    获取展会名称
    public function getExpoById($Id)
    {
        $map['id'] =$Id;
        $data =$this->where($map)->find();
        return $data['title'];
    }
//    数据删除
    public function myDel()
    {
        $id = explode(",", $_REQUEST['czid']);
        $this->startTrans();
        for ($i = 0; $i < count($id); $i++) {
            $cid = $id[$i];
            if ($cid) {
                $this->where('id = ' . $cid)->delete();
            } else {
                $this->rollback();
                return 0;
            }
        }
        $this->commit();
        return 1;
    }
//    输出展会列表
    public function getFormatAll($map)
    {
        $where=" 1=1 ";
        if($map){
            $where.=" and $map";
        }
        //获取Datatables发送的参数 必要
        $draw = $_GET['draw'];//这个值作者会直接返回给前台
        $start = $_GET['start'];//从多少开始
        $length = $_GET['length'];//数据长度
        $order_column = $_GET['order']['0']['column'];//那一列排序，从0开始
        $order_dir = $_GET['order']['0']['dir'];//ase desc 升序或者降序
        $p=$start/10+1;
        $orderSql = "";
        if(isset($order_column)){
            $i = intval($order_column);
            switch($i){
                case 4;$orderSql = " starttime ".$order_dir;break;
                case 5;$orderSql = " endtime ".$order_dir;break;
                default;$orderSql = '';
            }
        }
        $recordsTotal = $this->where($where)->count();
        $recordsFiltered = $this->where($where)->count();
        $list = $this->page($p.','.$length)->where($where)->order($orderSql)->select();
//        echo $this->getLastSql();
        $Class_model=D('Class');
        $tb_data =array();
        $project_model=D('Project');
        $orders_model=D('Orders');
        foreach ($list as $key => $value)
        {
            $edit='';
            if(strpos(getUserCzqx(),"展会编辑")>-1){
                $edit="<a class='btn btn-xs edit' czid=".$value['id'].">Edit</a><br>";
            }
            $size=$orders_model->where("expoid=".$value['id']." and orderstatus='有效订单'")->sum('acreage');
            $info=$project_model->where("id=".$value['pid'])->find();
            $tb_row=array(
                $key+1
                 ,"<input type=checkbox name=expoid[] value=".$value['id'].">"
                ,"<a href=/CRM/index.php/Home/Expo/view?czid=".$value['id']." target=_blank>".$value['title']."</a>"
                ,$Class_model->getNameById($info['hangye'])
                ,date('Y-m-d',strtotime($value['starttime']))
                ,date('Y-m-d',strtotime($value['endtime']))
                ,$value['mbmianji']?$value['mbmianji']."㎡":$value['mbmianji']
                ,$size?$size."㎡":$size
                ,$edit
                ,$value['id']
            );
            array_push($tb_data, $tb_row);
        }

        echo json_encode(array(
            "draw" => intval($draw),
            "recordsTotal" => intval($recordsTotal),
            "recordsFiltered" => intval($recordsFiltered),
            "data" => $tb_data
        ), JSON_UNESCAPED_UNICODE);
    }
//    输出展会详细订单列表
    public function getFormatAllOfOrders($map)
    {
        $where=" 1=1 ";
        if($map){
            $where.=" and $map";
        }
        $orders_model=D('Orders');
        $draw = $_GET['draw'];//这个值作者会直接返回给前台
        $start = $_GET['start'];//从多少开始
        $length = $_GET['length'];//数据长度
        $order_column = $_GET['order']['0']['column'];//那一列排序，从0开始
        $order_dir = $_GET['order']['0']['dir'];//ase desc 升序或者降序
        $p=$start/10+1;
        $orderSql = "";
        if(isset($order_column)){
            $i = intval($order_column);
            switch($i){
                case 0;$orderSql = " order by a.starttime asc";break;
                case 1;$orderSql = " order by a.id ".$order_dir;break;
                case 2;$orderSql = " order by a.title ".$order_dir;break;
                default;$orderSql = '';
            }
        }
        $recordsTotal = $orders_model->where($where)->count();
        $recordsFiltered = $orders_model->where($where)->count();
        $list = $orders_model->page($p.','.$length)->where($where)->select();
        $tb_data =array();
        $customer_model =D('Customer');
        $class_model =D('Class');
        foreach ($list as $key => $value)
        {
            $tb_row=array(
                $key+1
            ,'<a href="/CRM/index.php/Home/Customer/view?czid='.$value['cid'].'" target="_blank">'.$customer_model->getNameById($value['cid']).'</a>'
            ,'<a href="/CRM/index.php/Home/Expo/view?czid='.$value['expoid'].'" target="_blank">'.$this->getExpoById($value['expoid']).'</a>'
            ,$value['qydate']
            ,$value['acreage']."㎡"
            ,$class_model->getNameById($value['boothtype'])
            ,$value['id']
            );
            array_push($tb_data, $tb_row);
        }

        echo json_encode(array(
            "draw" => intval($draw),
            "recordsTotal" => intval($recordsTotal),
            "recordsFiltered" => intval($recordsFiltered),
            "data" => $tb_data
        ), JSON_UNESCAPED_UNICODE);
    }
}





