<?php
$this->breadcrumbs = array(
    Yii::t($this->aliasModule, 'Slider') => array($this->patchBackend .'index'),
    Yii::t($this->aliasModule, 'Add'),
);

$this->pageTitle = Yii::t($this->aliasModule, 'Slider - add');

$this->menu = array(
    array(
        'icon'  => 'fa fa-fw fa-list-alt',
        'label' => Yii::t($this->aliasModule, 'Slider management'),
        'url'   => array($this->patchBackend .'index')
    ),
);
?>
<div class="page-header">
    <h1>
        <?php echo Yii::t($this->aliasModule, 'Slider'); ?>
        <small><?php echo Yii::t($this->aliasModule, 'add'); ?></small>
    </h1>
</div>

<?php echo $this->renderPartial('_form', array(
        'model' => $model,
        'aliasModule' => $this->aliasModule,
    )
); ?>
