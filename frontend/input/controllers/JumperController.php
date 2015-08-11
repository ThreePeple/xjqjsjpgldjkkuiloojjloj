<?php

namespace app\input\controllers;

use app\models\JumperInfo;
use yii\base\ErrorException;
use yii\base\Exception;
use yii\data\ActiveDataProvider;
use yii\web\UploadedFile;

class JumperController extends \yii\web\Controller
{
    public function actionIndex()
    {
        $query = JumperInfo::find();
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

    public function actionImport(){
        set_time_limit(0);
        ini_set("memory_limit",'512M');

        $uploadfile = UploadedFile::getInstanceByName('file');
        if(!$uploadfile || $uploadfile->hasError()){
            return '文件上传失败';

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

}

