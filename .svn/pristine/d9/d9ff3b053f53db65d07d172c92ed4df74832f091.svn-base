<?php
/**
 * Created by PhpStorm.
 * User: 张靖
 * Date: 2018/5/2
 * Time: 16:33
 */

namespace app\admin\model;
class Member
{
    public function index(){
        $arr=db('user')->select();
        return $arr;
    }
    public function add($arr){//增加
        $data = [
            'uname' => $arr['user'],
            'upwd' => md5(sha1($arr['password'])),
            'usex' => $arr['sex'],
            'utel' => $arr['phone'],
            'uemail' => $arr['email'],
            'uwork' => $arr['work'],
            'ubirth' => date("Y-m-d",time()),
            'ustatus' => 1
        ];
//        print_r($data);
        db('user')->insert($data);
        echo true;
    }
    public function del($id){//删除
        db('user')->where('uid',$id)->delete();
    }
    public function etic($arr=[],$id=''){//修改
        if(empty($arr)){
            $arr=db('user')->where('uid',$id)->find();
            return $arr;
        }else{
            $data = [
                'uname' => $arr['user'],
                'usex' => $arr['sex'],
                'utel' => $arr['phone'],
                'uemail' => $arr['email'],
                'uwork' => $arr['work'],
            ];
            $id=$arr['id'];
            db('user')->where('uid',$id)->update($data);
            echo true;
        }
    }
    public function pwd($arr=[]){//修改密码
        $data = [
            'upwd' => md5(sha1($arr['password'])),
        ];
        $id=$arr['id'];
        db('user')->where('uid',$id)->update($data);
        echo true;

    }
    public function type($id,$status){//停用、启用
        db('user')->where('uid',$id)->update(['ustatus' =>$status]);
    }

}