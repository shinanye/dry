<?php

namespace app\admin\model;
use think\model;
class Index
{
    public function index($roleid){
        $arr=db('admincate as a')
            ->join('rolecate b','a.Id=b.cateid')
            ->field('a.*,b.status')
            ->where("b.roleid=$roleid")
            ->select();
        $arr1=db('admincate')
            ->where("parentid",0)
            ->select();
        $arr2=array();
        foreach($arr1 as $item){
            if($item['parentid']==0){
                $id=$item['Id'];
                $arr3=array();
                foreach($arr as $item1){
                    if($item1['parentid']==$id){
                        $item1['url']=$item1['url'].'?/status/'.$item1['status'];
                        $arr3[]=$item1;
                    }
                }
                if(!empty($arr3)){
                    $arr2[]=[$item,$arr3];
                }
            }
        }
        return $arr2;
    }
    public function role ($user){//在index页面role
        $arr=db('admin as a')
            ->join('admin_role b','a.arole=b.Id')
            ->field('Id,role,beizhu,describe')
            ->where('a.aname',$user)
            ->find();
        return $arr;
    }
    public function login($user){
        return db('admin')->where('aname',$user)->value('apwd');
    }
}