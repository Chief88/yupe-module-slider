<?php
$this->breadcrumbs = array(
    Yii::t($this->aliasModule, 'Slides') => array($this->patchBackend .'index'),
    Yii::t($this->aliasModule, 'Add'),
);

$this->pageTitle = Yii::t($this->aliasModule, 'Slides - add');

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
?>
<div class="page-header">
    <h1>
        <?php echo Yii::t($this->aliasModule, 'Slides'); ?>
        <small><?php echo Yii::t($this->aliasModule, 'add'); ?></small>
    </h1>
</div>

<?php echo $this->renderPartial('_form', array(
        'model' => $model,
        'aliasModule' => $this->aliasModule,
    )
); ?>
