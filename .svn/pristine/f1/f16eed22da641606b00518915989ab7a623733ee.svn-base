<?php
/**
 * Created by PhpStorm.
 * User: 张靖
 * Date: 2018/5/2
 * Time: 16:57
 */

namespace app\admin\model;

use think\Db;
class Admin
{
    public function index(){
        $arr=db('admin as a')
            ->join('admin_role b','a.arole=b.Id')
            ->field('a.*,b.role')
            ->select();
        return $arr;
    }
    public function adminadd($arr=[]){//添加管理员
        if(empty($arr)){
            $arr=db('admin_role')
                ->field('Id,role')
                ->select();
            return $arr;
        }else{
            $data = [
                'aname' => $arr['adminName'],
                'apwd' => md5(sha1($arr['password'])),
                'atel' => $arr['phone'],
                'aemail' => $arr['email'],
                'arole' => $arr['adminRole'],
                'atime' => date("Y-m-d h:i:s",time()),
                'beizhu'=> $arr['beizhu'],
                'astatus' => 0
            ];
            db('admin')->insert($data);
            echo true;
        }
    }
    public function adminetic($arr,$aid=''){//编辑管理员
        if(empty($arr)){
            $arr=db('admin')->where('aid',$aid)->find();
            return $arr;
        }else{
            $data = [
                'aname' => $arr['adminName'],
                'apwd' => md5(sha1($arr['password'])),
                'atel' => $arr['phone'],
                'aemail' => $arr['email'],
                'arole' => $arr['adminRole'],
                'atime' => date("Y-m-d h:i:s",time()),
                'beizhu'=> $arr['beizhu']
            ];
            $aid=$arr['id'];
            db('admin')->where('aid',$aid)->update($data);
            echo true;
        }
    }
    public function adel($aid){//管理员删除
        db('admin')->where('aid',$aid)->delete();
    }
    public function atype($aid,$status){//管理员停用-开启
        db('admin')->where('aid',$aid)->update(['astatus' =>$status]);
    }

    public function role(){
        $arr=db('admin_role')->select();
        return $arr;
    }
    public function radd($arr){//增加角色
        $date=[
            'role' => $arr['role'],
            'describe' => $arr['beizhu']
        ];
        db('admin_role')->insert($date);
    }
    public function rcate($arr=[]){//角色授权
        if(empty($arr)){
            $arr=db('admincate')
                ->field('Id,name,parentid')
                ->select();
            $arr1=array();
            foreach($arr as $item){
                if($item['parentid']==0){
                    $id=$item['Id'];
                    $arr2=array();
                    foreach($arr as $item1){
                        if($item1['parentid']==$id){
                            $arr2[]=$item1;
                        }
                    }
                    $arr1[]=[$item,$arr2];
                }
            }
            return $arr1;
        }else{
            $id=$arr['id'];
            $arr1=[];
            foreach($arr as $key=>$item){
                if(strpos($key,'id')===0){
                }else if(strpos($key,'a')===0){
                    $key=str_replace('a','',$key);
//                    echo $id.'---'.$key.'----a------'.$item;
//                    echo "<br>";
                    $arr1[]=['roleid'=>$id,'cateid' =>$key, 'status' => $item];
                }else{
                    return;
                }
            }
            print_r($arr1);
            Db::startTrans();
            try{
                Db::table('dry_rolecate')->where('roleid',$id)->delete();
                Db::table('dry_rolecate')->insertAll($arr1);
                // 提交事务
                Db::commit();
            } catch (\Exception $e) {
                // 回滚事务
                Db::rollback();
            }
//            db('rolecate')->insertAll($arr1);
        }
    }
    public function retic($arr=[],$id=''){//编辑角色
        if(empty($arr)){
            $arr=db('admin_role')->where('id',$id)->find();
            return $arr;
        }else{
            $date=[
                'role' => $arr['role'],
                'describe' => $arr['beizhu']
            ];
            db('admin_role')->where('id',$arr['id'])->update($date);
        }
    }
    public function rdel($id){//删除角色
        db('admin_role')->where('Id',$id)->delete();
    }

}