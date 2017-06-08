<?php
namespace Home\Model;
class SettingModel extends CommonModel {
	protected $tableName='sys_setting';
    public function getKeyValue($keyname)
    {
        $map['keyname'] =$keyname;
        $rlt= $this->where($map)->find();
        return $rlt;
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
        $param['id']=$param['czid'];
        $param['uptime']=date("Y-m-d H:i:s");
        $param['upuid']=session('uid');
        //return $this->save($param);
		return $this->where()->save($param);
    }
    //删除操作
    public function myDel($id){
        //return $this->delete($id);
		return $this->where('id = '.$id)->delete();
    }
    /*输出重组列表*/
    public function getFormatAll($map){
        $list=$this->getAll($map);
        $umodel=D('users');
        $codemodel =D('Code');
        $tb_data =array();
        $tb_row =array();
        foreach ($list as $key => $value)
        {
            $tb_row=array(
                $key+1,
                $value['keyname'],
                $value['keyvalue'],
                $value['note'],
                $value['flag'],
                $value['posttime'].$umodel->getUserName($value['uid']),
                $value['uptime'].$umodel->getUserName($value['upuid']),
                $value['id']);
            array_push($tb_data, $tb_row);
        }
        $result['data']=$tb_data;
        return $result;
    }
}





