<?php
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
