<?php
namespace Home\Model;
class FeedbackModel extends CommonModel{
	protected $tableName='feedback';
//    数据删除
    public function myDel()
    {
        $expo_model=D('Expo');
        $id = explode(",", $_REQUEST['czid']);
        $this->startTrans();
        for ($i = 0; $i < count($id); $i++) {
            $cid = $id[$i];
            if ($cid) {
                $res=$expo_model->where("pid=".$cid)->find();
                if(count($res)>0){
                    return "Please delete the expo first";
                }
                $this->where('id = ' . $cid)->delete();
            } else {
                $this->rollback();
                return 0;
            }
        }
        $this->commit();
        return 1;
    }
    /*输出重组列表*/
    public function getFormatAll(){
        $where=" 1=1 ";
        $draw = $_GET['draw'];//这个值作者会直接返回给前台
        $order_dir = $_GET['order']['0']['dir'];//ase desc 升序或者降序
        $start = $_GET['start'];//从多少开始
        $length = $_GET['length'];//数据长度
        $order_column = $_GET['order']['0']['column'];//那一列排序，从0开始
        $p=$start/10+1;
        if (isset($order_column)) {
            $i = intval($order_column);
            switch ($i) {
                case 2;$orderSql = " posttime ".$order_dir;break;
                case 6;$orderSql = " id " . $order_dir;break;
                default;$orderSql = '';
            }
        }
        $recordsTotal = $this->count();
        $recordsFiltered = $this->count();
        $list = $this->page($p.','.$length)->order($orderSql)->select();
        $usersmodel=D('Users');
        $classmodel=D('Class');
        $tb_data =array();
        foreach ($list as $key => $value)
        {

            $tb_row=array(
                $key+1,
                "<input type=checkbox name=pid[] value=".$value['id'].">",
                $value['score'],
                $value['note'],
                $usersmodel->getUserName($value['userid']),
                date("Y-m-d",strtotime($value['posttime'])),
                $value['id']
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





