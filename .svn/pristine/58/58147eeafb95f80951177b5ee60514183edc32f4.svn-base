<?php
    function retuanData($code,$msg,$cookies=""){
        $arr = array("status"=>$code,"txt"=>$msg,"cookies"=>$cookies);
        return $arr;
    }

    function checkPhone($tel){
        $regex = "/^((13[0-9])|(14[5|7])|(15([0-3]|[5-9]))|(18[0,5-9])|(17[0,5-9]))\\d{8}$/";
        $flags = preg_match($regex,$tel,$array);
        if($flags){
            return retuanData(1,"");
        }else{
            return retuanData(0,"非法电话号码或者电话号码不足11位");
        }
    }

    function sendSMS($tel){
        //个人发信息
        require(EXTEND_PATH.'/sms/YunpianAutoload.php');

        $randStr = str_shuffle('1234567890');//产生6位随机验证码数字
        $rand = substr($randStr,0,6);
//        setcookie("code",md5(sha1($rand)), time()+180);
        setcookie("code",$rand, time()+180);
        $smsOperator = new SmsOperator();
        $data['mobile'] = $tel;   //发送的电话号码
        $data['text'] = '【云片网】您的验证码是'.$rand;
//        $result = $smsOperator->single_send($data);
        return retuanData(1,"短信验证发送成功");
    }

