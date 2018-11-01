<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006~2016 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: liu21st <liu21st@gmail.com>
// +----------------------------------------------------------------------

//\think\Route::get('blog/add','index/one.Blog/add');

return [
    '__pattern__' => [
        'name' => '\w+',
    ],
    '[hello]'     => [
        ':id'   => ['index/hello', ['method' => 'get'], ['id' => '\d+']],
        ':name' => ['index/hello', ['method' => 'post']],
    ],
    
    //'hello/[:name]' => 'hello/hello',
    'hello/[:name]' => ['hello/hello', ['method' => 'get', 'ext' => 'html']],
    
    /*
    'blog/:year/:month' => ['blog/archive', ['method' => 'get'], ['year' => '\d{4}', 'month' => '\d{2}']],
    'blog/:id'          => ['blog/get', ['method' => 'get'], ['id' => '\d+']],
    'blog/:name'        => ['blog/read', ['method' => 'get'], ['name' => '\w+']],
    */
    
    '[blog]' => [
        ':year/:month' => ['blog/archive', ['method' => 'get'], ['year' => '\d{4}', 'month' => '\d{2}']],    
        ':id'          => ['blog/get', ['method' => 'get'], ['id' => '\d+']],
        ':name'        => ['blog/read', ['method' => 'get'], ['name' => '\w+']],
    ],
   

   

];

