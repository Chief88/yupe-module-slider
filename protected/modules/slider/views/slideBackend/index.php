<?php
$this->breadcrumbs = [
    Yii::t($this->aliasModule, 'Slider') => [$this->patchBackend .'index'],
    Yii::t($this->aliasModule, 'Slide') => [$this->patchBackend .'index'],
    Yii::t($this->aliasModule, 'Management'),
];

$this->pageTitle = Yii::t($this->aliasModule, 'Slides - manage');

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

$this->menu = [
    [
        'label' => 'Слайдры',
        'items' => [
            [
                'icon' => 'list-alt',
                'label' => Yii::t($this->aliasModule, 'Slider management'),
                'url' => ['/slider/sliderBackend/index']
            ],
        ]
    ],
    [
        'label' => 'Слайды',
        'items' => [
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
        ]
    ],
];

?>
<div class="page-header">
    <h1>
        <?= ucfirst(Yii::t($this->aliasModule, 'Slides')); ?>
        <small><?= Yii::t($this->aliasModule, 'management'); ?></small>
    </h1>
</div>

<?php
$this->widget(
    'yupe\widgets\CustomGridView',
    [
        'id'           => 'slide-grid',
    		'sortableRows'      => true,
    		'sortableAjaxSave'  => true,
    		'sortableAttribute' => 'sort',
    		'sortableAction'    => $this->patchBackend .'sortable',
        'dataProvider' => $model->search(),
        'filter'       => $model,
        'columns'      => [
            [
                'name'   => 'slider_id',
                'value'  => '$data->slider->name',
                'filter' => CHtml::activeDropDownList(
                    $model,
                    'slider_id',
                    Slider::model()->getListNameSlider(),
                    ['class' => 'form-control', 'encode' => false, 'empty' => '']
                ),
            ],
            [
                'name'   => Yii::t($this->aliasModule, 'file'),
                'type'   => 'raw',
                'value'  => 'CHtml::image($data->getImageUrl(155), $data->name)',
                'filter' => false
            ],
            'name',
            [
                    'class'   => 'yupe\widgets\EditableStatusColumn',
                    'name'    => 'status',
                    'url'     => $this->createUrl($this->patchBackend .'inline'),
                    'source'  => $model->getStatusList(),
                    'options' => [
                    Slide::STATUS_SHOW  => ['class' => 'label-success'],
                    Slide::STATUS_HIDE => ['class' => 'label-danger'],

                    ],
            ],
            [
                'class' => 'yupe\widgets\CustomButtonColumn',
            		'template'=>'{update}{delete}'
            ],
        ],
    ]
); ?>
