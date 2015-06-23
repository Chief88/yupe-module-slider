<?php

/**
 * SlideBackendController контроллер для управления изображениями в панели упраления
 **/
class SlideBackendController extends yupe\components\controllers\BackController
{

    public $aliasModule = 'SliderModule.slider';
    public $patchBackend = '/slider/slideBackend/';
    
    public function accessRules()
    {
        return array(
            array('allow', 'roles' => array('admin')),
            array('allow', 'actions' => array('create'), 'roles' => array('Slider.SlideBackend.Create')),
            array('allow', 'actions' => array('delete'), 'roles' => array('Slider.SlideBackend.Delete')),
            array('allow', 'actions' => array('index'), 'roles' => array('Slider.SlideBackend.Index')),
            array('allow', 'actions' => array('update, inline, sortable'), 'roles' => array('Slider.SlideBackend.Update')),
            array('deny')
        );
    }

    public function actions()
    {
        return array(
            'AjaxImageUpload' => array(
                'class'     => 'yupe\components\actions\YAjaxImageUploadAction',
                'maxSize'   => $this->module->maxSize,
                'mimeTypes' => $this->module->mimeTypes,
                'types'     => $this->module->allowedExtensions
            ),
            'AjaxImageChoose' => array(
                'class' => 'yupe\components\actions\YAjaxImageChooseAction'
            ),
        	'inline' => array(
        		'class'           => 'yupe\components\actions\YInLineEditAction',
        		'model'           => 'Slide',
        		'validAttributes' => array('status')
        	),
            'sortable' => [
                'class' => 'yupe\components\actions\SortAction',
                'model' => 'Slide',
                'attribute' => 'sort'
            ]


        );
    }

    /**
     * Создает новую модель изображения.
     * Если создание прошло успешно - перенаправляет на просмотр.
     *
     * @return void
     */
    public function actionCreate()
    {
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
                            array('create')
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

        $this->render('create', array('model' => $model));
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
                        array('update', 'id' => $model->id)
                    )
                );
            }
        }

        $this->render('update', array('model' => $model));
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
                array()
            )
        );

        $this->render('index', array('model' => $model));
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
        if (($model = Slide::model()->findByPk($id)) === null) {
            throw new CHttpException(
                404,
                Yii::t($this->aliasModule, 'Requested page was not found!')
            );
        }

        return $model;
    }
}
