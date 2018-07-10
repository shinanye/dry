<?php
namespace app\index\model;

use think\Db;
use think\Model;

class Login extends Model
{
    function userName($tel){
        $data = Db::name("user")
                ->field("upwd")
                ->where("utel",$tel)
                ->select();
        return $data;
    }


}
