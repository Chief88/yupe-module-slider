<?php
/**
 * SlideBackendController контроллер для управления изображениями в панели упраления
 ***/
class SlideBackendController extends yupe\components\controllers\BackController
{

    public $aliasModule = 'SliderModule.slider';
    public $patchBackend = '/slider/slideBackend/';

    public function accessRules()
    {
        return [
            ['allow', 'roles' => ['admin']],
            ['allow', 'actions' => ['create'], 'roles' => ['Slider.SlideBackend.Create']],
            ['allow', 'actions' => ['delete'], 'roles' => ['Slider.SlideBackend.Delete']],
            ['allow', 'actions' => ['index'], 'roles' => ['Slider.SlideBackend.Index']],
            ['allow', 'actions' => ['update, inline, sortable'], 'roles' => ['Slider.SlideBackend.Update']],
            ['deny']
        ];
    }

    public function actions()
    {
        return [
            'AjaxImageUpload' => [
                'class'     => 'yupe\components\actions\YAjaxImageUploadAction',
                'maxSize'   => $this->module->maxSize,
                'mimeTypes' => $this->module->mimeTypes,
                'types'     => $this->module->allowedExtensions
            ],
            'AjaxImageChoose' => [
                'class' => 'yupe\components\actions\YAjaxImageChooseAction'
            ],
            'inline' => [
                'class'           => 'yupe\components\actions\YInLineEditAction',
                'model'           => 'Slide',
                'validAttributes' => ['status']
            ],
            'sortable' => [
                'class' => 'yupe\components\actions\SortAction',
                'model' => 'Slide',
                'attribute' => 'sort'
            ]
        ];
    }

    /**
     * Создает новую модель изображения.
     * Если создание прошло успешно - перенаправляет на просмотр.
     *
     * @return void
     **/
    public function actionCreate(){
        $model = new Slide();

        if (($data = Yii::app()->getRequest()->getPost('Slide')) !== null) {

            $model->setAttributes($data);

            $transaction = Yii::app()->db->beginTransaction();

            try {

                if ($model->save()) {
                    $transaction->commit();

                    Yii::app()->user->setFlash(
                        yupe\widgets\YFlashMessages::SUCCESS_MESSAGE,
                        Yii::t($this->aliasModule, 'Slide created!')
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

        $this->render('create', ['model' => $model]);
    }

    /**
     * Редактирование изображения.
     *
     * @param integer $id the ID of the model to be update
     *
     * @return void
     */
    public function actionUpdate($id)
    {
        $model = $this->loadModel($id);

        if (($data = Yii::app()->getRequest()->getPost('Slide')) !== null) {

            $model->setAttributes($data);

            if ($model->save()) {

                Yii::app()->user->setFlash(
                    yupe\widgets\YFlashMessages::SUCCESS_MESSAGE,
                    Yii::t($this->aliasModule, 'Slide updated!')
                );

                $this->redirect(
                    (array)Yii::app()->getRequest()->getPost(
                        'submit-type',
                        ['update', 'id' => $model->id]
                    )
                );
            }
        }

        $this->render('update', ['model' => $model]);
    }

    /**
     * Удаяет модель изображения из базы
     * Если удаление прошло успешно - возвращется в index
     *
     * @param integer $id - идентификатор изображения, который нужно удалить
     *
     * @return void
     *
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
                Yii::t($this->aliasModule, 'Slide removed!')
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
        $model = new Slide('search');

        $model->unsetAttributes(); // clear any default values

        $model->setAttributes(
            Yii::app()->getRequest()->getParam(
                'Slide',
                []
            )
        );

        $this->render('index', ['model' => $model]);
    }

    /**
     * Возвращает модель по указанному идентификатору
     * Если модель не будет найдена - возникнет HTTP-исключение.
     * @param integer $id идентификатор нужной модели
     *
     * @return void
     *
     * @throws CHttpException
     */
    public function loadModel($id)
    {
        if (($model = Slide::model()->findByPk($id)) === null) {
            throw new CHttpException(
                404,
                Yii::t($this->aliasModule, 'Requested page was not found!')
            );
        }

        return $model;
    }
}