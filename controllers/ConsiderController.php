<?php

namespace backend\modules\customer\controllers;

use Yii;
use backend\modules\customer\models\RegisterCustomer;
use backend\modules\customer\models\RegisterCustomerConsider;
use backend\modules\customer\models\RegisterCustomerConsiderSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * ConsiderController implements the CRUD actions for RegisterCustomer model.
 */
class ConsiderController extends Controller {

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
        $searchModel = new RegisterCustomerConsiderSearch();
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
        $model = $detail['model'];
        $post = Yii::$app->request->post();
        if ($model->load($post)) {
            $model->staff_id = Yii::$app->user->id;
            $model->staff_date = time();
            if ($model->staff_receive == 1) {
                $model->status = 3;
            } elseif ($model->staff_receive == 0) {
                $model->status = 4;
            }
            if ($model->save()) {


                $modelConsider = new RegisterCustomerConsider();
                $modelConsider->status = $model->staff_receive;
                $modelConsider->register_cutomer_id = $model->id;
                $modelConsider->created_by = Yii::$app->user->id;
                $modelConsider->created_at = time();
                $modelConsider->data = [
                    'staff_receive' => $post['RegisterCustomer']['staff_receive'],
                    'financial_amount' => $post['RegisterCustomer']['financial_amount'],
                    'staff_receive_because' => $post['RegisterCustomer']['staff_receive_because'],
                ];

                if ($modelConsider->save(false)) {
                    Yii::$app->session->setFlash('success', 'บันทึกเรียบร้อย');
                    Yii::$app->notification->sent($model->statusLabelString, \yii\helpers\Url::to(['/customer/default/view', 'id' => $model->id]), $model->seller);
                    if($model->status==3){
                       return $this->redirect(['/customer/default/create', 'id' => $model->id]); 
                    }else{
                        return $this->redirect(['index']); 
                    }                    
                }else{
                    Yii::$app->session->setFlash('error', 'พบปัญหา');
                }
            } else {
                print_r($model->getErrors());
                //$err=implode(' ',$registerCustomer->getErrors());
                Yii::$app->session->setFlash('error', 'พบปัญหา');
            }
        }
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
