<?php
namespace Home\Model;
class DaochuModel extends CommonModel {
    protected $tableName='member';
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
        $Customer_model = D('Customer');
        $Class_model = D('Class');
        $ContactRecord_model = D('ContactRecord');
        $list=$this->where($where)->select();
        $tb_data =array();
        $tb_row =array();
        foreach ($list as $key => $value) {
            $value['ctitle'] = $Customer_model->getNameById($value['cid']);
            $value['xuhao'] = $key+1;
            $value['guojia'] = $Class_model->getNameById($Customer_model->getCountryById($value['cid']));
            $value['yuyan'] = $Class_model->getNameById($value['language']);
            $posttime = '';
            if($value['posttime']){
                $posttime =date('Y-m-d',strtotime($value['posttime']));
            }
            $updatetime = '';
            if($value['updatedtime']){
                $updatetime =date('Y-m-d',strtotime($value['updatedtime']));
            }
            $cr = '';
            $info = $ContactRecord_model->where('contact = '.$value['id'])->order('posttime desc')->find();
            $cr = $info['note'];
            $tb_row=array(
                $value['xuhao'],
                $value['ctitle'],
                $value['guojia'],
                $Class_model->getNameById($value['prefix']).$value['fullname'].'&nbsp;'.$value['middlename'].'&nbsp;'.$value['familyname'],
                $value['email'],
                $value['email1'],
                $value['yuyan'],
                $posttime,
                $updatetime,
                $cr,
                $value['id']
            );
            array_push($tb_data, $tb_row);
        }
        $result['data']=$tb_data;
        return $result;
    }
}






