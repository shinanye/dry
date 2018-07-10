<?php
/**
 * Created by PhpStorm.
 * User: 张靖
 * Date: 2018/5/2
 * Time: 16:58
 */

namespace app\admin\controller;
use think\Controller;

class Room extends Controller
{
    public function index(){
        $request=request();
        $type=$request->param()['type'];
        $arr=model('Room')->index();
        return $this->fetch('room',['type'=>$type,'arr'=>$arr]);

    }
}