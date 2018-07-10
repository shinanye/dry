<?php
/**
 * Created by PhpStorm.
 * User: 张靖
 * Date: 2018/5/2
 * Time: 16:47
 */

namespace app\admin\model;

class Agents
{
    public function index(){
        $arr=db('agent')->select();
        return $arr;
    }
    public function add($arr){//增加
        $data = [
            'gname' => $arr['user'],
            'gpwd' => md5(sha1($arr['password'])),
            'gtel' => $arr['phone'],
            'gemail' => $arr['email'],
            'gstatus' => 1
        ];
//        print_r($data);
        db('agent')->insert($data);
        echo true;
    }
    public function del($id){//删除
        db('agent')->where('gid',$id)->delete();
    }
    public function etic($arr=[],$id=''){//修改
        if(empty($arr)){
            $arr=db('agent')->where('gid',$id)->find();
            return $arr;
        }else{
            $data = [
                'gname' => $arr['user'],
                'gtel' => $arr['phone'],
                'gemail' => $arr['email']
            ];
            $id=$arr['id'];
            db('agent')->where('gid',$id)->update($data);
            echo true;
        }
    }
    public function pwd($arr=[]){//修改密码
        $data = [
            'gpwd' => md5(sha1($arr['password'])),
        ];
        $id=$arr['id'];
        db('agent')->where('gid',$id)->update($data);
        echo true;

    }
    public function type($id,$status){//停用、启用
        db('agent')->where('gid',$id)->update(['gstatus' =>$status]);
    }
}