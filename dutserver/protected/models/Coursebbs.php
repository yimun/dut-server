<?php

/**
 * This is the model class for table "{{coursebbs}}".
 *
 * The followings are the available columns in table '{{coursebbs}}':
 * @property integer $id
 * @property string $name
 * @property integer $fanscount
 * @property integer $comcount
 * @property string $uptime
 *
 * The followings are the available model relations:
 * @property Allcourse[] $allcourses
 * @property Comment[] $comments
 */
class Coursebbs extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Coursebbs the static model class
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
		return '{{coursebbs}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('name, uptime', 'required'),
			array('fanscount, comcount', 'numerical', 'integerOnly'=>true),
			array('name', 'length', 'max'=>50),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, name, fanscount, comcount, uptime', 'safe', 'on'=>'search'),
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
			'allcourses' => array(self::HAS_MANY, 'Allcourse', 'courseid'),
			'comments' => array(self::HAS_MANY, 'Comment', 'courseid'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'name' => 'Name',
			'fanscount' => 'Fanscount',
			'comcount' => 'Comcount',
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
		$criteria->compare('name',$this->name,true);
		$criteria->compare('fanscount',$this->fanscount);
		$criteria->compare('comcount',$this->comcount);
		$criteria->compare('uptime',$this->uptime,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}