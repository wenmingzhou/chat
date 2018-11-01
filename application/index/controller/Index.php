<?php
namespace app\index\controller;

use think\Controller;
use think\Log;
use think\Request;
use think\Cache;
use think\Session;
use app\index\model\UserModel;


class Index extends Controller
{
    public function Index()
    {
        $fromid     =input("fromid");
        $toid       =input("toid");
        $this->assign('fromid',$fromid);
        $this->assign('toid',$toid);

        return $this->fetch();
    }

}

