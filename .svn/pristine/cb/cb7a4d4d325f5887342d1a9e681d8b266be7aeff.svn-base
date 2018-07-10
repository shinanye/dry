<?php
namespace app\index\validate;
use think\Validate;
header("Content-type: text/html; charset=utf-8");
class User extends Validate{
    protected $rule = [
        'tel'  =>  'require|max:11|min:2|token',
        'password'  =>  'require|max:16|min:6',
        'newpwd'  =>  'require|max:16|min:6',
        'username'  =>  'require',
        'city'  =>  'require',
        'community'  =>  'require',
        'detailedAddress'  =>  'require',
    ];

    //错误提示
    protected $message  =   [
        'tel.require' => '电话必须填写',
        'tel.max'     =>'电话号码最多不超过11位',
        'password.require' => '密码必须填写',
        'password.min' => '密码最小为6位字符',
        'password.max' => '密码最长为16位字符',
        'newpwd.require' => '密码必须填写',
        'newpwd.min' => '密码最小为6位字符',
        'newpwd.max' => '密码最长为16位字符',
        'username'  =>  '您的姓名必须填写',
        'city'  =>  '请输入所在地区名称',
        'community'  =>  '请输入小区名称',
        'detailedAddress'  =>  '请输入单元、座栋等',
    ];

    protected $scene  =   [
        'register' => ['tel','password'],//验证的场景 => 需要验证的字段
        'login' => ['tel','password'],
        'forget' => ['tel','newpwd'],
        'owner' => ['tel','username','city','community','detailedAddress'],
    ];
}