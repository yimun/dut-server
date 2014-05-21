<?php

class PlanController extends Controller
{
    
	/**
	 * @title 查询是否有新的分数出来
	 * @action /plan/scorequery
	 * @method get
	 */
	public function actionScoreQuery ()
	{
	    $userARlist = User::model()->findAll('doinform=1');
	    foreach ($userARlist as $userAR)
	    {
	        $user = $userAR->attributes;
	        $user['pass'] = Coder::php_decrypt($user['pass']);
	        $getter = new Mcurl($user);
	        if(!$list = $getter->listScorethis())
	            continue;
	        $amount = count($list);
	        if ($amount > $userAR->scorecount) 
	        {
	            $add = $amount - $userAR->scorecount;
	            $this->informUser($userAR,$add);
	            $userAR->scorecount = $amount;
	            $userAR->update();
	        }
	    }
	}
	
	/**
	 * @title 测试
	 * @action /plan/test
	 * @params name '' STRING
	 * @params pageId 0 INT
	 * @method post
	 */
	public function actionTest ()
	{
	
	    for ($i = 1; $i <= 100; $i++) {  
            print "#$i 完毕<hr>";  
            sleep(1);  
            print str_pad("", 10000);
            flush();  
        }  
	}
	
	
	
	/**
	 * @title 添加课程论坛
	 * @action /plan/bbsadd
	 * @method post
	 */
	public function actionBbsAdd ()
	{
	    $bbscount = 0;
	    $userARlist = User::model()->findAll();
	    $connection=Yii::app()->db;
	    foreach ($userARlist as $userAR)
	    {
	        $user = $userAR->attributes;
	        $user['pass'] = Coder::php_decrypt($user['pass']);
	        $getter = new Mcurl($user);
	        if(!$list = $getter->listSchedule())
	            continue;
	        
	        foreach ($list as $course)
	        {
	            $sql = "INSERT INTO tbl_coursebbs(name) ".
	            "SELECT '{$course['name']}' FROM dual WHERE NOT EXISTS ".
	            "(SELECT * FROM tbl_coursebbs WHERE name='{$course['name']}');";
	            $command = $connection->createCommand($sql);
	            $bbscount += $command->execute();
               /*  if (!Coursebbs::model()->find("name='{$course['name']}'"))
                {
                    $courseAR = new Coursebbs;
                    $courseAR->setAttributes($course);
                    $courseAR->insert();
                    $bbscount++;
                } */
	        }
	    }
	    $this->mrender('10000', 'Get all bbs OK','Add+'.$bbscount);
	}
	
	
	protected function informUser ($userAR , $add)
    {
        $apiKey = Yii::app()->param['apiKey'];
        $secretKey = Yii::app()->param['secretKey'];
        $channel = new Channel ( $apiKey, $secretKey ) ;
    }
    
    /**
     * @title 密碼加密方式的修改
     * @action /plan/changemm
     * @method post
     */
    public function actionChangemm ()
    {
        $counter = 0;
        $success = 0;
        $failed  = 0;
        $userARlist = User::model()->findAll('length(pass) < 16');
        echo "All selected number:".count($userARlist)."<hr>";
        foreach ($userARlist as $userAR)
        {
            print str_pad("", 10000);
            flush();
            $counter ++ ;
            $user = $userAR->attributes;
            echo '<br />';
            echo $counter.":".$user['stuid']."|";
            if(strlen($user['pass'])>=16){
                echo "------------already change the pass";
                continue;
            }
            $user['pass'] = Coder::php_decrypt($user['pass']);
            $getter = new Mcurl($user);
            if(!$getter->isValidate()){
                $user['pass'] = Coder::php_decrypt2($user['pass']);
                $getter = new Mcurl($user);
                if(!$getter->isValidate()){
                    echo "------------can not deode the correct pass!";
                    $failed++;
                    continue;
                }
            }
            $user['pass'] = Coder::encode_pass($user['pass'],$user['stuid']);
            $userAR->saveAttributes($user);
            $success++;
            echo "------------success";
            
        }
    	echo '<br /><hr>'."OK  recorders influencesed:$counter    success:$success   failed:$failed";
    }
}