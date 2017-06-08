<?php
namespace Home\Model;
class BumenModel extends CommonModel {
    protected $tableName='bumen';
    //2016-11-8 by jn  功能:判断付款id是否属于会展一部 我是你爷爷
    public function getIsId($id){
        $data =$this->where('id = '.$id)->find();
        if($data['parid'] == 4 or $data['id'] == 4){
           return 1;
        }else{
           return 0;
        }
    }
    public function getParid($id){
        $map['id'] =$id;
        $data =$this->where($map)->find();
        return $data['parid'];
    }
    public function getParpath($id){
        $map['id'] =$id;
        $data =$this->where($map)->find();
        return $data['parpath'];
    }
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
        $param['sequence'] = $param['djid'];
        $param['parid'] = $param['djid'];
        $param['userid'] = session('uid');
        $parpath = $this->getParpath($param['djid']);
        if($param['djid'] != 0){
            $param['parpath'] = $parpath.','.$param['djid'];
        }else{
            $param['parpath'] = '0';
        }
        return $this->add($param);
    }
    //修改操作
    public function mySave($param=array()){
        return $this->where('id = '.(int)$param['czid'])->save($param);
    }
    //删除操作
    public function myDel($id){
        return $this->where('id = '.$id)->delete();
    }
    /*输出处理后的列表*/
    public function getFormatAll($where){
        if(!$where['bmid']){
            $map['parid'] = 0;
        }else{
            $map['parid'] = $where['bmid'];
        }
        $list=$this->getAll($map);
        $tb_data =array();
        $tb_row =array();
        foreach ($list as $key => $value) {
            $name='<a href="javascript://" class="zfl" id="'.$value['id'].'" parid="'.$value['parid'].'" >'.$value['classname'].'</a>';
            $tb_row=array(
                '',
                $name,
                $value['note'],
                '',
                '',
                '',
                $value['id']
            );
            array_push($tb_data, $tb_row);
        }
        $result['data']=$tb_data;
        return $result;
    }
}






