<?php

/**
 * Slide основная модель для работы с изображениями
 *
 * @author Sergey Latyskov <serg.latyshkov@gmail.com>
 */

/**
 * Class Slide
 */
class Slide extends yupe\models\YModel
{
    const STATUS_SHOW = 1;
    const STATUS_HIDE = 0;

    private $_aliasModule = 'SliderModule.slider';

    /**
     * Returns the static model of the specified AR class.
     *
     * @param string $className - class name
     *
     * @return Slide the static model class
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
        return '{{slide_slide}}';
    }

    /**
     * validation rules
     *
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        return [
            ['name, description', 'filter', 'filter' => [new CHtmlPurifier(), 'purify']],
            ['slider_id, file', 'required'],
            ['name, description, url', 'filter', 'filter' => 'trim'],
            ['slider_id, status, sort', 'numerical', 'integerOnly' => true],
            ['user_id, status', 'length', 'max' => 11],
            ['name, file', 'length', 'max' => 250],
            ['sort, slider_id, id, name, description, url, creation_date, user_id, status', 'safe', 'on' => 'search'],
        ];
    }

    public function behaviors()
    {
        $module = Yii::app()->getModule('slider');

        return [
            'imageUpload' => [
                'class'         => 'yupe\components\behaviors\ImageUploadBehavior',
                'attributeName' => 'file',
                'minSize'       => $module->minSize,
                'maxSize'       => $module->maxSize,
                'types'         => $module->allowedExtensions,
                'uploadPath'    => $module->uploadPath,
                'resizeOptions' => [
                    'width'   => 9999,
                    'height'  => 9999,
                    'quality' => [
                        'jpegQuality'         => 100,
                        'pngCompressionLevel' => 10
                    ],
                ]
            ],
            'sortable'             => [
                'class'         => 'yupe\components\behaviors\SortableBehavior',
                'attributeName' => 'sort'
            ]

        ];
    }

    public function afterDelete()
    {
        @unlink(Yii::app()->getModule('slider')->getUploadPath() . '/' . $this->file);

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
            [
//                'slide'    => [self::BELONGS_TO, 'Slide', 'id'],
                'user'    => [self::BELONGS_TO, 'User', 'user_id'],
                'slider'  => [self::BELONGS_TO, 'Slider', 'slider_id'],
            ],
			[]
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return [
            'id'            => Yii::t($this->_aliasModule, 'id'),
            'name'          => Yii::t($this->_aliasModule, 'Title'),
            'description'   => Yii::t($this->_aliasModule, 'Description'),
            'file'          => Yii::t($this->_aliasModule, 'File'),
        	'url'        	=> Yii::t($this->_aliasModule, 'Url'),
            'creation_date' => Yii::t($this->_aliasModule, 'Created at'),
            'user_id'       => Yii::t($this->_aliasModule, 'Creator'),
            'status'        => Yii::t($this->_aliasModule, 'Status'),
            'slider_id'     => Yii::t($this->_aliasModule, 'Slider'),
        ];
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
        $criteria->compare('t.description', $this->description, true);
        $criteria->compare('t.url', $this->url, true);
        $criteria->compare('t.file', $this->file, true);
        $criteria->compare('t.creation_date', $this->creation_date, true);
        $criteria->compare('t.user_id', $this->user_id, true);
        $criteria->compare('t.status', $this->status);
        $criteria->compare('t.slider_id', $this->slider_id);


        return new CActiveDataProvider(get_class($this), [
        		'criteria' => $criteria,
        		'sort'     => ['defaultOrder' => 't.sort']
        		]);
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
        return [
            self::STATUS_SHOW    => Yii::t($this->_aliasModule, 'show'),
            self::STATUS_HIDE => Yii::t($this->_aliasModule, 'hide')
        ];
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
     * Получаем имя того, кто загрузил картинку:
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

}
