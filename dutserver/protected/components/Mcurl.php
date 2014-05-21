<?php
class Mcurl
{
    public $isDebug = false;

    public $loginUrl;
    public $crawlUrl;
        
    public function __construct ($params)
    {
        $crawlUrl = $loginUrl = Yii::app()->params['baseUrl'];
        $loginUrl .= 'loginAction.do?zjh='.$params['stuid']
                        .'&mm='.$params['pass'];
        $this->loginUrl = $loginUrl;
        $this->crawlUrl = $crawlUrl;
        
    }
    
    public function crawl ()
    {
        $cookie_file = tempnam('C:\\Windows\\Temp', 'cookie');// 目录不存在则保存到系统内
        $ch = curl_init($this->loginUrl);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_COOKIEJAR, $cookie_file);
        if(!curl_exec($ch))
            return null;
        curl_close($ch);
        
        $ch = curl_init($this->crawlUrl);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_COOKIEFILE, $cookie_file);
        if(!$contents = curl_exec($ch))
            return null;
        curl_close($ch);
        $contents = iconv("GBK", "utf-8//IGNORE", $contents);
        $contents = preg_replace('/\s|&nbsp;/', '', $contents);
		//echo $contents;
        return $contents;
       
    }
    
    public function listScorethis ()
    {
        $this->crawlUrl .= 'bxqcjcxAction.do';
        
        if($this->isDebug){
            $content = file_get_contents('I:\Users\linwei\Desktop\test\score_this.htm');
            $content = iconv("GBK", "utf-8//IGNORE", $content);
            $content = preg_replace('/\s|&nbsp;/', '', $content);
        }
        else{
            $content = $this->crawl();
        }
        $preg = '#evenfocus.*?><td.*?>.*?</td><td.*?>.*?</td><td.*?>(.*?)</td><td.*?>.*?</td><td.*?>(.*?)</td><td.*?>(.*?)</td><td.*?>(.*?)</td></tr>#i';
        if (!preg_match_all($preg, $content, $resAll)) 
            return null;
        $scorelist = array();
        $amount = count($resAll[0]);
        for($i = 0; $i < $amount ; $i++ )
        {
            $item = array(
            	'name'   => $resAll[1][$i],
                'credit' => $resAll[2][$i],
                'type'   => $resAll[3][$i],
                'score'  => $resAll[4][$i],
            );
            array_push($scorelist, $item);
        }
        return $scorelist;
    }
    
    public function listScoreall ()
    {
        $this->crawlUrl .= 'gradeLnAllAction.do?type=ln&oper=qbinfo';
        if($this->isDebug){
            $content = file_get_contents('I:\Users\linwei\Desktop\test\score_all.htm');
            $content = iconv("GBK", "utf-8//IGNORE", $content);
            $content = preg_replace('/\s|&nbsp;/', '', $content);
        }
        else{
            $content = $this->crawl();
        }
        //var_dump($content);
        $preg = '#evenfocus.*?><td.*?>.*?</td><td.*?>.*?</td><td.*?>(.*?)</td><td.*?>.*?</td><td.*?>(.*?)</td><td.*?>(.*?)</td><td.*?><palign.*?>(.*?)</p></td></tr>#i';
        if (!preg_match_all($preg, $content, $resAll)){
            echo "false";
            return null;
        }
        $scorelist = array();
        $amount = count($resAll[0]);
        for($i = 0; $i < $amount ; $i++ )
        {
            $item = array(
                    'name'   => $resAll[1][$i],
                    'credit' => $resAll[2][$i],
                    'type'   => $resAll[3][$i],
                    'score'  => $resAll[4][$i],
            );
            array_push($scorelist, $item);
        }
        return $scorelist;
    }
    
   
    public function listExam ()
    {
        $this->crawlUrl .= 'ksApCxAction.do?oper=getKsapXx';
        if($this->isDebug){
            $content = file_get_contents('I:\Users\linwei\Desktop\test\exam.htm');
            $content = iconv("GBK", "utf-8//IGNORE", $content);
            $content = preg_replace('/\s|&nbsp;/', '', $content);
        }
        else{
            $content = $this->crawl();
        }
        $preg = '#odd.*?><td>(.*?)</td><td>.*?</td><td>.*?</td><td>(.*?)</td><td>(.*?)</td><td>(.*?)</td><td>(.*?)</td><td>(.*?)</td>#';
        if (!preg_match_all($preg, $content, $resAll))
            return null;
       // var_dump($resAll);
        $examlist = array();
        $amount = count($resAll[0]);
        for($i = 0; $i < $amount ; $i++ )
        {
            $item = array(
                    'type'   => $resAll[1][$i],
                    'position' => $resAll[2][$i],
                    'name'   => $resAll[3][$i],
                    'time'  =>  '第'.$resAll[4][$i].'周'.
                    ' 星期'.$this->formatweek($resAll[5][$i]).$resAll[6][$i],
            );
            array_push($examlist, $item);
        }
        return $examlist;
    }
    

    public function listSchedule ()
    {
        $this->crawlUrl .= 'xkAction.do?actionType=6&oper';
        if($this->isDebug){
            $content = file_get_contents('I:\Users\linwei\Desktop\test\Schedule.htm');
            $content = iconv("GBK", "utf-8//IGNORE", $content);
            $content = preg_replace('/\s|&nbsp;/', '', $content);
        }
        else{
            $content = $this->crawl();
        }
        
        $list = array();
        $preg3 = '#evenfocus.*?</tr>#';
        if (!preg_match_all($preg3, $content, $resList)) {
            return null;
        }
        $sourlist = $resList[0];
        for($i=0; $i<count($sourlist) ; $i++)
        {
            $pregsub1 = '#<tdrowspan="(\d+)">.*?</td><.*?>.*?</td><.*?>(.*?)</td><.*?>.*?</td><.*?>(.*?)</td><.*?>(.*?)</td><.*?>.*?</td><.*?>(.*?)</td><.*?>.*?</td><.*?>.*?</td><.*?>.*?</td><.*?>(.*?)</td><.*?>(.*?)</td><.*?>(.*?)</td><.*?>(.*?)</td><.*?>.*?</td><.*?>(.*?)</td><.*?>(.*?)</td>#';
            $pregsub2 = '#<td>(.*?)</td><td>(.*?)</td><td>(.*?)</td><td>(.*?)</td><td>.*?</td><td>(.*?)</td><td>(.*?)</td>#';
            if(!preg_match($pregsub1, $sourlist[$i],$get))
                continue;
    
            $item = array(
                    'name'    => $get[2],
                    'credit'  => $get[3],
                    'type'    => $get[4],
                    'teacher' => $get[5],
                    'weeks'   => $get[6],
                    'weekday' => $get[7], 
                    'seque'   => $get[8],
                    'amount'  => $get[9],
                    'position'=> $get[10].$get[11],
            );
            array_push($list, $item);
    
            $classcount = intval($get[1])-1;
            //$i += $classcount;
            for($j = 0;$j < $classcount;$j++)
            {
                $i++;
                if(!preg_match($pregsub2, $sourlist[$i],$get2))
                    continue;
                $item2 = array(
                        'weeks'   => $get2[1],
                        'weekday' => $get2[2],
                        'seque'   => $get2[3],
                        'amount'  => $get2[4],
    					'position'=> $get2[5].$get2[6],
    			    );
    			array_push($list, array_merge($item,$item2));
    		}
        }
        return $list;
    }
    
    public function isValidate()
    {
        $this->crawlUrl .= 'xjInfoAction.do?oper=xjxx';
        $content = $this->crawl();
        $preg = '#姓名:</td><.*?>(.*?)</td>.*?系所:</td><.*?>(.*?)</td>.*?专业:</td><.*?>(.*?)</td>.*?年级:</td><.*?>(.*?)</td>#i';
        if (!preg_match_all($preg, $content,$resAll))
            return null;
        $data = array(
        	'name'       => $resAll[1][0],
            'department' => $resAll[2][0],
            'major'      => $resAll[3][0],
            'grade'      => $resAll[4][0],
        );
        return $data;
    }
    
    
    private function formatweek ($get)
    {
        $values = array('一','二','三','四','五','六','日');
        return $values[intval($get)-1];
    }
}