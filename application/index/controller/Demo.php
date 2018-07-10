<?php
namespace app\index\controller;

use think\Controller;

class Demo extends Controller
{
    public function demo()//加盟界面
    {
        return view("demo");
    }

    public function pop()//加盟界面
    {
        return view("pop");
    }

    public function mai()//加盟界面
    {
        return view("mai");
    }
}
