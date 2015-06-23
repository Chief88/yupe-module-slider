<?php

/**
 * Slider
 *
 * @author Valek Vergilyush <v.vergilyush@gmail.com>
 * @link http://green-s.pro
 * @copyright 2010-2014 green-s.pro
 * @package yupe.modules.slide.models
 * @since 0.1
 *
 */

/**
 * This is the model class for table "Slider".
 *
 * The followings are the available columns in table 'Slider':
 * @property string $id
 * @property string $name
 * @property string $description
 * @property string $creation_date
 * @property string $user_id
 * @property integer $status

 * The followings are the available model relations:
 * @property User $user
 */
class Slider extends yupe\models\YModel
{
    const STATUS_SHOW = 1;
    const STATUS_HIDE = 0;

    private $_aliasModule = 'SliderModule.slider';

    /**
     * Returns the static model of the specified AR class.
     *
     * @param string $className - class name
     *
     * @return Slider the static model class
     */
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    /**
     * table name
     *
     * @return string the associated database table name
     */
    public function tableName()
    {
        return '{{slide_slider}}';
    }

    /**
     * validation rules
     *
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        return array(
            array('name, description', 'filter', 'filter' => array(new CHtmlPurifier(), 'purify')),
            array('name, code', 'required'),
            array('name, description', 'filter', 'filter' => 'trim'),
            array('status', 'numerical', 'integerOnly' => true),
            array('user_id, status', 'length', 'max' => 11),
            array('name, code', 'length', 'max' => 250),
            array('code', 'unique'),
            array('code, id, name, description, creation_date, user_id, status', 'safe', 'on' => 'search'),
        );
    }

    public function afterDelete()
    {
            foreach ($this->slides as $slide) {
            $slide->delete();
        }

        return parent::afterDelete();
    }

    /**
     * @return array relational rules.
     */
    public function relations()
    {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array_merge(
            array(
                'slides'    => array(self::HAS_MANY, 'Slide', 'slider_id'),
                'user'     => array(self::BELONGS_TO, 'User', 'user_id'),
            ),
			array()
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'id'            => Yii::t($this->_aliasModule, 'id'),
            'name'          => Yii::t($this->_aliasModule, 'Name slider'),
            'description'   => Yii::t($this->_aliasModule, 'Description slider'),
            'creation_date' => Yii::t($this->_aliasModule, 'Created at'),
            'user_id'       => Yii::t($this->_aliasModule, 'Creator'),
            'status'        => Yii::t($this->_aliasModule, 'Status'),
            'code'          => Yii::t($this->_aliasModule, 'Code'),
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

        $criteria = new CDbCriteria();

        $criteria->compare('t.id', $this->id);
        $criteria->compare('t.name', $this->name, true);
        $criteria->compare('t.code', $this->code, true);
        $criteria->compare('t.description', $this->description, true);
        $criteria->compare('t.creation_date', $this->creation_date, true);
        $criteria->compare('t.user_id', $this->user_id, true);
        $criteria->compare('t.status', $this->status);


        return new CActiveDataProvider(get_class($this), array(
        		'criteria' => $criteria,
        		'sort'     => array('defaultOrder' => 't.id')
        		));
    }

    public function beforeValidate()
    {
        if ($this->getIsNewRecord()) {
            $this->creation_date = new CDbExpression('NOW()');
            $this->user_id = Yii::app()->user->getId();
        }

        return parent::beforeValidate();
    }

    public function getStatusList()
    {
        return array(
            self::STATUS_SHOW    => Yii::t($this->_aliasModule, 'show'),
            self::STATUS_HIDE => Yii::t($this->_aliasModule, 'hide')
        );
    }

    public function getStatus()
    {
        $data = $this->getStatusList();

        return isset($data[$this->status]) ? $data[$this->status] : Yii::t($this->_aliasModule, '*unknown*');
    }


    /**
     * Проверка на возможность редактировать/удалять изображения
     *
     * @return boolean can change
     **/
    public function canChange()
    {
        return Yii::app()->user->isSuperUser() || Yii::app()->user->getId() == $this->user_id;
    }





    /**
     * Получаем имя того, кто создал слайдер:
     *
     * @return string user full name
     **/
    public function getUserName()
    {
        return $this->user instanceof User
            ? $this->user->getFullName()
            : '---';
    }



    public function getName()
    {
        return $this->name ? $this->name : $this->alt;
    }

    public function getListNameSlider(){
        return CHtml::listData($this->model()->findAll(), 'id', 'name');
    }

    public function getListSlider(){
        return CHtml::listData(
            $this->model()->findAll(),
            'id',
            'name'
        );
    }

}
