<?php
include_once('../config/init.php');

$action = isset($_GET['action']) ? $_GET['action'] : "";

if($action == "register")
{
  $username = isset($_POST['username']) ? $_POST['username'] : '';

  $user = $db->select()->from("user")->where("username = '$username'")->find();

  //用户已被注册
  if($user)
  {
    return json("用户已被注册");
    exit;
  }

  //生成密码盐
  $salt = $string->string();

  //将密码和盐一起加密
  $password = md5(trim($_POST['password']).$salt);

  $data = [
    "username"=>$_POST['username'],
    "password"=>$password,
    "salt"=>$salt,
    "createtime"=>time(),
  ];

  //插入数据库
  if($db->add("user",$data))
  {
    return json('注册成功',true);
  }else{
    return json('注册失败');
  }
}else if($action == "login")
{
  if($_POST)
  {
    $username = trim($_POST['username']);

    $user = $db->select()->from("user")->where("username = '$username'")->find();

    if(!$user)
    {
      return json("用户不存在");
      exit;
    }

    //判断密码 md5 是不可逆
    $salt = $user['salt'];
    $password = md5(trim($_POST['password']).$salt);

    //密码不正确
    if($password != $user['password'])
    {
      return json("密码不正确");
      exit;
    }else{

      //登录成功
      unset($user['password']);
      unset($user['salt']);

      return json('登录成功',true,$user);
      exit;
    }

  }
}


?>