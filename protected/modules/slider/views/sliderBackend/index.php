<?php
$this->breadcrumbs = array(
    Yii::t($this->aliasModule, 'Slider') => array($this->patchBackend .'index'),
    Yii::t($this->aliasModule, 'Management'),
);

$this->pageTitle = Yii::t($this->aliasModule, 'Slider - manage');

$this->menu = array(
    array(
        'label' => 'Слайдеры',
        'items' => array(
            array(
                'icon'  => 'fa fa-fw fa-list-alt',
                'label' => Yii::t($this->aliasModule, 'Slider management'),
                'url'   => array($this->patchBackend .'index')
            ),
            array(
                'icon'  => 'fa fa-fw fa-plus-square',
                'label' => Yii::t($this->aliasModule, 'Add slider'),
                'url'   => array($this->patchBackend .'create')
            ),
        )
    ),
    array(
        'label' => 'Слайды',
        'items' => array(
            array(
                'icon' => 'list-alt',
                'label' => Yii::t($this->aliasModule, 'Slide management'),
                'url' => array('/slider/slideBackend/index')
            ),
        )
    ),
);
?>

<div class="page-header">
    <h1>
        <?php echo ucfirst(Yii::t($this->aliasModule, 'Slider')); ?>
        <small><?php echo Yii::t($this->aliasModule, 'management'); ?></small>
    </h1>
</div>

<?php
$this->widget(
    'yupe\widgets\CustomGridView',
    array(
        'id'           => 'slider-grid',
        'dataProvider' => $model->search(),
        'filter'       => $model,
        'columns'      => array(
            [
                'class'    => 'bootstrap.widgets.TbEditableColumn',
                'name'     => 'name',
                'editable' => [
                    'url'    => $this->createUrl('/slider/sliderBackend/inline'),
                    'mode'   => 'inline',
                    'params' => [
                        Yii::app()->request->csrfTokenName => Yii::app()->request->csrfToken
                    ]
                ],
                'filter'   => CHtml::activeTextField($model, 'name', ['class' => 'form-control']),
            ],
            [
                'class'    => 'bootstrap.widgets.TbEditableColumn',
                'name'     => 'code',
                'editable' => [
                    'url'    => $this->createUrl('/slider/sliderBackend/inline'),
                    'mode'   => 'inline',
                    'params' => [
                        Yii::app()->request->csrfTokenName => Yii::app()->request->csrfToken
                    ]
                ],
                'filter'   => CHtml::activeTextField($model, 'code', ['class' => 'form-control']),
            ],
            'description',
            array(
                    'class'   => 'yupe\widgets\EditableStatusColumn',
                    'name'    => 'status',
                    'url'     => $this->createUrl($this->patchBackend .'inline'),
                    'source'  => $model->getStatusList(),
                    'options' => [
                    Slide::STATUS_SHOW  => ['class' => 'label-success'],
                    Slide::STATUS_HIDE => ['class' => 'label-danger'],

                    ],
            ),

            array(
                'class' => 'yupe\widgets\CustomButtonColumn',
            		'template'=>'{update}{delete}'
            ),
        ),
    )
); ?>
