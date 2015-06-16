<?php
$this->breadcrumbs = array(
    Yii::t($this->aliasModule, 'Slides') => array($this->patchBackend .'index'),
    $model->name                          => array($this->patchBackend .'view', 'id' => $model->id),
    Yii::t($this->aliasModule, 'Edit'),
);

$this->pageTitle = Yii::t($this->aliasModule, 'Slides - edit');

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
    array('label' => Yii::t($this->aliasModule, 'Slide') . ' «' . mb_substr($model->name, 0, 32) . '»'),
    array(
        'icon'  => 'fa fa-fw fa-pencil',
        'label' => Yii::t($this->aliasModule, 'Edit slide'),
        'url'   => array(
            $this->patchBackend .'update',
            'id' => $model->id
        )
    ),
    array(
        'icon'  => 'fa fa-fw fa-eye',
        'label' => Yii::t($this->aliasModule, 'View slide'),
        'url'   => array(
            $this->patchBackend .'view',
            'id' => $model->id
        )
    ),
    array(
        'icon'        => 'fa fa-fw fa-trash-o',
        'label'       => Yii::t($this->aliasModule, 'Remove slide'),
        'url'         => '#',
        'linkOptions' => array(
            'submit'  => array($this->patchBackend .'delete', 'id' => $model->id),
            'params'  => array(Yii::app()->getRequest()->csrfTokenName => Yii::app()->getRequest()->csrfToken),
            'confirm' => Yii::t($this->aliasModule, 'Do you really want to remove slide?'),
            'csrf'    => true,
        )
    ),
);
?>
<div class="page-header">
    <h1><?php echo Yii::t($this->aliasModule, 'Change slide'); ?><br/>
        <small>&laquo;<?php echo $model->name; ?>&raquo;</small>
    </h1>
</div>
<?php echo $this->renderPartial('_form', array(
        'model' => $model,
        'aliasModule' => $this->aliasModule,
    )
); ?>
