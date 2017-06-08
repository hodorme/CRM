<?php
namespace Home\Controller;
use Think\Controller;
class CommonController extends Controller {

	//功能类似构造方法,率先执行的方法
	public function _initialize(){
		// echo '你调用了我';
		// 用户的登录检测
		// $id = session('user.id');
		// $data = session('inru');
		// $ddqx = session('inruqx');
      	// $this->assign('data',$data);
		// VAR_DUMP($_SESSION);die;
		//检测
		// if(empty($id)){
			// 没有登录
			// $this->error('您还没有登录',U('Home/Login/index'),2);
		// }

			//权限验证
			// $AUTH = new \Think\Auth();
			// //类库位置应该位于ThinkPHP\Library\Think\
			// if(!$AUTH->check(MODULE_NAME.'/'.CONTROLLER_NAME.'/'.ACTION_NAME, session('id'))){
			//            $this->error('没有权限',U('Home/Index/index'));
			// }
	}
}






