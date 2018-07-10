<?php

namespace app\admin\controller;
use think\Controller;
use think\Validate;
use think\Request;
use think\Cookie;
class agents extends Controller
{
    public function index(){
        $request=request();
        $type=$request->param()['type'];
        $arr=model('agents')->index();
        return $this->fetch('agents',['type'=>$type,'arr'=>$arr]);
    }
    public function add(){//增加
        $request=request();
        if(empty($request->param())){
            return $this->fetch('add');
        }else{
            $validate = new Validate([
                'user'  => 'require|token',
                'phone' => 'require|number|min:11|max:11',
                'email' => 'email'
            ]);
            if (!$validate->check($request->param())) {
                dump($validate->getError());
                echo false;
            }else{
//                print_r($request->param());
                $str=model('agents')->add($request->param());
                echo $str;
            }
        }
    }
    public function del(){//删除
        $request=request();
        $id=$request->param('id');
        model('agents')->del($id);
        echo true;
    }
    public function etic(){//修改
        $request=request();
        if(empty($request->param())){
            $id=cookie('agent_id');
            cookie('agent_id', null);
            $arr=model('agents')->etic([],$id);
//            print_r($arr);
            return $this->fetch('etic',['id'=>$id,'arr'=>$arr]);
        }else{
            $validate = new Validate([
                'user'  => 'require|token',
                'phone' => 'require|number|min:11|max:11',
                'email' => 'email'
            ]);
            if (!$validate->check($request->param())) {
                dump($validate->getError());
                echo false;
            }else{
//                print_r($request->param());
                $str=model('agents')->etic($request->param());
                echo $str;
            }
        }
    }
    public function pwd(){//修改密码
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
                model('agents')->pwd($request->param());
            }
        }
    }
    public function type(){//停用、启用
        $request=request();
        $id=$request->param('id');
        $status=$request->param('status');
        model('agents')->type($id,$status);
        echo true;
    }
}