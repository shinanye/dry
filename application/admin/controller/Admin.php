<?php
namespace app\admin\controller;
use think\Controller;
use think\Request;
use think\Validate;
use think\Cookie;
class Admin extends Controller
{
    public function index(){
        $request=request();
        $type=$request->param()['type'];
        $arr=model('admin')->index();
        return $this->fetch('admin',['type'=>$type,'arr'=>$arr]);
    }
    public function adminadd(){//添加管理员
        $request=request();
        if(empty($request->param())){
            $arr=model('admin')->adminadd();
            return $this->fetch('adminadd',['arr'=>$arr]);
        }else{
            $validate = new Validate([
                'adminName'  => 'require|token',
                'password' => 'require|max:20',
                'phone' => 'require|number|min:11|max:11',
                'email' => 'require|email',
                'adminRole' => 'require|max:2'
            ]);
            if (!$validate->check($request->param())) {
                dump($validate->getError());
                echo false;
            }else{
//                print_r($request->param());
                model('admin')->adminadd($request->param());
            }
        }
    }
    public function adminetic(){//编辑管理员
        $request=request();
        if(empty($request->param())){
            $arr=model('admin')->adminadd();
            $arr1=model('admin')->adminetic([],cookie('admin_id'));
            cookie('admin_id', null);
//            print_r($arr1);
//            exit;
            return $this->fetch('adminetic',['arr'=>$arr,'arr1'=>$arr1]);
        }else{
            $validate = new Validate([
                'adminName'  => 'require|token',
                'password' => 'require|max:20',
                'phone' => 'require|number|min:11|max:11',
                'email' => 'require|email',
                'adminRole' => 'require|max:2'
            ]);
            if (!$validate->check($request->param())) {
                dump($validate->getError());
                echo false;
            }else{
//                print_r($request->param());
                model('admin')->adminetic($request->param());
            }
        }
    }
    public function adel(){//管理员删除
        $request=request();
        $aid=$request->param('aid');
        model('admin')->adel($aid);
        echo true;
    }
    public function atype(){//管理员停用/开始
        $request=request();
        $aid=$request->param('aid');
        $status=$request->param('astatus');
        model('admin')->atype($aid,$status);
        echo true;
    }
    public function role(){
        $request=request();
        $type=$request->param()['type'];
        $arr=model("admin")->role();
//        print_r($arr);
        return $this->fetch('role',['type'=>$type,'arr'=>$arr]);
    }
    public function radd(){//增加角色
        $request=request();
        if(empty($request->param())){
            return $this->fetch('radd');
        }else{
            $validate = new Validate([
                'role' => 'require',
                'beizhu' => 'require'
            ]);
            if (!$validate->check($request->param())) {
                dump($validate->getError());
                echo false;
            }else{
                print_r($request->param());
                model('admin')->radd($request->param());
                echo false;
            }
        }
    }
    public function rcate(){//角色授权
        $request=request();
        if(empty($request->param())){
            $id=cookie('role_id');
            $arr=model('admin')->rcate();
//            print_r($arr);
//            exit;
            return $this->fetch('rcate',['arr'=>$arr,'id'=>$id]);
        }else{
//            print_r($request->param());
            model('admin')->rcate($request->param());

        }
    }
    public function retic(){//编辑角色
        $request=request();
        if(empty($request->param())){
            $id=cookie('role_id');
            $arr=model('admin')->retic([],$id);
            return $this->fetch('retic',['arr'=>$arr,'id'=>$id]);
        }else{
            $validate = new Validate([
                'role' => 'require',
                'beizhu' => 'require'
            ]);
            if (!$validate->check($request->param())) {
                dump($validate->getError());
                echo false;
            }else{
                print_r($request->param());
                model('admin')->retic($request->param());
            }
        }
    }
    public function rdel(){//删除角色
        $request=request();
        $id=$request->param('id');
        model('admin')->rdel($id);
        echo true;
    }

}