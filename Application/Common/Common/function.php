<?php
/**
 * 功能说明：根据传递条件直接输出百分比结果
 * 参数：$map 订单条件
 * 返回值： by watson
 * 时间：2017.3.12
 */
/*提供给外部访问的layTree*/
function getLayTree($biao,$nameField,$parentid=0,$treeArray=array()){
    $rlt =getTree($biao,$nameField,$parentid=0,$treeArray=array());
    return json_encode($rlt);
}
/*为getTree提供子节点数据的函数*/
function getChild($biao,$parentid=0)
{
    // 获取父节点下的所有子节点
    $map['parid'] = $parentid;
    $rs = D($biao)->where($map)->order('id')->select();
    $results=array();//声明一个空数组，方便装入子分类。
    foreach($rs as $val)//通过while循环抓取返回给$child
    {
        $results[]=$val;//把子分类组里的数据插入到$results这个数组中
    }
    return $results;//把结果返回给函数。
}
/*递归产生的树型数据源*/
function getTree($biao,$nameField,$parentid=0,$treeArray=array())
{
    $child =getChild($biao,$parentid);//返回的是形参输入的父id下面的子分类组。
    foreach($child as $rss)
    {
        $nodes_val = getTree($biao,$nameField,$rss['id'],$nodes_val);//函数回调，形成一个循环。
        $tags_val =count($nodes_val);
        if($nodes_val[0]===null){$nodes_val=null;}
        $treeArray[]=array(
            'id'=>$rss['id'],
            'name'=>$rss[$nameField],
            'children'=>$nodes_val,
        );//将默认传入的一个空数组装入子分类的数据。　
        $nodes_val= []; //清空
    }
    return $treeArray;//return装着子分类的数组，返回给函数，
}
function getBFB($num1, $num2) {
    $num = false;
    if(is_numeric($num1) && is_numeric($num2)) {
        $num = ( $num1 / $num2 ) * 100 ."%";
        return $num;
    } else {
        return $num;
    }
}
/**
 * 功能说明：根据传递条件直接输出相关费用统计
 * 参数：$map 订单条件
 * 返回值： by watson
 * 时间：2017.2.25

function ShowExpoFee($map,$sclassid,$bmid){
//var_dump("1");die;
$opclassidtj="";
$bxopclassidtj="";
if($sclassid){
$opclassidtj=" AND opclassid in(".$sclassid.")";
$bxopclassidtj=" AND classid in(".$sclassid.")";
}
$bmidtj="";
if($bmid){
$bmidtj=" AND userid in(select id from Ww_users where bmid=" . $bmid . " or bmid in (select id from Ww_bumen where charindex('," .$bmid . "',parpath)>0))";
}

$cgmap = " AND orderstatus='有效订单'$opclassidtj";
$odmap = " AND CHARINDEX(orderstatus, '待审核,有效订单,已退展订单')>0$opclassidtj$bmidtj";
$extj="expoid in(select id from Ww_expo where $map)";
$otj="oid in(select id from Ww_orders where ".$extj."".$odmap.")";
$cgtj=$extj.$cgmap;
$bxtj=$extj." AND zhuangtai='报销成功'$bxopclassidtj";
$Expo_model=D('Expo');
$fy_model=M('orders_fy');
$yh_model=M('orders_yh');
$fyong_model=M('orders_fanyong');
$rl_model=M('cw_daozhang_rl');
$PurchaseOrder_model=D('PurchaseOrder');
$fk_model=M('fukuandan');
$bx_model=M('cw_baoxiao');
$zongj=$fy_model->where($otj)->sum('ptotal');//报价总计
$youhui=$yh_model->where($otj)->sum('jine');//优惠金额
$result['youhui']=$youhui;
$fyong=$fyong_model->where($otj." AND (isnd=0 or isnd is null)")->sum('jine');//正常返佣金额
$result['fyong']=$fyong;
$ndfyong=$fyong_model->where($otj." AND isnd=1")->sum('jine');//年底返佣
//var_dump($otj." AND isnd=1");die;
$result['ndfyong']=$ndfyong?$ndfyong:0;
$tuikuan=$fk_model->where($otj." AND istk=1 and tktype=0 and zhuangtai='付款成功'")->sum('renminbi');//已退款金额
$result['tuikuan']=$tuikuan;
//应收
$result['yshou']=round($zongj-$youhui-$fyong-$tuikuan,2);
//实收（已经分配金额）
$result['sshou']=round($rl_model->where($otj." and shstatus='已分配'")->sum('fpjine'),2);
//待收金额
$result['dshou']=round($result['yshou']-$result['sshou'],2);
//应付金额
$result['yfu'] = round($PurchaseOrder_model->where($cgtj)->sum('renminbi'), 2);
//实付金额
$result['sfu'] = round($fk_model->where("zhuangtai='付款成功' and oid in(select id from Ww_cgorders where $cgtj)")->sum('renminbi'), 2);
//待付金额
$result['dfu']=round($result['yfu']-$result['sfu'],2);
//其他支出
$result['qtzc'] = round($bx_model->where($bxtj)->sum('zongjine'), 2);
return  $result;
}
 *  */
