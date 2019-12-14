<?php
include_once('../config/init.php');

$action = isset($_GET['action']) ? $_GET['action'] : "";

if($action == "addredit")
{
  
  $ressid = isset($_POST['ressid']) ? $_POST['ressid'] : 0;


  $editdata = $db->select()->from("user_address")->where("id = $ressid")->find();

  return json("",true,$editdata);
}
else if($action =="edit")
{
  // $poss=isset($_POST) ? $_POST : "";

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

  if($db->update("user_address",$data,"id = ".$_POST['id']))
    {
      return json("编辑成功",true);
    }else{
      return json("编辑失败");
    }
}

?>