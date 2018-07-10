<?php
/**
 * Created by PhpStorm.
 * User: 张靖
 * Date: 2018/5/7
 * Time: 17:56
 */

namespace app\admin\controller;
use think\Controller;
use think\Cookie;
use think\Request;
use think\Validate;
class House extends Controller
{
    public function index(){
        $request=request();
        $type=$request->param()['type'];
        $arr=model('house')->index(4);
//        print_r($arr);
        return $this->fetch('house',['type'=>$type,'arr'=>$arr]);
    }
    public function newhouse(){
        $request=request();
        $type=$request->param()['type'];
        $arr=model('house')->index(1);
//        print_r($arr);
        return $this->fetch('newhouse',['type'=>$type,'arr'=>$arr]);
    }
    public function allot(){
        $request=request();
        if(empty($request->param())){
            $id=cookie('house_id');
            cookie('house_id', null);
            $arr=model('house')->allot();
            return $this->fetch('allot',['id'=>$id,'arr'=>$arr]);
            print_r($arr);
        }else{
            if(!($request->param()['agent']==0)){
                model('house')->allot($request->param());
            }else{
                echo false;
            }
        }
    }
    public function etic(){
        $id=cookie('house_id');
        cookie('house_id', null);
        $arr=model('house')->etic([],$id);
//        print_r($arr);
        return $this->fetch('etic',['arr'=>$arr,'url'=>1]);
    }
    public function netic(){
        $id=cookie('house_id');
        cookie('house_id', null);
        $arr=model('house')->etic([],$id);
//        print_r($arr);
        return $this->fetch('etic',['arr'=>$arr,'url'=>0]);
    }
    public function commonetic(){
        $request=request();
        $validate = new Validate([
            'id' => 'require|number',
            'name'  => 'require|token',
            'phone' => 'require|number|min:11|max:11',
            'area' => 'require',
            'village' => 'require'
        ]);
        if (!$validate->check($request->param())) {
            dump($validate->getError());
            echo false;
        }else{
//                print_r($request->param());
            $str=model('house')->etic($request->param());
            echo $str;
        }

    }
    public function del(){
        $request=request();
        $id=$request->param()['id'];
        $str=model('house')->del($id);
        echo $str;
    }
}