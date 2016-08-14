<?php

namespace ikhlas\customer\controllers;

use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\data\ActiveDataProvider;
use beastbytes\wizard\WizardBehavior;
use ikhlas\customer\models\Customer;
use ikhlas\customer\models\CustomerSearch;
use ikhlas\customer\models\RegisterCustomer;
use backend\modules\persons\models\Person;
use backend\modules\persons\models\PersonDetail;
use backend\modules\persons\models\Address;
use backend\modules\persons\models\ContactAddress;
use backend\modules\persons\models\PersonContact;
use backend\modules\persons\models\PersonCareer;
use ikhlas\customer\models\RegisterCustomerConsider;

/**
 * DefaultController implements the CRUD actions for Customer model.
 */
class DefaultController extends Controller {

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
     * Lists all Customer models.
     * @return mixed
     */
    public function actionIndex() {
        $searchModel = new CustomerSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Customer model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id) {

        $model = $this->findModel($id);
//        if ($model->profit_id == null) {
//            Yii::$app->session->setFlash('warning', 'กรุณากรอกกำไร');
//        }
        return $this->render('view', [
                    'model' => $model,
        ]);
    }

    public function actionConfirm($id) {
        $model = RegisterCustomer::find()->where(['id' => $id, 'seller_id' => Yii::$app->user->id])->one();
//        print_r($model);
//        exit();
        if (empty($model)) {
            Yii::$app->session->setFlash('warning', 'ไม่สามารถเข้าถึงข้อมูลนี้ได้');
            return $this->redirect(['index']);
        }
        if ($model->status != 0) {
            Yii::$app->session->setFlash('warning', 'ไม่พบสถานะที่เตรียมจะยืนยัน');
            return $this->redirect(['index']);
        }
        $modelPerson = $model->person_id ? $model->person : new Person();
        $modelPersonDetail = $modelPerson->personDetail ? $modelPerson->personDetail : new PersonDetail();
        $modelAddress = $modelPerson->address_id ? $modelPerson->address : new Address();
        $modelContactAddress = $modelPerson->contact_address_id ? $modelPerson->contactAddress : new ContactAddress();
        $modelContactAddress->contactBy = ($modelPerson->address_id == $modelPerson->contact_address_id) ? 1 : 2;
        $modelPersonContact = $modelPerson->personContact ? $modelPerson->personContact : new PersonContact();
        $modelPersonCareer = $modelPerson->personCareer ? $modelPerson->personCareer : new PersonCareer();
        $modelConsider = new RegisterCustomerConsider();


        $post = Yii::$app->request->post();

        if ($modelConsider->load($post)) {
            //print_r($post);
            //exit();
//            if (isset($post['btnConfirm']) && $model->confirm) {
//                $model->status = 1;
//            }
//            $model->seller_date = time();
            $modelConsider->register_cutomer_id = $model->id;
            $modelConsider->created_by = Yii::$app->user->id;
            $modelConsider->created_at = time();
            $consider_basic = $post['RegisterCustomerConsider']['consider_basic'];
            if ($consider_basic) {//การพิจารณาเบื้ยงต้น
                $consider_basic_new = [];
                foreach ($consider_basic as $key => $val) {
                    foreach ($val as $index => $ch) {
                        if ($index != 0 && $ch != 0)
                            $consider_basic_new[$key][($index - 1)] = $ch;
                    }
                }
                $consider_basic = $consider_basic_new;
            }
            $should_receive = $post['RegisterCustomerConsider']['should_receive'];
            $modelConsider->data = [
                'doc_fully' => $post['RegisterCustomerConsider']['doc_fully'],
                'doc_comment' => $post['RegisterCustomerConsider']['doc_comment'],
                'should_receive' => $post['RegisterCustomerConsider']['should_receive'],
                'consider_basic' => $consider_basic,
            ];
            if ($modelConsider->save(false)) {

                if ($should_receive == 1) {
                    $model->status = 1;
                }
                if ($model->save(false)) {
                    Yii::$app->session->setFlash('success', 'ระบบได้ทำการยืนเอกสารการสมัครเรียบร้อยแล้ว');
                    return $this->redirect(['index']);
                }
            } else {
                Yii::$app->session->setFlash('error', 'พบข้อผิดพลาดโปรดแจ้งเจ้าหน้าที่');
                return $modelConsider->getError();
            }
        }

        return $this->render('confirm', [
                    'model' => $model,
                    'modelPerson' => $modelPerson,
                    'modelPersonDetail' => $modelPersonDetail,
                    'modelAddress' => $modelAddress,
                    'modelContactAddress' => $modelContactAddress,
                    'modelPersonContact' => $modelPersonContact,
                    'modelPersonCareer' => $modelPersonCareer,
                    'modelConsider' => $modelConsider
        ]);
    }

