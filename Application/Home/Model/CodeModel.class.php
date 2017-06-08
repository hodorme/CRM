<?php
namespace Home\Model;
class CodeModel extends CommonModel {
	protected $tableName='sys_code';
	public function getNameById($Id)
	{
		  $map['id'] =$Id;
		  $data =$this->where($map)->find();
		  return $data['name'];
	}
	public function getNoteById($Id)
	{
		  $map['id'] =$Id;
		  $data =$this->where($map)->find();
		  return $data['note'];
	}
	public function getNameByCode1($code)
	{
		$where['code']=array('eq',$code);
		$name=$this->where($where)->getField('name');
		return $name;
	}
    public function getCodeById($Id)
    {
        $map['id'] =$Id;
        $data =$this->where($map)->find();
        return $data['code'];
    }
	/*
	 * 功能说明:根据code的name转成id输出
	 * 日期 2016-7-1 by watson
	 * 参数: $map $what
	*/
	public function getId($name)
	{
		$map['name']=$name;
		$data =$this->where($map)->find();
		return $data['id'];
	}
	/*
	 * 功能说明:输出结果集给Handsontable
	 * 日期 2016-7-1 by watson
	 * 参数: $map $what
	*/
	public function getCodeTypes($map,$what){
		$rlt =$this->where($map)->select();
		foreach($rlt as $key=>$val) {
			$rlt[$key] =$val[$what];
		}
		return $rlt;
	}
	/*
	 * 功能说明:通过传递code的id和codename判断是否存在数据
	 * 日期 2016-7-1 by watson
	 * 参数:$Id,$str
	 */
	public function isEqParentName($Id,$str)
	{
		$sqltxt="select count(1) num from ww_sys_code where sid =(select id from ww_sys_code where name='".$str."') and id=".$Id;
		$data=$this->query($sqltxt);
		return  $data[0]['num'];
	}
	public function getAll($map)
	{   
		  $data =$this->where($map)->select();
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
    //功能说明：返回所有业务类型（海运和空运）
	public function getAllYtype(){
		$sqltxt ="select id,name from ww_sys_code where sid in(select id from ww_sys_code where name in('AIR_BUSINESS_TYPE','SEA_BUSINESS_TYPE'))";
		$data =$this->query($sqltxt);
		return  $data;
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
		return $this->delete($id);
	}
	/*输出重组列表*/
	public function getFormatAll($map){
		$list=$this->order('sid')->getAll($map);
		$umodel=D('users');
		$codemodel =D('Code');
		$tb_data =array();
		$tb_row =array();
		foreach ($list as $key => $value)
		{
			$tb_row=array(
					$key+1,
					$value['name'],
					$value['code'],
					$value['note'],
					$this->getNameById($value['sid']),
					$value['seq'],
					$value['uptime'].$umodel->getUserName($value['upuid']),
					$value['id']);
			array_push($tb_data, $tb_row);
		}
		$result['data']=$tb_data;
		return $result;
	}
    /*
     功能说明：获取格式化数据，仅支持三级
     Author:linjc 
     Date:2016-4-11
    */
	public function getFormatData($id)
	{
		$listarr = array();
		$level1 = array();
		$map['id'] =$id;
    //$map['sid'] =0;
		$list =$this->getall($map);
		for ($i = 0; $i < count($list); $i++){ 
			 array_push($listarr,array(
            	"name"=>$list[$i]["name"],
            	"note"=>$list[$i]["note"], 
            	"seq"=>$list[$i]["seq"],
            	"id"=>$list[$i]["id"]));
           $list_leve2 =$this->getall(array("sid=".$list[$i]["id"]));
           $level2 = array();  //每轮清空数组
           for($j =0; $j < count($list_leve2); $j++){
              array_push($level2,array(
            	"name"=>$list_leve2[$j]["name"],
            	"note"=>$list_leve2[$j]["note"], 
            	"seq"=>$list_leve2[$j]["seq"],
            	"id"=>$list_leve2[$j]["id"],
            	"mxmx"=>$this->getall(array("sid=".$list_leve2[$j]["id"]))
            	));
           }
          $listarr[$i]['mx'] =$level2;
		}
      return $listarr;
	}
    //判断一个城市是否属于一个国家
    public function is_aCityInCountry($country,$city){
       $map['sid'] =$country;
        $map['id']=$city;
        $rlt =$this->where($map)->find();
        if($rlt){
            return 1;
        }else{
            return 0;
        }

    }
}
 





