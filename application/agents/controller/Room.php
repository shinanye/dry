<?php
/**
 * Created by PhpStorm.
 * User: 张靖
 * Date: 2018/5/3
 * Time: 10:17
 */
namespace app\agents\controller;
use think\Request;
use think\Controller;
use think\Validate;
class Room extends Controller
{
    public function index(){
        $agent=cookie('agent');
        $arr=model('room')->index($agent);
//        print_r($arr);
//        exit;
        return $this->fetch('room',['arr'=>$arr]);
    }
    public function roomadd(){//房源添加
        $request=request();
        if(empty($request->param())){
            $id=model('room')->roomadd([],cookie('agent'));
            return $this->fetch('roomadd',['id'=>$id]);
        }else{
            $validate = new Validate([
                'tel'  => 'require|min:11|max:11|token',
                'addr' => 'require|min:5|max:50',
                'type' => 'require',
                'rtype' => 'require',
                'decoriate' => 'require',
                'floor' => 'require',
                'floors' => 'require',
            ]);
            if (!$validate->check($request->param())) {
//                dump($validate->getError());
                echo false;
            }else{
//                print_r($request->param());
//                exit;
                $str=model('room')->roomadd($request->param());
                echo $str;
            }
        }
    }
    public function roometic(){//房源编辑
        $request=request();
        if(empty($request->param())){
            $rid=cookie('room_id');
            cookie('room_id',null);
            $arr=model('room')->roometic([],$rid);
            $str=$arr['rfloor'];
            $strarr=explode('/',$str);
            $arr['rfloor']=$strarr[0];
            $arr['rfloors']=$strarr[1];
//        print_r($arr);
            return $this->fetch('roometic',['arr'=>$arr]);
        }else{
            $validate = new Validate([
                'tel'  => 'require|min:11|max:11|token',
                'addr' => 'require|min:5|max:50',
                'type' => 'require',
                'rtype' => 'require',
                'decoriate' => 'require',
                'floor' => 'require',
                'floors' => 'require',
            ]);if (!$validate->check($request->param())) {
//                dump($validate->getError());
                echo false;
            }else{
//           print_r($request->param());
                $str=model('room')->roometic($request->param());
                echo $str;
            }
        }
    }
    public function roomdel(){//房源删除
        $request=request();
        $rid=$request->param('id');
        $str=model('room')->roomdel($rid);
        echo $str;
    }
    public function rent(){
        $agent=cookie('agent');
        $arr=model('room')->rent($agent);
        return $this->fetch('rent',['arr'=>$arr]);
    }
    public function rentadd(){//出租房屋添加
        $request=request();
        if(empty($request->param())){
            $id=model('room')->roomadd([],cookie('agent'));
            $arr=model('room')->rentadd([],[],$id);
//            print_r($arr);
            return $this->fetch('rentadd',['arr'=>$arr]);
        }else{
            $validate = new Validate([
                'rid' => 'number',
                'title'  => 'require|min:4|max:40|token',
                'area' => 'require|min:2|max:6',
                'direction' => 'max:4',
                'price' => 'require|number'
            ]);
            if (!$validate->check($request->param())) {
                dump($validate->getError());
                echo 0;
            }else{
//                print_r($request->param());
                if(empty($_FILES['pic'])){
                    echo 1;
                }else {
                    $pic=[];
                    for ($i = 0; $i < count($_FILES['pic']['name']); $i++) {
                        if (($_FILES['pic']['type'][$i] == 'image/jpeg' | 'image/png') && $_FILES['pic']['error'][$i] == 0) {
                            if (is_uploaded_file($_FILES["pic"]["tmp_name"][$i])) {
                                $str = time() . rand(10000, 100000);
                                if (move_uploaded_file($_FILES["pic"]["tmp_name"][$i], "static/dbimg/$str.png")) {
                                    $pic[] = $str . ".png";
                                } else {
                                    foreach ($pic as $item) {
                                        unlink("static/dbimg/$item");
                                    }
                                    echo 2;
                                }
                            } else {
                                echo 2;
                            }
                        }
                    }
                    $str = model('room')->rentadd($request->param(), $pic);
                    echo $str;
                }
            }
        }
    }
    public function rentetic(){//出租房屋编辑
        $request=request();
        if(empty($request->param())){
            $id=cookie('join_id');
            cookie('join_id',null);
            $arr=model('room')->rentetic([],$id);
            $arr[0]['rtitle']=str_replace($arr[0]['rname'],'',$arr[0]['rtitle']);
//        echo $arr[0]['rtitle'];
//        print_r($arr);
            return $this->fetch('rentetic',['id'=>$id,'arr'=>$arr[1],'strarr'=>$arr[0]]);
        }else{
            $validate = new Validate([
                'rid' => 'number',
                'title'  => 'require|min:4|max:40|token',
                'area' => 'require|min:2|max:6',
                'direction' => 'max:4',
                'price' => 'require|number'
            ]);
            if (!$validate->check($request->param())) {
                dump($validate->getError());
                echo false;
            }else{
//                print_r($request->param());
                $str=model('room')->rentetic($request->param());
                echo $str;
            }
        }
    }
    public function rentpic(){
        $request=request();
        if(empty($request->param())){
            $id=cookie('join_id');
            cookie('join_id',null);
            $arr=model('room')->rentpic([],[],$id);
            $rid=$arr[0]['rid'];
//            print_r($rid);
//            exit;
            return $this->fetch('rentpic',['id'=>$id,'rid'=>$rid,'arr'=>$arr]);
        }else{
//            print_r($request->param()['imageid']);
//            exit;
            if(empty($_FILES['pic'])){
                echo false;
            }else {
                $pic=[];
                for ($i = 0; $i < count($_FILES['pic']['name']); $i++) {
                    if (($_FILES['pic']['type'][$i] == 'image/jpeg' | 'image/png') && $_FILES['pic']['error'][$i] == 0) {
                        if (is_uploaded_file($_FILES["pic"]["tmp_name"][$i])) {
                            $str = time() . rand(10000, 100000);
                            if (move_uploaded_file($_FILES["pic"]["tmp_name"][$i], "static/dbimg/$str.png")) {
                                $pic[] = $str . ".png";
                            } else {
                                foreach ($pic as $item) {
                                    unlink("static/dbimg/$item");
                                }
                                echo false;
                            }
                        } else {
                            echo false;
                        }
                    }
                }
                if(!empty($pic)){
                    $str = model('room')->rentpic($request->param(), $pic);
                    echo $str;
                }else{
                    echo false;
                }
            }
        }
    }

    public function rentdel(){//出租房屋删除
        $request=request();
        $id=$request->param('id');
        $str=model('room')->rentdel($id);
        echo $str;
    }
    public function renttype(){//出租房屋状态
        $request=request();
        $id=$request->param('id');
        $status=$request->param('status');
        $str=model('room')->renttype($id,$status);
        echo $str;
    }
    public function order(){

    }
}