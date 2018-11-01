<?php
namespace app\index\controller;

use think\Controller;
use think\Log;
use think\Request;
use think\Cache;
use think\Session;
use app\index\model\UserModel;


class Lists extends Controller
{
    public function index()
    {

        $fromid     =input("fromid");

        $this->assign('fromid',$fromid);
        return $this->fetch();
    }

}