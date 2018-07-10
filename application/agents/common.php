<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006-2016 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: 流年 <liu21st@gmail.com>
// +----------------------------------------------------------------------

// 应用公共文件


/**
 * 文件上传
 * @param $file   要上传的文件
 * @param $size  大小设置
 * @param $ext  文件类型
 * @return bool  是否上传成功
 */
function imgUpload($file, $size, $ext){
    $info = $file->validate(['size'=>$size,'ext'=>$ext])->move(ROOT_PATH . 'public/static/' . DS . 'uploads');
    if($info){
        $filename=$info->getSaveName();
        $image=\think\Image::open("static/uploads/".$filename);
        // 按照原图的比例生成一个最大为200*200的缩略图并保存为thumb.png
        $image->thumb(200, 200)->save("static/uploads/".$filename);
        return $filename;
    }else{
        return false;
    }
}

/**
 * 判断类型
 * @param $num   需要判断是那种类型
 */
function judgeType($param,$type){
    if($type=="array"&&is_array($param)){
        return  returnData(1,"success");

    }else if($type=="string"&&is_string($param)){

        return  returnData(1,"success");

    }else if($type=="int"&&is_int($param)){

        return  returnData(1,"success");

    }else if($type=="float"&&is_float($param)){
        return  returnData(1,"success");
    }
    return returnData(0,"类型不正确");
}
/**
 * 判断字段长度是否满足条件
 * @param $str  要判断的字段
 * @param $len  长度
 */
function judgeLen($str, $len){
    $allLen=mb_strlen($str,'utf8');
    if($allLen>$len){
        return returnData(0,"长度过长");
    }
    return returnData(1,"");
}

/**
 * 过滤危险字符
 * @param $str
 */
function filterDangerChars($str){

    foreach(config("dangerChars") as $item){

        if(mb_strpos($str,$item,0,"utf8") !==false){
            return returnData(0,"存在敏感字符");
            break;
        }
    }
    return returnData(1,"");
}

/**
 * 基础过滤
 * @param $param  字段
 * @param $type  类型
 * @param $len  长度
 */
function filterBase($param, $type, $len){
    if(!isset($param)){
        return  returnData(0,"字段为空");
    }
    $typeResult=judgeType($param, $type);  //判断类型是否一致
    if($typeResult["code"]==0) return $typeResult;
    $lenResult=judgeLen($param,$len);   //判断长度是否满足要求
    if($lenResult["code"]==0) return $lenResult;
    $dangerResult=filterDangerChars($param);  //是否包含非法字符

    if($dangerResult["code"]==0) return $dangerResult;

    return returnData(1,"success");

}


/**
 * sql防注入 进行转义
 * @param $param   需要过滤的字段
 * @param bool|true $addslashes   true---通过addslashes 转义，false---替换一些sql中的关键字
 * @param string $type     转成什么类型
 * @return int|mixed|string
 */
function filterSql($param, $addslashes=true, $type=""){
    if($addslashes){
        $param = addslashes($param);
    }else{
        $param=paramReplace($param);
    }
    if($type=="int"){
        $param=changeType($param,"int");
    }

    return $param;
}

/**
 * 强制转换成指定类型
 * @param $param   需要转换的字段
 * @param $type   需要转换的类型
 * @return array|float|int|string  返回的数据
 */
function changeType($param, $type){
    if($type=="int"){
        $param = intval($param);
    }else if($type="float"){
        $param = floatval($param);
    }else if($type=="string"){
        $param = strval($param);
    }else if($type=="array"){
        $param=array($param);
    }
    return $param;
}

/**
 * 过滤一些特殊的sql语句中的关键字
 * @param $str
 * @return mixed
 */
function paramReplace($str)
{
    $str = str_replace(" ","",$str);
    $str = str_replace("\n","",$str);
    $str = str_replace("\r","",$str);
    $str = str_replace("'","",$str);
    $str = str_replace('"',"",$str);
    $str = str_replace("or","",$str);
    $str = str_replace("and","",$str);
    $str = str_replace("#","",$str);
    $str = str_replace("\\","",$str);
    $str = str_replace("null","",$str);
    $str = str_replace(">","",$str);
    $str = str_replace("<","",$str);
    $str = str_replace("=","",$str);
    $str = str_replace("char","",$str);
    $str = str_replace("order","",$str);
    $str = str_replace("select","",$str);
    $str = str_replace("create","",$str);
    $str = str_replace("delete","",$str);
    $str = str_replace("insert","",$str);
    $str = str_replace("execute","",$str);
    $str = str_replace("update","",$str);
    $str = str_replace("count","",$str);
    return $str;
}

/**
 * 为了避免xss漏洞 把指定的标签进行过滤  （strip_tags  去掉全部）
 * @param $param 要过滤的字段  $str="dfdf<b>dfdf</b><script>alert('1111');<em>斜体</em></script>";
 * @param $tags  指定哪些标签需要过滤
 * @return mixed
 */
function filterXSS($param, $tags){
    foreach($tags as $tag) {
        $pattern = '/\<.*?'.$tag.'.*?\>.*\<(\/)?'.$tag.'.*?\>/i';
//正则过滤指定标签
        $param=  preg_replace($pattern, '', $param);
    }
    return $param;
}

/**
 * 为了避免xss漏洞，把标签转为字符串
 * @param $param  需要把标签转成字符串的的字段
 */
function filterXSS1($param){
    $param = htmlspecialchars($param);
    return $param;
}
/**
 *
 */
function filterUpload($file,$type){
    if($type=="img"){
        if(in_array($file,config("img"))){
            return returnData(1,"");
        }
    }
    return returnData(0,"类型不正确");
}

/**
 * @param $code  0---error  1-success
 * @param $data
 * @return array   返回的是数组
 */
function returnData($code, $data){
    return array(
        "code"=>$code,
        "data"=>$data
    );
}



