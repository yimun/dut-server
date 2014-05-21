<?php

// 定义交互的数据格式
return array(
        
        'User' => array(
                'id' => 'id',
                'stuid' => 'stuid',
                'sid' => 'sid',
                'name' => 'name',
                'sign' => 'sign',
                'face' => 'face',
                'faceurl' => 'faceurl',
                'grade' => 'grade',
                'department' => 'department',
                'major' => 'major',
                'doinform' => 'doinform',   
            
        ),
        
        'Exam' => array(
        	'type' => 'type',
                'position' => 'position',
                'name' => 'name',
                'time' => 'time',   
        ),
        
        'Score' => array(
        	
                'name' => 'name',
                'credit' => 'credit',
                'type' => 'type',
                'score' => 'score',    
        ),
        
        'Schedule' => array(

                'name'    => 'name',
                'credit'  => 'credit',
                'type'    => 'type',
                'teacher' => 'teacher',
                'weeks'   => 'weeks',
                'weekday' => 'weekday',
                'seque'   => 'seque',
                'amount'  => 'amount',
                'position'=> 'position',
        ),
        
        'Bbs' => array(
                'id' => 'id',   
                'name' => 'name',
                'unread' => 'unread',////
                'lastupdate' => 'lastupdate',
        ),
        'Comment' => array(
                'id' => 'id',
                'courseid' => 'courseid',
                'userid' => 'userid',
                'username' => 'username',
                'content' => 'content',
                'uptime' => 'uptime',
        ),
        
);
