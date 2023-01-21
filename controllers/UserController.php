<?php


namespace app\controllers;


use yii\db\Connection;
use yii\web\Controller;
use yii\web\Response;

class UserController extends Controller
{
    public function actionIndex()
    {

        $db = \Yii::$app->db;
        $users = $db->createCommand('SELECT * FROM user')->queryAll();

        var_dump($users);
    }

    public function actionPoll()
    {
        $db = \Yii::$app->db;
        $polling_unit = $db->createCommand('SELECT uniqueid,polling_unit_name FROM polling_unit')->queryAll();
        $lga = $db->createCommand('SELECT uniqueid,lga_name FROM lga')->queryAll();

        return $this->render('poll', [
            'polling_unit' => $polling_unit,
            'lga' => $lga
        ]);

    }

    public function actionReturnResult()
    {
        $db = \Yii::$app->db;
        if(!$_REQUEST['pu'] && $_REQUEST['lga']){
            $result = $db->createCommand('SELECT SUM(party_score) as score, party_abbreviation FROM announced_lga_results WHERE lga_name = :lga_name GROUP BY party_abbreviation ORDER BY score DESC')->bindValue('lga_name', $_REQUEST["lga"])->queryAll();

        } else {
            if($_REQUEST['pu'] == 'all'){
                $result = $db->createCommand('SELECT SUM(party_score) as score, party_abbreviation FROM announced_pu_results LEFT JOIN polling_unit ON announced_pu_results.polling_unit_uniqueid = polling_unit.uniqueid WHERE lga_id = :lga_id GROUP BY party_abbreviation ORDER BY score DESC')->bindValue('lga_id', $_REQUEST["lga"])->queryAll();

           }else{
                $result = $db->createCommand('SELECT SUM(party_score) as score, party_abbreviation FROM announced_pu_results WHERE polling_unit_uniqueid = :polling_unit_uniqueid GROUP BY party_abbreviation ORDER BY score DESC')->bindValue('polling_unit_uniqueid', $_REQUEST["pu"])->queryAll();
            }
        }
        return $this->render('returnresult', [
            'result' => $result,
        ]);
        }

    public function actionCreate()
    {
        $db = \Yii::$app->db;
        $polling_units = $db->createCommand('SELECT uniqueid, polling_unit_name FROM polling_unit')->queryAll();
        $party = $db->createCommand('SELECT id, partyname FROM party')->queryAll();

        return $this->render('create', [
            'polling_units' => $polling_units,
            'party' => $party
        ]);
    }

    public function actionStore()
    {
        $db = \Yii::$app->db;
        $request = \Yii::$app->request;
        $formfields =[];
        $formfields['polling_unit_uniqueid'] =  $_REQUEST['pu'];
        $formfields['party_abbreviation'] =  $_REQUEST['party'];
        $formfields['party_score'] = $_REQUEST['score'];
        $formfields['entered_by_user'] = $_REQUEST['entree'];
        $formfields['date_entered'] = date('Y-m-d H:i:s');
        $formfields['user_ip_address'] =  $request->getUserIP();
//
//        $date_entered = $formfields['date_entered'];
//        $user_ip_address = $formfields['user_ip_address'];
//        $polling_unit_uniqueid = $formfields['polling_unit_uniqueid'];
//        $party_abbreviation = $formfields['party_abbreviation'];
//        $party_score = $formfields['party_score'];
//        $entered_by_user = $formfields['entered_by_user'];
//        $result_id = rand(1,1000);

        $db->createCommand()->insert('announced_pu_results', [
            'result_id' => rand(1,1000),
            'polling_unit_uniqueid' => $formfields['polling_unit_uniqueid'],
            'party_abbreviation' => $formfields['party_abbreviation'],
            'party_score' => $formfields['party_score'],
            'entered_by_user' => $formfields['entered_by_user'],
            'date_entered' => $formfields['date_entered'],
            'user_ip_address' => $formfields['user_ip_address']
        ])->execute();


        return $this->redirect('./create');

    }
//
//    public function actionTest()
//    {
//        $db = \Yii::$app->db;
//        $result = $db->createCommand()->insert('announced_pu_results', [
//            'result_id' => 12,
//           'polling_unit_uniqueid' => 'asd',
//           'party_abbreviation' => 'adds',
//            'party_score' => '4203',
//            'entered_by_user' => 'Oga_onigbo',
//            'date_entered' => '2023-11-04',
//            'user_ip_address' => '009088'
//        ])->execute();
//    }




}

