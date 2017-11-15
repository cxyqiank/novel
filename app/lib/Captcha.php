<?php
/**
 * 图像验证码了类
 */
namespace app\lib;
class Captcha
{
    //验证码的宽度
    private $width = 100;
    //验证码的高度
    private $height = 40;
    //验证码字体文件
    private $font = './public/novel/fonts/framd.ttf';
    //验证码字体大小
    private $size = 18;
    //验证码字符个数
    private $number = 4;

    public function __set($name, $value)
    {
        if(property_exists($this,$name)){
            $this -> $name = $value;
        }
    }
    public function __get($name)
    {
        if(property_exists($this,$name)){
            return $this -> $name;
        }
    }

    //开始绘制验证码图像
    public function makeImage()
    {
        //1. 先创建一个背景图片，颜色随机变化的
        $image = imagecreatetruecolor($this -> width,$this->height);
        //填充颜色
        $color = imagecolorallocate($image,mt_rand(100,255),mt_rand(100,255),mt_rand(100,255));
        imagefill($image,0,0,$color);

        //2. 调用makeCode方法，给我返回随机的字符串
        $code = $this -> makeCode();
        //将随机的字符串保存到session中
        $_SESSION['code'] = $code;

        $color = imagecolorallocate($image,mt_rand(0,150),mt_rand(0,150),mt_rand(0,150));

        //遍历字符串，拿到每一个字符，然后一个一个的写入
        for($i=0;$i<strlen($code);$i++){
            $x = ($this -> width) / ($this -> number) * $i + 8;
            imagettftext($image,$this->size,mt_rand(-30,30),$x,30,$color,$this->font,$code[$i]);
        }
        //再向画布中写入像素点
        for($i=0;$i<100;$i++){
            $color = imagecolorallocate($image,mt_rand(100,255),mt_rand(100,255),mt_rand(100,255));
            imagesetpixel($image,mt_rand(0,$this->width),mt_rand(0,$this->height),$color);
        }
        //再向画布中写入10个线条imageline
        for($i=0;$i<5;$i++){
            $color = imagecolorallocate($image,mt_rand(100,255),mt_rand(100,255),mt_rand(100,255));
            imageline($image,mt_rand(0,$this->width),mt_rand(0,$this->height),mt_rand(0,$this->width),mt_rand(0,$this->height),$color);
        }


        //输出到浏览器
        header("Content-Type:image/png");
        imagepng($image);

        //销毁图像资源
        imagedestroy($image);
    }
    //随机生成字符（数字、字母）
    private function makeCode()
    {
        //1. 先创建随机的数字
        $number = range(3,9);  //忽略0 1 2 和 字母 o l  z不容易区分
        //2. 创建随机的字母
        $lower = range('a','z');
        //3. 创建随机的大写字母
        $upper = range('A','Z');

        $arr = array_merge($number,$lower,$upper);

        //打乱数组的顺序
        shuffle($arr);

        //返回指定个数的字符个数
        $str = '';
        for($i=0;$i<$this->number;$i++){
            $str .= $arr[$i];
        }
        return $str;
    }
    //验证用户的输入和我们生成的随机的字符串进行比较
    //参数：调用时传递进行来的用户输入
    public function verify($input)
    {

        //比较的时候忽略大小写，实现：统一的转换成小写或大写再进行比较
        if(strtolower($input) == strtolower($_SESSION['code'])){
            return true;
        }else{
            return false;
        }
    }
}