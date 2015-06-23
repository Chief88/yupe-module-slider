<?php
$this->breadcrumbs = array(
    Yii::t($this->aliasModule, 'Slider') => array($this->patchBackend .'index'),
    Yii::t($this->aliasModule, 'Slide') => array($this->patchBackend .'index'),
    Yii::t($this->aliasModule, 'Management'),
);

$this->pageTitle = Yii::t($this->aliasModule, 'Slides - manage');

$this->menu = array(
    array(
        'icon'  => 'fa fa-fw fa-list-alt',
        'label' => Yii::t($this->aliasModule, 'Slide management'),
        'url'   => array($this->patchBackend .'index')
    ),
    array(
        'icon'  => 'fa fa-fw fa-plus-square',
        'label' => Yii::t($this->aliasModule, 'Add slide'),
        'url'   => array($this->patchBackend .'create')
    ),
);

$this->menu = array(
    array(
        'label' => 'Слайды',
        'items' => array(
            array(
                'icon'  => 'fa fa-fw fa-list-alt',
                'label' => Yii::t($this->aliasModule, 'Slide management'),
                'url'   => array($this->patchBackend .'index')
            ),
            array(
                'icon'  => 'fa fa-fw fa-plus-square',
                'label' => Yii::t($this->aliasModule, 'Add slide'),
                'url'   => array($this->patchBackend .'create')
            ),
        )
    ),
    array(
        'label' => 'Слайдры',
        'items' => array(
            array(
                'icon' => 'list-alt',
                'label' => Yii::t($this->aliasModule, 'Slider management'),
                'url' => array('/slider/sliderBackend/index')
            ),
        )
    ),
);

?>
<div class="page-header">
    <h1>
        <?php echo ucfirst(Yii::t($this->aliasModule, 'Slides')); ?>
        <small><?php echo Yii::t($this->aliasModule, 'management'); ?></small>
    </h1>
</div>

<?php
$this->widget(
    'yupe\widgets\CustomGridView',
    array(
        'id'           => 'slide-grid',
    		'sortableRows'      => true,
    		'sortableAjaxSave'  => true,
    		'sortableAttribute' => 'sort',
    		'sortableAction'    => $this->patchBackend .'sortable',
        'dataProvider' => $model->search(),
        'filter'       => $model,
        'columns'      => array(
            array(
                'name'   => 'slider_id',
                'value'  => '$data->slider->name',
                'filter' => CHtml::activeDropDownList(
                    $model,
                    'slider_id',
                    Slider::model()->getListNameSlider(),
                    array('class' => 'form-control', 'encode' => false, 'empty' => '')
                ),
            ),
            array(
                'name'   => Yii::t($this->aliasModule, 'file'),
                'type'   => 'raw',
                'value'  => 'CHtml::image($data->getImageUrl(75, 75), $data->name, array("width" => 75, "height" => 75))',
                'filter' => false
            ),
            'name',
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
