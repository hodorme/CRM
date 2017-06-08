<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/3/31
 * Time: 10:48
 */
$a= Array(0 => Array('day' => '2017-03-28','reg_count' => 14),1=> Array('day' => '2017-03-27','reg_count' => 53));
$b=Array(0 => Array('day' => '2017-03-29', 'pay_count' => 2), 1 => Array('day' => '2017-03-28', 'pay_count' => 12));
$res = array();
$c =array_merge($a,$b);
foreach($c as $v){
    $res[$v['day']]['day'] =$v['day'];
    if(isset($v['reg_count'])){
        $res[$v['day']]['reg_count'] =$v['reg_count'];
    }
    if(isset($v['pay_count'])){
        $res[$v['day']]['pay_count'] =$v['pay_count'];
    }
    var_dump($v);
}
die;
var_dump($res);var_dump($c);die;