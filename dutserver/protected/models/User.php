<?php

/**
 * This is the model class for table "{{user}}".
 *
 * The followings are the available columns in table '{{user}}':
 * @property integer $id
 * @property string $stuid
 * @property string $pass
 * @property string $name
 * @property string $sign
 * @property string $face
 * @property string $grade
 * @property string $department
 * @property string $major
 * @property integer $doinform
 * @property integer $scorecount
 * @property string $baiduid
 * @property string $uptime
 *
 * The followings are the available model relations:
 * @property Comment[] $comments
 */
class User extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return User the static model class
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
		return '{{user}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('stuid, pass, name, department, major, baiduid, uptime', 'required'),
			array('doinform, scorecount', 'numerical', 'integerOnly'=>true),
			array('stuid, pass, name, sign, face, grade', 'length', 'max'=>100),
			array('department, major, baiduid', 'length', 'max'=>50),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, stuid, pass, name, sign, face, grade, department, major, doinform, scorecount, baiduid, uptime', 'safe', 'on'=>'search'),
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
			'comments' => array(self::HAS_MANY, 'Comment', 'userid'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'stuid' => 'Stuid',
			'pass' => 'Pass',
			'name' => 'Name',
			'sign' => 'Sign',
			'face' => 'Face',
			'grade' => 'Grade',
			'department' => 'Department',
			'major' => 'Major',
			'doinform' => 'Doinform',
			'scorecount' => 'Scorecount',
			'baiduid' => 'Baiduid',
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
		$criteria->compare('stuid',$this->stuid,true);
		$criteria->compare('pass',$this->pass,true);
		$criteria->compare('name',$this->name,true);
		$criteria->compare('sign',$this->sign,true);
		$criteria->compare('face',$this->face,true);
		$criteria->compare('grade',$this->grade,true);
		$criteria->compare('department',$this->department,true);
		$criteria->compare('major',$this->major,true);
		$criteria->compare('doinform',$this->doinform);
		$criteria->compare('scorecount',$this->scorecount);
		$criteria->compare('baiduid',$this->baiduid,true);
		$criteria->compare('uptime',$this->uptime,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}