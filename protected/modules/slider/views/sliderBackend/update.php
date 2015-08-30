<?php
$this->breadcrumbs = [
    Yii::t($this->aliasModule, 'Slider') => [$this->patchBackend .'index'],
    $model->name,
    Yii::t($this->aliasModule, 'Edit'),
];

$this->pageTitle = Yii::t($this->aliasModule, 'Slider - edit');

$this->menu = [
    [
        'icon'  => 'fa fa-fw fa-list-alt',
        'label' => Yii::t($this->aliasModule, 'Slider management'),
        'url'   => [$this->patchBackend .'index']
    ],
    [
        'icon'  => 'fa fa-fw fa-plus-square',
        'label' => Yii::t($this->aliasModule, 'Add slider'),
        'url'   => [$this->patchBackend .'create']
    ],
    ['label' => Yii::t($this->aliasModule, 'Slider') . ' «' . mb_substr($model->name, 0, 32) . '»'],
    [
        'icon'  => 'fa fa-fw fa-pencil',
        'label' => Yii::t($this->aliasModule, 'Edit slider'),
        'url'   => [
            $this->patchBackend .'update',
            'id' => $model->id
        ]
    ],
    [
        'icon'        => 'fa fa-fw fa-trash-o',
        'label'       => Yii::t($this->aliasModule, 'Remove slider'),
        'url'         => '#',
        'linkOptions' => [
            'submit'  => [$this->patchBackend .'delete', 'id' => $model->id],
            'params'  => [Yii::app()->getRequest()->csrfTokenName => Yii::app()->getRequest()->csrfToken],
            'confirm' => Yii::t($this->aliasModule, 'Do you really want to remove slider?'),
            'csrf'    => true,
        ]
    ],
];
?>
<div class="page-header">
    <h1><?= Yii::t($this->aliasModule, 'Edition slider'); ?><br/>
        <small>&laquo;<?= $model->name; ?>&raquo;</small>
    </h1>
</div>
<?= $this->renderPartial('_form', [
        'model' => $model,
        'aliasModule' => $this->aliasModule,
    ]
); ?>
