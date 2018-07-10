<?php
/**
 * Created by PhpStorm.
 * User: 张靖
 * Date: 2018/5/8
 * Time: 12:32
 */

namespace app\agents\model;

use think\Db;
class House
{
    public function index($agent){
        $id=db('agent')->where('gname',$agent)->field('gid')->find()['gid'];
        $arr=db('housers')->where('ssign','>',1)->where('ssign','<',4)->where('sid',$id)->select();
        return $arr;
    }
    public function house($agent){
        $id=db('agent')->where('gname',$agent)->field('gid')->find()['gid'];
        $arr=Db::view('agent','gid')
            ->view('dry_room','sid','dry_room.gid=agent.gid')
            ->view('dry_housers','*','dry_room.sid=dry_housers.Id')
            ->where('agent.gid',$id)
            ->group('dry_housers.Id')
            ->select();
        return $arr;
    }
    public function etic($arr){
        if($arr['type']==4){
            $tel=db('housers')->where('Id',$arr['id'])->find()['stel'];
            $arr1=db('housers')->where('ssign',4)->where('stel',$tel)->find();
            if(empty($arr1)){
                db('housers')->where('Id',$arr['id'])->update(['ssign' => $arr['type']]);
                return true;
            }else{
                db('housers')->where('Id',$arr['id'])->delete();
                return true;
            }
        }else{
            db('housers')->where('Id',$arr['id'])->update(['ssign' => $arr['type']]);
            return true;
        }
    }
    public function del($id){
        db('housers')->where('Id',$id)->delete();
        return true;
    }
}