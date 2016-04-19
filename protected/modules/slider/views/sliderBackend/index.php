<?php
$this->breadcrumbs = [
	Yii::t($this->aliasModule, 'Slider') => [$this->patchBackend . 'index'],
	Yii::t($this->aliasModule, 'Management'),
];

$this->pageTitle = Yii::t($this->aliasModule, 'Slider - manage');

$this->menu = [
	[
		'label' => 'Слайдеры',
		'items' => [
			[
				'icon' => 'fa fa-fw fa-list-alt',
				'label' => Yii::t($this->aliasModule, 'Slider management'),
				'url' => [$this->patchBackend . 'index']
			],
			[
				'icon' => 'fa fa-fw fa-plus-square',
				'label' => Yii::t($this->aliasModule, 'Add slider'),
				'url' => [$this->patchBackend . 'create']
			],
		]
	],
	[
		'label' => 'Слайды',
		'items' => [
			[
				'icon' => 'list-alt',
				'label' => Yii::t($this->aliasModule, 'Slide management'),
				'url' => ['/slider/slideBackend/index']
			],
		]
	],
];
?>

<div class="page-header">
	<h1>
		<?= ucfirst(Yii::t($this->aliasModule, 'Slider')); ?>
		<small><?= Yii::t($this->aliasModule, 'management'); ?></small>
	</h1>
</div>

<?php
$this->widget(
	'yupe\widgets\CustomGridView',
	[
		'id' => 'slider-grid',
		'dataProvider' => $model->search(),
		'filter' => $model,
		'columns' => [
			[
				'class' => 'bootstrap.widgets.TbEditableColumn',
				'name' => 'name',
				'editable' => [
					'url' => $this->createUrl('/slider/sliderBackend/inline'),
					'mode' => 'inline',
					'params' => [
						Yii::app()->request->csrfTokenName => Yii::app()->request->csrfToken
					]
				],
				'filter' => CHtml::activeTextField($model, 'name', ['class' => 'form-control']),
			],
			[
				'class' => 'bootstrap.widgets.TbEditableColumn',
				'name' => 'code',
				'editable' => [
					'url' => $this->createUrl('/slider/sliderBackend/inline'),
					'mode' => 'inline',
					'params' => [
						Yii::app()->request->csrfTokenName => Yii::app()->request->csrfToken
					]
				],
				'filter' => CHtml::activeTextField($model, 'code', ['class' => 'form-control']),
			],
			'description',
			[
				'class' => 'yupe\widgets\EditableStatusColumn',
				'name' => 'status',
				'url' => $this->createUrl($this->patchBackend . 'inline'),
				'source' => $model->getStatusList(),
				'options' => [
					Slide::STATUS_SHOW => ['class' => 'label-success'],
					Slide::STATUS_HIDE => ['class' => 'label-danger'],

				],
			],
			[
				'name' => 'lang',
				'filter' => $this->yupe->getLanguagesList(),
				'type' => 'html',
			],
			[
				'class' => 'yupe\widgets\CustomButtonColumn',
				'template' => '{update}{delete}'
			],
		],
	]
); ?>
