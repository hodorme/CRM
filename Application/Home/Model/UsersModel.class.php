<?php
namespace Home\Model;
class UsersModel extends CommonModel {
    protected $tableName='users';
    //2016-11-8 by jn  功能:获取部门id
    public function getFukuanId($id){
        $map['id'] =$id;
        $data =$this->where($map)->find();
        return $data['bmid'];
    }
    public function getSex($id){
        $map['id'] =$id;
        $data =$this->where($map)->find();
        return $data['u_sex'];
    }
    public function getUserName($userId)
    {
        $map['id'] =$userId;
        $data =$this->where($map)->find();
        return $data['username'];
    }
	 public function getNames($str_ids){
        $map['id'] = array ('in',$str_ids);
        $data =$this->where($map)->select();
        $str="";
        for($i=0;$i<count($data);$i++)
        {
            $str.=$data[$i]['username'].',';
        }
        $str =substr($str, 0,strlen($str) - 1);
        $str =!empty($str)?$str:'';
        return  $str;
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
        $data =$this->where($map)->select();
        return $data;
    }
    //新增操作
    public function myAdd($param=array()){
        return $this->add($param);
    }
    //修改操作
    public function mySave($param=array()){
        if($param['pwd']){
            $param['pwd']=md5($param['pwd']);
        }
        return $this->where('id = '.(int)$param['czid'])->save($param);
    }
    //删除操作
    public function myDel($id){
        return $this->where('id = '.$id)->delete();
    }
    /*输出处理后的列表*/
    public function getFormatAll(){
        $sql="SELECT
					a.*,b.classname as bumen,c.classname as zhiwei
                FROM
                    AEG_users a
					LEFT JOIN AEG_bumen b ON a.bmid = b.id
					LEFT JOIN AEG_bumen_zw c ON a.zwid = c.id
                ";
        //$list=$this->table('AEG_users a,AEG_bumen b,AEG_bumen_zw c')->field('a.*,b.classname as bumen,c.classname as zhiwei')->where('a.bmid = b.id and a.zwid = c.id')->select();

        //a.bmid in(4,30,31,16,33) and a.zwid in(14,53,21) and
        $list=$this->query($sql);
        //$list=$this->getAll($map);
        $tb_data =array();
        $tb_row =array();
        foreach ($list as $key => $value) {
            $rmodel=D('Role');
            //$roleid=$rmodel->getNames($value['roleid']);
            $tb_row=array(
                '',
                $value['usercode'],
                $value['username'],
                $value['bumen'],
                $value['zhiwei'],
                $value['uptime'],
                $value['id']
            );
            array_push($tb_data, $tb_row);
        }
        $result['data']=$tb_data;
        return $result;
    }
}