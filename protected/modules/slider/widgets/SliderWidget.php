<?php

Yii::import('application.modules.slider.models.*');

class SliderWidget extends yupe\widgets\YWidget
{
	public $view = 'slider';
	public $code;
	public $params;

	public function run()
	{

		$criteria = new CDbCriteria();
		$criteria->condition = 't.code = :code AND t.status = :status AND t.lang = :lang';
		$criteria->params = [
			':code' => $this->code,
			':status' => Slider::STATUS_SHOW,
			':lang' => Yii::app()->language,
		];

		$slider = Slider::model()->find($criteria);

		if(null == $slider){
			$criteria->params[':lang'] = Yii::app()->controller->yupe->defaultLanguage;
			$slider = Slider::model()->find($criteria);
		}

		if(null != $slider){
			$criteria = new CDbCriteria();
			$criteria->condition = 't.slider_id = :sliderId AND t.status = :slideStatus';
			$criteria->params = [
				':sliderId' => $slider->id,
				':slideStatus' => Slide::STATUS_SHOW,
			];
			$criteria->order = 't.sort';

			$items = Slide::model()->findAll($criteria);

			$this->render($this->view, [
				'items' => $items,
				'slider' => $slider,
				'params' => $this->params,
			]);
		}
	}
}
