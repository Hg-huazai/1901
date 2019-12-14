<?php
include_once('../config/init.php');

$action = isset($_GET['action']) ? $_GET['action'] : "";

if($action == "usertext")
{
  
  $ressid = isset($_POST['ressid']) ? $_POST['ressid'] : 0;


  $userdata = $db->select()->from("user")->where("id = $ressid")->find();


  return json("",true,$userdata);
}
else if($action =="mytext")
{
  $id = isset($_POST['id']) ? $_POST['id'] : 0;

  $data = [
    'username'=>$_POST['username'],
		   'id'=>$_POST['id'],
		   'phone'=>$_POST['phone'],
       'money'=>$_POST['money'],
       'income'=>$_POST['income'],
		  'sex'=>$_POST['sex'],
			'job'=>$_POST['job'],
			'identity'=>$_POST['identity'],
		  'position'=>$_POST['position'],
      'job'=>$_POST['job'],
      'avatar'=>'/static/img/'.$_POST['avatar'],
  ];

  // if(!upload('avatar','/static/img/')){
  //   return json("上传头像失败");
  // };

  if($db->update("user",$data,"id = ".$id))
    {
      return json("编辑成功",true);
    }else{
      return json("编辑失败");
    }
}else if($action =="mycomment")
{
  $userid = isset($_POST['userid']) ? $_POST['userid'] : 0;

  $commentlist=$db->select()->from("order_comment")->where("userid = $userid")->all();
  // var_dump($commentlist);

  
   return json("评论数据",true,$commentlist);
}else if($action =="commenteditdata")
{
  $commentid = isset($_POST['commentid']) ? $_POST['commentid'] : 0;
  // var_dump($commentid);

  $userdata=$db->select()->from("order_comment")->where("id = $commentid")->find();
  // var_dump($userdata);

  
   return json("评论数据",true,$userdata);
}
else if($action =="mycommentedit")
{
  $userdata = isset($_POST) ? $_POST : "";
  // var_dump($userdata);

  $data=[
      "id"=> $userdata["id"],
		  "content"=> $userdata["content"],
		 	"level"=> $userdata["level"],
		  "createtime"=>time()
  ];

 $update=$db->update("order_comment",$data,"id = ".$userdata["id"]);

  if($update)
  {
    return json("编辑成功",true);
  }else{
    return json("编辑失败");
  }

}
else if($action =="couponlist")
{
  $userid = isset($_POST["userid"]) ? $_POST["userid"] : 0;

   //用户不存在
   if(!$userid)
   {
     return json("用户不存在");
     exit;
   }
 
   $status = isset($_POST['status']) ? $_POST['status'] : 1;


   $couponlist=$db->select()->from("coupon")->where("userid = $userid AND status =$status")->all();

   return json("优惠券数据",true,$couponlist);

}else if($action =="cashdata")
{
  $userid = isset($_POST['userid']) ? $_POST['userid'] : 0;

  $cashdata=$db->select()->from("user")->where("id = $userid")->find();
  // var_dump($commentlist);

  
   return json("评论数据",true,$cashdata);
}
else if($action =="mycash")
{
  $userid = isset($_POST['userid']) ? $_POST['userid'] : 0;
  $money = isset($_POST['money']) ? $_POST['money'] : 0;
  $value= isset($_POST['value']) ? $_POST['value'] : "";

  $user=$db->select()->from("user")->where("id = $userid")->find();

  $usermoney=$user["money"]+$money;

  $userdata=["money"=>$usermoney];

  $userlogdata=[
    "desc"=>"充值方式：{$value} 充值：{$money}",
    "userid"=>$userid,
    "price"=>$money,
    "createtime"=>time(),
    "status"=>2,
  ];

  $userlog=$db->add("user_log",$userlogdata);

  if(!$userlog){
    return json("消费记录表更新失败",true);
  }


  if($db->update("user",$userdata,"id=$userid")){
    return json("充值成功",true);
  }else{
    return json("充值失败",true);
  }
}else if($action =="jiege")
{
  pload();
}else if($action =="myavatar")
{
  $userid=isset($_POST["userid"])?$_POST['userid']:0;

  $avatar =isset($_POST["avatar"])?$_POST['avatar']:"";

  $data=["avatar"=>$avatar];

  if($db->update("user",$data,"id=$userid")){
    return json("修改头像成功",true);
  }else{
    return json("修改头像失败",true);
  }
}

?>