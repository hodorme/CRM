<?php
namespace Home\Model;
class RoleModel extends CommonModel {
	//protected $tableName='sys_role';
	protected $tableName='bumen_zw';
	public function getXField($Id,$x)
	{
		$map['id'] =$Id;
		$data =$this->where($map)->getField($x);
		return $data;
	}
	public function getNameById($Id)
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
		//有逗号分开处理数据范围
		$qx="";
		for($i=0;$i<count($param['qx']);$i++){
			if($i>0){
				$qx.=','.$param['qx'][$i];
			}else{
				$qx=$param['qx'][$i];
			}
		}
		$param['qx']= $qx;
		$czqx="";
		for($i=0;$i<count($param['czqx']);$i++){
			if($i>0){
				$czqx.=','.$param['czqx'][$i];
			}else{
				$czqx=$param['czqx'][$i];
			}
		}
		$param['czqx']= $czqx;
		$param['posttime']=date("Y-m-d H:i:s");
		$param['uid']=session('uid');
		return $this->add($param);
	}
	//修改操作
	public function mySave($param=array()){
		//有逗号分开处理数据范围
		$qx="";
		for($i=0;$i<count($param['qx']);$i++){
			if($i>0){
				$qx.=','.$param['qx'][$i];
			}else{
				$qx=$param['qx'][$i];
			}
		}
		$param['qx']= $qx;
		$czqx="";
		for($i=0;$i<count($param['czqx']);$i++){
			if($i>0){
				$czqx.=','.$param['czqx'][$i];
			}else{
				$czqx=$param['czqx'][$i];
			}
		}
		$param['czqx']= $czqx;
		$param['uptime']=date("Y-m-d H:i:s");
		$param['upuid']=session('uid');
		return $this->where('id = '.(int)$param['czid'])->save($param);
	}
	//删除操作
	public function myDel($id){
		return $this->where('id = '.$id)->delete();
	}
	/*输出处理后的列表*/
	public function getFormatAll($map){
		$list=$this->order('sequence')->getAll($map);
		$Users_model=D('Users');
		$Menu_model=D('Menu');
		$Bumen_model=D('Bumen');
		$tb_data =array();
		$tb_row =array();
		foreach ($list as $key => $value)
		{
			$tb_row=array(
				'',
				$Bumen_model->getName($value['bmid']),
				$value['classname'],
				$value['qx'],//$Menu_model->getNames($value['qx']),
				$value['czqx'],
				$value['uptime']."<br>".$Users_model->getUserName($value['upuid']),
				$value['id']);
			array_push($tb_data, $tb_row);
		}
		$result['data']=$tb_data;
		return $result;
	}
}





