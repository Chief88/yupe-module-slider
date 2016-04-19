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
    <?= Yii::t($aliasModule, 'Fields with'); ?>
    <span class="required">*</span>
    <?= Yii::t($aliasModule, 'are required.'); ?>
</div>

<?= $form->errorSummary($model); ?>

<div class="row">
    <div class="col-sm-7">
        <?= $form->dropDownListGroup(
            $model,
            'slider_id',
            [
                'widgetOptions' => [
                    'data'        => Slider::model()->getListSlider(),
                    'htmlOptions' => [
                        'empty'  => '--Выбрать--',
                        'encode' => false
                    ],
                ],
            ]
        ); ?>
    </div>
</div>

<div class='row'>
    <div class="col-sm-7">
        <?php
        echo CHtml::image(
            !$model->isNewRecord && $model->file ? $model->getImageUrl() : '#',
            $model->name,
            [
                'class' => 'preview-image',
                'style' => !$model->isNewRecord && $model->file ? 'max-width: 100%;' : 'display:none; max-width: 100%;'
            ]
        ); ?>

        <?= $form->fileFieldGroup($model, 'file', [
                'widgetOptions' => [
                    'htmlOptions' => [
                        'onchange' => 'readURL(this);',
                        'style'    => 'background-color: inherit;'
                    ]
                ]
            ]
        ); ?>
    </div>
</div>

<div class='row'>
    <div class="col-sm-7">
        <?= $form->textFieldGroup($model, 'name'); ?>
    </div>
</div>

<div class="row">
    <div class="col-sm-7 <?= $model->hasErrors('description') ? 'has-error' : ''; ?>">
        <?= $form->labelEx($model, 'description'); ?>
        <?php $this->widget(
            $this->module->getVisualEditor(),
            [
                'model'     => $model,
                'attribute' => 'description',
            ]
        ); ?>
        <?= $form->error($model, 'description'); ?>
    </div>
</div>

<div class='row'>
    <div class="col-sm-7">
        <?= $form->textFieldGroup($model, 'url'); ?>
    </div>
</div>

<div class='row'>
    <div class='col-sm-7'>
        <?= $form->dropDownListGroup(
            $model,
            'status',
            [
                'widgetOptions' => [
                    'data' => $model->getStatusList(),
                ],
            ]
        ); ?>
    </div>

</div>

<?php
$this->widget(
    'bootstrap.widgets.TbButton',
    [
        'buttonType' => 'submit',
        'context'    => 'primary',
        'label'      => $model->isNewRecord ? Yii::t($aliasModule, 'Add slide and close') : Yii::t(
                $aliasModule,
                'Save slide and continue'
            ),
    ]
); ?>

<?php
$this->widget(
    'bootstrap.widgets.TbButton',
    [
        'buttonType'  => 'submit',
        'htmlOptions' => ['name' => 'submit-type', 'value' => 'index'],
        'label'       => $model->isNewRecord ? Yii::t($aliasModule, 'Add slide and save') : Yii::t(
                $aliasModule,
                'Save mage and close'
            ),
    ]
); ?>

<?php $this->endWidget(); ?>
