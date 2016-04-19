<?php

/**
 * Slide основная модель для работы с изображениями
 *
 * @author Sergey Latyskov <serg.latyshkov@gmail.com>
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
 * @property string $lang
 * @property string $file
 * @property string $title1
 * @property string $title2
 * @property string $code
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
		return [
			['code, title1, title2, name, description', 'filter', 'filter' => [new CHtmlPurifier(), 'purify']],
			['lang, name, code', 'required'],
			['code, title1, title2, name, description', 'filter', 'filter' => 'trim'],
			['status', 'numerical', 'integerOnly' => true],
			['user_id, status', 'length', 'max' => 11],
			['title1, title2, file, name, code', 'length', 'max' => 250],
			['lang', 'length', 'max' => 2],
			['code', 'yupe\components\validators\YUniqueSlugValidator'],
			[
				'code',
				'yupe\components\validators\YSLugValidator',
				'message' => Yii::t(
					'SliderModule.slider',
					'Unknown field format "{attribute}" only alphas, digits and _, from 2 to 50 characters'
				)
			],
			['title1, title2, file, lang, code, id, name, description, creation_date, user_id, status', 'safe', 'on' => 'search'],
		];
	}

	public function afterDelete()
	{
		foreach ($this->slides as $slide) {
			$slide->delete();
		}
		@unlink(Yii::app()->getModule('slider')->getUploadPath() . '/' . $this->file);

		return parent::afterDelete();
	}

	/**
	 * @return array
	 */
	public function behaviors()
	{
		$module = Yii::app()->getModule('slider');

		return [
			'imageUpload' => [
				'class' => 'yupe\components\behaviors\ImageUploadBehavior',
				'attributeName' => 'file',
				'minSize' => $module->minSize,
				'maxSize' => $module->maxSize,
				'types' => $module->allowedExtensions,
				'uploadPath' => $module->uploadPath,
				'resizeOptions' => [
					'width' => 9999,
					'height' => 9999,
					'quality' => [
						'jpegQuality' => 100,
						'pngCompressionLevel' => 9
					],
				]
			],
		];
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
				'slides' => [self::HAS_MANY, 'Slide', 'slider_id'],
				'user' => [self::BELONGS_TO, 'User', 'user_id'],
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
			'id' => Yii::t($this->_aliasModule, 'id'),
			'name' => Yii::t($this->_aliasModule, 'Name slider'),
			'description' => Yii::t($this->_aliasModule, 'Description slider'),
			'creation_date' => Yii::t($this->_aliasModule, 'Created at'),
			'user_id' => Yii::t($this->_aliasModule, 'Creator'),
			'status' => Yii::t($this->_aliasModule, 'Status'),
			'code' => Yii::t($this->_aliasModule, 'Code'),
			'lang' => Yii::t($this->_aliasModule, 'Language'),
			'file' => Yii::t($this->_aliasModule, 'File'),
			'title1' => Yii::t($this->_aliasModule, 'Title 1'),
			'title2' => Yii::t($this->_aliasModule, 'Title 2'),
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
		$criteria->compare('t.title1', $this->title1, true);
		$criteria->compare('t.title2', $this->title2, true);
		$criteria->compare('t.code', $this->code, true);
		$criteria->compare('t.description', $this->description, true);
		$criteria->compare('t.creation_date', $this->creation_date, true);
		$criteria->compare('t.user_id', $this->user_id, true);
		$criteria->compare('t.status', $this->status);
		$criteria->compare('t.lang', $this->lang);


		return new CActiveDataProvider(get_class($this), [
			'criteria' => $criteria,
			'sort' => ['defaultOrder' => 't.id']
		]);
	}

	/**
	 * @return bool
	 */
	public function beforeValidate()
	{
		if (!$this->lang) {
			$this->lang = Yii::app()->language;
		}

		if ($this->getIsNewRecord()) {
			$this->creation_date = new CDbExpression('NOW()');
			$this->user_id = Yii::app()->user->getId();
		}

		return parent::beforeValidate();
	}

	/**
	 * @return array
	 */
	public function getStatusList()
	{
		return [
			self::STATUS_SHOW => Yii::t($this->_aliasModule, 'show'),
			self::STATUS_HIDE => Yii::t($this->_aliasModule, 'hide')
		];
	}

	/**
	 * @return string
	 */
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

	/**
	 * @return mixed|string
	 */
	public function getName()
	{
		return $this->name ? $this->name : $this->alt;
	}

	/**
	 * @return array
	 */
	public function getListNameSlider()
	{
		return CHtml::listData($this->model()->findAll(), 'id', 'name', 'lang');
	}

	/**
	 * @return array
	 */
	public function getListSlider()
	{
		return CHtml::listData(
			$this->model()->findAll(),
			'id',
			'name',
			'lang'
		);
	}
}
