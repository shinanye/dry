<?php
/**
 * Created by PhpStorm.
 * User: 张靖
 * Date: 2018/5/2
 * Time: 16:58
 */

namespace app\admin\model;
use think\Db;
class Room
{
    public function index(){
        $arr=Db::view('room','*')
            ->view('dry_housers','sname','room.sid=dry_housers.Id')
            ->where('dry_housers.ssign',4)
            ->select();
        return $arr;
    }
}