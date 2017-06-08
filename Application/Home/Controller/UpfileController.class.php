<?php
namespace Home\Controller;
use Think\Controller;
use Think\Model;
class UpfileController extends Controller {
    //文件上传
	public function index(){
		import('ORG.Net.UploadFile');
		$upload = new UploadFile();// 实例化上传类
		$upload->allowExts  = array('jpg', 'gif', 'png', 'jpeg');// 设置附件上传类型
		$upload->autoSub =true ;
		$upload->subType ='date' ;
		$upload->dateFormat ='ym' ;
		$upload->savePath =  './Uploads/thumb/';// 设置附件上传目录
		if($upload->upload()){
			$info =  $upload->getUploadFileInfo();
			echo json_encode(array(
				'url'=>$info[0]['savename'],
				'title'=>htmlspecialchars($_POST['pictitle'], ENT_QUOTES),
				'original'=>$info[0]['name'],
				'state'=>'SUCCESS'
			));
		}else{
			echo json_encode(array(
				'state'=>$upload->getErrorMsg()
			));
		}
	}
}


