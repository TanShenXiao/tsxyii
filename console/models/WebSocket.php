<?php
namespace console\models;

use Yii;
use yii\base\Model;
use common\models\Chatrecord;
use common\models\User;
use yii\db\Exception;
use yii\helpers\Json;

class WebSocket extends Model
{
    /*
     * 允许连接的ip
     */
    public $ip='0.0.0.0';
    /*
     * swoole端口号
     */
    public $sport=9501;
    /*
     * redis端口号
     */
    public $rport=6379;
    /*
     * swoole对象
     */
    public $swoole_websocket_server;
    /*
     * redis对象
     */
    public $redis;

    public function __construct(array $config = [])
    {
        parent::__construct($config);
        $this->swoole_websocket_server=new \swoole_websocket_server($this->ip,$this->sport);
        $this->redis=new \redis();
        $this->redis->connect("127.0.0.1");
    }

    public function exe()
    {
        $this->swoole_websocket_server->on('open', function (\swoole_websocket_server $server, $request) {
           // echo "server: handshake success with fd{$request->fd}\n";
            $this->open($server,$request);
        });

        $this->swoole_websocket_server->on('message', function (\swoole_websocket_server $server, $frame) {
            $this->message( $server, $frame);
        });

        $this->swoole_websocket_server->on('close', function ($ser, $fd) {
          echo "fid为".$fd."的连接关闭";
        });

        $this->swoole_websocket_server->start();
    }

    /*
     * 当有人发送消息的时候
     */
    public function message(\swoole_websocket_server $server, $frame)
    {
        $data=explode("94bb8b5325d0c835",$frame->data,3);
        $this->redis->select(0);
        if($data[0] == "tsx-save"){
            $this->validate_user($data,$frame);
            return ;
        }
        if(!$this->redis->get($data[0])){
            $this->swoole_websocket_server->push($frame->fd,"身份验证失败");
        }
        /*
         * 对消息进行处理
         */
        $this->SetSwoole($server,$frame,$data);
    }

    /*
     * 当有人连接的时候
     */
    public function open(\swoole_websocket_server $server, $request)
    {
        echo "用户已连接，连接的fid为{$request->fd}\n";
    }
    /*
     * 当有人关闭的时候
     */
    public function close($ser, $fd)
    {

        echo "用户已关闭，关闭的fid为{$fd}\n";
    }

    /*
     * 验证当前用户是否连接如何没有连接就创建
     */
    public function SetSwoole(\swoole_websocket_server $server,$frame,$data)
    {

        $send=$this->redis->get($data[1]);
        if(!isset($send)){
            $this->redis->select(1);
            $this->save_caht($frame,$data,30);
            return ;
        }
        if($this->save_caht($frame,$data,20)) {
            $server->push($send, $data[2]);
        }
    }

    /*
     * 身份验证
     */
    public function validate_user($data,$frame)
    {
        $row=User::find()->where(["status"=>10,'id'=>$data[1]])->one();
        if($row){
            $this->redis->set($data[1],$frame->fd);
            return ;
        }
        $this->swoole_websocket_server->push($frame->fd,"身份验证失败");

    }

    /*
     * 将消息记录保存到数据库
     */
    public function save_caht($frame,$data,$status=20)
    {
        $da=[
            'uid'=>$data[0],
            'fid'=>$data[1],
            'content'=>$data[2],
            'status'=>$status,
            'created_at'=>time(),
        ];
        $begintransaction=Yii::$app->db->beginTransaction();
        try{
            $chat=new Chatrecord();
            $chat->uid=$da['uid'];
            $chat->fid=$da['fid'];
            $chat->content=$da['content'];
            $chat->status=$da['status'];
            $chat->created_at=$da['created_at'];
            if(!$chat->save()){
                throw new Exception("");
            }
            $json=Json::encode($da);
            $keysrray=[$data[0],$data[1]];
            sort($keysrray,SORT_NUMERIC);
            $key=$keysrray[0].$keysrray[1];
            $this->redis->select(1);
            if(!$this->redis->lPush($key,$json)){
                throw new Exception("");
            }
            if($this->redis->lLen($key) > 100){
                $this->redis->rPop($key);
            }
            $begintransaction->commit();
            return true;
        }catch (\Exception $e){
            echo $e->getMessage();
            $this->swoole_websocket_server->push($frame->fd,"消息发送失败");
            $begintransaction->rollback();
            return false;

        }


    }
}