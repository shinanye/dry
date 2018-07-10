<?php
/**
 * Created by PhpStorm.
 * User: 张靖
 * Date: 2018/5/12
 * Time: 9:06
 */

namespace app\agents\controller;


use think\Controller;
use think\Validate;
use think\Request;
class Orders extends Controller
{
    public function index(){
        $agent=cookie('agent');
        $arr=model('orders')->index($agent);
        return $this->fetch('index',['arr'=>$arr]);
    }
    public function add(){
        $request=request();
        if(empty($request->param())){
            $agent=cookie('agent');
//            $arr=model('orders')->add();
            return $this->fetch('add',['agent'=>$agent]);
        }else{
            $validate = new Validate([
                'uname'  => 'require',
                'sname'  => 'require|token'

            ]);
            if (!$validate->check($request->param())) {
                dump($validate->getError());
                echo 0;
            }else{
//                print_r($request->param());
                if(empty($_FILES['pic'])){
                    echo 1;
                }else {
                    if (($_FILES['pic']['type'] == 'image/jpeg' | 'image/png') && $_FILES['pic']['error'] == 0) {
                        if (is_uploaded_file($_FILES["pic"]["tmp_name"])) {
                            $str = time() . rand(10000, 100000);
                            if (move_uploaded_file($_FILES["pic"]["tmp_name"], "static/agents/orders/$str.png")) {
                                $pic = $str . ".png";
                            } else {
                                echo 2;
                            }
                        } else {
                            echo 2;
                        }
                    }
                    $str = model('orders')->add($request->param(), $pic);
                    echo $str;
                }
            }
        }
    }
}