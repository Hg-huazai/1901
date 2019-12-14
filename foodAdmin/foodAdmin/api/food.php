<?php
include_once('../config/init.php');

$action = isset($_GET['action']) ? $_GET['action'] : "";

if($action == "hot")
{
  $top = $db->select()->from("food")->where("status = 'top'")->limit("10")->all();

  $hot = $db->select()->from("food")->where("status = 'hot'")->limit("10")->all();

  $data = [
    "top"=>$top,
    "hot"=>$hot,
  ];

  return json("",true,$data);
}else if($action == "catelist")
{
  $result = [
    [
      "id"=>"0",
      "name"=>"全部"
    ]
  ];
  $catelist = $db->select()->from('cate')->all();

  $catelist = array_merge($result,$catelist);

  return json("",true,$catelist);
}else if($action == "foodlist")
{
  $cateid = isset($_POST['cateid']) ? $_POST['cateid'] : 0;
  $page = isset($_POST['page']) ? $_POST['page'] : 1;
  $limit = 10;
  $start = ($page-1)*$limit;

  $where = "1";

  if($cateid)
  {
    $where = "cateid = $cateid";
  }

  $foodlist = $db->select()->from('food')->where($where)->limit("$start,$limit")->all();

  if($foodlist)
  {
    return json("",true,$foodlist);
  }else{
    return json("",false,$foodlist);
  }

  
}else if($action == "cartedit")
{
  //添加购物车
  $foodid = isset($_POST['foodid']) ? $_POST['foodid'] : 0;
  $userid = isset($_POST['userid']) ? $_POST['userid'] : 0;

  $food = $db->select()->from("food")->where("id = $foodid")->find();

  if(!$food)
  {
    return json("该食品不存在");
  }

  //用户是否存在
  $user = $db->select()->from("user")->where("id = $userid")->find();

  if(!$user)
  {
    return json("用户不存在");
  }

  $cart = $db->select()->from("cart")->where("foodid = $foodid AND userid = $userid")->find();

  $foodnum = isset($_POST['foodnum']) ? $_POST['foodnum'] : 1;
  $price = $foodnum*$food['price'];

  if($cart)
  {
    $data = [
      'foodnum'=>$foodnum,
      "foodprice"=>$price
    ];

    if($foodnum <= 0)
    {
      if($db->delete("cart","id = ".$cart['id']))
      {
        return json("删除购物车数据成功",true);
      }else{
        return json("删除购物车数据失败");
      }
    }

    //update
    if($db->update("cart",$data,"id = ".$cart['id']))
    {
      return json("更新购物车成功",true);
    }else{
      return json("更新购物车失败");
    }
  }else{
    $data = [
      'foodnum'=>$foodnum,
      "foodprice"=>$price,
      'userid'=>$userid,
      "foodid"=>$foodid
    ];

    if($db->add("cart",$data))
    {
      return json('添加购物车成功',true);
    }else{
      return json('添加购物车失败');
    }
  }

}else if($action == "cartdata")
{
  $userid = isset($_POST['userid']) ? $_POST['userid'] : 0;

  //用户是否存在
  $user = $db->select()->from("user")->where("id = $userid")->find();

  if(!$user)
  {
    return json("用户不存在");
  }

  $cart = $db->select("cart.*,food.name,food.thumb,food.price")->from("cart")->join("food","cart.foodid = food.id")->where("cart.userid = $userid")->all();

  $foodcount = 0;
  $foodprice = 0;

  if($cart)
  {
    foreach($cart as $item)
    {
      $foodcount += $item['foodnum'];
      $foodprice += $item['foodprice'];
    }
  }

  $data = [
    "foodcount"=>$foodcount,
    "foodprice"=>$foodprice,
    "cartdata"=>$cart
  ];

  return json("",true,$data);
}


?>