/**
 * 功能说明：根据传递条件直接输出相关费用统计
 * 参数：$map 订单条件
 * 返回值： by watson
 * 时间：2017.2.25

function ShowExpoFee($map,$sclassid,$bmid){
    //var_dump("1");die;
    $opclassidtj="";
    $bxopclassidtj="";
    if($sclassid){
        $opclassidtj=" AND opclassid in(".$sclassid.")";
        $bxopclassidtj=" AND classid in(".$sclassid.")";
    }
    $bmidtj="";
    if($bmid){
        $bmidtj=" AND userid in(select id from Ww_users where bmid=" . $bmid . " or bmid in (select id from Ww_bumen where charindex('," .$bmid . "',parpath)>0))";
    }

    $cgmap = " AND orderstatus='有效订单'$opclassidtj";
    $odmap = " AND CHARINDEX(orderstatus, '待审核,有效订单,已退展订单')>0$opclassidtj$bmidtj";
    $extj="expoid in(select id from Ww_expo where $map)";
    $otj="oid in(select id from Ww_orders where ".$extj."".$odmap.")";
    $cgtj=$extj.$cgmap;
    $bxtj=$extj." AND zhuangtai='报销成功'$bxopclassidtj";
    $Expo_model=D('Expo');
    $fy_model=M('orders_fy');
    $yh_model=M('orders_yh');
    $fyong_model=M('orders_fanyong');
    $rl_model=M('cw_daozhang_rl');
    $PurchaseOrder_model=D('PurchaseOrder');
    $fk_model=M('fukuandan');
    $bx_model=M('cw_baoxiao');
    $zongj=$fy_model->where($otj)->sum('ptotal');//报价总计
    $youhui=$yh_model->where($otj)->sum('jine');//优惠金额
    $result['youhui']=$youhui;
    $fyong=$fyong_model->where($otj." AND (isnd=0 or isnd is null)")->sum('jine');//正常返佣金额
    $result['fyong']=$fyong;
    $ndfyong=$fyong_model->where($otj." AND isnd=1")->sum('jine');//年底返佣
    //var_dump($otj." AND isnd=1");die;
    $result['ndfyong']=$ndfyong?$ndfyong:0;
    $tuikuan=$fk_model->where($otj." AND istk=1 and tktype=0 and zhuangtai='付款成功'")->sum('renminbi');//已退款金额
    $result['tuikuan']=$tuikuan;
    //应收
    $result['yshou']=round($zongj-$youhui-$fyong-$tuikuan,2);
    //实收（已经分配金额）
    $result['sshou']=round($rl_model->where($otj." and shstatus='已分配'")->sum('fpjine'),2);
    //待收金额
    $result['dshou']=round($result['yshou']-$result['sshou'],2);
    //应付金额
    $result['yfu'] = round($PurchaseOrder_model->where($cgtj)->sum('renminbi'), 2);
    //实付金额
    $result['sfu'] = round($fk_model->where("zhuangtai='付款成功' and oid in(select id from Ww_cgorders where $cgtj)")->sum('renminbi'), 2);
    //待付金额
    $result['dfu']=round($result['yfu']-$result['sfu'],2);
    //其他支出
    $result['qtzc'] = round($bx_model->where($bxtj)->sum('zongjine'), 2);
    return  $result;
}
 *  */
/**
 * 功能说明：根据传递条件直接输出订单的相关费用统计
 * 参数：$map 订单条件
 * 返回值： by watson
 * 时间：2017.2.12
 */
