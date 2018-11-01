<?php
namespace app\index\service;

use think\Model;

class UserModel  extends Model
{
	protected $pk = 'id';
   //数据表，需要写表全名，如表前缀wb,那么这里需要写wb_category
    protected $table = 'user';
 	
	function test()
	{
		die("service");
	}
	
}