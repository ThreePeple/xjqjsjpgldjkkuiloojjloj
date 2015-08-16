<?php

namespace app\input\controllers;

use app\models\JumperInfo;
use app\models\JumperInfoSearch;
use yii\base\ErrorException;
use yii\base\Exception;
use yii\data\ActiveDataProvider;
use yii\web\NotFoundHttpException;
use yii\web\UploadedFile;
use Yii;

class JumperController extends \yii\web\Controller
{
    public $enableCsrfValidation = false;
    public function actionIndex()
    {
        $searchModel = new JumperInfoSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        /*$query = JumperInfo::find();
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                "pageSize"  => 10
            ]
        ]);*/
        return $this->render("index",[
            'dataProvider'=>$dataProvider,
            'model' => $searchModel
        ]);
    }

    /**
     * Updates an existing JumperInfo model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    public function actionImport(){

        set_time_limit(0);
        ini_set("memory_limit",'512M');

        $uploadfile = UploadedFile::getInstanceByName('Filedata');
        if(!$uploadfile || $uploadfile->getHasError()){
            return 0;

        }

        $data = $this->getExcelData($uploadfile->tempName);
        //$data = $this->getExcelData('/Users/jsj/workspace/cnpc/test.xls');
        $trans = \Yii::$app->db->beginTransaction();
        try{
            foreach($data as $item){
                $columns = array_keys($item);
                $value = array_values($item);

                $updates = array_map(function($k,$v){
                    return $k ."='".$v."'";
                },$columns,$value);
                $sql = "insert into jumper_info (".implode(',',$columns).") values('".implode("','",$value)."') ON DUPLICATE KEY update ".implode(',',$updates);

                $result = \Yii::$app->db->createCommand($sql)->execute();

            }
            $trans->commit();
        }catch (Exception $e){
            $trans->rollBack();
            throw $e;
        }
        return 1;
    }

    private function getExcelData($file){
        $reader = new \PHPExcel_Reader_Excel2007();
        if(!$reader->canRead($file)){
            $reader = new \PHPExcel_Reader_Excel5();
            if(!$reader->canRead($file)){
                throw new ErrorException("can not read file as Excel");
            }
        }
        $reader->setReadDataOnly(true);

        $excel = $reader->load($file);
        $currentSheet = $excel->getActiveSheet();

        $allRow = $currentSheet->getHighestRow();

        $arr = [];
        for($j = 1;$j <=$allRow;$j++){
            /**从第A列开始输出*/
            $strs = [];
            for($k= 'A';$k<= 'F' ; $k++){
                $strs[] = $excel->getActiveSheet()->getCell("$k$j")->getValue();
            }
            if(empty($strs[0]) && empty($strs[1])){
                continue;
            }
            $arr[] = $strs;
        }
        $data = [];
        foreach($arr as $i=>$item) {
            if($i == 0) continue;
            $data[$i]["ip"] = $item[0];
            $data[$i]["port"] = $item[1];
            $data[$i]["wire_frame"] = $item[2];
            $data[$i]["wire_position"] = $item[3];
            $data[$i]["point"] = $item[4];
            $data[$i]["insert_no"] = $item[5];
        }
        return $data;
    }

    public function actionDelete($id){
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    public function actionDeleteBatch(){
        $ids = Yii::$app->request->post("ids");
        $result = JumperInfo::deleteAll(["id"=>$ids]);
        return json_encode(["status"=>$result]);
    }

    /**
     * Finds the JumperInfo model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return JumperInfo the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = JumperInfo::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}