function ShowYingshou($map){
    //var_dump($map);die;
    ///*
    $fy_model=M('orders_fy');
    $yh_model=M('orders_yh');
    $fyong_model=M('orders_fanyong');
    $rl_model=M('cw_daozhang_rl');
    $fk_model=M('fukuandan');
    $otj="oid in(select id from Ww_orders where $map)";
    $zongj=$fy_model->where($otj)->sum('ptotal');//报价总计
    $youhui=$yh_model->where($otj)->sum('jine');//优惠金额
    $result['youhui']=$youhui;
    $fyong=$fyong_model->where($otj." and (isnd=0 or isnd is null)")->sum('jine');//正常返佣金额
    $result['fyong']=$fyong;
    $tuikuan=$fk_model->where($otj." and istk=1 and tktype=0 and zhuangtai='付款成功'")->sum('renminbi');//已退款金额
    $result['tuikuan']=$tuikuan;
    //应收
    $result['yshou']=round($zongj-$youhui-$fyong-$tuikuan,2);
    //实收（已经分配金额）
    $result['sshou']=round($rl_model->where($otj." and shstatus='已分配'")->sum('fpjine'),2);
    //待收金额
    $result['dshou']=$result['yshou']-$result['sshou'];
    //*/
    return  $result;
}
/**
 * 功能说明：根据传递条件直接输出展会或者订单的相关费用统计
 * 参数：$expoid 展会的ID 支持多个 $oid 订单ID 支出多个 $uid 用户ID 支出多个
 * 使用实例：
    $tongji=ShowTongji($idx,'expo');   //根据展会输出统计
    $tongji=ShowTongji($idx,'oid');     //根据订单输出统计
    $tongji=ShowTongji($idx,'uid');     //根据人员输出统计
 * 返回值： by watson
 * 时间：2017.1.12
 */
