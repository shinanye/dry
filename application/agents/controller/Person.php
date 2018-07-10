<?php
/**
 * Created by PhpStorm.
 * User: 张靖
 * Date: 2018/5/3
 * Time: 10:13
 */
namespace app\agents\controller;
use think\Controller;
use think\Cookie;
use think\Validate;
use think\Request;
class Person extends Controller
{
    public function index(){
        $agent=cookie('agent');
        $arr=model('person')->index($agent);
//        print_r($arr);
//        exit;
        return $this->fetch('person',['arr'=>$arr]);
    }
    public function etic(){
        $request = request();
        $validate = new Validate([
            'agent'  => 'require|token',
            'phone' => 'require|number',
            'email' => 'require|email'
        ]);
        if (!$validate->check($request->param())) {
            $str=model('person')->etic($request->param());
            echo $str;
        }else{
            echo 0;
        }
    }
    public function pwd(){
        $request=request();
        if(empty($request->param())){
            $id=cookie('agent_id');
            cookie('agent_id', null);
//            print_r($arr);
            return $this->fetch('pwd',['id'=>$id]);
        }else{
            $validate = new Validate([
                'password' => 'require|max:20|token',
            ]);
            if (!$validate->check($request->param())) {
                dump($validate->getError());
                echo false;
            }else{
//                print_r($request->param());
                model('person')->pwd($request->param());
            }
        }
    }
}