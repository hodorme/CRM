<?php
namespace Home\Model;
class MenuModel extends CommonModel {
	protected $tableName='sys_menu';
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
        return $data['title'];
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
            $str.=$data[$i]['title'].',';
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
        if(!$param['seq']){
            $param['seq']=$this->max('seq')+1;
        }
        $param['posttime']=date("Y-m-d H:i:s");
        $param['uid']=session('uid');
        return $this->add($param);
    }
    //修改操作
    public function mySave($param=array()){
        $param['uptime']=date("Y-m-d H:i:s");
        $param['upuid']=session('uid');
        if(!$param['display_flag']){
            $param['display_flag']=0;
        }
        return $this->where('id = '.(int)$param['czid'])->save($param);
    }
    //删除操作
    public function myDel($id){
        return $this->where('id = '.$id)->delete();
    }
    /*输出重组列表*/
    public function getFormatAll($map){
        $list=$this->order('sid,seq asc')->getAll($map);
        $umodel=D('users');
        $codemodel =D('Code');
        $tb_data =array();
        $tb_row =array();
        foreach ($list as $key => $value)
        {
            $flag=($value['flag']==1)?"功能组":"功能项";
            $tb_row=array(
                $key+1,
                $value['title'],
                "<i class='fa ".$value['icon']."'></i>",
                $value['url'],
                $this->getNameById($value['sid']),
                $flag,
                $value['uptime'].$umodel->getUserName($value['upuid']),
                $value['id']);
            array_push($tb_data, $tb_row);
        }
        $result['data']=$tb_data;
        return $result;
    }
    //根据当前控制器名和方法名获取Menu表中的title by linjc
    function  GetMenuTitle($controllerName,$actionName){
        if ($actionName =='index')
         {
            $map['url'] =$controllerName;
         }else{
            $map['rul'] =$controllerName.'/'.$actionName;
        }
        $map['flag'] = array(array('NEQ',1),array('EXP','IS NULL'),'OR');
        $rlt =$this->where($map)->field('title')->find();
        return $rlt['title'];
     }
}





