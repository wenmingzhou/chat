<?php
namespace app\index\controller;
use think\Db;
use app\index\model\UserModel;

use think\Validate;

class Blog
{

	public function edit()
	{
		
		$user = new UserModel();

		 $user->data([
                'username'=>'ZhouZhouZhouZhouZhouZhouZhouZhouZhouZhou',
                'sex'=>'125',
                'status'=>'1',
            ]);
		$validate = \Think\Loader::validate('User');
		if($validate->scene('add')->check($user))
		//if($validate->check($user))
		{	 
			//注意，在模型数据操作的情况下，验证字段的方式，直接传入对象即可验证
             $db= $user->save();  //这里的save()执行的是添加
              if($db){
                    echo "success";
              }else{
                     echo "failed";
              }
        }
        else
        {
               return $validate->getError();
        }
		
		
	
	} 
	
    public function get($id)
    {
    	
		
		
		
		
		
		die;
		
	    $data = [
	    'name'=>'thinkphpthinkphpthinkphpthinkphpthinkphp',
	    'email'=>'thinkphp'
		];

		$validate = \Think\Loader::validate('User');
		
		if(!$validate->batch()->check($data)){
		    dump($validate->getError());
		}
		
		
		die;
    	
    	
		$validate = new Validate([
		    'name'  => 'require|max:25',
		    'email' => 'email'
		]);
		$data = [
		    'name'  => 'thinkphpthinkphpthinkphpthinkphp',
		    'email' => 'thinkphp@qq.com'
		];
		if (!$validate->check($data)) {
		    print_r($validate->getError());
		}
    	die;
    	$user = UserModel::get(48);
    	//print_r($user->toJson());
    	echo json_encode($user);
    	//$user = \think\Loader::model('UserModel','service');
    	//$user->test();
    	/*
    	$user = new UserModel();
		$user->username = 'Zhou';
		$user->sex = '2';
		$user->status = '1';
		$user->save();
		echo $user->sex; die;
    	
    	
    	$user = UserModel::get(48);
    	print_r($user->status);
    	echo $user->getData('status');
    	//print_r($user->toArray());
    	print_r($user->status_text);die;
		$user->delete();*/
		
    	/*
    	$user = UserModel::get(46);
		$user->username     = 'thinkphp';
		$user->sex    = 'thi';
		$user->save();
    	*/
    	/*
    	// 静态调用
    	$user = UserModel::get(46);
    	print_r($user);
    	
    	
    	// 实例化模型
    	$user = model('UserModel');
		$user->username= 'thinkphp';
		$user->sex= 'thinkphp';
		$user->save();
		
		// 或者使用助手函数`model`
    	$user = new UserModel;
		$user->username= 'thinkphp';
		$user->sex= 'thinkphp';
		
    	$user->allowField(['username'])->save();
    	echo $user->id;
    	*/
    	/*
    	//添加多条数据
    	$user = new UserModel;
		$list = [
		    ['username'=>'thinkphp','sex'=>'t'],
		    ['username'=>'onethink','sex'=>'o']
		];
		$user->saveAll($list);
		
		
		//静态方法
		
		$user = UserModel::create([
		    'username'  =>  'thinkphp',
		    'sex' =>  'th'
		]);
		echo $user->username;
		echo $user->sex;
		echo $user->id; // 获取自增ID
    	
    	
    	$User_model = new UserModel();    // 实例化用户模型
		//$User_model->store(array('username'=>'刘艳','sex'=>'女')) ;
		//$User_model->up(array('username'=>'刘艳2','sex'=>'女')) ;
		//$User_model->del('5') ;
		$data =$User_model->sel() ;
		
		print_r($data);die;
		
        /*
    	$data10 =Db::query("select * from user");
    	print_r($data10);die;
    	echo Db::table('user')->count();
    	
    	$data =array(array('username'=>'刘艳','sex'=>'女'),array('username'=>'费静静','sex'=>'女'));
    	Db::name('user')->insertAll($data);
		$userId = Db::name('user')->getLastInsID();
		echo $userId;
    	
    	$data1 =Db::table('user')->where('id',1)->find();
    	$data2 =Db::table('user')->where('id',1)->select();
    	print_r($data1);
    	print_r($data2);*/
    	
    }

    public function read($name)
    {
    	
        return '查看name=' . $name . '的内容';
    }

    public function archive($year, $month)
    {
        return '查看' . $year . '/' . $month . '的归档内容';
    }
}