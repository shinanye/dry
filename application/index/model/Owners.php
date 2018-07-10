<?php
namespace app\index\model;

use think\Db;

class Owners
{
    public function owners($tel){
        $data = Db::table("dry_housers")
            ->where("stel",$tel)
            ->select();
        return $data;
    }

    public function insertData($arr){
        $arr = ["sname"=>$arr["username"],"stel"=>$arr["tel"],"sarea"=>$arr["city"],"svillage"=>$arr["community"],"sothers"=>$arr["remarks"],"sdetailAddress"=>$arr["detailedAddress"]];

        $data = Db::table('dry_housers')
            ->insert($arr);
        return $data;
    }
}
