<?php
/**
 * Created by PhpStorm.
 * User: 张靖
 * Date: 2018/5/3
 * Time: 18:25
 */

namespace app\admin\model;
use think\Db;
class Admincate
{
    public function index(){
        $arr=Db::view('admincate','*')
            ->view('dry_adminhandle',['group_concat(handle)'=>'handle'],'admincate.Id=dry_adminhandle.handlecateid')
            ->group('dry_adminhandle.handlecateid')
            ->select();
        return $arr;
    }
    public function add($arr){
        if(empty($arr)){
            $arr=db('admincate')
                ->field('Id,name')
                ->where('parentid',0)
                ->select();
            return $arr;
        }else{
            Db::startTrans();
            try{
                $data = [
                    'name' => $arr['name'],
                    'url' => $arr['url'],
                    'icon' => $arr['icon'],
                    'parentid' => $arr['parent']
                ];
                Db::table('dry_admincate')->insert($data);
                if(!empty($arr['check'])){
                    $id = Db::table('dry_admincate')->getLastInsID();
                    $data1 = [];
//                    print_r($arr['check']);
                    foreach($arr['check'] as $item){
                        $data1[]=['handlecateid' => $id , 'handle' => $item];
                    }
                    Db::table('dry_adminhandle')->insertAll($data1);
                }

                // 提交事务
                Db::commit();
                return true;
            } catch (\Exception $e) {
                // 回滚事务
                Db::rollback();
                return false;
            }
        }
    }
    public function etic($arr,$id=''){
        if(empty($arr)){
            return db('admincate')->where('Id',$id)->find();
        }else{
            Db::startTrans();
            try{
                $data = [
                    'name' => $arr['name'],
                    'url' => $arr['url'],
                    'icon' => $arr['icon'],
                    'parentid' => $arr['parent']
                ];
                Db::table('dry_admincate')->where('Id',$arr['id'])->update($data);
                if(!empty($arr['check'])){
                    $data1 = [];
//                    print_r($arr['check']);
                    foreach($arr['check'] as $item){
                        $data1[]=['handlecateid' => $id , 'handle' => $item];
                    }
                    Db::table('dry_adminhandle')->where('handlecateid',$arr['id'])->delete();
                    Db::table('dry_adminhandle')->insertAll($data1);
                }
                // 提交事务
                Db::commit();
                return true;
            } catch (\Exception $e) {
                // 回滚事务
                Db::rollback();
                return false;
            }
        }
    }
    public function del($id){

        Db::startTrans();
        try{
            $arr=Db::table('dry_admincate')->where('Id',$id)->find();
            if($arr['parentid']==0){
                $pid=$arr['Id'];
               $arr=Db::table('dry_admincate')->where('parentid',$pid)->field('Id')->select();
                foreach($arr as $item){
                    Db::table('dry_admincate')->where('Id',$item['Id'])->delete();
                    Db::table('dry_adminhandle')->where('handlecateid',$item['Id'])->delete();
                }
            }
            Db::table('dry_admincate')->where('Id',$id)->delete();
            Db::table('dry_adminhandle')->where('handlecateid',$id)->delete();
            // 提交事务
            Db::commit();
            return true;
        } catch (\Exception $e) {
            // 回滚事务
            Db::rollback();
            return false;
        }
    }
}