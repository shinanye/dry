<?php
/**
 * Created by PhpStorm.
 * User: 张靖
 * Date: 2018/5/8
 * Time: 9:19
 */

namespace app\admin\model;
class House
{
    public function index($type){
        $arr=db('housers')
            ->where('ssign',$type)
            ->select();
        return $arr;
    }
    public function allot($arr=[]){
        if(empty($arr)){
            $arr=db('agent')
                ->field('gid,gname')
                ->select();
            return $arr;
        }else{
            $data = [
                'sid' => $arr['agent'],
                'ssign' => 2
            ];
            db('housers')->where('Id',$arr['id'])->update($data);
            echo true;
        }
    }
    public function etic($arr,$id=''){
        if(empty($arr)){
            $arr=db('housers')->where('Id',$id)->find();
            return $arr;
        }else{
            $data = [
                'sname' => $arr['name'],
                'stel' => $arr['phone'],
                'sarea' => $arr['area'],
                'svillage' => $arr['village'],
                'sothers' => $arr['other']
            ];
            db('housers')->where('Id',$arr['id'])->update($data);
            echo true;
        }
    }
    public function del($id){
        db('housers')->where('Id',$id)->delete();
        return true;
    }
}