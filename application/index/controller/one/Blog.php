<?php
namespace app\index\controller\one;

use think\Controller;

class Blog extends Controller
{
    public function index()
    {
    	$request = request();
    	// 获取当前域名
		echo 'domain: ' . $request->domain() . '<br/>';
		// 获取当前入口文件
		echo 'file: ' . $request->baseFile() . '<br/>';
		// 获取当前URL地址 不含域名
		echo 'url: ' . $request->url() . '<br/>';
		// 获取包含域名的完整URL地址
		echo 'url with domain: ' . $request->url(true) . '<br/>';
		// 获取当前URL地址 不含QUERY_STRING
		echo 'url without query: ' . $request->baseUrl() . '<br/>';
		// 获取URL访问的ROOT地址
		echo 'root:' . $request->root() . '<br/>';
		// 获取URL访问的ROOT地址
		echo 'root with domain: ' . $request->root(true) . '<br/>';
		// 获取URL地址中的PATH_INFO信息
		echo 'pathinfo: ' . $request->pathinfo() . '<br/>';
		// 获取URL地址中的PATH_INFO信息 不含后缀
		echo 'pathinfo: ' . $request->path() . '<br/>';
		// 获取URL地址中的后缀信息
		echo 'ext: ' . $request->ext() . '<br/>';
		echo "当前模块名称是" . $request->module(). '<br/>';
		echo "当前控制器名称是" . $request->controller(). '<br/>';
		echo "当前操作名称是" . $request->action(). '<br/>';
		


		//print_r($request);
		die;
        return $this->fetch();
    }
    
    public function add()
    {die("22");
        return $this->fetch();
    }
    
    public function edit($id)
    {die("33");
        return $this->fetch();
    }
}
?>