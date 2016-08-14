<?php

namespace backend\modules\customer\controllers;

use Yii;
use backend\modules\customer\models\RegisterCustomer;
use backend\modules\customer\models\RegisterCustomerAcceptance;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use backend\modules\customer\models\RegisterCustomerConsider;

/**
 * AcceptanceController implements the CRUD actions for RegisterCustomer model.
 */
class AcceptanceController extends Controller {

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
        $searchModel = new RegisterCustomerAcceptance();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

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
        $detail = RegisterCustomer::getDetailRegister($id);
        return $this->render('view', [
                    'model' => $detail['model'],
                    'modelPerson' => $detail['modelPerson'],
                    'modelPersonDetail' => $detail['modelPersonDetail'],
                    'modelAddress' => $detail['modelAddress'],
                    'modelContactAddress' => $detail['modelContactAddress'],
                    'modelPersonContact' => $detail['modelPersonContact'],
                    'modelPersonCareer' => $detail['modelPersonCareer'],
            'modelConsider' => new RegisterCustomerConsider
        ]);
    }

    /**
     * Creates a new RegisterCustomer model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate() {
        $model = new RegisterCustomer();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                        'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing RegisterCustomer model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id) {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('update', [
                        'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing RegisterCustomer model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id) {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
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
