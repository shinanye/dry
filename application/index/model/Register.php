<?php
namespace app\index\model;

use think\Db;
use think\Model;

class Register extends Model
{
    function selectData($_tel){
        $data = Db::name("user")
            ->where(["utel"=>$_tel])
            ->select();
        return $data;
    }

    function insertData($arr){// 插入成功返回1
        $data = Db::name('user')->insert($arr);
        return $data;
    }


}
