<?php
namespace console\models;

use Yii;
use yii\base\Model;
use common\models\Swoolefd;

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
           $this->close($ser, $fd);
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
            $this->redis->set($data[1],$frame->fd);
            return ;
        }
        $this->SetSwoole($server, $frame,$data);
        $send=$this->redis->get($data[1]);
        if(!isset($send)){
            $this->redis->select(1);

            return ;
        }
        $server->push($send,$data[2]);
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
    public function SetSwoole(\swoole_websocket_server $server, $frame,$uid)
    {


    }
}