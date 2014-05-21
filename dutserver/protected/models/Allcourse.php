<?php

/**
 * This is the model class for table "{{allcourse}}".
 *
 * The followings are the available columns in table '{{allcourse}}':
 * @property integer $id
 * @property string $teacher
 * @property integer $courseid
 * @property double $failrate
 * @property string $uptime
 *
 * The followings are the available model relations:
 * @property Coursebbs $course
 */
class Allcourse extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Allcourse the static model class
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
		return '{{allcourse}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('teacher, courseid, failrate, uptime', 'required'),
			array('courseid', 'numerical', 'integerOnly'=>true),
			array('failrate', 'numerical'),
			array('teacher', 'length', 'max'=>50),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, teacher, courseid, failrate, uptime', 'safe', 'on'=>'search'),
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
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'teacher' => 'Teacher',
			'courseid' => 'Courseid',
			'failrate' => 'Failrate',
			'uptime' => 'Uptime',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function search()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id);
		$criteria->compare('teacher',$this->teacher,true);
		$criteria->compare('courseid',$this->courseid);
		$criteria->compare('failrate',$this->failrate);
		$criteria->compare('uptime',$this->uptime,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}