<?php
$this->breadcrumbs = [
    Yii::t($this->aliasModule, 'Slides') => [$this->patchBackend .'index'],
    $model->name                          => [$this->patchBackend .'view', 'id' => $model->id],
    Yii::t($this->aliasModule, 'Edit'),
];

$this->pageTitle = Yii::t($this->aliasModule, 'Slides - edit');

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
    ['label' => Yii::t($this->aliasModule, 'Slide') . ' «' . mb_substr($model->name, 0, 32) . '»'],
    [
        'icon'  => 'fa fa-fw fa-pencil',
        'label' => Yii::t($this->aliasModule, 'Edit slide'),
        'url'   => [
            $this->patchBackend .'update',
            'id' => $model->id
        ]
    ],
    [
        'icon'  => 'fa fa-fw fa-eye',
        'label' => Yii::t($this->aliasModule, 'View slide'),
        'url'   => [
            $this->patchBackend .'view',
            'id' => $model->id
        ]
    ],
    [
        'icon'        => 'fa fa-fw fa-trash-o',
        'label'       => Yii::t($this->aliasModule, 'Remove slide'),
        'url'         => '#',
        'linkOptions' => [
            'submit'  => [$this->patchBackend .'delete', 'id' => $model->id],
            'params'  => [Yii::app()->getRequest()->csrfTokenName => Yii::app()->getRequest()->csrfToken],
            'confirm' => Yii::t($this->aliasModule, 'Do you really want to remove slide?'),
            'csrf'    => true,
        ]
    ],
];
?>
<div class="page-header">
    <h1><?= Yii::t($this->aliasModule, 'Change slide'); ?><br/>
        <small>&laquo;<?= $model->name; ?> [<?= $model->slider->name; ?>]&raquo;</small>
    </h1>
</div>
<?= $this->renderPartial('_form', [
        'model' => $model,
        'aliasModule' => $this->aliasModule,
    ]
); ?>
