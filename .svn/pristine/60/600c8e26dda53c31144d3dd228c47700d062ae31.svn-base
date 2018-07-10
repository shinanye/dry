<?php
namespace app\index\model;

use think\Db;

class Forget
{
    public function forget($tel){//找回密码
        $data = Db::table('dry_user')
            ->where('utel', $tel)
            ->select();
        return $data;
    }

    public function insertData($tel,$pwd){
        $data = Db::table('dry_user')
            ->where('utel', $tel)
            ->update(['upwd' => $pwd]);
    }
}
