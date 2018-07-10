<?php
/**
 * Created by PhpStorm.
 * User: 张靖
 * Date: 2018/5/8
 * Time: 12:31
 */

namespace app\agents\controller;


use think\Controller;
use think\Request;
use think\Cookie;
class House extends Controller
{
    public function index(){
        $agent=cookie('agent');
        $arr=model('house')->index($agent);
//        echo $agent;
//        print_r($arr);
//        exit;
        return $this->fetch('index',['arr'=>$arr]);
    }
    public function house(){
        $agent=cookie('agent');
        $arr=model('house')->house($agent);
        return $this->fetch('house',['arr'=>$arr]);
    }
    public function etic(){
        $request=request();
        if(empty($request->param())){
            $id=cookie('house_id');
            cookie('house_id',null);
            return $this->fetch('etic',['id'=>$id]);
        }else{
            if($request->param()['type']==0){
                echo false;
            }else{
                $str=model('house')->etic($request->param());
                echo $str;
            }

        }
    }
    public function del(){
        $request=request();
        $id=$request->param('id');
        $str=model('house')->del($id);
        echo $str;
    }
}