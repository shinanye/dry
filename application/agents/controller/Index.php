<?php
namespace app\agents\controller;
use think\Controller;
use think\Validate;
use think\Request;
use think\Cookie;
class Index extends Controller
{
    public function index(){
        if(Cookie::has('agent')){
            $agent=cookie('agent');
            return $this->fetch('home',['agent'=>$agent]);
        }else{
            $arr=Array ( 'user' => '' ,'pwd' => '' );
            return $this->fetch('login',['arr'=>$arr]);
        }
    }
    public function login(){
        $request = request();
        $validate = new Validate([
            'user'  => 'require|max:25|token',
            'pwd' => 'max:20',
        ]);
        if (!$validate->check($request->param())) {
            echo "<script>alert('填写信息不符合规范')</script>";
//                dump($validate->getError());
            return $this->fetch('login',['arr'=>$request->param()]);
        }else{
            $user=$request->param()['user'];
            $pwdarr=model('index')->login($user);
            if(empty($pwdarr)){
                echo "<script>alert('填写账号不存在')</script>";
                return $this->fetch('login',['arr'=>$request->param()]);
            }else{
                $pwd=$pwdarr ['gpwd'];
                if($pwd==md5(sha1($request->param()['pwd']))){
                    cookie('agent', $user,10800);
                    header("location:index");
                }else{
                    echo "<script>alert('填写密码不正确')</script>";
                    return $this->fetch('login',['arr'=>$request->param()]);
                }
            }

        }
    }
    public function regist(){
        $request=request();
        if(!empty($request->param())){
            $validate = new Validate([
                'user'  => 'require|max:25|token',
                'pwd' => 'max:20',
                'tel' => 'number',
                'email' => 'email'
            ]);
            if (!$validate->check($request->param())) {
                echo "<script>alert('填写信息有误')</script>";
//                dump($validate->getError());
                return $this->fetch('regist',['arr'=>$request->param()]);
            }else{
                $arr=model('index')->regist([],$request->param()['user']);
                if(empty($arr)){
                    model('index')->regist($request->param());
                    cookie('agent', $request->param()['user'],10800);
                    header("location:index");
                }else{
                    echo "<script>alert('用户名已存在')</script>";
                    return $this->fetch('regist',['arr'=>$request->param()]);
                }
            }
        }else{
            $arr=Array ( 'user' => '' ,'pwd' => '' ,'tel' => '' ,'email' => '');
            return $this->fetch('index/regist',['arr'=>$arr]);
        }
    }
    public function home(){
        return $this->fetch('welcome');
    }
    public function quit(){
        cookie('agent',null);
        header("location:index");
    }
}