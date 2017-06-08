<?php
namespace Home\Model;
class ZhiweiModel extends CommonModel {
    protected $tableName='bumen_zw';
	 public function getName($Id)
    {
        $map['id'] =$Id;
        $data =$this->where($map)->find();
        return $data['classname'];
    }
	 public function getNames($str_ids){
        $map['id'] = array ('in',$str_ids);
        $data =$this->where($map)->select();
        $str="";
        for($i=0;$i<count($data);$i++)
        {
            $str.=$data[$i]['classname'].',';
        }
        $str =substr($str, 0,strlen($str) - 1);
        $str =!empty($str)?$str:'';
        return  $str;
    }
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
        $param['uptime']=date("Y-m-d H:i:s");
        $param['upuid']=session('uid');
        return $this->where('id = '.(int)$param['czid'])->save($param);
    }
    //删除操作
    public function myDel($id){
        return $this->delete($id);
    }
    /*输出处理后的列表*/
    public function getFormatAll($map){
        $list=$this->getAll($map);
        $tb_data =array();
        $tb_row =array();
        foreach ($list as $key => $value) {
            $tb_row=array(
                '',
                $value['id']
            );
            array_push($tb_data, $tb_row);
        }
        $result['data']=$tb_data;
        return $result;
    }
}