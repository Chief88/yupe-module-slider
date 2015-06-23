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
        $criteria->with[] = 'slider';
        $criteria->condition = 'slider.code = :code AND slider.status = :sliderStatus AND t.status = :slideStatus';
        $criteria->params = [
            ':code' => $this->code,
            ':sliderStatus' => Slider::STATUS_SHOW,
            ':slideStatus' => Slide::STATUS_SHOW,
        ];
        $criteria->order = 't.sort';

        $items = Slide::model()->findAll($criteria);

        if (count($items) > 0){
            $this->render($this->view, [
                'items' => $items,
                'params' => $this->params,
            ]);
        }

    }
}
