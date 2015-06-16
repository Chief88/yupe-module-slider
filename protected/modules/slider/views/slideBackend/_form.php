<?php
/**
 * Отображение для default/_form:
 **/
$form = $this->beginWidget(
    'bootstrap.widgets.TbActiveForm',
    array(
        'id'                     => 'slide-form',
        'enableAjaxValidation'   => false,
        'enableClientValidation' => true,
        'type'                   => 'vertical',
        'htmlOptions'            => array('class' => 'well', 'enctype' => 'multipart/form-data'),
    )
); ?>
<div class="alert alert-info">
    <?php echo Yii::t($aliasModule, 'Fields with'); ?>
    <span class="required">*</span>
    <?php echo Yii::t($aliasModule, 'are required.'); ?>
</div>

<?php echo $form->errorSummary($model); ?>

<div class='row'>
    <div class="col-sm-7">

        <div class="row">
            <div class="col-sm-7">
                <?php echo $form->dropDownListGroup(
                    $model,
                    'slider_id',
                    array(
                        'widgetOptions' => array(
                            'data'        => Slider::model()->getListSlider(),
                            'htmlOptions' => array(
                                'empty'  => '--Выбрать--',
                                'encode' => false
                            ),
                        ),
                    )
                ); ?>
            </div>
        </div>

        <div class='row'>
            <div class="col-sm-12">
                <br/>
                <?php if (!$model->isNewRecord) : { ?>
                    <?php echo CHtml::image($model->getImageUrl(350, 200), '', array("width" => 350, "height" => 200)); ?>
                <?php } endif; ?>
                <?php echo $form->fileFieldGroup(
                    $model,
                    'file',
                    array(
                        'widgetOptions' => array(
                            'htmlOptions' => array('style' => 'background-color: inherit;'),
                        ),
                    )
                ); ?>
            </div>
        </div>

        <div class='row'>
            <div class="col-sm-12">
                <?php echo $form->textFieldGroup($model, 'name'); ?>
            </div>
        </div>

        <div class="row">
            <div class="col-sm-12 <?php echo $model->hasErrors('description') ? 'has-error' : ''; ?>">
                <?php echo $form->labelEx($model, 'description'); ?>
                <?php $this->widget(
                    $this->module->getVisualEditor(),
                    [
                        'model'     => $model,
                        'attribute' => 'description',
                    ]
                ); ?>
                <?php echo $form->error($model, 'description'); ?>
            </div>
        </div>

        <div class='row'>
            <div class="col-sm-12">
                <?php echo $form->textFieldGroup($model, 'url'); ?>
            </div>
        </div>

        <div class='row'>
            <div class='col-sm-8'>
                <?php echo $form->dropDownListGroup(
                    $model,
                    'status',
                    array(
                        'widgetOptions' => array(
                            'data' => $model->getStatusList(),
                        ),
                    )
                ); ?>
            </div>

        </div>

    </div>

</div>

<?php
$this->widget(
    'bootstrap.widgets.TbButton',
    array(
        'buttonType' => 'submit',
        'context'    => 'primary',
        'label'      => $model->isNewRecord ? Yii::t($aliasModule, 'Add slide and close') : Yii::t(
            $aliasModule,
            'Save slide and continue'
        ),
    )
); ?>

<?php
$this->widget(
    'bootstrap.widgets.TbButton',
    array(
        'buttonType'  => 'submit',
        'htmlOptions' => array('name' => 'submit-type', 'value' => 'index'),
        'label'       => $model->isNewRecord ? Yii::t($aliasModule, 'Add slide and save') : Yii::t(
            $aliasModule,
            'Save mage and close'
        ),
    )
); ?>

<?php $this->endWidget(); ?>
