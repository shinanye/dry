<?php
namespace app\index\model;


use think\Db;

class Index
{
    public function index($address)
    {
        $data = Db::name("room")
                ->alias("r")
                ->join('join j','r.rid = j.rid')
                ->join('image img','j.id = img.fid')
                ->where("img.imagetype",0)
                ->where("r.rcity",$address)
                ->where("j.rstatus",0)
                ->field('r.rid,img.imageurl,j.rtitle,j.rareas,j.rdirection,j.rprice,r.raddress,r.rfloor,r.rrentType,img.fid')
                ->limit(5)
                ->group("j.rprice")
                ->select();

        return $data;
    }

    public function forget($tel){

    }
}