function ShowTongji($idx,$what){
    $fy_model=M('orders_fy');
    $yh_model=M('orders_yh');
    $fyong_model=M('orders_fanyong');
    $rl_model=M('cw_daozhang_rl');
    $PurchaseOrder_model=D('PurchaseOrder');
    $fk_model=M('fukuandan');
    $bx_model=M('cw_baoxiao');
    if($what=='expo'){
        $tj="expoid in($idx)";
    }else if($what=='oid'){
        $tj="oid in($idx)";
    }else if($what=='uid'){
        $tj="userid in($idx)";
    }
    $cgtj=$tj."and orderstatus='有效订单'";
    $otj="oid in(select id from Ww_orders where $tj and CHARINDEX(orderstatus, '待审核,有效订单,已退展订单,待退/转展订单,已转展订单')>0)";
    $zongj=$fy_model->where($otj)->sum('ptotal');//报价总计
    $youhui=$yh_model->where($otj)->sum('jine');//优惠金额
    $result['youhui']=$youhui;//正常返佣金额
    $fyong=$fyong_model->where($otj." and (isnd=0 or isnd is null)")->sum('jine');//正常返佣金额
    $result['fyong']=$fyong;//正常返佣金额
    $tuikuan=$fk_model->where($otj." and istk=1 and tktype=0 and zhuangtai='付款成功'")->sum('renminbi');//已退款金额
    $result['tuikuan']=$tuikuan;//已退款金额
    //应收
    $result['yshou']=round($zongj-$youhui-$fyong-$tuikuan,2);
    //实收（已经分配金额）
    $result['sshou']=round($rl_model->where($otj." and shstatus='已分配'")->sum('fpjine'),2);
    //待收金额
    $result['dshou']=$result['yshou']-$result['sshou'];
    if($what=='oid'){
        $result['fytj1'] = round($fy_model->where($tj." AND pid in(12,13,17,45)")->sum('ptotal'), 2);
        $result['fytj2'] = round($fy_model->where($tj." AND pid in(14)")->sum('ptotal'), 2);
        $result['fytj3'] = round($fy_model->where($tj." AND pid in(33)")->sum('ptotal'), 2);
        $result['fytj4'] = round($fy_model->where($tj." AND pid in(6)")->sum('ptotal'), 2);
        $result['fytj5'] = round($fy_model->where($tj." AND pid in(11)")->sum('ptotal'), 2);
        $result['fytj6'] = round($fy_model->where($tj." AND pid in(15)")->sum('ptotal'), 2);
        $result['fytj7'] = round($fy_model->where($tj." AND pid in(22,36,37,44,46)")->sum('ptotal'), 2);
        $result['fytj8'] = round($fy_model->where($tj." AND pid in(21)")->sum('ptotal'), 2);
        $result['fytj9'] = round($fy_model->where($tj." AND pid in(20)")->sum('ptotal'), 2);
    }
    if($what=='expo'){
        //应付金额
        $result['yfu'] = round($PurchaseOrder_model->where($cgtj)->sum('renminbi'), 2);
        //实付金额
        $result['sfu'] = round($fk_model->where("zhuangtai='付款成功' and oid in(select id from Ww_cgorders where $cgtj)")->sum('renminbi'), 2);
        //其他支出
        $result['qtzc'] = round($bx_model->where("zhuangtai='报销成功' and $tj")->sum('zongjine'), 2);
//        $Orders_model=D('Orders');
//        //签约情况
//        $result['qyqy'] = $Orders_model->where($tj." and id in(select MAX([id]) from Ww_orders where $tj and opclassid in(1,2) and charindex(orderstatus,'有效订单,待审核')>0 group by cid)")->count();
//        $result['oid1'] = $Orders_model->where($tj." and opclassid in(1) and charindex(orderstatus,'有效订单,待审核')>0")->count();
//        $result['oid2'] = $Orders_model->where($tj." and opclassid in(2) and charindex(orderstatus,'有效订单,待审核')>0")->count();
//        $result['oid3'] = $Orders_model->where($tj." and charindex(orderstatus,'待退/转展订单,已转展订单,已退展订单')>0")->count();
//        $result['oid4'] = $Orders_model->where($tj." and charindex(orderstatus,'有效意向单')>0 and (qydate is null)")->count();
//        $result['oid5'] = $Orders_model->where($tj." and charindex(orderstatus,'已挂单')>0")->count();
//        //面积情况
//        $OrdersBooth_model=D('OrdersBooth');
//        $result['mianji1'] = $PurchaseOrder_model->where($tj." and charindex(orderstatus,'有效订单,待审核')>0")->sum('mianji');
//        $result['mianji3'] = $OrdersBooth_model->where("oid in(select id from Ww_orders where $tj and charindex(orderstatus,'有效订单,待审核')>0)")->sum('mianji');
//        $result['mianji4'] = $OrdersBooth_model->where("oid in(select id from Ww_orders where $tj and charindex(orderstatus,'待退/转展订单,已转展订单,已退展订单')>0)")->sum('mianji');
//        //随团情况
//        $OrdersRy_model=D('OrdersRy');
//        $result['st1'] = $OrdersRy_model->where("oid in(select id from Ww_orders where $tj and opclassid=2) or (oid=0 and $tj)")->count();
//        $result['st2'] = $OrdersRy_model->where("oid in(select id from Ww_orders where $tj and opclassid=1)")->count();
    }
    return  $result;
}
/**
 * 功能说明：根据传递参数直接输出业绩相关数据
 * 参数：
 * 返回值： by watson
 */
function ShowArrayYeji($topnum,$what){
    if($what=="nian"){
        $where="charindex('2016',qydate)>0";
    }
    $sql="select top $topnum sum(yeji) as aa,userid from Ww_view_yeji
          where id in(Select id from Ww_orders where $where and orderstatus='有效订单') and userid in(Select id from Ww_users where ustatus='在职' and username<>'admin')
          group by userid order by aa desc";
    $rlt=D('Yeji')->query($sql);
    $Users_model=D('Users');
    for($i=0;$i<count($rlt);$i++)
    {
            $rlt[$i]['userid']=$Users_model->getUserName($rlt[$i]['userid']);
    }
    $result['categories']=array_column($rlt, 'userid');
    $result['data']=array_column($rlt, 'aa');
    return  $result;
}
/**
 * 功能说明：根据当前用户ID返回操作权限
 * 参数：$uid 用户系统ID
 * 返回值：变量
 */
function getUserCzqx(){
    //通过session中uid获取juese；
    $map['id']=$_SESSION['uid'];
    $zwid=D('Users')->where($map)->getField('zwid');
    //通过角色获取一个或多个roleid值；
    $map_role['id'] =array('eq',$zwid);
    //$map_role['id'] =array('in',$zwid);
    $rlt=D('Role')->where($map_role)->getField('czqx');
    //var_dump($rlt);die;
    return $rlt;
}
/**
 * 功能说明：根据当前用户ID和SID参数返回菜单权限
 * 参数：sid 指菜单功能中的sid字段（父节点）
 * 返回值：菜单ID，菜单名称
 */
