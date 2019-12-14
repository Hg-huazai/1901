<?php
@session_start();
header("Content-Type:text/html;charset=utf-8");


//php5.6一下才有 自动加载函数
//当检测到某个类不存在的时候，会通过autoload这个方法尝试进行加载
function __autoload($name)
{
  include_once("extends/$name.php");
}

//数据库类
$db = new DB("localhost","root","root","food");

//字符串类
$string = new Text();

include_once("helpers.php");


?>