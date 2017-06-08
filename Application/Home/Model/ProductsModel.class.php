<?php
namespace Home\Model;
class ProductsModel extends CommonModel {
    protected $tableName='products';
    // public function getKeyValue($keyname)
    // {
    //     $map['keyname'] =$keyname;
    //     $rlt= $this->where($map)->find();
    //     return $rlt;
    // }
    public function getProductsName($Id)
    {
        $map['id'] =$Id;
        $data =$this->where($map)->find();
        return $data['title'];
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
        // var_dump($id);die;
        return $this->where('id = '.$id)->delete();
        // return $this->delete($id);
    }
    /*输出重组列表*/
    public function getFormatAll($map){
        $list=$this->getAll($map);
        $tb_data =array();
        $tb_row =array();
        foreach ($list as $key => $value)
        {
            $tb_row=array(
                '',
                $value['id']);
            array_push($tb_data, $tb_row);
        }
        $result['data']=$tb_data;
        return $result;
    }
}



