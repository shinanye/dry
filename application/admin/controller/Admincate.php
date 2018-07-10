<?php
/**
 * Created by PhpStorm.
 * User: 张靖
 * Date: 2018/5/3
 * Time: 18:25
 */

namespace app\admin\controller;
use think\Controller;
use think\Validate;
use think\Request;
class Admincate extends Controller
{
    public function index(){
        $request=request();
        $type=$request->param()['type'];
        $arr=model("admincate")->index();
        for($i=0;$i<count($arr);$i++){
//        foreach($arr as $item){
            $str=$arr[$i]['handle'];
            $str=str_replace('0','查找',$str);
            $str=str_replace('1','停用',$str);
            $str=str_replace('2','启用',$str);
            $str=str_replace('3','删除',$str);
            $str=str_replace('4','添加',$str);
            $str=str_replace('5','编辑',$str);
            $str=str_replace('6','修改密码',$str);
//            echo $str;
            $arr[$i]['handle']=$str;
            if($arr[$i]['parentid']>0){
                $arr[$i]['name']='-------'.$arr[$i]['name'];
            }
        }
        $arr1=array();
        foreach($arr as $item){
            if($item['parentid']==0){
                $id=$item['Id'];
                $arr2=array();
                foreach($arr as $item1){
                    if($item1['parentid']==$id){
                        $arr2[]=$item1;
                    }
                }
                $arr1[]=[$item,$arr2];
            }
        }
//        print_r($arr1);
//        exit;
        return $this->fetch('admincate',['type'=>$type,'arr'=>$arr1]);
    }
    public function add(){
        $request=request();
        if(empty($request->param())){
            $arr=model("admincate")->add([]);
            return $this->fetch('add',['arr'=>$arr]);
        }else{
            $validate = new Validate([
                'name'  => 'require|chs|token',
                'icon' => 'max:20',
                'parent' => 'require|number'
            ]);
            if (!$validate->check($request->param())) {
                dump($validate->getError());
                echo false;
            }else{
//                print_r($request->param());
                model('admincate')->add($request->param());
            }
        }

    }
    public function etic(){
        $request=request();
        if(empty($request->param())){
            $id=cookie('admincate_id');
            cookie('admincate_id',null);
            $arr=model("admincate")->add([]);
            $arr1=model("admincate")->etic([],$id);
//            print_r($arr1);
            return $this->fetch('etic',['arr'=>$arr,'arr1'=>$arr1]);
        }else{
            $validate = new Validate([
                'name'  => 'require|chs|token',
                'icon' => 'max:20',
                'parent' => 'require|number'
            ]);
            if (!$validate->check($request->param())) {
                dump($validate->getError());
                echo false;
            }else{
//                print_r($request->param());
                model('admincate')->etic($request->param());
            }
        }
    }
    public function del(){
        $request=request();
        $id=$request->param('id');
        $str=model('admincate')->del($id);
        echo $str;
    }
}