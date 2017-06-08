<?php
namespace Home\Model;
class QuanxianModel extends CommonModel {
	protected $tableName='sys_quanx';
    public function getXField($Id,$x)
    {
        $map['id'] =$Id;
        $data =$this->where($map)->getField($x);
        return $data;
    }
    /*
    功能说明：通过参数(多个）获取name字符集
    日期：2016-4-13 by linjc
    参数：$str_ids
	*/
    public function getNames($str_ids){
        $map['id'] = array ('in',$str_ids);
        $data =$this->where($map)->select();
        $str="";
        for($i=0;$i<count($data);$i++)
        {
            $str.=$data[$i]['name'].',';
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
        $param['posttime']=date("Y-m-d H:i:s");
        $param['uid']=session('uid');
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
        return $this->where('id = '.$id)->delete();
    }
    /*输出重组列表*/
    public function getFormatAll($map){
        $list=$this->getAll($map);
        $umodel=D('users');
        $Menu_model=D('Menu');
        $tb_data =array();
        $tb_row =array();
        foreach ($list as $key => $value)
        {
            $tb_row=array(
                '',
                $Menu_model->getXField($value['sid'],'title'),
                $value['note'],
                $value['qx'],
                $value['uptime'].$umodel->getUserName($value['upuid']),
                $value['id']);
            array_push($tb_data, $tb_row);
        }
        $result['data']=$tb_data;
        return $result;
    }
}





