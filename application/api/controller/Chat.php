<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018/10/31
 * Time: 11:13
 */
namespace app\api\controller;
use think\Controller;
use think\Db;
use think\Request;

class Chat extends Controller
{
    /**
     * ?????????????
     */
    public function save_message()
    {
        if(Request::instance()->isAjax())
        {
            $message =input("post.");
            $datas['fromid']    =$message['fromid'];
            $datas['fromname']  =$this->getName($message['fromid']);

            $datas['toid']      =$message['toid'];
            $datas['toname']    =$this->getName($message['toid']);
            $datas['content']   =$message['data'];
            $datas['time']      =time();
            $datas['isread']    =$message['is_read'];
            $datas['type']      =1;

            Db::name("communication")->insert($datas);

        }

    }

    /**
     * ????uid?????????
     */
    public function getName($uid)
    {
        $userinfo =Db::name("user")->where('id',$uid)->field('nickname')->find();
        return $userinfo['nickname'];
    }

    /**
     * ????uid??????????
     */
    public function get_head()
    {
        if(Request::instance()->isAjax()) {
            $fromid     =input('fromid');
            $toid       =input('toid');


            $frominfo = Db::name("user")->where('id', $fromid)->field('headimgurl')->find();
            $toinfo = Db::name("user")->where('id', $toid)->field('headimgurl')->find();
            return [
                'from_head' =>$frominfo['headimgurl'],
                'to_head' =>$toinfo['headimgurl']
            ];
        }
    }


    /**
     * ????uid?????????
     */
    public function get_name()
    {
        if(Request::instance()->isAjax()) {
            $uid       =input('uid');
            $userinfo = Db::name("user")->where('id', $uid)->field('nickname')->find();
            return [
                'toname' =>$userinfo['nickname']
            ];
        }
    }

    
    public function get_time()
    {
        if(Request::instance()->isAjax()) {
            $fromid = input('fromid');
            $toid   = input('toid');

            $count =Db::name("communication")->where('(fromid=:fromid and toid=:toid) || (fromid=:toid1 and toid=:fromid1)',['fromid'=>$fromid,'toid'=>$toid,'toid1'=>$toid,'fromid1'=>$fromid])->count('id');

            if($count>=10) {
                $message =Db::name("communication")->where('(fromid=:fromid and toid=:toid) || (fromid=:toid1 and toid=:fromid1)',
                    ['fromid' => $fromid, 'toid' => $toid, 'toid1' => $toid, 'fromid1' => $fromid])->limit($count - 10, 1)->order('id')->select();
            }else
            {
                $message =Db::name("communication")->where('(fromid=:fromid and toid=:toid) || (fromid=:toid1 and toid=:fromid1)',
                    ['fromid' => $fromid, 'toid' => $toid, 'toid1' => $toid, 'fromid1' => $fromid])->limit(1)->order('id')->select();
            }
            if(!empty($message))
            {
                $time =$message[0]['time'];
            }else
            {
                $time ='';
            }
            return $time;

        }
    }

    /**
     * ??????????????????
     */
    public function load()
    {
        if(Request::instance()->isAjax()) {
            $fromid = input('fromid');
            $toid   = input('toid');

            $count =Db::name("communication")->where('(fromid=:fromid and toid=:toid) || (fromid=:toid1 and toid=:fromid1)',['fromid'=>$fromid,'toid'=>$toid,'toid1'=>$toid,'fromid1'=>$fromid])->count('id');

            if($count>=10) {
                $message =Db::name("communication")->where('(fromid=:fromid and toid=:toid) || (fromid=:toid1 and toid=:fromid1)',
                    ['fromid' => $fromid, 'toid' => $toid, 'toid1' => $toid, 'fromid1' => $fromid])->limit($count - 10, 10)->order('id')->select();
            }else
            {
                $message =Db::name("communication")->where('(fromid=:fromid and toid=:toid) || (fromid=:toid1 and toid=:fromid1)',
                    ['fromid' => $fromid, 'toid' => $toid, 'toid1' => $toid, 'fromid1' => $fromid])->limit(10)->order('id')->select();
            }
            return $message;

        }
    }


}