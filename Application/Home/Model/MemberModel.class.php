<?php
namespace Home\Model;
class MemberModel extends CommonModel {
    protected $tableName='member';
    public function getUserName($userId)
    {
        $map['id'] =$userId;
        $data =$this->where($map)->find();
        return $data['username'];
    }
    //获取fullname by sc 2016-10-17
    public function getFullName($userId)
    {
        $map['id'] =$userId;
        $data =$this->where($map)->find();
        return $data['fullname'];
    }
    //获取fullname by sc 2016-10-17
    public function getPosition($userId)
    {
        $map['id'] =$userId;
        $data =$this->where($map)->find();
        return $data['position'];
    }
    //获取cid by sc 2016-10-17
    public function getCid($userId)
    {
        $map['id'] =$userId;
        $data =$this->where($map)->find();
        return $data['cid'];
    }
    //获取联系电话 by sc 2016-11-11
    public function getTel($userId)
    {
        $map['id'] =$userId;
        $data =$this->where($map)->find();
        return $data['tel'];
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
    public function myAdd($param=array())
    {
        $info = $this->where('cid = '.$param['cid'])->select();
        if(!$info){
            $param['setdefault'] = 1;
        }
        $param['userid'] = session('uid');
        return $this->add($param);
    }
    //修改操作
    public function mySave($param=array())
    {
        $param['upuserid']=session('uid');
        return $this->where('id = '.$param['czid'])->save($param);
    }
    //删除操作
    public function myDel($id)
    {
        return $this->where('id = '.$id)->delete();
    }
    /*输出处理后的列表*/
    public function getFormatAll($map)
    {
        $Class_model = D('Class');
        $list=$this->getAll($map);
        $tb_data =array();
        $tb_row =array();
        foreach ($list as $key => $value) {
            if($value['setdefault'] == 1){
                $setdefault='<input type="radio" id="'.$value['id'].'" class="upmember" value="'.$value['setdefault'].'" checked>';
            }else{
                $setdefault='<input type="radio" id="'.$value['id'].'" class="upmember" value="'.$value['setdefault'].'">';
            }
            $tb_row=array(
                '',
                $setdefault,
                $Class_model->getNameById($value['prefix']),
                $value['fullname'].'&nbsp; '.$value['middlename'].'&nbsp; '.$value['familyname'],
                $value['bumen'],
                $value['position'],
                $value['telarea']."-".$value['tel']."-".$value['fenji'],
                $value['marea'] . "- "  . $value['mobile'],
                $value['faxarea']."-".$value['fax'],
                '<a href="mailto:'.$value['email'].'">'.$value['email'].'</a>',
                '<a href="javascript:" class="lxredit" id="'.$value['id'].'">Edit</a>',
                $value['id']
            );
            array_push($tb_data, $tb_row);
        }
        $result['data']=$tb_data;
        return $result;
    }
}





