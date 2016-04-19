<?php

/**
 * SliderModule основной класс модуля slider
 */

use yupe\components\WebModule;

class SliderModule extends WebModule
{
	const VERSION = '0.1';

	public $uploadPath = 'slider';
	public $documentRoot;
	public $allowedExtensions = 'jpg,jpeg,png,gif';
	public $minSize = 0;
	public $maxSize = 5242880;
	public $maxFiles = 1;
	public $types;
	public $mimeTypes = 'slider/gif, slider/jpeg, slider/png';
	public $maxWidth = 1170;
	public $maxHeight = 350;
	public $aliasModule = 'SliderModule.slider';

	public function getUploadPath()
	{
		return Yii::app()->uploadManager->getBasePath() . DIRECTORY_SEPARATOR . $this->uploadPath;
	}

	public function getInstall()
	{
		if (parent::getInstall()) {
			@mkdir($this->getUploadPath(), 0755);
		}

		return false;
	}

	/**
	 * @return bool
	 */
	public function isMultiLang()
	{
		return true;
	}

	public function getDependencies()
	{
		return [];
	}

	public function getVersion()
	{
		return self::VERSION;
	}

	public function getIcon()
	{
		return "fa fa-fw fa-picture-o";
	}

	public function getParamsLabels()
	{
		return [
			'uploadPath' => Yii::t($this->aliasModule, 'Directory for uploading slides'),
			'allowedExtensions' => Yii::t($this->aliasModule, 'Allowed extensions (separated by comma)'),
			'minSize' => Yii::t($this->aliasModule, 'Minimum size (in bytes)'),
			'maxSize' => Yii::t($this->aliasModule, 'Maximum size (in bytes)'),
			'mimeTypes' => Yii::t($this->aliasModule, 'Mime types'),
			'maxWidth' => Yii::t($this->aliasModule, 'maxWidth'),
			'maxHeight' => Yii::t($this->aliasModule, 'maxHeight'),
		];
	}

	public function getEditableParams()
	{
		return [
			'uploadPath',
			'allowedExtensions',
			'minSize',
			'maxSize',
			'mimeTypes',
			'maxWidth',
			'maxHeight',
		];
	}

	public function getEditableParamsGroups()
	{
		return [
			'main' => [
				'label' => Yii::t($this->aliasModule, 'General module settings'),
				'items' => [
					'allowedExtensions',
					'mimeTypes',
					'minSize',
					'maxSize',
					'uploadPath',
					'maxWidth',
					'maxHeight'
				]
			]
		];
	}

	public function checkSelf()
	{
		$messages = [];

		$uploadPath = Yii::app()->uploadManager->getBasePath() . DIRECTORY_SEPARATOR . $this->uploadPath;

		if (!$uploadPath) {
			$messages[WebModule::CHECK_ERROR][] = [
				'type' => WebModule::CHECK_ERROR,
				'message' => Yii::t(
					$this->aliasModule,
					'Please, choose catalog for slides! {link}',
					[
						'{link}' => CHtml::link(
							Yii::t($this->aliasModule, 'Change module settings'),
							[
								'/yupe/backend/modulesettings/',
								'module' => $this->id,
							]
						),
					]
				),
			];
		}

		if (!is_dir($uploadPath) || !is_writable($uploadPath)) {
			$messages[WebModule::CHECK_ERROR][] = [
				'type' => WebModule::CHECK_ERROR,
				'message' => Yii::t(
					$this->aliasModule,
					'Directory "{dir}" is not accessible for writing ot not exists! {link}',
					[
						'{dir}' => $uploadPath,
						'{link}' => CHtml::link(
							Yii::t($this->aliasModule, 'Change module settings'),
							[
								'/yupe/backend/modulesettings/',
								'module' => $this->id,
							]
						),
					]
				),
			];
		}

		if (!$this->maxSize || $this->maxSize <= 0) {
			$messages[WebModule::CHECK_ERROR][] = [
				'type' => WebModule::CHECK_ERROR,
				'message' => Yii::t(
					$this->aliasModule,
					'Set maximum slides size {link}',
					[
						'{link}' => CHtml::link(
							Yii::t($this->aliasModule, 'Change module settings'),
							[
								'/yupe/backend/modulesettings/',
								'module' => $this->id,
							]
						),
					]
				),
			];
		}

		return (isset($messages[WebModule::CHECK_ERROR])) ? $messages : true;
	}

	public function getCategory()
	{
		return Yii::t($this->aliasModule, 'Content');
	}

	public function getName()
	{
		return Yii::t($this->aliasModule, 'Slider');
	}

	public function getDescription()
	{
		return Yii::t($this->aliasModule, 'Module for slider management');
	}

	public function getAuthor()
	{
		return Yii::t($this->aliasModule, 'Sergey Latyshkov');
	}

	public function getAuthorEmail()
	{
		return Yii::t($this->aliasModule, 'serg.latyshkov@gmail.com');
	}

	public function init()
	{
		parent::init();

		$this->documentRoot = $_SERVER['DOCUMENT_ROOT'];
		$forImport = [];

		if (Yii::app()->hasModule('gallery')) {
			$forImport[] = 'gallery.models.*';
		}

		$this->setImport(
			array_merge(
				[
					'slider.models.*'
				],
				$forImport
			)
		);
	}

	public function getNavigation()
	{
		return [
			[
				'icon' => 'fa fa-fw fa-list-alt',
				'label' => Yii::t($this->aliasModule, 'Slider list'),
				'url' => ['/slider/sliderBackend/index']
			],
			[
				'icon' => 'fa fa-fw fa-plus-square',
				'label' => Yii::t($this->aliasModule, 'Add slider'),
				'url' => ['/slider/sliderBackend/create']
			],
		];
	}

	public function getAdminPageLink()
	{
		return '/slider/sliderBackend/index';
	}

	/**
	 * Получаем разрешённые форматы:
	 * @return array of allowed extensions
	 **/
	public function allowedExtensions()
	{
		return explode(',', $this->allowedExtensions);
	}

	public function getAuthItems()
	{
		return [
			[
				'name' => 'Slider.SliderManager',
				'description' => Yii::t($this->aliasModule, 'Manage slider'),
				'type' => AuthItem::TYPE_TASK,
				'items' => [
					[
						'type' => AuthItem::TYPE_OPERATION,
						'name' => 'Slider.SliderBackend.Create',
						'description' => Yii::t($this->aliasModule, 'Creating slider')
					],
					[
						'type' => AuthItem::TYPE_OPERATION,
						'name' => 'Slider.SliderBackend.Delete',
						'description' => Yii::t($this->aliasModule, 'Removing slider')
					],
					[
						'type' => AuthItem::TYPE_OPERATION,
						'name' => 'Slider.SliderBackend.Index',
						'description' => Yii::t($this->aliasModule, 'List of slider')
					],
					[
						'type' => AuthItem::TYPE_OPERATION,
						'name' => 'Slider.SliderBackend.Update',
						'description' => Yii::t($this->aliasModule, 'Editing slider')
					],
					[
						'type' => AuthItem::TYPE_OPERATION,
						'name' => 'Slider.SliderBackend.Inline',
						'description' => Yii::t($this->aliasModule, 'Editing slider')
					],
					[
						'type' => AuthItem::TYPE_OPERATION,
						'name' => 'Slider.SliderBackend.View',
						'description' => Yii::t($this->aliasModule, 'Viewing slider')
					],
				]
			]
		];
	}
}