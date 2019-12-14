<?php
include_once('../config/init.php');

$action = isset($_GET['action']) ? $_GET['action'] : "";

if($action == "add")
{
  $userid = isset($_POST['userid']) ? $_POST['userid'] : 0;

  $user = $db->select()->from("user")->where("id = $userid")->find();

  //用户不存在
  if(!$user)
  {
    return json("用户不存在");
    exit;
  }

  $data = [
    "name"=>$_POST['name'],
    "phone"=>$_POST['phone'],
    "province"=>$_POST['province'],
    "city"=>$_POST['city'],
    "area"=>$_POST['area'],
    "status"=>isset($_POST['status']) ? $_POST['status'] : 0,
    "userid"=>$_POST['userid'],
    "address"=>$_POST['address'],
  ];

  //插入数据库
  if($db->add("user_address",$data))
  {
    return json('添加收货地址成功',true);
  }else{
    return json('添加失败');
  }
}else if($action == "list")
{
  $userid = isset($_POST['userid']) ? $_POST['userid'] : 0;

  $user = $db->select()->from("user")->where("id = $userid")->find();

  //用户不存在
  if(!$user)
  {
    return json("用户不存在");
    exit;
  }
  $dbprefix = $db->dbprefix;
  $sql = "SELECT address.*,province.region_name AS provinceName,city.region_name AS cityName,area.region_name AS areaName FROM {$dbprefix}user_address AS address LEFT JOIN {$dbprefix}region AS province ON address.province = province.region_id LEFT JOIN {$dbprefix}region AS city ON address.city = city.region_id LEFT JOIN {$dbprefix}region AS area ON address.area = area.region_id WHERE address.userid = $userid";
  $addrlist = $db->query($sql);
  return json("收货地址",true,$addrlist);
}else if($action == "addrdefault")
{
  //获取用户的默认收货地址
  $userid = isset($_POST['userid']) ? $_POST['userid'] : 0;

  $user = $db->select()->from("user")->where("id = $userid")->find();

  //用户不存在
  if(!$user)
  {
    return json("用户不存在");
    exit;
  }
  $dbprefix = $db->dbprefix;
  $sql = "SELECT address.*,province.region_name AS provinceName,city.region_name AS cityName,area.region_name AS areaName FROM {$dbprefix}user_address AS address LEFT JOIN {$dbprefix}region AS province ON address.province = province.region_id LEFT JOIN {$dbprefix}region AS city ON address.city = city.region_id LEFT JOIN {$dbprefix}region AS area ON address.area = area.region_id WHERE address.userid = $userid";
  $addrlist = $db->query($sql);

  if($addrlist)
  {
    return json("默认地址",true,$addrlist[0]);
  }else{
    return json("无默认收货地址");
  }



}

?>