<?php

class ExtraController extends Controller
{
	/**
	 * @title 是否接受新成绩提醒的通知
	 * @action /extra/inform
	 * @method post
	 */
	public function actionInform ()
	{
	
		$this->mrender('10000','NotInTime');
	}
	
	/**
	 * @title 
	 * @action /extra/jsontest
	 * @params name '' STRING
	 * @params pageId 0 INT
	 * @method post
	 */
	public function actionJsontest ()
	{
	
	    $baseurl = "http://yimutest.sinaapp.com/dutserver/index.php?r=";
	    
	    
		$this->mrender('10000','OK',$baseurl);
	}
	
	/**
	 * @title 推送测试
	 * @action /extra/globalinform
	 * @params baiduid 1103666223370233220 STRING
	 * @params content 测试 STRING
	 * @method post
	 */
	public function actionGlobalinform ()
	{
	    $user_id = $this->param('baiduid');
	    $content = $this->param('content');
	    $apiKey = Yii::app()->params['apiKey'];
	    $secretKey = Yii::app()->params['secretKey'];
	    $channel = new Channel ( $apiKey, $secretKey ) ;
	    //推送消息到某个user，设置push_type = 1;
	    //推送消息到一个tag中的全部user，设置push_type = 2;d d
	    //推送消息到该app中的全部user，设置push_type = 3;
	    $push_type = 1; //推送单播消息
	    $optional[Channel::USER_ID] = $user_id; //如果推送单播消息，需要指定user
	    //optional[Channel::TAG_NAME] = "xxxx";  //如果推送tag消息，需要指定tag_name
	    
	    //指定发到android设备
	    $optional[Channel::DEVICE_TYPE] = 3;
	    //指定消息类型为通知
	    $optional[Channel::MESSAGE_TYPE] = 0;
	    //通知类型的内容必须按指定内容发送，示例如下：
	    $message = '{
			"title": "大工助手",
			"description": "'.$content.'",
			"notification_basic_style":0,
			"open_type":2,
	        "pkg_content":"#Intent;component=com.siwe.dutschedule/.ui.UiHome;end"
 		}';
	    
	    $message_key = "msg_key";
	    $ret = $channel->pushMessage ( $push_type, $message, $message_key, $optional ) ;
	    if ( false === $ret )
	    {
	        error_output ( 'WRONG, ' . __FUNCTION__ . ' ERROR!!!!!' ) ;
	        error_output ( 'ERROR NUMBER: ' . $channel->errno ( ) ) ;
	        error_output ( 'ERROR MESSAGE: ' . $channel->errmsg ( ) ) ;
	        error_output ( 'REQUEST ID: ' . $channel->getRequestId ( ) );
	    }
	    else
	    {
	        $this->right_output ( 'SUCC, ' . __FUNCTION__ . ' OK!!!!!' ) ;
	        $this->right_output ( 'result: ' . print_r ( $ret, true ) ) ;
	    }
	}
	
	public function error_output ( $str )
	{
	    echo "\033[1;40;31m" . $str ."\033[0m" . "\n";
	}
	
	public function right_output ( $str )
	{
	    echo "\033[1;40;32m" . $str ."\033[0m" . "\n";
	}

	// Uncomment the following methods and override them if needed
	/*
	public function filters()
	{
		// return the filter configuration for this controller, e.g.:
		return array(
			'inlineFilterName',
			array(
				'class'=>'path.to.FilterClass',
				'propertyName'=>'propertyValue',
			),
		);
	}

	public function actions()
	{
		// return external action classes, e.g.:
		return array(
			'action1'=>'path.to.ActionClass',
			'action2'=>array(
				'class'=>'path.to.AnotherActionClass',
				'propertyName'=>'propertyValue',
			),
		);
	}
	*/
}