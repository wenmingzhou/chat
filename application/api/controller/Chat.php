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
     * 文本消息数据持久化
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
            //$datas['isread']  =$message['is_read'];
            $datas['isread']    =0;
            $datas['type']      =1;

            Db::name("communication")->insert($datas);

        }

    }

    public function changeNoRead()
    {
        if(Request::instance()->isAjax()) {
            $fromid = input('toid');
            $toid = input('fromid');
            Db::name("communication")->where(['fromid'=>$fromid,'toid'=>$toid])->update(['isread'=>1]);

        }
    }

    /**
     * 根据uid返回用户名
     */
    public function getName($uid)
    {
        $userinfo =Db::name("user")->where('id',$uid)->field('nickname')->find();
        return $userinfo['nickname'];
    }

    /**
     * 根据uid返回用户头像
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
     * 根据uid返回用户名
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
     * 页面加载显示双方聊天记录
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

    /**
     * 上传图片 返回图片地址
     */
    function uploadimg()
    {

        $file       = $_FILES['file'];
        $fromid     =input('fromid');
        $toid       =input('toid');
        $online     =input('online');

        $suffix     =strtolower(strrchr($file['name'],'.'));
        $type       =['jpg','jpeg','png','gif'];
        if(in_array($suffix,$type))
        {
            return ['status'=>'img type error'];
        }

        if($file['size']/1024>5120)
        {
            return ['status'=>'img is too large'];
        }

        $filename   =uniqid("char_img_",false);
        $uploadpaths=ROOT_PATH.'public\\uploads\\';
        $file_up    =$uploadpaths.$filename.$suffix;

        $re =move_uploaded_file($file['tmp_name'],$file_up);
        if($re)
        {
            $name               =$filename.$suffix;
            $data['content']    =$name;
            $data['fromid']     =$fromid;
            $data['toid']       =$toid;
            $data['fromname']   =$this->getName($data['fromid']);
            $data['toname']     =$this->getName($data['toid']);
            //$data['isread']     =$online;
            $data['isread']     =0;
            $data['time']       =time();
            $data['type']       =0;

            $message_id         =Db::name("communication")->insertGetId($data);
            if($message_id)
            {
                return ['status'=>'ok','img_name'=>$name];
            }else
            {
                return ['status'=>'false'];
            }
        }
    }

    /**
     * 根据当前用户回去聊天列表
     */
    public function get_list()
    {

        if(Request::instance()->isAjax()) {
            $fromId = input('fromid');
            $info = Db::name('communication')->field(['fromid', 'toid', 'fromname'])->where(['toid' =>$fromId])->group('fromid')->select();

            $rows =array_map(function ($res) {
                return [
                    'head_url' =>$this->get_head_one($res['fromid']),
                    'username' =>$res['fromname'],
                    'countNoread' =>$this->getCountNoread($res['fromid'],$res['toid']),
                    'last_message' =>$this->getLastMessage($res['fromid'],$res['toid']),
                    'chat_page' =>"http://www.chat.com/?fromid=".$res['toid']."&toid=".$res['fromid'],
                ];
            },$info);
            return $rows;




        }
    }

    /**
     * @param $fromid
     * @param $toid
     * 根据fromid获取最后一条数据
     */
    public function getLastMessage($fromid,$toid)
    {
        $info =Db::name("communication")->where('(fromid=:fromid and toid=:toid) || (fromid=:toid1 and toid=:fromid1)',
            ['fromid' => $fromid, 'toid' => $toid, 'toid1' => $toid, 'fromid1' => $fromid])->order('id desc')->limit(1)->find();
        return $info;
    }

    /**根据uid获取头像
     * @param $uid
     */
    public function get_head_one($uid)
    {

        $userinfo = Db::name("user")->where('id', $uid)->field('headimgurl')->find();

        return $userinfo['headimgurl'];
    }


    /**
     * @param $from
     * @param $toid
     * 根据fromid获取未读消息数量
     */
    public function getCountNoread($fromid,$toid)
    {
        return Db::name('communication')->where(['fromid' =>$fromid,'toid' =>$toid,'isread' =>0])->count('*');
    }


}