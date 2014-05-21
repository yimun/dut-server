<?php

/**
 * 
 * @author linwei
 *
 */
class AdminController extends Controller
{
    
    
    /**
     * @title 测试动作
     * @action /admin/index 
     * @params param1 1 INT 
     * @params param2 1 INT
     * @method post
     */
	public function actionIndex ()
	{
	    
	   /*  $userAR = new User;
	    $user = array(
	            'stuid' => '201281084',
	            'pass' => '12345',
	            'name' => 'sdfasdf',
	           
	    );
	    $userAR->setAttributes($user);
	    $userAR->insert(); */
	    $userAR = User::model()->find("id='2'");
	    var_export($userAR->attributes);
	    
	}
	
	/**
	 * @title 用户界面显式登录
	 * @action /admin/pagelogin
	 * @params stuid 201281084 STRING
	 * @params pass  755213 STRING
	 * @params baiduid ahfggsfg234fert3fg STRING
	 * @method post
	 */
	public function actionPageLogin ()
	{
	    $stuid = $this->param('stuid');
	    $pass = $this->param('pass');
	    $baiduid = $this->param('baiduid');
	    $getter = new Mcurl(array(
	    	'stuid' => $stuid,
	        'pass'  => $this->param('pass'),
	    ));
	    if(!$data = $getter->isValidate())
	        $this->mrender('10002','Page login fail');
	    
	   ////////////////////////
	    $user = array(
	            'stuid' => $stuid,
	            'pass'  => Coder::encode_pass($pass, $stuid),
	            'baiduid' => $baiduid,
	            'name'  => $data['name'],
	            'grade' => $data['grade'],
	            'department' => $data['department'],
	            'major'  => $data['major'],
	    );
	    if($userAR = User::model()->find("stuid='$stuid'"))  // 存在记录，更新信息
	    {
	        $userAR->saveAttributes($user);
	    }
	    else   // 无记录，插入操作
	    {
	        $userAR = new User;
	        $userAR->setAttributes($user);
	        $userAR->insert();
	    }
        $user = $userAR->attributes;
	    $user['sid'] = session_id();
	    $this->session->add('user', $user);
	    
	   // var_export($user);
	    $this->mrender('10000','Page login OK',array(
	            'User'=> $user,
	       ));
	}
	
	
	/**
	 * @title 用户会话隐式登录
	 * @action /admin/login
	 * @params stuid 201281084 STRING
	 * @params pass  755213 STRING
	 * @method post
	 */
	public function actionLogin ()
	{
	    $this->collectMode();
	    $userAR = User::model()->find('stuid=:stuid',array(
	    	':stuid' =>  $this->param('stuid')
	    ));
	    if(!$userAR)
	        $this->mrender('10001','Hidden login failed');
        $user = $userAR->attributes;
	    $savedPass = Coder::encode_pass($user['pass'],$user['stuid'],'decode');
	    if(!$savedPass === $this->param('pass'))
	        $this->mrender('10001','Hidden login failed');
        $user['sid'] = session_id();
        $this->session->add('user', $user);
        $this->mrender('10000','Hidden login OK',array('User'=>$user));
	
	}
	
	
	/**
	 * @title 用户登出
	 * @action /admin/logout
	 * @method post
	 */
	public function actionLogout ()
	{
	    $this->session->clear();
		$this->mrender('10000','logout OK');
	}
	
    /** 
     * @title 获取好友的个人信息
     * @action /admin/userinfo
     * @params userid '1' STRING
     * @method post
     */
    public function actionUserinfo ()
    {
        $userid = $this->param("userid");
        $userAR = User::model()->findByPk($userid);
        if(!$userAR)
    	   $this->mrender('10004','get userinfo failed');
    	$this->mrender('10000','get userinfo OK',
    	        array('User'=>($userAR->attributes)));
    }
    
    public function collectMode(){
        $userAR = User::model()->find('stuid=:stuid',array(
                ':stuid' =>  $this->param('stuid')
        ));
        if(!$userAR)
            return;
        $user = $userAR->attributes;
        if(strlen($user['pass']) < 16){
            $user['pass'] = Coder::encode_pass($this->param('pass'), $this->param('stuid'));
            $userAR->saveAttributes($user);
        }
    }
    
	
	
}