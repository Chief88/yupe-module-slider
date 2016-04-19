<?php
$this->breadcrumbs = [
    Yii::t($this->aliasModule, 'Slides') => [$this->patchBackend .'index'],
    Yii::t($this->aliasModule, 'Add'),
];

$this->pageTitle = Yii::t($this->aliasModule, 'Slides - add');

$this->menu = [
    [
        'icon'  => 'fa fa-fw fa-list-alt',
        'label' => Yii::t($this->aliasModule, 'Slide management'),
        'url'   => [$this->patchBackend .'index']
    ],
    [
        'icon'  => 'fa fa-fw fa-plus-square',
        'label' => Yii::t($this->aliasModule, 'Add slide'),
        'url'   => [$this->patchBackend .'create']
    ],
];
?>
<div class="page-header">
    <h1>
        <?= Yii::t($this->aliasModule, 'Slides'); ?>
        <small><?= Yii::t($this->aliasModule, 'add'); ?></small>
    </h1>
</div>

<?= $this->renderPartial('_form', [
        'model' => $model,
        'aliasModule' => $this->aliasModule,
    ]
); ?>
