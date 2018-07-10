<?php
namespace app\agents\model;
class Index
{
    public function index(){

    }
    public function login($user){
        $arr=db('agent')
            ->where('gname',$user)
            ->where("gstatus",1)
            ->find();
        return $arr;
    }
    public function regist($arr=[],$name=''){
        if(empty($arr)){
            $arr=db('agent')
                ->where('gname',$name)
                ->find();
            return $arr;
        }else{
            $data = [
                'gname' => $arr['user'],
                'gpwd' => md5(sha1($arr['pwd'])),
                'gtel' => $arr['tel'],
                'gemail' => $arr['email'],
                'gstatus' => 1
            ];
//        print_r($data);
//        exit;
            db('agent')->insert($data);
        }
    }
}