<?php
$this->breadcrumbs = [
	Yii::t($this->aliasModule, 'Slider') => [$this->patchBackend . 'index'],
	Yii::t($this->aliasModule, 'Add'),
];

$this->pageTitle = Yii::t($this->aliasModule, 'Slider - add');

$this->menu = [
	[
		'icon' => 'fa fa-fw fa-list-alt',
		'label' => Yii::t($this->aliasModule, 'Slider management'),
		'url' => [$this->patchBackend . 'index']
	],
];
?>
<div class="page-header">
	<h1>
		<?= Yii::t($this->aliasModule, 'Slider'); ?>
		<small><?= Yii::t($this->aliasModule, 'add'); ?></small>
	</h1>
</div>

<?= $this->renderPartial('_form', [
		'model' => $model,
		'aliasModule' => $this->aliasModule,
		'languages' => $languages
	]
); ?>
