<?php
namespace Home\Controller;
use Think\Controller;
use User\Api\UserApi;
class LayUploadController extends Controller {
	public function index(){
		$upload = new \Think\Upload();// 实例化上传类
		$upload->maxSize   =     31457280000 ;// 设置附件上传大小
		$upload->exts      =     array('jpg', 'gif', 'png', 'jpeg','peg','bmp','pdf');// 设置附件上传类型
		$upload->rootPath  =     './Uploads/'; // 设置附件上传根目录
		$upload->savePath  =     ''; // 设置附件上传（子）目录
		$upload->saveName = time().'_'.mt_rand();
		// 上传单个文件
		$info= $upload->uploadOne($_FILES['photo']);
		if(!$info) {// 上传错误提示错误信息
			$this->ajaxreturn(array('code' => 2, 'msg' => $upload->getError(), 'url' => '/Img/2wma.jpg'));
		}else{// 上传成功
			$picture_url='/Uploads/' . $info['savepath'] . $info['savename'];
			$this->ajaxreturn(array('code' => 1, 'msg' => '上传成功！', 'url' => $picture_url));
		}
	}
}
