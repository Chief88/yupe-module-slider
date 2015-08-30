<?php
/**
 * Отображение для default/_form:
 *
 * @author Sergey Latyshkov <serg.latyshkov@gmail.com>
 **/
$form = $this->beginWidget(
    '\yupe\widgets\ActiveForm',
    [
        'id'                     => 'slider-form',
        'enableAjaxValidation'   => false,
        'enableClientValidation' => true,
        'type'                   => 'vertical',
        'htmlOptions'            => ['class' => 'well', 'enctype' => 'multipart/form-data'],
    ]
); ?>
<div class="alert alert-info">
    <?= Yii::t($aliasModule, 'Fields with'); ?>
    <span class="required">*</span>
    <?= Yii::t($aliasModule, 'are required.'); ?>
</div>

<?= $form->errorSummary($model); ?>

<div class='row'>
    <div class="col-sm-7">

		<div class='row'>
		    <div class="col-sm-12">
		        <?= $form->textFieldGroup($model, 'name'); ?>
		    </div>
		</div>

		<div class='row'>
		    <div class="col-sm-12">
                <?= $form->slugFieldGroup($model, 'code', ['sourceAttribute' => 'name']); ?>
		    </div>
		</div>

        <div class="row">
            <div class="col-sm-12 <?= $model->hasErrors('description') ? 'has-error' : ''; ?>">
                <?= $form->textAreaGroup($model, 'description'); ?>
            </div>
        </div>

		<div class='row'>
		    <div class='col-sm-8'>
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
