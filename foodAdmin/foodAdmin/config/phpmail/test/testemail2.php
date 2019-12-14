<?php
/**
* Simple example script using PHPMailer with exceptions enabled
* @package phpmailer
* @version $Id$
*/

require '../class.phpmailer.php';

try {
	$mail = new PHPMailer(true); //New instance, with exceptions enabled

	// $body             = file_get_contents('contents.html');
  // $body             = preg_replace('/\\\\/','', $body); //Strip backslashes
  $body = "<a href='javascript:void(0)'>邮箱验证链接</a>";

	$mail->IsSMTP();                           // tell the class to use SMTP
	$mail->SMTPAuth   = true;                  // enable SMTP authentication
	$mail->Port       = 25;                    // set the SMTP server port
	$mail->Host       = "smtp.163.com"; // SMTP server  SMTP 服务
	$mail->Username   = "dancefunk@163.com";     // SMTP server username   服务账号  
	$mail->Password   = "h1901123";            // SMTP server password

	//$mail->IsSendmail();  // tell the class to use Sendmail

	$mail->AddReplyTo("dancefunk@163.com","Mr.Lee");     //"邮件回复人地址","邮件回复人名称

	$mail->From       = "dancefunk@163.com";  			//发件人地址
	$mail->FromName   = "Mr.Lee";						//发件人名称

	$to = "2925712507@qq.com";							//收件人地址

	$mail->AddAddress($to);

	$mail->Subject  = "指引问答网";		//邮件主题

	$mail->AltBody    = "To view the message, please use an HTML compatible email viewer!"; // optional, comment out and test
	$mail->WordWrap   = 80; // set word wrap

	$mail->MsgHTML($body);    //发送内容

	$mail->IsHTML(true); // send as HTML

	$mail->Send();
	echo 'Message has been sent.';
} catch (phpmailerException $e) {
	echo $e->errorMessage();
}
?>