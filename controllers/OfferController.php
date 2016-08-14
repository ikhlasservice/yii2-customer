<?php

namespace backend\modules\customer\controllers;

use Yii;
use backend\modules\customer\models\RegisterCustomer;
use backend\modules\customer\models\RegisterCustomerOffer;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * OfferController implements the CRUD actions for RegisterCustomer model.
 */
class OfferController extends Controller {

    public function behaviors() {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['post'],
                ],
            ],
        ];
    }

    /**
     * Lists all RegisterCustomer models.
     * @return mixed
     */
    public function actionIndex() {
        $searchModel = new RegisterCustomerOffer();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $dataProvider->sort->defaultOrder = ['status' => SORT_DESC];


        return $this->render('index', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single RegisterCustomer model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id) {
       $detail=RegisterCustomer::getDetailRegister($id);        
        return $this->render('view', [
                    'model' => $detail['model'],
                    'modelPerson' => $detail['modelPerson'],
                    'modelPersonDetail' => $detail['modelPersonDetail'],
                    'modelAddress' => $detail['modelAddress'],
                    'modelContactAddress' => $detail['modelContactAddress'],
                    'modelPersonContact' => $detail['modelPersonContact'],
                    'modelPersonCareer' => $detail['modelPersonCareer'],
        ]);
    }

    
    /**
     * Finds the RegisterCustomer model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return RegisterCustomer the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id) {
        if (($model = RegisterCustomer::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

}
