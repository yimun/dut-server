<?php

class BbsController extends Controller
{
    
    /**
     * @title 添加评论
     * @action /bbs/comment
     * @params courseid 1 INT
     * @params content test STRING
     * @method post
     */
    public function actionComment ()
    {
        $this->doAuth();
        $commentAR = new Comment;
        $commentAR->userid = $this->user['id'];
        $commentAR->courseid = $this->param('courseid');
        $commentAR->content = $this->param('content');
        if(!$commentAR->insert())
            $this->mrender('10013','Add comment fail');
        $courseAR = Coursebbs::model()->findByPk($this->param('courseid'));
        $courseAR->comcount++;
        $courseAR->update();
        $this->mrender('10000','Add comment OK');    	
    }
    
    /**
     * @title 删除评论
     * @action /bbs/delcomment
     * @params commentid 0 INT
     * @method post
     */
    public function actionDelcomment ()
    {
        $commentId = $this->param("commentid");
        $affect = Comment::model()->deleteByPk($commentId);
        if($affect>0)
    	   $this->mrender('10000','del commentOK');
    	$this->mrender('10018','del comment failed');
    }
    
    /**
     * @title 获取评论列表
     * @action /bbs/getlist
     * @params courseid 1 STRING
     * @params earliertime 0 STRING
     * @method post
     */
    public function actionGetlist ()
    {
        $this->doAuth();
        $commentlist =array();
        $provider = Comment::model()->searchByCourse(
                $this->param('courseid'),
                $this->param('earliertime'));
        
        $listobj = $provider->getData();
        if(!$listobj)
            $this->mrender('10014','Get comment Fail');
        foreach ($listobj as $itemobj)
        {
            $comment = $itemobj->attributes;
            $comment['username'] = $itemobj->user->name;
            array_push($commentlist,$comment);   
        }
    	$this->mrender('10000','Get comment OK',array('Comment.list'=>$commentlist));
    }
    
    /**
     * @title 获取未读消息
     * @action /bbs/unread
     * @params data '%1#2014-02-01 21:42:23%' STRING
     * @method post
     */
    public function actionUnread ()
    {
        $resultlist = array();
        //$get = '1#工科数学#2014-02-01 21:42:01%1#2014-02-01 21:42:01%';
        $get = $this->param("data");
        $list = preg_split('/%/', $get);
        foreach ($list as $data) 
        {
            $item = preg_split('/#/', $data);
            if(count($item) != 3)
                continue;
            $id = $item[0];
            $name = $item[1];
            $uptime = $item[2];
            $number = Comment::model()->count('courseid=:id AND uptime>:time',array(
            	':id' => $id,
            	':time' => $uptime, 
            ));
            array_push($resultlist,array(
            	'id' => $id,
            	'name' => $name,
            	'unread' => $number,
            ));
            
        }
        if(!$resultlist)
            $this->mrender('10016',"Get unread Fail");
    	$this->mrender('10000',"Get unread OK",array('Bbs.list'=>$resultlist));
    }
    
    /**
     * @title 获取某个时间之后的未读消息
     * @action /bbs/unreadlist
     * @params courseid 1 STRING
     * @params latertime 0 STRING
     * @method post
     */
    public function actionUnreadlist ()
    {
        $unreadlist = array();
        $ARlist = array();
        $ARlist = Comment::model()->findAll('courseid=:id AND uptime>:time ORDER BY uptime DESC',
                array(':id' => $this->param("courseid"),
                ':time' => $this->param("latertime"),
        ));
        if(count($ARlist) == 0)
    	   $this->mrender('10017','get unread list failed');
        foreach ($ARlist as $AR)
        {
            $item = $AR->attributes;
            $item['username'] = $AR->user['name'];
            array_push($unreadlist, $item);
        }
        $this->mrender('10000',"Get unread list OK",array('Comment.list'=>$unreadlist));
    }
    
    /**
     * @title 搜索课程论坛
     * @action /bbs/search
     * @params name '' STRING
     * @method post
     */
    public function actionSearch ()
    {
        $list = array();
        $name = $this->param("name");
        $ARlist = Coursebbs::model()->findAll("name like '%$name%' limit 20",null);
        if(count($ARlist) == 0)
            $this->mrender('10018','search bbs list failed');
        foreach ($ARlist as $AR)
        {
            $item = $AR->attributes;
            $item['unread'] = 0;
            $item['lastupdate'] = date("Y-m-d H:i:s",time());
            array_push($list, $item);
        }
    	$this->mrender('10000','search bbs OK',array('Bbs.list'=>$list));
    }
    
    
}