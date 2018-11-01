<?php

namespace app\index\validate;

use think\Validate;

class User extends Validate
{
     protected $rule =   [
        'username'  => 'require|max:25',
        'sex'   => 'number|between:1,120',
        'email' => 'email',    
    ];
    
    protected $message  =   [
        'username.require' => '名称必须',
        'username.max'     => '名称最多不能超过25个字符',
        'sex.number'   => '年龄必须是数字',
        'sex.between'  => '年龄只能在1-120之间',
        'email'        => '邮箱格式错误',    
    ];
    
    protected $scene = [
        'edit'  =>  ['username','sex'],
    	'add'  =>  ['username','sex'],
    ];
    

}
