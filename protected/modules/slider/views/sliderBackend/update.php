<?php
$this->breadcrumbs = array(
    Yii::t($this->aliasModule, 'Slider') => array($this->patchBackend .'index'),
    $model->name                          => array($this->patchBackend .'view', 'id' => $model->id),
    Yii::t($this->aliasModule, 'Edit'),
);

$this->pageTitle = Yii::t($this->aliasModule, 'Slider - edit');

$this->menu = array(
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
    array('label' => Yii::t($this->aliasModule, 'Slider') . ' «' . mb_substr($model->name, 0, 32) . '»'),
    array(
        'icon'  => 'fa fa-fw fa-pencil',
        'label' => Yii::t($this->aliasModule, 'Edit slider'),
        'url'   => array(
            $this->patchBackend .'update',
            'id' => $model->id
        )
    ),
    array(
        'icon'  => 'fa fa-fw fa-eye',
        'label' => Yii::t($this->aliasModule, 'View slider'),
        'url'   => array(
            $this->patchBackend .'view',
            'id' => $model->id
        )
    ),
    array(
        'icon'        => 'fa fa-fw fa-trash-o',
        'label'       => Yii::t($this->aliasModule, 'Remove slider'),
        'url'         => '#',
        'linkOptions' => array(
            'submit'  => array($this->patchBackend .'delete', 'id' => $model->id),
            'params'  => array(Yii::app()->getRequest()->csrfTokenName => Yii::app()->getRequest()->csrfToken),
            'confirm' => Yii::t($this->aliasModule, 'Do you really want to remove slider?'),
            'csrf'    => true,
        )
    ),
);
?>
<div class="page-header">
    <h1><?php echo Yii::t($this->aliasModule, 'Change slider'); ?><br/>
        <small>&laquo;<?php echo $model->name; ?>&raquo;</small>
    </h1>
</div>
<?php echo $this->renderPartial('_form', array(
        'model' => $model,
        'aliasModule' => $this->aliasModule,
    )
); ?>
