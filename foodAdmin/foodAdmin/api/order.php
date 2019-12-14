<?php
include_once('../config/init.php');

$action = isset($_GET['action']) ? $_GET['action'] : "";

if($action == "orderadd")
{
  //获取用户的默认收货地址
  $userid = isset($_POST['userid']) ? $_POST['userid'] : 0;

  // 优惠券
  $couponid=isset($_POST['couponid']) ? $_POST['couponid'] : 0;

  $user = $db->select()->from("user")->where("id = $userid")->find();

  //用户不存在
  if(!$user)
  {
    return json("用户不存在");
    exit;
  }

  // 优惠券来了
  if($couponid)
  {
    $coupon = $db->select()->from("coupon")->where("id = $couponid")->find();
  }

  // var_dump($coupon);

  $orderPrice = 0;
  $cartdata = $db->select()->from("cart")->where("userid = $userid")->all();

  foreach($cartdata as $item)
  {
    $orderPrice += $item['foodprice'];
  }

  if($coupon["cash"]){
    $orderPrice = $orderPrice - $coupon["cash"];
  }


  $userMoney = $user['money'] - $orderPrice;


  if($userMoney < 0)
  {
    return json("余额不足");
  }

  $ordersn = $string->string();

  $orderData = [
    "userid"=>$userid,
    "ordersn"=>$ordersn,
    "createtime"=>time(),
    'price'=>$orderPrice,
    "status"=>1,
    "addrid"=>$_POST['addrid'],
    "content"=>isset($_POST['content']) ? $_POST['content'] : ""
  ];

  //开启事务
  //添加订单order -> 订单商品表 order_food -> 消费记录表 user_log -> user 用户 -> 购物车
  $start = $db->transaction('start transaction');

  $orderRes = $db->add("order",$orderData);

  if(!$orderRes)
  {
    return json("下订单失败");
  }

  //订单商品表
  $orderFoodData = [];

  foreach($cartdata as $item)
  {
    $orderFoodData[] = [
      "orderid"=>$orderRes,
      "foodid"=>$item['foodid'],
      "foodnum"=>$item['foodnum'],
      "foodprice"=>$item['foodprice']
    ];
  }

  $orderFoodRes = $db->addAll("order_food",$orderFoodData);

  if(!$orderFoodRes)
  {
    //回滚
    $db->transaction("ROLLBACK");
    return json("订单商品添加失败");
  }


  //消费记录表
  $logData = [
    "desc"=>"订单：{$ordersn} 消费：{$orderPrice}",
    "userid"=>$userid,
    "price"=>$orderPrice,
    "createtime"=>time(),
    "status"=>1, //正常下单支付
  ];

  $logRes = $db->add("user_log",$logData);

  if(!$logRes)
  {
    $db->transaction("ROLLBACK");
    return json("添加消费记录失败");
  }

  //用户余额字段更新
  $userData = [
    'money'=>$userMoney
  ];

  $userRes = $db->update("user",$userData,"id = $userid");

  if(!$userRes)
  {
    $db->transaction("ROLLBACK");
    return json('用户余额更新失败');
  }

  //清空购物车
  $cartRes = $db->delete("cart","userid = $userid");
  
  if(!$cartRes)
  {
    $db->transaction("ROLLBACK");
    return json('更新购物车失败');
  }
  
  // 更新优惠券状态
  if($couponid){
    $coudata=["status"=>2, "ordersn"=>$ordersn,];
    $upcouponstatus=$db->update("coupon",$coudata,"id = $couponid");
    if(!$upcouponstatus){
        $db->transaction("ROLLBACK");
      return json('更新优惠券失败');
    }
  }

  if($orderRes && $orderFoodRes && $logRes && $userRes && $cartRes && $upcouponstatus)
  {
    $db->transaction('commit');
    return json("下单成功",true);
  }else{
    $db->transaction('ROLLBACK');
    return json('下单失败');
  }

}else if($action == "orderlist")
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

  $status = isset($_POST['status']) ? $_POST['status'] : 1;

  $sql = "SELECT * FROM {$db->dbprefix}order WHERE userid = $userid AND status = $status";
  
  $orderlist = $db->query($sql);

  return json("订单数据",true,$orderlist);

}else if($action == "ordermoudle")
{
  // 获取用户ID
  $userid = isset($_POST['userid']) ? $_POST['userid'] : 0;

  // 获取订单ID
  $orderid =isset($_POST['orderid'])? $_POST['orderid'] :0;



  // 获取订单数据
  // $ordermoudle = $db->select()->from("order")->where("id = $orderid")->find();
  $sql = "SELECT * FROM {$db->dbprefix}order  WHERE id = $orderid ";
  
  $ordermoudle = $db->query($sql);

  // var_dump($ordermoudle[0]['addrid']);
 
  //收获地址
  $orderaddress=$db->select()->from("user_address")->where("id=".$ordermoudle[0]['addrid'])->find();

  // 订单
  $orderuser=$db->select("order_food.*,food.name,food.thumb,food.price")->from("order_food")->join("food","order_food.foodid = food.id")->where("orderid= $orderid")->all();
// var_dump($orderuser);

  $foodcount = 0;
  $foodprice = 0;

  if($orderuser)
  {
    foreach($orderuser as $item)
    {
      $foodcount += $item['foodnum'];
      $foodprice += $item['foodprice'];
    }
  }

  //总价
  // $price=$db->select()->from("user_log")->where("orderid= $orderid")->all();

  $data=[
    "ordermoudle"=>$ordermoudle,
    "orderaddress"=> $orderaddress,
    "orderuser"=> $orderuser,
    "foodcount"=>$foodcount,
    "foodprice"=>$foodprice,
  ];

  return json("订单数据不存在",true,$data);
}
//确认收货
else if($action=="orderreceive")
{

  $orderid=isset($_POST['orderid'])?$_POST['orderid']:0;

  $data=[
    "status"=>2,
  ];

  $edit=$db->update("order",$data,"id=$orderid");

  if($edit)
  {
    return json("确认收货成功",true);
  }else{
    return json("确认收货失败",true);
  }

}
// 取消订单
else if($action=="ordercancel")
{

  $orderid=isset($_POST['orderid'])?$_POST['orderid']:0;

  $data=[
    "status"=>0,
  ];

  $edit=$db->update("order",$data,"id=$orderid");

  if($edit)
  {
    return json("已取消，订单待审核",true);
  }else{
    return json("取消订单失败",true);
  }

}else if($action == "orderagainadd")
{
  //获取用户的默认收货地址
  $userid = isset($_POST['userid']) ? $_POST['userid'] : 0;

  // 获取订单号
  $orderid = isset($_POST['orderid']) ? $_POST['orderid'] : 0;

  //收货地址号
  $addrid =isset($_POST['addrid'])? $_POST['addrid'] :0;

    // 优惠券
    $couponid=isset($_POST['couponid']) ? $_POST['couponid'] : 0;

  $user = $db->select()->from("user")->where("id = $userid")->find();

  //用户不存在
  if(!$user)
  {
    return json("用户不存在");
    exit;
  }

  // 优惠券来了
  if($couponid)
  {
    $coupon = $db->select()->from("coupon")->where("id = $couponid")->find();
  }

  //获取本次订单的数据
  $orderPrice = 0;
  $cartdata = $db->select()->from("order_food")->where("orderid = $orderid")->all();
  // var_dump($cartdata);

  foreach($cartdata as $item)
  {
    $orderPrice += $item['foodprice'];
  }

  if($coupon["cash"]){
    $orderPrice = $orderPrice - $coupon["cash"];
  }

  $userMoney = $user['money'] - $orderPrice;

  if($userMoney < 0)
  {
    return json("余额不足");
  }

  $ordersn = $string->string();

  $orderData = [
    "userid"=>$userid,
    "ordersn"=>$ordersn,
    "createtime"=>time(),
    'price'=>$orderPrice,
    "status"=>1,
    "addrid"=>$_POST['addrid'],
    "content"=>isset($_POST['content']) ? $_POST['content'] : ""
  ];

  //开启事务
  //添加订单order -> 订单商品表 order_food -> 消费记录表 user_log -> user 用户 -> 购物车
  $start = $db->transaction('start transaction');

  $orderRes = $db->add("order",$orderData);

  if(!$orderRes)
  {
    return json("下订单失败");
  }

  //订单商品表
  $orderFoodData = [];

  foreach($cartdata as $item)
  {
    $orderFoodData[] = [
      "orderid"=>$orderRes,
      "foodid"=>$item['foodid'],
      "foodnum"=>$item['foodnum'],
      "foodprice"=>$item['foodprice']
    ];
  }

  $orderFoodRes = $db->addAll("order_food",$orderFoodData);

  if(!$orderFoodRes)
  {
    //回滚
    $db->transaction("ROLLBACK");
    return json("订单商品添加失败");
  }


  //消费记录表
  $logData = [
    "desc"=>"订单：{$ordersn} 消费：{$orderPrice}",
    "userid"=>$userid,
    "price"=>$orderPrice,
    "createtime"=>time(),
    "status"=>1, //正常下单支付
  ];

  $logRes = $db->add("user_log",$logData);

  if(!$logRes)
  {
    $db->transaction("ROLLBACK");
    return json("添加消费记录失败");
  }

  //用户余额字段更新
  $userData = [
    'money'=>$userMoney
  ];

  $userRes = $db->update("user",$userData,"id = $userid");

  if(!$userRes)
  {
    $db->transaction("ROLLBACK");
    return json('用户余额更新失败');
  }

   // 更新优惠券状态
   if($couponid){
    $coudata=["status"=>2, "ordersn"=>$ordersn,];
    $upcouponstatus=$db->update("coupon",$coudata,"id = $couponid");
    if(!$upcouponstatus){
        $db->transaction("ROLLBACK");
      return json('更新优惠券失败');
    }
  }

  
  if($orderRes && $orderFoodRes && $logRes && $userRes && $upcouponstatus)
  {
    $db->transaction('commit');
    return json("下单成功",true);
  }else{
    $db->transaction('ROLLBACK');
    return json('下单失败');
  }
} 
//订单评价
else if($action == "ordercomment")
{
// 获取用户ID
$userdata= isset($_POST) ? $_POST : 0;
// var_dump($userdata);

// 获取订单ID
// $orderid =isset($_POST['orderid'])? $_POST['orderid'] :0;


$data=[
  "orderid"=>$userdata["orderid"],
  "content"=> $userdata["content"],
  "userid"=> $userdata["userid"],
  "level"=>$userdata["level"],
  "createtime"=>time(),
];

$commentdata=$db->add("order_comment",$data);

$statedata=[
  "status"=>3,
];

$upstate=$db->update("order",$statedata,"id =".$userdata["orderid"]);

if($commentdata && $upstate)
{
  return json("评论成功",true);
}else{
  return json("评论失败",true);
}
}


?>