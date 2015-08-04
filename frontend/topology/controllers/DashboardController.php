<?php

namespace app\topology\controllers;

use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use app\models\ViewTemplate;
use yii\helpers\Json;

class DashboardController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['index'],
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
    public function actionIndex()
    {
        return $this->render('index');
    }

    /**
     * 刷新面板数据
     */
    public function actionAjaxRefresh(){
        $data = [];
        $selected = ViewTemplate::getTempateSet(ViewTemplate::TYPE_BUILD);
        $data["build"] = $selected;
        return Json::encode($data);
    }

    public function  actionDeviceArea(){
        return $this->render("area");
    }

    public function actionAjaxGetNodes(){
        /*
         *  nodes.update([
                {
                    "id": "1",
                    "label": "交换机1",
                    "group":"hub"
                },
                {
                    "id": "2",
                    "label": "交换机2",
                    "group":"hub"
                },
                {
                    "id": "3",
                    "label": "服务器1",
                    "group":"server"
                },
                {
                    "id": "4",
                    "label": "防火墙",
                    "group":"firewall"
                },
                {
                    "id": "5",
                    "label": "数据库",
                    "group":"db"
                }
            ]);
            edges.add([
                {
                    "id": "1",
                    "from": "1",
                    "to": "2",
                    "color":{color:'red'}
                },
                {
                    "id": "2",
                    "from": "1",
                    "to": "3",
                    "color":{color:'red'}
                },
                {
                    "id": "3",
                    "from": "2",
                    "to": "4",
                    "color":{color:'green'}
                },
                {
                    "id": "4",
                    "from": "2",
                    "to": "5",
                    "color":{color:'green'},
                    dashes:[5,5,3,3]
                }
            ]);return;*/
        $nodes = [
            ["id"=>1,"label"=>"交换机1","group"=>"hub"],
            ["id"=>2,"label"=>"交换机2","group"=>"hub"],
            ["id"=>3,"label"=>"服务器","group"=>"server"],
            ["id"=>4,"label"=>"防火墙","group"=>"firewall"],
            ["id"=>5,"label"=>"数据库","group"=>"db"],
        ];
        $edges = [
            ["id"=>1,"from"=>1,"to"=>2,"color"=>"green"],
            ["id"=>2,"from"=>1,"to"=>3,"color"=>"red"],
            ["id"=>3,"from"=>2,"to"=>4,"color"=>"green"],
            ["id"=>4,"from"=>2,"to"=>5,"color"=>"green","dashes"=>[5,5,3,3]],
           // ["id"=>5,"from"=>1,"to"=>5,"color"=>"red"],
        ];
        return Json::encode([
            "nodes" => $nodes,
            "edges" => $edges
        ]);
    }
}
