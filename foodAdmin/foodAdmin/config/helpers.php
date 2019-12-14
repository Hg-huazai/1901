<?php

 function pload(){//上传图片、文件、视频什么的都可以用这个
  // 允许上传的图片后缀
  $allowedExts = array("gif", "jpeg", "jpg", "png");
  $temp = explode(".", $_FILES["file"]["name"]);
  echo $_FILES["file"]["size"];
  $extension = end($temp);     // 获取文件后缀名
  if ((($_FILES["file"]["type"] == "image/gif")
  || ($_FILES["file"]["type"] == "image/jpeg")
  || ($_FILES["file"]["type"] == "image/jpg")
  || ($_FILES["file"]["type"] == "imagepeg")
  || ($_FILES["file"]["type"] == "image/x-png")
  || ($_FILES["file"]["type"] == "image/png"))
  && ($_FILES["file"]["size"] < 2046549680220)   // 小于 200 kb
  && in_array($extension, $allowedExts))
  {
      if ($_FILES["file"]["error"] > 0)
      {
          echo "错误：: " . $_FILES["file"]["error"] . "<br>";
      }
      else
      {
          echo "上传文件名: " . $_FILES["file"]["name"] . "<br>";
          echo "文件类型: " . $_FILES["file"]["type"] . "<br>";
          echo "文件大小: " . ($_FILES["file"]["size"] / 1024) . " kB<br>";
          echo "文件临时存储的位置: " . $_FILES["file"]["tmp_name"] . "<br>";
          
          // 判断当期目录下的 upload 目录是否存在该文件
          // 如果没有 upload 目录，你需要创建它，upload 目录权限为 777
          if (file_exists("upload/" . $_FILES["file"]["name"]))
          {
              echo $_FILES["file"]["name"] . " 文件已经存在。 ";
          }
          else
          {
              // 如果 upload 目录不存在该文件则将文件上传到 upload 目录下
              move_uploaded_file($_FILES["file"]["tmp_name"], "upload/" . $_FILES["file"]["name"]);
              echo "文件存储在: " . "upload/" . $_FILES["file"]["name"];
          }
      }
  }
  else
  {
      echo "非法的文件格式";
  }
}

//----------------------------------------------------------------

function json($msg='未知消息',$result=false,$data=null)
{
  $res = ["msg"=>$msg,"data"=>$data,"result"=>$result];
  echo json_encode($res); 
  exit;
}

function level($level)
{
  $str = "";
  for($i=0;$i<$level;$i++)
  {
    $str .= "——";
  }

  return $str;
}

//后台系统提醒
function showAdmin($msg="",$url="")
{
  if(empty($url))
  {
    $url = $_SERVER["HTTP_REFERER"];
  }

  //将url地址进行编码
  $url = urlencode($url);

  header("Location:404.php?msg=$msg&url=$url");
}

//系统提醒
function showMsg($msg="",$url="")
{
  if(empty($url))
  {
    $url = $_SERVER["HTTP_REFERER"];
  }

  //将url地址进行编码
  $url = urlencode($url);

  header("Location:404.php?msg=$msg&url=$url");
}


//发送邮件
function sendMail($email,$subject,$body)
{

  //判断邮箱是否为空
  if(empty($email))
  {
    return false;
  }

  if(empty($subject))
  {
    return false;
  }

  if(empty($body))
  {
    return false;
  }

  include_once('phpmail/class.phpmailer.php');

  try 
  {
    //初始化一个邮件发送的对象
    $mail = new PHPMailer(true);

    $mail->IsSMTP(); //使用smtp邮件发送协议
    $mail->SMTPAuth   = true;
    $mail->Port       = 25;
    $mail->Host       = "smtp.163.com";
    $mail->Username   = "dancefunk@163.com"; //服务账号  
    $mail->Password   = "h1901123";  //密码

    //"邮件回复人地址","邮件回复人名称
    $mail->AddReplyTo("dancefunk@163.com","Flyes社区");

    $mail->From       = "dancefunk@163.com"; //发件人地址
    $mail->FromName   = "Flyes社区";				//发件人名称

    $mail->AddAddress($email); //收件人地址

    $mail->Subject  = $subject;		//邮件主题

    $mail->WordWrap   = 80; // 80个字符换行

    $mail->MsgHTML($body);    //发送内容

    $mail->IsHTML(true); //是否可以发送html

    $mail->Send();
    return true;
  } catch (phpmailerException $e) {
      // echo $e->errorMessage();
      return false;
  }

}









