<?php
@session_start();
include_once('extends/Captcha.php');


//实例化验证码类
$ob = new Captcha;

//生成验证码
$ob->entry();


//获取验证码
$imgcode = $ob->verify();

$_SESSION['imgcode'] = $imgcode;
?>