    /**
     * Creates a new Customer model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate($id = null) {
        $modelRegisterCustomer = RegisterCustomer::findOne($id);
        if (empty($modelRegisterCustomer)) {
            Yii::$app->session->setFlash('warning', 'ไม่สามารถเข้าถึงข้อมูลนี้ได้');
            return $this->redirect(['index']);
        }
        if ($modelRegisterCustomer->status != 3) {
            Yii::$app->session->setFlash('warning', 'ไม่พบสถานะที่เตรียมจะสร้างบันชี');
            return $this->redirect(['index']);
        }
        $model = $modelRegisterCustomer->customer ? $modelRegisterCustomer->customer : new Customer();

        if ($model->isNewRecord) {
            $model->id = Customer::genId();
            $model->register_customer_id = $modelRegisterCustomer->id;
            $model->seller_id = $modelRegisterCustomer->seller_id;
            $model->staff_id = $modelRegisterCustomer->staff_id;
            $model->person_id = $modelRegisterCustomer->person_id;
            $model->financial_amount = $modelRegisterCustomer->financial_amount;
            $model->created_at = time();
            $model->status = 0;
            $model->save(false);
        }
        $post = Yii::$app->request->post();
        //print_r($post);
        if ($model->load($post)) {
            #############################
            $model->status = 1;
            if ($model->save(false)) {
                Yii::$app->session->setFlash('success', 'บันทึกเรียบร้อย');
                Yii::$app->notification->sent($model->statusLabelString, \yii\helpers\Url::to(['/customer/default/view', 'id' => $model->id]), $model->seller);
                return $this->redirect(['view', 'id' => $model->id]);
            } else {
                print_r($model->getErrors());
                //$err=implode(' ',$registerCustomer->getErrors());
                Yii::$app->session->setFlash('error', 'พบปัญหา');
            }
        }
        return $this->render('create', [
                    'model' => $model,
        ]);
    }

    public function actionRegister($id = null) {
        if ($id === NULL) {
            $model = new RegisterCustomer();
            $model->status = 0;
            $model->created_at = time();
            $model->seller_id = Yii::$app->user->id;
            if ($model->save()) {
                $this->redirect(['register', 'id' => $model->id]);
            } else {
                print_r($model->getErrors());
            }
        } else {

            $model = RegisterCustomer::findOne($id);
            $modelPerson = $model->person_id ? $model->person : new Person();
            $modelPersonDetail = $modelPerson->personDetail ? $modelPerson->personDetail : new PersonDetail();
            $modelAddress = $modelPerson->address_id ? $modelPerson->address : new Address();
            $modelContactAddress = $modelPerson->contact_address_id ? $modelPerson->contactAddress : new ContactAddress();
            $modelContactAddress->contactBy = ($modelPerson->address_id == $modelPerson->contact_address_id) ? 1 : 2;
            $modelPersonContact = $modelPerson->personContact ? $modelPerson->personContact : new PersonContact();
            $modelPersonCareer = $modelPerson->personCareer ? $modelPerson->personCareer : new PersonCareer();



            $post = Yii::$app->request->post();
            //print_r($post);
            if ($model->load($post)) {

                // ที่อยู่ตามสำเนา
                if ($modelAddress->load($post)) {
                    //$modelPersonDetail->person_id = $modelPerson->id;
                    if ($modelAddress->save()) {
                        $modelPerson->address_id = $modelAddress->id;
                    } else {
                        print_r($modelAddress->getError());
                    }
                }
                // ที่อยู่ที่ติดต่อได้
                if ($modelContactAddress->load($post)) {
                    //$modelPersonDetail->person_id = $modelPerson->id;
                    if ($modelContactAddress->save()) {
                        $modelPerson->contact_address_id = $modelContactAddress->id;
                    } else {
                        print_r($modelContactAddress->getError());
                    }
                }

                // ข้อมูลทั่วไป
                if ($modelPerson->load($post)) {
                    $modelPerson->id_card = str_replace('-', '', $modelPerson->id_card);

                    if ($modelPerson->save()) {
                        $model->person_id = $modelPerson->id;
                    } else {
                        print_r($modelPerson->getError());
                    }
                }

                // ข้อมูลทั่วไป-รายละเอียด
                if ($modelPersonDetail->load($post)) {
                    $modelPersonDetail->person_id = $modelPerson->id;
                    if ($modelPersonDetail->save()) {
                        
                    } else {
                        print_r($modelPersonDetail->getError());
                    }
                }

                if ($modelPersonContact->load($post)) {
                    $modelPersonContact->person_id = $modelPerson->id;
                    if ($modelPersonContact->save()) {
                        
                    } else {
                        print_r($modelPersonContact->getError());
                    }
                }

                if ($modelPersonCareer->load($post)) {
                    $modelPersonCareer->person_id = $modelPerson->id;
                    if ($modelPersonCareer->save()) {
                        
                    } else {
                        print_r($modelPersonCareer->getError());
                    }
                }

                #############################
                if ($model->save()) {
                    if (isset($post['btnConfirm'])) {
                        return $this->redirect(['confirm', 'id' => $model->id]);
                    }
                    Yii::$app->session->setFlash('success', 'บันทึกเรียบร้อย');
                } else {
                    print_r($model->getErrors());
                    //$err=implode(' ',$registerCustomer->getErrors());
                    Yii::$app->session->setFlash('error', 'พบปัญหา');
                }
            }
            return $this->render('register', [
                        'model' => $model,
                        'modelPerson' => $modelPerson,
                        'modelPersonDetail' => $modelPersonDetail,
                        'modelAddress' => $modelAddress,
                        'modelContactAddress' => $modelContactAddress,
                        'modelPersonContact' => $modelPersonContact,
                        'modelPersonCareer' => $modelPersonCareer,
            ]);
        }
    }

    /**
     * Updates an existing Customer model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionProfit($id) {
        $model = $this->findModel($id);
        $post = Yii::$app->request->post();
        if ($model->load($post)) {
            if ($model->save(false)) {
                return $this->redirect(['view', 'id' => $model->id]);
            }
        }
        return $this->render('profit', [
                    'model' => $model,
        ]);
    }

    public function actionFinancial($id) {
        $model = $this->findModel($id);
        $post = Yii::$app->request->post();
        if ($model->load($post)) {
            if ($model->save(false)) {
                return $this->redirect(['view', 'id' => $model->id]);
            }
        }
        return $this->render('financial', [
                    'model' => $model,
        ]);
    }

    /**
     * Updates an existing Customer model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id) {
        $model = $this->findModel($id);
        $modelPerson = $model->person;
        $modelPersonDetail = $model->person->personDetail ? $model->person->personDetail : new PersonDetail();
        $modelAddress = $model->person->address_id ? $model->person->address : new Address();
        $post = Yii::$app->request->post();
        if ($model->load($post)) {

            if ($modelAddress->load($post) && $modelAddress->save(false)) {
                
                $modelPerson->address_id = $modelAddress->id;
            } else {
                print_r($modelAddress->getErrors());
            }
            
            if ($modelPerson->load($post) && $modelPerson->save(false)) {
                $modelPersonDetail->person_id = $modelPerson->id;
                
            } else {
                print_r($modelPerson->getErrors());
            }
            
            if ($modelPersonDetail->load($post) && $modelPersonDetail->save(false)) {
                
            } else {
                print_r($modelPersonDetail->getErrors());
            }
            



            if ($model->save(false)) {
                return $this->redirect(['view', 'id' => $model->id]);
            }
        }
        return $this->render('update', [
                    'model' => $model,
                    'modelPerson' => $modelPerson,
                    'modelPersonDetail' => $modelPersonDetail,
                    'modelAddress' => $modelAddress,
        ]);
    }

    /**
     * Deletes an existing Customer model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id) {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Customer model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Customer the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id) {
        if (($model = Customer::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    ###############################################################
    ###############################################################

    public function actionList() {
        $dataProvider = new ActiveDataProvider([
            'query' => Customer::find()
                    ->where(['status' => '1', 'seller_id' => Yii::$app->user->id])
                    ->orderBy('id DESC'),
            'pagination' => [
                'pageSize' => 10,
            ],
        ]);
        return $this->renderAjax('list', [
                    'listDataProvider' => $dataProvider,
                    'ajax' => Yii::$app->request->isAjax
        ]);
    }

    public function actionFind($id) {
        $model = Customer::find()
                //->select(['person.fullname','person.id'])
                ->with('person')
                ->where(['id' => $id])
                ->one();

        $data = [];
        if ($model) {
            $data = [
                'id' => $model->id,
                'fullname' => $model->person->fullname,
                'profit' => $model->profit
            ];
        }
        header('Content-type: application/json');
        echo \yii\helpers\Json::encode($data);
        Yii::$app->end();
    }

}
