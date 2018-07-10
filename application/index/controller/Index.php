<?php
namespace app\index\controller;

use app\index\model\Login as logModel;
use app\index\model\Register as reModel;
use think\Controller;
use think\captcha\Captcha;
use \app\index\model\Index as indexModel;
use \app\index\model\Forget as forgetModel;

class Index extends Controller
{
    public function index()//首页
    {
        $indexObj = new indexModel();
        $cityCurrent = "北京市";
        $data = $indexObj->index($cityCurrent);
        $this->assign("dataSources",$data);
        return view("index");
    }

    public function user(){//用户界面

        if(isset($_COOKIE["jack"])){
            $jack = $_COOKIE["jack"];
            $three = substr($jack,0,3);
            $jack = substr($jack,7);
            $jack = $three."****".$jack;
            $this->assign("jack",$jack);
            $this->assign("status",1);
        }else{
            $this->assign("status",0);
        }
        return view("user");
    }

    public function login()//登录界面
    {

        $logModel = new logModel();
        if(!empty($_POST)){
            if (captcha_check($_POST["code"])) {//验证码验证
                $checkTel = checkPhone($_POST["tel"]);
                if($checkTel["status"]==0){//正则电话验证失败
                    $arr =  $checkTel;
                }else{
                    $validate = $this->validate($_POST,'User.login');
                    if(true !==$validate){
                        //验证失败
                        $arr = retuanData(0,$validate);
                    }else{
                        $data = $logModel->userName($_POST["tel"]);
//                        var_dump($_POST);
//                        var_dump($data);
//                        var_dump(!empty($data));
                        if(!empty($data)){
                            if(md5(sha1($_POST["password"]))==$data[0]["upwd"]){
                                setcookie("jack",$_POST["tel"],time()+3600*24,"/");
                                $arr = retuanData(1,"登录成功");
                            }else{
                                $arr = retuanData(0,"用户密码不正确");
                            }
                        }else{
                            $arr = retuanData(0,"电话号码不存在,请先注册");
                        }
                    }
                }
            }else{
                $arr = retuanData(0,"验证码错误，请先获取验证码");
            }
            return json_encode($arr);
        }else{
            return view("login");
        }

    }

    public function register()//注册界面
    {
        $reModel = new reModel();
        $arr =array();
        if(!empty($_POST)){
            if (captcha_check($_POST["img_code"])){//验证码验证
                $checkTel = checkPhone($_POST["tel"]);
                if($checkTel["status"]==1){//正则电话验证成功
                    $verify_code = $_COOKIE["code"];
                    if($_POST["verify_code"]==$verify_code){//短信验证成功
                        $validate = $this->validate($_POST,'User.register');
                        if(true ===$validate){//tp5校验框架成功
                            $data = $reModel->selectData($_POST["tel"]);
                            //将用户数据信息添加到数据库中
                            if(!$data){
                                unset($_POST["__token__"]);
                                unset($_POST["img_code"]);
                                unset($_POST["verify_code"]);
                                unset($_POST["uid"]);
                                $_POST["password"] = md5(sha1($_POST["password"]));//密码加密
                                $arr = array("utel"=>$_POST['tel'],"upwd"=>$_POST["password"]);
                                $data = $reModel->insertData($arr);
                                if($data===1){
                                    setcookie("jack",$_POST["tel"],time()+3600*24,"/");
                                    $arr = retuanData(1,"注册成功",$_POST["tel"]);
                                }else{
                                    $arr = retuanData(0,"注册失败");
                                }
                            }else{
                                $arr = retuanData(0,"该电话号码已被注册");
                            }
                        }else{
                            $arr = retuanData(0,$validate);
                        }//验证失败 tp5校验框架
                    }else{
                        $arr = retuanData(0,"短信验证失败");
                    }//sms校验
                }else{
                    $arr =  $checkTel;
                }//tel格式校验
            }else{
                $arr = retuanData(0,"验证码错误，请先获取验证码");
            }//imgcode
            return json_encode($arr);
        }else{
            return view("register");
        }
    }

    public function forget(){//找回密码
        $forgetModel = new forgetModel();
        $arr =array();
        if(!empty($_POST)){
//            var_dump($_POST);
            if (captcha_check($_POST["img_code"])){//验证码验证
                $checkTel = checkPhone($_POST["tel"]);
                if($checkTel["status"]==1){//正则电话验证成功
                    $verify_code = $_COOKIE["code"];
                    if($_POST["verify_code"]==$verify_code){//短信验证成功
                        $validate = $this->validate($_POST,'User.forget');
                        if(true ===$validate){//tp5校验框架成功
                            $pwd =  md5(sha1($_POST["newpwd"]));
                            $data = $forgetModel->forget($_POST["tel"]);
                            if($data){
                                setcookie("jack",$_POST["tel"],time()+3600*24,"/");
                                $data = $forgetModel->insertData($_POST["tel"],$pwd);
                                $arr = retuanData(1,"密码修改成功");
                            }else{
                                $arr = retuanData(0,"该用户不存在");
                            }
                            //将用户数据信息添加到数据库中
                            var_dump($data);
                        }else{
                            $arr = retuanData(0,$validate);
                        }//验证失败 tp5校验框架
                    }else{
                        $arr = retuanData(0,"短信验证失败");
                    }//sms校验
                }else{
                    $arr =  $checkTel;
                }//tel格式校验
            }else{
                $arr = retuanData(0,"验证码错误，请先获取验证码");
            }//imgcode
            return json_encode($arr);
        }else{
            return view("forget");
        }
    }

    public function sendSMSCode(){
        $tel = $_GET["tel"];
        if(strlen($tel)>0){//电话号码存在
            $checkTel = checkPhone($tel);
            if($checkTel["status"]==0){//正则电话验证失败
                $arr =  $checkTel;
            }else{
                $arr = sendSMS($tel);
                if($arr["status"]!=1){
                    $arr = retuanData(0,"短信发送失败，点击再次发送");
                }
            }
        }else{
            $arr = retuanData(0,"请输入手机号");
        }
        echo json_encode($arr);

    }
}
