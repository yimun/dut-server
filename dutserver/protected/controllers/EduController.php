<?php

class EduController extends Controller
{

    /**
     * @title 获取考试列表
     * @action /edu/exam
     *
     * @params stuid 201281084 STRING
     * @params pass 755213 STRING
     * @method post
     */
    public function actionExam ()
    {
        $getter = new Mcurl(
                array(
                        'stuid' => $this->param('stuid'),
                        'pass' => $this->param('pass')
                ));
        $list = $getter->listExam();
        if (! $list)
            $this->mrender('10010', 'Get examlist failed');
       // var_dump($list);
        $this->mrender('10000', 'Get examlist OK', 
                array(
                        'Exam.list' => $list
                ));
    }

    /**
     * @title 获取课程列表
     * @action /edu/schedule
     *
     * @params stuid 201281084 STRING
     * @params pass 755213 STRING
     * @method post
     */
    public function actionSchedule ()
    {
        $getter = new Mcurl(
                array(
                        'stuid' => $this->param('stuid'),
                        'pass' => $this->param('pass')
                ));
        $list = $getter->listSchedule();
        if (! $list)
            $this->mrender('10011', 'Get schedulelist failed');
        $this->mrender('10000', 'Get scheduleList OK', 
                array(
                        'Schedule.list' => $list
                ));
    }

    /**
     * @title 获取本学期成绩列表
     * @action /edu/scorethis
     *
     * @params stuid 201281084 STRING
     * @params pass 755213 STRING
     * @method post
     */
    public function actionScorethis ()
    {
        $getter = new Mcurl(
                array(
                        'stuid' => $this->param('stuid'),
                        'pass' => $this->param('pass')
                ));
        $list = $getter->listScorethis();
        if (! $list)
            $this->mrender('10011', 'Get scorethislist failed');
        
        $userAR = User::model()->find("stuid={$this->param('stuid')}");
        $userAR['scorecount'] = count($list);
        $userAR->update();
        $this->mrender('10000', 'Get scorethisList OK', 
                array(
                        'Score.list' => $list
                ));
    }

    /**
     * @title 获取所有成绩列表
     * @action /edu/scoreall
     *
     * @params stuid 201281084 STRING
     * @params pass 755213 STRING
     * @method post
     */
    public function actionScoreall ()
    {
        $getter = new Mcurl(
                array(
                        'stuid' => $this->param('stuid'),
                        'pass' => $this->param('pass')
                ));
        $list = $getter->listScoreall();
        if (! $list)
            $this->mrender('10011', 'Get scorealllist failed');
        $this->mrender('10000', 'Get scoreallList OK', 
                array(
                        'Score.list' => $list
                ));
    }

    /**
     * @title 初始化默认关注的课程论坛
     * @action /edu/defaultbbs
     *
     * @params stuid 201281084 STRING
     * @params pass 755213 STRING
     * @method post
     */
    public function actionDefaultbbs ()
    {
        $bbslist = array();
        $getter = new Mcurl(
                array(
                        'stuid' => $this->param('stuid'),
                        'pass' => $this->param('pass')
                ));
        $list = $getter->listSchedule();
        $connection=Yii::app()->db;
        $sort = array();
        foreach ($list as $item) {
          
            $name = $item['name'];
            $sql = "INSERT INTO tbl_coursebbs(name) ".
                    "SELECT '$name' FROM dual WHERE NOT EXISTS ".
                    "(SELECT * FROM tbl_coursebbs WHERE name='$name');";
            $command = $connection->createCommand($sql);
            $command->execute();
            
            $bbsAR = Coursebbs::model()->find('name=:name', 
                    array(
                            ':name' => $name
                    ));
            if ($bbsAR) {
                $arr = $bbsAR->attributes;
                if (! array_key_exists($arr['id'], $sort)) {
                    $sort[$arr['id']] = '';
                    array_push($bbslist, 
                            array(
                                    'id' => $arr['id'],
                                    'name' => $arr['name'],
                                    'unread' => 0,
                                    'lastupdate' => date("Y-m-d H:i:s",time()), 
                            ));
                }
            }
        }
        if (! $bbslist)
            $this->mrender('10011', 'Get default bbslist failed');
            // var_dump($bbslist);
        $this->mrender('10000', 'Get default bbsList OK', 
                array(
                        'Bbs.list' => $bbslist
                ));
    }

    /**
     * @title 获取新闻
     * @action /edu/news
     *
     * @params type 0 STRING
     * @method post
     */
    public function actionNews ()
    {
        $type = intval($this->param("type"));
        $list = array();
        switch ($type) {
            case 0:
                $getter = new Newscurl();
                $list = $getter->getJiaowu();
                break;
            case 1:
                $getter = new Newscurl();
                $list = $getter->getTuanwei();
                break;
            case 2:
                $getter = new Newscurl();
                $list = $getter->getChuangxin();
                break;
        }
        if(!$list)
            $this->mrender('10012', 'get news failed');
        $this->mrender('10000', 'OK', 
                array(
                        'News.list' => $list
                ));
    }
}