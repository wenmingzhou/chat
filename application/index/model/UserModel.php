<?php
namespace app\index\model;

use think\Model;

class UserModel   extends Model
{
	protected $pk = 'id';
   //数据表，需要写表全名，如表前缀wb,那么这里需要写wb_category
    protected $table = 'user';
 	
    public function test()
    {
    	die("model");
    }
	public function getstatusAttr($value)
    {
        $status = [-1=>'删除',0=>'禁用',1=>'正常',2=>'待审核'];
        return ['val' => $value, 'text' => $status[$value]];
       
    }
    
 	public function setusernameAttr($value)
    {
        return strtolower($value);
    }
    
    
	public function getstatustextAttr($value,$data)
    {
        $status = [-1=>'删除1',0=>'禁用1',1=>'正常1',2=>'待审核1'];
        return $status[$data['status']];
       
    }
   public function store($data)
   {
      $result = $this->save($data);
   }
   public function up($data)
   {
   	  $this->save($data,['id' => 5]);
   }
   public function del()
   {
   	  $this->where('id','<=',45)->delete();
   }
   public function sel()
   {
   	
   		$bb = $this->where('id','=',46)->select();
   		$data =array();
	    foreach($bb as $key=>$user)
	    {
	    	$data[$key]['id'] = $user->id;
	    	$data[$key]['username'] = $user->username;
	    	$data[$key]['sex'] = $user->sex;
	    	$data[$key]['time'] = $user->time;
		}
		return $data;
   }
	
}