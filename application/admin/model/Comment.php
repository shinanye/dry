<?php
/**
 * Created by PhpStorm.
 * User: 张靖
 * Date: 2018/5/12
 * Time: 9:30
 */

namespace app\admin\model;


class Comment
{
    public function index(){
        $arr=db('advice')->select();
        return $arr;
    }
    public function add($arr){
        $data = [
            'tel' => $arr['phone'],
            'city' => $arr['city'],
            'describe' => $arr['des']
        ];
//        print_r($data);
        db('advice')->insert($data);
        echo true;
    }
    public function etic($arr,$id=''){
        if(empty($arr)){
            $arr=db('advice')->where('Id',$id)->find();
            return $arr;
        }else{
            $data = [
                'tel' => $arr['phone'],
                'city' => $arr['city'],
                'describe' => $arr['des']
            ];
            $id=$arr['id'];
            db('advice')->where('Id',$id)->update($data);
            echo true;
        }
    }
    public function del($id){
        db('advice')->where('Id',$id)->delete();
    }
}