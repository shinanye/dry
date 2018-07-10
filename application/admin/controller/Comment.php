<?php
/**
 * Created by PhpStorm.
 * User: 张靖
 * Date: 2018/5/4
 * Time: 11:36
 */

namespace app\admin\controller;


use think\Controller;
use think\Request;
use think\Validate;
class Comment extends Controller
{
    public function index(){
        $request=request();
        $type=$request->param()['type'];
        $arr=model('comment')->index();
        return $this->fetch('index',['type'=>$type,'arr'=>$arr]);
    }
    public function add(){
        $request=request();
        if(empty($request->param())){
            return $this->fetch('add');
        }else{
            $validate = new Validate([
                'phone'  => 'require|token'
            ]);
            if (!$validate->check($request->param())) {
                dump($validate->getError());
                echo false;
            }else{
                print_r($request->param());
                $str=model('comment')->add($request->param());
                echo $str;
            }
        }
    }
    public function etic(){
        $request=request();
        if(empty($request->param())){
            $id=cookie('advice_id');
            cookie('advice_id', null);
            $arr=model('comment')->etic([],$id);
//            print_r($arr);
            return $this->fetch('etic',['arr'=>$arr]);
        }else{
            $validate = new Validate([
                'phone'  => 'require|token'
            ]);
            if (!$validate->check($request->param())) {
                dump($validate->getError());
                echo false;
            }else{
//                print_r($request->param());
                $str=model('comment')->etic($request->param());
                echo $str;
            }
        }
    }
    public function del(){
        $request=request();
        $id=$request->param('id');
        model('comment')->del($id);
        echo true;
    }
}