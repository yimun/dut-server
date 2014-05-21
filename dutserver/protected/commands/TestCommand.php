<?php

class TestCommand extends CConsoleCommand
{
    const DELAY_TIME = 1800;
    
    
    public function run1 ($args)
    {
        $flag = true;
        do {
           
            $userARlist = User::model()->findAll('doinform=1');
            foreach ($userARlist as $userAR) 
            {
                $getter = new Mcurl($userAR->attributes);
                if(!$list = $getter->listScorethis())
                    continue;
                $amount = count($list);
                if ($amount > $userAR->scorecount) {
                    $add = $amount - $userAR->scorecount;
                    $this->informUser($userAR,$add);
                    $userAR->scorecount = $amount;
                    $userAR->update();
                }
            }
            sleep(self::DELAY_TIME);
        } while ($flag);
    }

    /*
    public function run($args)
    {
        echo 'console test';
    }*/
    public function informUser ($userAR , $add)
    {
        
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
            print "#$i over\r\n";  
            sleep(1);   
        }  
	}
    
}