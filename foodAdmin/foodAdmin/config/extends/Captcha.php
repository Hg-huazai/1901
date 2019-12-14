<?php

/*
*验证码类
*verify方法生成验证码字符串
*entry方法生成验证码
*特别提醒：这里要先用entry生成验证码，再用verify生成验证码的字符串，也就是必须先调用entry，然后才能够调用verify生成验证码的字符串，原因代码已经说明问题了，因为验证码的字符串是在entry方法调用captchaImage生成的，所以必须先调用它才行
*有的地方对中文的字体要求比较高，所以，有的地方不支持中文验证码
*/
class Captcha
{
  //配置参数
  private $config = array();
  //验证码
  private $verifyCode = '';
  //获取配置文件的配置信息，给类传参数就行，例如new Captcha($config);$config是你的配置文件信息
  public function __construct($config=array('width'=>100,'height'=>40,'length'=>4,'size'=>7,'lines'=>3,'dots'=>5,'font'=>'simhei.ttf','rectangle'=>array(255,255,255),'charset'=>true,'chinese'=>'来到新机场主航站楼建设在婚姻关系存续期间所负债务她在收到要求她偿还前夫在婚姻关系存续期间所欠债务的法院传票后要精益求精善始善终')){
    $this->config = $config;
  }
  //创建验证码
  private function captchaImage(){
    //画布
    $img = imagecreatetruecolor($this->config['width'],$this->config['height']);
    //填充画布颜色
    imagefill($img,0,0,imagecolorallocate($img,mt_rand(200,255),mt_rand(200,255),mt_rand(200,255)));
    //需要边框则画边框
    if($this->config['rectangle'] && is_array($this->config['rectangle']) && count($this->config['rectangle']) == 3){
      $this->tangle($img);
    }
    $this->verifyCode = $this->code($img,$this->config['charset'],$this->config['chinese']);
    //存在则添加干扰线
    if($this->config['lines']){
      $this->codeLines($img);
    }
    //存在则添加干扰点
    if($this->config['dots']){
      $this->codeDots($img);
    }
    return $img;
  }
  private function codeLines($img){
    //绘制干扰线
    for($i=0;$i<$this->config['lines'];$i++){
      imageline($img,mt_rand(0,$this->config['width'] / 10),mt_rand(0,$this->config['height']),mt_rand($this->config['width'] * 7/ 10,$this->config['width'] * 9/ 10),mt_rand(0,$this->config['height']),imagecolorallocate($img,mt_rand(0,255),mt_rand(0,255),mt_rand(0,255)));
    }
  }
  private function codeDots($img){
    //添加噪点
    for($i=0;$i<$this->config['dots'];$i++){
      //噪点颜色
      $color = imagecolorallocate($img,mt_rand(0,180),mt_rand(0,180),mt_rand(0,180));
      imagestring($img,mt_rand(1,3),mt_rand(0,170),mt_rand(0,30),'*',$color);
    
    }
  }
  /*画布边框*/
  private function tangle($img){
    imagerectangle($img,0,0,$this->config['width']-1,$this->config['height']-1,imagecolorallocate($img,$this->config['rectangle'][0],$this->config['rectangle'][1],$this->config['rectangle'][2]));
  }
  /*生成验证码,默认英文，$ch为true则为中文*/
  private function code($img,$ch=false,$set=''){
    $str = "";
    //计算间隔
    $span = ceil($this->config['width']/($this->config['length']+1));
    if($ch && !empty($set)){
      //随机产生字符
      $set = $this->config['chinese'];
      for($i=0;$i<$this->config['length'];$i++){
        $end = strlen($set)/3;
        $pos = mt_rand(0,$end-1);
        $str .= substr($set,$pos*3,3);
      }
      //每次绘制一个字符
      for($i=1;$i<=$this->config['length'];$i++){
        imagettftext($img,16,mt_rand(-30,60),$i*$span,$this->config['height']*3/5,imagecolorallocate($img,mt_rand(0,180),mt_rand(0,180),mt_rand(0,180)),$this->config['font'],substr($str,($i-1)*3,3));
      }
    }else{
      //随机生成字母或者数字
      for($i=0;$i<$this->config['length'];$i++){
        switch(mt_rand(0,2)){
          case 0:
          $str .= chr(mt_rand(65,90));
          break;
        case 1:
          $str .= chr(mt_rand(97,122));
          break;
        case 2:
          $str .= chr(mt_rand(48,57));
        }
      }
      //每次绘制一个字符
      for($i=1;$i<=$this->config['length'];$i++){
        imagestring($img,$this->config['size'],$i*$span,0,$str[$i-1],imagecolorallocate($img,mt_rand(0,180),mt_rand(0,180),mt_rand(0,180)));
      }
    }
    return $str;
  }
  //获取验证码
  public function verify(){
    return $this->verifyCode;
  }
  //生成验证码
  public function entry(){
    header("content-type:image/png");
    imagepng($this->captchaImage());
  }
}

?>