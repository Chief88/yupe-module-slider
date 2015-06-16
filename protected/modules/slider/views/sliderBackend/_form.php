<script type='text/javascript'>
    $(document).ready(function () {
        $('#slider-form').liTranslit({
            elName: '#Slider_name',
            elAlias: '#Slider_code'
        });
    })
</script>

<?php
/**
 * Отображение для default/_form:
 *
 * @category YupeView
 * @package  yupe
 * @author Valek Vergilyush <v.vergilyush@gmail.com>
 * @license  BSD http://ru.wikipedia.org/wiki/%D0%9B%D0%B8%D1%86%D0%B5%D0%BD%D0%B7%D0%B8%D1%8F_BSD
 * @link http://green-s.pro
 **/
$form = $this->beginWidget(
    '\yupe\widgets\ActiveForm',
    array(
        'id'                     => 'slider-form',
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

        <div class='row'>
            <div class="col-sm-12">
                <?php echo $form->textFieldGroup($model, 'name'); ?>
            </div>
        </div>

        <div class='row'>
            <div class="col-sm-12">
                <?php echo $form->slugFieldGroup($model, 'code', ['sourceAttribute' => 'name']); ?>
            </div>
        </div>

        <div class="row">
            <div class="col-sm-12 <?php echo $model->hasErrors('description') ? 'has-error' : ''; ?>">
                <?php echo $form->textAreaGroup($model, 'description'); ?>
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
