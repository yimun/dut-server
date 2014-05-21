<?php

/**
 * This is the model class for table "{{comment}}".
 *
 * The followings are the available columns in table '{{comment}}':
 * @property integer $id
 * @property integer $userid
 * @property integer $courseid
 * @property string $content
 * @property string $uptime
 *
 * The followings are the available model relations:
 * @property Coursebbs $course
 * @property User $user
 */
class Comment extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Comment the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{comment}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('userid, courseid, content, uptime', 'required'),
			array('userid, courseid', 'numerical', 'integerOnly'=>true),
			array('content', 'length', 'max'=>1000),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, userid, courseid, content, uptime', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
			'course' => array(self::BELONGS_TO, 'Coursebbs', 'courseid'),
			'user' => array(self::BELONGS_TO, 'User', 'userid'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'userid' => 'Userid',
			'courseid' => 'Courseid',
			'content' => 'Content',
			'uptime' => 'Uptime',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function searchByCourse ($courseid,$earliertime)
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;
		//$criteria->compare('courseid',$courseid);
		$criteria->condition= "courseid='$courseid' AND uptime<'$earliertime'";
		//$criteria->with = array('user'); // 关系查询
		$criteria->order = 'uptime DESC';
		
		/* $count = $this->count($criteria);
		$pages = new CPagination($count);
		$pages->pageSize = 10;
		$pages->setCurrentPage($pageId);
		$pages->applyLimit($criteria); */
		
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
	        'sort'=>array(
	                'defaultOrder'=>'uptime DESC',
	        ), 
	        'pagination'=>array(
	                'pageSize' => 10,  //TODO
	        //        'currentPage' => $pageId,
	        ), 
		));
	}
	
}