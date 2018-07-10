<?php
namespace app\index\controller;

use think\Controller;
use app\index\model\Owners as Owners;

    class Owner extends Controller
    {
        public function owner()//加盟界面
        {
            $owModel = new Owners();
            if(!empty($_POST)){
                $arr = [];
                $checkTel = checkPhone($_POST["tel"]);
                if($checkTel["status"]==0){//正则电话验证失败
                    $arr =  $checkTel;
                }else{
                    $validate = $this->validate($_POST,'User.owner');
                    if(true ===$validate){
                        $data = $owModel->owners($_POST["tel"]);
                        if(empty($data)){
                            unset($_POST["__token__"]);
                            $data = $owModel->insertData($_POST);
                            if($data==1){
                                $arr = retuanData(1,"你的申请已被接受，工作人员将在3-5个工作日内联系你，请保持电话畅通");
                            }else{
                                $arr = retuanData(0,"加盟失败，请重新填信息");
                            }
                        }else{
                            $arr = retuanData(0,"该电话号码已加盟，更多内容请跟工作人员联系");
                        }
                    }else{
                        //验证失败
                        $arr = retuanData(0,$validate);
                    }
                }
                return json_encode($arr);
            }else{
                return view("owner");
            }

        }

        public function aboutus()//关于我们
        {
            return view("aboutus");
        }

    }

