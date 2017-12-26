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
     * 端口号
     */
    public $port=9501;

    public $swoole_websocket_server;

    public function __construct(array $config = [])
    {
        parent::__construct($config);
        $this->swoole_websocket_server=new \swoole_websocket_server($this->ip,$this->port);
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
        echo "receive from {$frame->fd}:{$frame->data},opcode:{$frame->opcode},fin:{$frame->finish}\n";
        $user=Yii::$app->user->identity;
        $server->push($frame->fd, "this is servser".$frame->fd.$user->username);
    }

    /*
     * 当有人连接的时候
     */
    public function open(\swoole_websocket_server $server, $request)
    {
        echo "用户已连接，连接的fid为{$request->fd}\n";
    }
    /*
     * 当有人连接的时候
     */
    public function close($ser, $fd)
    {
        echo "用户已关闭，关闭的fid为{$fd}\n";
    }

    /*
     * 验证当前用户是否连接如何没有连接就创建
     */
    public function SetSwoole(\swoole_websocket_server $server, $frame)
    {


    }
}