<?php
include_once('../config/init.php');

$action = isset($_GET['action']) ? $_GET['action'] : "";

if($action == "province")
{
  $province = $db->select()->from("region")->where("parent_id = 1")->all();

  return json("",true,$province);
}else if($action == "city")
{
  $provinceid = isset($_POST['provinceid']) ? $_POST['provinceid'] : 0;

  $city = $db->select()->from("region")->where("parent_id = $provinceid")->all();

  return json("",true,$city);
}else if($action == "area")
{
  $cityid = isset($_POST['cityid']) ? $_POST['cityid'] : 0;

  $city = $db->select()->from("region")->where("parent_id = $cityid")->all();

  return json("",true,$city);
}


?>