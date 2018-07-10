<?php
/**
 * Created by PhpStorm.
 * User: 张靖
 * Date: 2018/5/3
 * Time: 10:13
 */

namespace app\agents\model;
use think\Cookie;
class Person
{
    public function index($agent){
        $arr=db('agent')
            ->where('gname',$agent)
            ->find();
        return $arr;
    }
    public function etic($arr){
        $id=$arr['id'];
        $arrs=db('agent')->where('gid',$id)->find();
        if($arrs['gname']==$arr['agent']){
            $data = [
                'gtel' => $arr['phone'],
                'gemail' => $arr['email']
            ];
            db('agent')->where('gid',$id)->update($data);
            return 1;
        }else{
            $namearr=db('agent')->where('gname',$arr['agent'])->find();
            if(empty($namearr)){
                $data = [
                    'gname' => $arr['agent'],
                    'gtel' => $arr['phone'],
                    'gemail' => $arr['email']
                ];
                db('agent')->where('gid',$id)->update($data);
                cookie('agent', $arr['agent'],10800);
                return 2;
            }else{
                return 3;
            }
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
}