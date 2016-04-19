<?php
/**
 * Отображение для default/_form:
 *
 * @author Sergey Latyshkov <serg.latyshkov@gmail.com>
 **/
$form = $this->beginWidget(
	'\yupe\widgets\ActiveForm',
	[
		'id' => 'slider-form',
		'enableAjaxValidation' => false,
		'enableClientValidation' => true,
		'type' => 'vertical',
		'htmlOptions' => ['class' => 'well', 'enctype' => 'multipart/form-data'],
	]
); ?>
<div class="alert alert-info">
	<?= Yii::t($aliasModule, 'Fields with'); ?>
	<span class="required">*</span>
	<?= Yii::t($aliasModule, 'are required.'); ?>
</div>

<?= $form->errorSummary($model); ?>

<div class='row'>
	<div class="col-sm-6">
		<div class='row'>
			<div class='col-sm-12'>
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
	</div>

	<div class="col-sm-6">
		<div class="row">
			<div class="col-sm-12">

				<?php if (count($languages) > 1): { ?>
					<?= $form->dropDownListGroup(
						$model,
						'lang',
						[
							'widgetOptions' => [
								'data' => $languages,
								'htmlOptions' => [
									'empty' => Yii::t($aliasModule, '--choose--'),
								],
							],
						]
					); ?>
					<?php if (!$model->isNewRecord): { ?>
						<?php foreach ($languages as $k => $v): { ?>
							<?php if ($k !== $model->lang): { ?>
								<?php if (empty($langModels[$k])): { ?>
									<a href="<?= $this->createUrl(
										$this->patchBackend . 'create',
										['id' => $model->id, 'lang' => $k]
									); ?>"><i class="iconflags iconflags-<?= $k; ?>" title="<?= Yii::t(
											$aliasModule,
											'Add translate in to {lang}',
											['{lang}' => $v]
										) ?>"></i></a>
								<?php } else: { ?>
									<a href="<?= $this->createUrl(
										$this->patchBackend . 'update',
										['id' => $langModels[$k]]
									); ?>"><i class="iconflags iconflags-<?= $k; ?>" title="<?= Yii::t(
											$aliasModule,
											'Change translation in to {lang}',
											['{lang}' => $v]
										) ?>"></i></a>
								<?php } endif; ?>
							<?php } endif; ?>
						<?php } endforeach; ?>
					<?php } endif; ?>
				<?php } else: { ?>
					<?= $form->hiddenField($model, 'lang'); ?>
				<?php } endif; ?>

			</div>
		</div>

		<div class="row">
			<div class="col-sm-12">
				<?= $form->textFieldGroup($model, 'title1'); ?>
			</div>
		</div>

		<div class="row">
			<div class="col-sm-12">
				<?= $form->textFieldGroup($model, 'title2'); ?>
			</div>
		</div>

		<div class="row">
			<div class="col-sm-12">
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
	</div>
</div>

<?php
$this->widget(
	'bootstrap.widgets.TbButton',
	[
		'buttonType' => 'submit',
		'context' => 'primary',
		'label' => $model->isNewRecord ? Yii::t($aliasModule, 'Add slide and close') : Yii::t(
			$aliasModule,
			'Save slide and continue'
		),
	]
); ?>

<?php
$this->widget(
	'bootstrap.widgets.TbButton',
	[
		'buttonType' => 'submit',
		'htmlOptions' => ['name' => 'submit-type', 'value' => 'index'],
		'label' => $model->isNewRecord ? Yii::t($aliasModule, 'Add slide and save') : Yii::t(
			$aliasModule,
			'Save mage and close'
		),
	]
); ?>

<?php $this->endWidget(); ?>
