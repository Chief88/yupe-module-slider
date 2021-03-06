<?php

/**
 * SliderBackendController контроллер для управления слайдерами в панели упраления
 **/
class SliderBackendController extends yupe\components\controllers\BackController
{
    public $aliasModule = 'SliderModule.slider';
    public $patchBackend = '/slider/sliderBackend/';

    public function accessRules()
    {
        return [
            ['allow', 'roles' => ['admin']],
            ['allow', 'actions' => ['index'], 'roles' => ['Slider.SliderBackend.Index']],
            ['allow', 'actions' => ['create'], 'roles' => ['Slider.SliderBackend.Create']],
            ['allow', 'actions' => ['update', 'inline'], 'roles' => ['Slider.SliderBackend.Update']],
            ['allow', 'actions' => ['delete', 'multiaction'], 'roles' => ['Slider.SliderBackend.Delete']],
            ['deny']
        ];
    }

    public function actions()
    {
        return [
            'inline' => [
                'class'           => 'yupe\components\actions\YInLineEditAction',
                'model'           => 'Slider',
                'validAttributes' => ['status', 'name', 'code']
            ]
        ];
    }

    /**
     * Создает новую модель изображения.
     * Если создание прошло успешно - перенаправляет на просмотр.
     *
     * @return void
     */
    public function actionCreate()
    {
        $model = new Slider();

        if (($data = Yii::app()->getRequest()->getPost('Slider')) !== null) {

            $model->setAttributes($data);

            $transaction = Yii::app()->db->beginTransaction();

            try {

                if ($model->save()) {



                    $transaction->commit();

                    Yii::app()->user->setFlash(
                        yupe\widgets\YFlashMessages::SUCCESS_MESSAGE,
                        Yii::t($this->aliasModule, 'Slider created!')
                    );

                    $this->redirect(
                        (array)Yii::app()->getRequest()->getPost(
                            'submit-type',
                            ['create']
                        )
                    );
                }
            } catch (Exception $e) {
                $transaction->rollback();

                Yii::app()->user->setFlash(
                    yupe\widgets\YFlashMessages::ERROR_MESSAGE,
                    $e->getMessage()
                );
            }
        }

        $languages = $this->yupe->getLanguagesList();

        //если добавляем перевод
        $id = (int)Yii::app()->getRequest()->getQuery('id');
        $lang = Yii::app()->getRequest()->getQuery('lang');

        if (!empty($id) && !empty($lang)) {
            $slider = Slider::model()->findByPk($id);

            if (null === $slider) {
                Yii::app()->user->setFlash(
                    yupe\widgets\YFlashMessages::ERROR_MESSAGE,
                    Yii::t($this->aliasModule, 'Targeting slider was not found!')
                );
                $this->redirect(['create']);
            }

            if (!array_key_exists($lang, $languages)) {
                Yii::app()->user->setFlash(
                    yupe\widgets\YFlashMessages::ERROR_MESSAGE,
                    Yii::t($this->aliasModule, 'Language was not found!')
                );

                $this->redirect(['create']);
            }

            Yii::app()->user->setFlash(
                yupe\widgets\YFlashMessages::SUCCESS_MESSAGE,
                Yii::t(
                    $this->aliasModule,
                    'You are adding translate in to {lang}!',
                    [
                        '{lang}' => $languages[$lang]
                    ]
                )
            );

            $model->lang = $lang;
            $model->name = $slider->name;
            $model->code = $slider->code;
        } else {
            $model->lang = Yii::app()->language;
        }

        $this->render('create', ['model' => $model, 'languages' => $languages]);
    }

    /**
     * Редактирование изображения.
     *
     * @param integer $id the ID of the model to be updated
     *
     * @return void
     */
    public function actionUpdate($id)
    {
        $model = $this->loadModel($id);

        if (($data = Yii::app()->getRequest()->getPost('Slider')) !== null) {

            $model->setAttributes($data);

            if ($model->save()) {

                Yii::app()->user->setFlash(
                    yupe\widgets\YFlashMessages::SUCCESS_MESSAGE,
                    Yii::t($this->aliasModule, 'Slider updated!')
                );

                $this->redirect(
                    (array)Yii::app()->getRequest()->getPost(
                        'submit-type',
                        ['update', 'id' => $model->id]
                    )
                );
            }
        }

        $this->render('update', ['model' => $model, 'languages' => $this->yupe->getLanguagesList()]);
    }

    /**
     * Удаяет модель изображения из базы.
     * Если удаление прошло успешно - возвращется в index
     *
     * @param integer $id - идентификатор изображения, который нужно удалить
     *
     * @return void
     *
     * @throws CHttpException
     */
    public function actionDelete($id)
    {
        if (Yii::app()->getRequest()->getIsPostRequest()) {

            // we only allow deletion via POST request
            $this->loadModel($id)->delete();

            Yii::app()->user->setFlash(
                yupe\widgets\YFlashMessages::SUCCESS_MESSAGE,
                Yii::t($this->aliasModule, 'Slider removed!')
            );

            // if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
            Yii::app()->getRequest()->getParam('ajax') !== null || $this->redirect(
                (array)Yii::app()->getRequest()->getPost('returnUrl', 'index')
            );
        } else {
            throw new CHttpException(
                400,
                Yii::t($this->aliasModule, 'Bad request. Please don\'t repeat similar requests anymore')
            );
        }
    }

    /**
     * Управление изображениями.
     *
     * @return void
     */
    public function actionIndex()
    {
        $model = new Slider('search');

        $model->unsetAttributes(); // clear any default values

        $model->setAttributes(
            Yii::app()->getRequest()->getParam(
                'Slider',
                []
            )
        );

        $this->render('index', ['model' => $model]);
    }

    /**
     * Возвращает модель по указанному идентификатору
     * Если модель не будет найдена - возникнет HTTP-исключение.
     *
     * @param integer $id идентификатор нужной модели
     *
     * @return void
     *
     * @throws CHttpException
     */
    public function loadModel($id)
    {
        if (($model = Slider::model()->findByPk($id)) === null) {
            throw new CHttpException(
                404,
                Yii::t($this->aliasModule, 'Requested page was not found!')
            );
        }

        return $model;
    }
}