function initMenu($param_sid,$operators,$display_flag){
    //通过session中uid获取juese；
    $map['id']=$_SESSION['uid'];
    $zwid=D('Users')->where($map)->getField('zwid');
    //通过角色获取一个或多个roleid值；
    $map_role['id'] =array('eq',$zwid);
    $rlt =D('Role')->where($map_role)->select();
    //构建用逗号隔开的多个角色ID；
    $str ='';
    foreach($rlt as $key => $value){
        $str.= $value['qx'].',';
    }
    //var_dump($rlt);die;
    $str=substr($str,0,strlen($str) - 1);
    $map_menu['id']=array('in',$str);
    if($display_flag){
        $map_menu['display_flag']=array('in',$display_flag);
    }
    $map_menu['sid']=array($operators,$param_sid);
    $menu_model=D('Menu');
    $list=$menu_model->where($map_menu)->order('seq asc')->select();
    return $list;
}
/**
 * 功能说明：根据传递参数直接输出数组
 * 参数：
 * 返回值： by watson
 */
function ShowArray($biao,$where,$field){
    $rlt=D($biao)->field($field)->where($where)->select();
    foreach($rlt as $key=>$val) {
        $rlt[$key] =$val[$field];
//        foreach($rlt as $key=>$val) {
//            $arr = explode(',', $field);
//            $list="";
//            for($i=0;$i<count($arr);$i++){
//                if($i>0){
//                    $list=$list.'|'.$val[$arr[$i]];
//                }else{
//                    $list=$val[$arr[$i]];
//                }
//            }
//            $rlt[$key]=$list;
//        }
    }
    return json_encode($rlt);
}
function ShowZdy($a,$b){
    $rlt[0]=$a;
    $rlt[1]=$b;
    return json_encode($rlt);
}
/**
 * 功能说明：根据传递的变量分解并输出表头
 * 参数：ziduan 指菜传递的表头变量
 * 返回值：表格表头
 */
function showThead($ziduan){
    $thead="";
    $arr=explode(',','id,'.$ziduan);
    $count = count($arr);
    for($i=0;$i<$count;$i++){
        $thead.="<th>".$arr[$i]."</th>";
    }
    return $thead;
}
/**
 * 功能说明：返回编码类型
 * 作者：watson  2016-8-10
 */
function ShowClassList($code){
    //$what=new \Think\Model();
    //$sql="select * from ww_class where parid in(select id from ww_class where code='".$code."')";
   // $list=$what->query($sql);
    //return $list;
}
//算一年多少周，同时计算出这一周的开始时间和结束时间（可选返回时间戳或日期）
function getWeekStartAndEnd($year,$week=1){
    $year = (int)$year;
    $week = (int)$week;
    //按给定的年份计算本年周总数
    $date = new DateTime;
    $date->setISODate($year, 53);
    $weeks = max($date->format("W"),52);
    //如果给定的周数大于周总数或小于等于0
    if($week>$weeks || $week<=0){
        return false;
    }
    //如果周数小于10
    if($week<10){
        $week = '0'.$week;
    }
    //当周起止时间戳
    $timestamp['start'] = strtotime($year.'W'.$week);
    $timestamp['end'] = strtotime('+1 week -1 day',$timestamp['start']);
    //当周起止日期
    $timeymd['start'] = date("Y-m-d",$timestamp['start']);
    $timeymd['end'] = date("Y-m-d",$timestamp['end']);
    
    //返回起始时间戳
    return $timestamp;
    //返回日期形式
    // return $timeymd;
}
//生成随机英文字母
function randStr($i){
    $str = "ABCEFGHJKMNPQRSWXYZ";
    $finalStr = "";
    for($j=0;$j<$i;$j++)
    {
        $finalStr .= substr($str,rand(0,25),1);
    }
    return $finalStr;
}
//生成随机数字
function ShowOno() {
    $sjno=date(Ymdhis).rand(100,200).session('uid');
    return $sjno;
}
//查询条件批处理
//function getSearch($_REQUEST) {

