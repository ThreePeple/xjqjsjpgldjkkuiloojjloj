<?php

namespace app\system\controllers;

use app\models\AlarmCategory;
use app\models\AlarmLevel;
use app\models\DeviceCategory;
use app\models\User;
use frontend\models\SmsTemplate;
use Yii;
use frontend\models\SmsConfig;
use frontend\models\SmsConfigSearch;
use yii\filters\AccessControl;
use yii\helpers\ArrayHelper;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * SmsController implements the CRUD actions for SmsConfig model.
 */
class SmsController extends Controller
{
    public function behaviors()
    {
        return [
            'access'=>[
                'class'=>AccessControl::className(),
                'rules' =>[

                    [
                        'actions'=>['index'],
                        'allow' => true,
                        'roles' => ['@']
                    ],
                    [
                        'allow'=>true,
                        'roles' => ['admin']
                    ],
                    [
                        'allow' => false,
                        'roles'=>['operator'],
                        'denyCallback' => function($rule,$action){
                            return $this->redirect(['/site/login']);
                        }
                    ],
                ]
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['post'],
                ],
            ],
        ];
    }

    /**
     * Lists all SmsConfig models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new SmsConfigSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single SmsConfig model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new SmsConfig model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new SmsConfig();
        if($model->load(Yii::$app->request->post())){
            $model->setAlarmCondition();
            if($model->save()){
                return $this->redirect(['index']);
            }
        }
        $data = array_merge(['model'=>$model],$this->getViewData());
        return $this->render('create', $data);
    }

    /**
     * Updates an existing SmsConfig model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if($model->load(Yii::$app->request->post())){
            $model->setAlarmCondition();
            if($model->save()){
                return $this->redirect(['index']);
            }
        } else {
            $data = array_merge(['model'=>$model],$this->getViewData());

            return $this->render('update',$data);
        }
    }

    private function getViewData(){
        $levels =AlarmLevel::find()->where(['not',['id'=>255]])->select(["id","text"=>"desc"])->asArray()->all();
        $categorys =AlarmCategory::find()->select(["id","text"=>"subDesc"])->asArray()->all();
        $users = ArrayHelper::map(User::find()->select(["id","username"])->all(),'id','username');

        $templates = SmsTemplate::find()->select(["id","name"])->asArray()->all();
        $templates = ArrayHelper::map($templates,'id','name');
        return [
            "levels" => $levels,
            "categorys" => $categorys,
            "users" => $users,
            "templates" => $templates
        ];
    }

    /**
     * Deletes an existing SmsConfig model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the SmsConfig model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return SmsConfig the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = SmsConfig::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
