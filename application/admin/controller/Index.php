<?php
namespace app\admin\controller;
use think\Controller;
use think\Request;
use think\Cookie;
class Index extends Controller
{
    public function index(){
        if(Cookie::has('admin')){
            $admin=cookie('admin');
            $rolearr=model("index")->role($admin);
//            print_r($rolearr);
//            exit;
//            $role=$rolearr['role'];
            $arr=model('index')->index($rolearr['Id']);
//            print_r($arr[0][1]);
//            exit;
            return $this->fetch('home',['arr'=>$arr,'admin'=>$admin,'role'=>$rolearr]);
        }else{
            $arr=Array ( 'user' => '' ,'pwd' => '' );
            return $this->fetch('login',['arr'=>$arr]);
        }
    }
    public function login(){
        $request=request();
        if(!empty($request->param())){
            $admin=$request->param('user');
            $pwd=model('index')->login($admin);
            if($pwd==md5(sha1($_POST['pwd']))){
                cookie('admin', $admin,10800);
                header("location:index");
            }else{
                return $this->fetch('login',['arr'=>$request->param()]);
            }
        }
    }
    public function home(){
        return $this->fetch('welcome');
    }
    public function quit(){
        cookie('admin',null);
        header("location:index");
    }
}