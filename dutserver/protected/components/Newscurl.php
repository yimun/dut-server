<?php
class Newscurl
{
    private $jiaowuUrl = "http://teach.dlut.edu.cn/o2.asp";
    private $tuanweiUrl = "http://tuanwei.dlut.edu.cn/list.php?classid=6";
    private $chuangxinUrl = "http://chuangxin.dlut.edu.cn/SecondPage_News.aspx?Type=6";
    
    public function getJiaowu (){
        $ch = curl_init($this->jiaowuUrl);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        if(!$contents = curl_exec($ch))
            return null;
        curl_close($ch);
        $contents = iconv("GBK", "utf-8//IGNORE", $contents);
        $contents = preg_replace('/\s|&nbsp;/', '', $contents);
        $preg = '#align="left">.*?<ahref="\.\.(.*?)".*?title="(.*?)".*?<td.*?</td><td.*?</td><td.*?>(.*?)</td></tr>#i';
        if (!preg_match_all($preg, $contents, $resAll)){
            return null;
        }
        $list = array();
        $amount = count($resAll[0]);
        for($i = 0; $i < $amount ; $i++ )
        {
            $item = array(
                    'url'   => "http://teach.dlut.edu.cn".$resAll[1][$i],
                    'title'  => $resAll[2][$i],
                    'uptime'  => $resAll[3][$i],
            );
            array_push($list, $item);
        }
        return $list;
    }
    
    public function getTuanwei() {
        $ch = curl_init($this->tuanweiUrl);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        if(!$contents = curl_exec($ch))
            return null;
        curl_close($ch);
        $contents = iconv("GBK", "utf-8//IGNORE", $contents);
        $contents = preg_replace('/\s|&nbsp;/', '', $contents);
        $preg = '#><ahref="(.*?)".*?>(.*?)</a></td><td.*?</td><.*?><.*?>(.*?)</font>#i';
        if (!preg_match_all($preg, $contents, $resAll)){
            echo "none";
            return null;
        }
        $list = array();
        $amount = count($resAll[0]);
        for($i = 0; $i < $amount ; $i++ )
        {
            $item = array(
                    'url'   => "http://tuanwei.dlut.edu.cn/".$resAll[1][$i],
                    'title'  => $resAll[2][$i],
                    'uptime'  => $resAll[3][$i],
            );
            array_push($list, $item);
        }
        return $list;
        
        
    }
    
    public function getChuangxin() {
        $ch = curl_init($this->chuangxinUrl);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        if(!$contents = curl_exec($ch))
            return null;
        curl_close($ch);
        $contents = iconv("GBK", "utf-8//IGNORE", $contents);
        $contents = preg_replace('/\s|&nbsp;/', '', $contents);
        $preg = '#title="(.*?)".*?href="(.*?)".*?</div><div.*?>.*?[(](.*?)[)]#i';
        if (!preg_match_all($preg, $contents, $resAll)){
            //echo "none";
            return null;
        }
        $list = array();
        $amount = count($resAll[0]);
        for($i = 0; $i < $amount ; $i++ )
        {
            $item = array(
                    'url'   => "http://chuangxin.dlut.edu.cn/".$resAll[2][$i],
                    'title'  => $resAll[1][$i],
                    'uptime'  => $resAll[3][$i],
            );
            array_push($list, $item);
        }
        return $list;
    
    
    }
}