//得到当前网址
function get_url(){
	$str = $_SERVER['PHP_SELF'].'?';
	if($_GET){
		foreach ($_GET as $k=>$v){  //$_GET['page']
			if($k!='page'){
				$str .= $k.'='.$v.'&';
			}
		}
	}
	return $str;
}



//分页函数
/**
 *@pargam $current	当前页
 *@pargam $count	记录总数
 *@pargam $limit	每页显示多少条
 *@pargam $size		中间显示多少条
 *@pargam $class	样式
*/
function page($current,$count,$limit,$size,$class='sabrosus'){
	$str='';
	if($count>$limit){
		$pages = ceil($count/$limit);//算出总页数
		$url = get_url();//获取当前页面的URL地址（包含参数）
		
		$str.='<div class="'.$class.'">';
		//开始
		if($current==1){
			$str.='<span class="disabled">首&nbsp;&nbsp;页</span>';
			$str.='<span class="disabled">  &lt;上一页 </span>';
		}else{
			$str.='<a href="'.$url.'page=1">首&nbsp;&nbsp;页 </a>';
			$str.='<a href="'.$url.'page='.($current-1).'">  &lt;上一页 </a>';
		}
		//中间
		//判断得出star与end
	    
		 if($current<=floor($size/2)){ //情况1
			$star=1;
			$end=$pages >$size ? $size : $pages; //看看他两谁小，取谁的
		 }else if($current>=$pages - floor($size/2)){ // 情况2
				 
			$star=$pages-$size+1<=0?1:$pages-$size+1; //避免出现负数
		
			$end=$pages;
		 }else{ //情况3
		 
			$d=floor($size/2);
			$star=$current-$d;
			$end=$current+$d;
		 }
	
		for($i=$star;$i<=$end;$i++){
			if($i==$current){
				$str.='<span class="current">'.$i.'</span>';	
			}else{
				$str.='<a href="'.$url.'page='.$i.'">'.$i.'</a>';
			}
		}
		//最后
		if($pages==$current){
			$str .='<span class="disabled">  下一页&gt; </span>';
			$str.='<span class="disabled">尾&nbsp;&nbsp;页  </span>';
		}else{
			$str.='<a href="'.$url.'page='.($current+1).'">下一页&gt; </a>';
			$str.='<a href="'.$url.'page='.$pages.'">尾&nbsp;&nbsp;页 </a>';
		}
		$str.='</div>';
	}
	
	return $str;
}



//封装上传文件
//返回的结果
$result = array("result"=>false,"msg"=>"","data"=>null);
function upload($name,$path,$size=123123123,$ext=array('png','jpeg','gif','jpg'))
{
  global $result;
  $file = $_FILES[$name];
  $error = $file['error'];

  //判断上传错误
  if($error > 0)
  {
    switch($error)
    {
      case 1:
        $result['msg'] = "上传的文件超过了php.ini配置大小";
        break;
      case 2:
        $result['msg'] = '超过表单隐藏域限制的大小配置';
        break;
      case 3:
        $result['msg'] = '文件上传到一半网络中断';
        break;
      case 4:
        $result['msg'] = '无文件上传';
        break;
      default:
        $result['msg'] = '未知错误';
    }

    return false;
  }

  //判断上传的文件大小是否有超过自己限制的
  if($file['size'] > $size)
  {
    $result['msg'] = "超过函数限制上传大小";
    return false;
  }

  //类型
  $type = PATHINFO($file['name'],PATHINFO_EXTENSION);

  //判断是否是允许的上传类型
  if(!in_array($type,$ext))
  {
    $result['msg'] = '该文件不是允许上传的类型';
    return false;
  }

  //重新命名文件
  //mt_rand() 从一个范围内随机选择数字
  $filname = date("YmdHis").mt_rand(111111,9999999).".".$type;

  if(!is_dir($path))
  {
    $result['msg'] = '上传路径有误，请重新填写';
    return false;
  }

  //判断文件是否是通过http post上传的
  if(is_uploaded_file($file['tmp_name']))
  {
    //将临时文件移动 到我指定的目录 $path
    $res = move_uploaded_file($file['tmp_name'],$path."/".$filname);

    if($res)
    {
      //成功
      $result['result'] = true;
      $result['msg'] = '上传文件成功';
      $result['data'] = $filname;
      return true;
    }else{
      //失败
      $result['msg'] = '上传文件失败';
      return false;
    }
  }else{
    $result['msg'] = '非法上传';
    return false;
  }
}

//获取文件上传的结果
function getResult()
{
  global $result;
  return $result;
}


?>