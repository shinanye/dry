<?php
/**
 * Created by PhpStorm.
 * User: 张靖
 * Date: 2018/5/12
 * Time: 10:08
 */

namespace app\agents\model;

use think\Db;
class Orders
{
    public function index($agent){
//        $arr=Db::view('bargain','Id,agent,conimg')
//            ->view('dry_housers','sname','bargain.sid=dry_housers.Id')
//            ->view('dry_user','uname','bargain.uid=dry_user.uid')
//            ->where('bargain.agent',$agent)
//            ->select();
        $arr=db('bargain')->where('agent',$agent)->select();
        return $arr;
    }
    public function add($arr=[],$pic=[]){
        if(empty($arr)){
            $arr=db('join')->field('Id,rtitle')->where('rstatus',1)->select();
        }else{
            Db::startTrans();
            try{
                $data=['sname' => $arr['sname'],'uname' => $arr['uname'],'agent' => $arr['agent'], 'conimg' => $pic];
//            Db::table('dry_bargain')->insert($data);
//            $id = Db::table('dry_bargain')->getLastInsID();
                // 提交事务
                Db::commit();
                return 3;
            } catch (\Exception $e) {
                // 回滚事务
                unlink("static/agents/orders/$pic");
                Db::rollback();
                return 2;
            }
        }

    }
}