//}
//显示系统编码名
function ShowCodeName($id) {
	$date=M('sys_code');
    $where['id']=array('eq',$id);
    $rlt=$date->where($where)->getField('name');
    return $rlt;
}
//显示系统编码名
function ShowCodeNameByCode($code) {
    $Code_model=D('Code');
    $where['code']=array('eq',$code);
    $rlt=$Code_model->where($where)->getField('name');
    return $rlt;
}
//显示客户名
function ShowCusName($id) {
    $date=D('Customer');
    $where['id']=$id;
    $list=$date->field('name')->where($where)->find();
    return $list['name'];
}
//显示关联字段名
function ShowName($biao,$id,$name) {
    $date=M($biao);
    $where['id']=$id;
    $list=$date->field($name)->where($where)->find();
    return $list[$name];
}
//显示列表
function ShowList($biao,$where,$orderby) {
    $date=D($biao);
    //if($biao=='users'){
    //    $where.=" and status='正常'";
    //}
    if($biao=='Products'){
        $where.=" AND ptype<>'采购目录'";
    }
    $list=$date->where($where)->order($orderby)->select();
    //var_dump($where);die;
    return $list;
}
//读取编码子类
function ShowCode($name,$orderby){
    $what=new \Think\Model();
    $sql="select * from ww_sys_code where sid in(select id from ww_sys_code where name='".$name."')";
    $list=$what->query($sql);
    return $list;
}
//读取编码二级子类
function Show2Code($name,$orderby){
    $what=new \Think\Model();
    $sql="select * from ww_sys_code  where sid in(
      select id from ww_sys_code where sid in(
      select id from ww_sys_code where name ='".$name."')) ";
    $list=$what->query($sql);
    return $list;
}

//取子分类
function SidType($sid,$biao){
    $what=M($biao);
	$list=$what->where('sid='.$sid)->order('seq')->select();
	return $list;
}

//读取明细
function EdtAjax(){
}
//写入操作日志
function WriteLog($note){
    $data['actime']=date("Y-m-d H:i:s");
    $data['uid']=session('uid');
    $data['uname']=session('uname');
    $data['acip']=get_client_ip();
    $data['note']=$note;
    $data['actype']="PC"; //客户端类型
    $log= M('sys_log');
    $result=$log->add($data); 
}
//消息列表
function ShowMsg($isread){
	$msg=M('sys_msg');
	$isread=($isread==0)?" and isread='0'":"";
	$where['jsren']=$uid;
    $list=$msg->where($where)->order('id')->select();
	return $list;
}
function strip_textarea($string){
	return nl2br(str_replace(' ', '&nbsp;', htmlspecialchars($string, ENT_QUOTES)));
}
/**
** 截取中文字符串
**/
function msubstr($str, $start=0, $length, $charset="utf-8", $suffix=true){
	if(function_exists("mb_substr")){
		$slice= mb_substr($str, $start, $length, $charset);
	}elseif(function_exists('iconv_substr')) {
		$slice= iconv_substr($str,$start,$length,$charset);
	}else{
		$re['utf-8'] = "/[x01-x7f]|[xc2-xdf][x80-xbf]|[xe0-xef][x80-xbf]{2}|[xf0-xff][x80-xbf]{3}/";
		$re['gb2312'] = "/[x01-x7f]|[xb0-xf7][xa0-xfe]/";
		$re['gbk'] = "/[x01-x7f]|[x81-xfe][x40-xfe]/";
		$re['big5'] = "/[x01-x7f]|[x81-xfe]([x40-x7e]|xa1-xfe])/";
		preg_match_all($re[$charset], $str, $match);
		$slice = join("",array_slice($match[0], $start, $length));
	}    
	$fix='';
	if(strlen($slice) < strlen($str)){
		$fix='';
	}
	return $suffix ? $slice.$fix : $slice;
}

/**
* 弹窗
* @param string $_info
* @return js
*/
function alert($_info) {
	echo "<script>alert('$_info');</script>";
	//exit();
}

/**
 * js 弹窗并且跳转
 * @param string $_info
 * @param string $_url
 * @return js
 */
function alertLocation($_info, $_url) {
	echo "<script type='text/javascript'>alert('$_info');location.href='$_url';</script>";
	exit();
}
function getSessionOrgId(){
    return array($_SESSION['orgid']);
}
?>





