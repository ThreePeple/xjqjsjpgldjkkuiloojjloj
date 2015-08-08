<?php
/**
 * Created by PhpStorm.
 * Author: Shengjun
 * CreateTime: 15-7-14.上午10:46
 * Description:
 */

namespace app\system\controllers;

use yii\data\ActiveDataProvider;
use yii\web\Controller;
use Yii;
use app\models\User;
use yii\helpers\Url;
use yii\web\Response;
use yii\widgets\ActiveForm;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;

class UserController extends Controller {

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    public function actionIndex(){
        $query = User::find();
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                "pageSize"  => 10
            ]
        ]);
        return $this->render("index",[
            'dataProvider'=>$dataProvider,
        ]);
    }

    public function actionCreate(){
        $model = new User();
        if (Yii::$app->request->isAjax && $model->load(Yii::$app->request->post())) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ActiveForm::validate($model,['username']);
        }
        if(Yii::$app->request->isPost){
            $model->load(Yii::$app->request->post());
            $model->setPassword($model->password_set);
            $model->generateAuthKey();
            if( $model->save()){
                return $this->redirect(Url::toRoute(['/system/user/index']));
            }
        }
        return $this->render("create",[
            "model" => $model,
        ]);
    }

} 