<?php
namespace console\controllers;

use yii\console\Controller;
use console\models\WebSocket;

class IndexController extends Controller
{
	public function actionHome()
	{
        $websocket=new WebSocket();
        $websocket->exe();
	}
	
	public function actionSs()
	{
		echo "sss";
	}
}
