<?php
namespace Home\Model;
class ClassModel extends CommonModel {
    protected $tableName='class';
    /*
    * 功能说明:根据classname转成id输出
    * 日期 2016-7-1 by watson
    * 参数: $map $what
   */
    public function getAll($map)
    {
        $data =$this->where($map)->select();
        return $data;
    }
    //新增操作
    public function myAdd($param=array()){
        return $this->add($param);
    }
    //修改操作
    public function mySave($param=array()){
        return $this->where('id = '.(int)$param['czid'])->save($param);
    }
    //删除操作
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
    public function getNameById($Id)
    {
        $map['id'] =$Id;
        $data =$this->where($map)->find();
        return $data['classname'];
    }
    public function getFormatAll($map){

        $draw = $_GET['draw'];//这个值作者会直接返回给前台
        $order_dir = $_GET['order']['0']['dir'];//ase desc 升序或者降序
        $start = $_GET['start'];//从多少开始
        $length = $_GET['length'];//数据长度
        $order_column = $_GET['order']['0']['column'];//那一列排序，从0开始
        $p=$start/10+1;
        if (isset($order_column)) {
            $i = intval($order_column);
            switch ($i) {
                case 0;$orderSql = " order by a.posttime " . $order_dir;break;
                case 2;$orderSql = " order by a.posttime " . $order_dir;break;
                case 3;$orderSql = " order by a.cid " . $order_dir;break;
                case 6;$orderSql = " order by a.fkdate " . $order_dir;break;
                case 9;$orderSql = " order by a.id " . $order_dir;break;
                default;$orderSql = '';
            }
        }
        $recordsTotal = $this->where($map)->count();
        $recordsFiltered = $this->where($map)->count();
        $list = $this->where($map)->page($p.','.$length)->select();
        $infos=array();
        foreach ($list as $key => $value)
        {
            $classname="<a type=".$value['id']." class='btn btn-xs type'>".$value['classname']."</a>";
            $obj=array(
                $key+1,
                "<input type=checkbox name=classid[] value=".$value['id'].">",
                $classname,
                "<a class='btn btn-xs edit' czid=".$value['id'].">编辑</a><br>",
                $value['id']);
            array_push($infos, $obj);
        }
        echo json_encode(array(
            "draw" => intval($draw),
            "recordsTotal" => intval($recordsTotal),
            "recordsFiltered" => intval($recordsFiltered),
            "data" => $infos
        ), JSON_UNESCAPED_UNICODE);
    }
}






