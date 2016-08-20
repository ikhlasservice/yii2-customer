<?php

namespace ikhlas\customer\controllers;

use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\Json;
use ikhlas\customer\models\RegisterCustomer;
use ikhlas\customer\models\RegisterCustomerSearch;
use ikhlas\persons\models\Person;
use ikhlas\persons\models\PersonDetail;
use ikhlas\persons\models\Address;
use ikhlas\persons\models\ContactAddress;
use ikhlas\persons\models\PersonContact;
use ikhlas\persons\models\PersonCareer;
use ikhlas\customer\models\RegisterCustomerConsider;

/**
 * RegisterController implements the CRUD actions for RegisterCustomer model.
 */
class RegisterController extends Controller {

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
        $searchModel = new RegisterCustomerSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $dataProvider->sort->defaultOrder = ['status' => SORT_DESC];
        //$dataProvider->pagination->pagesize = 10;

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
        if ($model->status == 1 && Yii::$app->user->can('staff')) {
            $model->status = 2;
            $model->save(false);
        }
        
        $data = [
            'model' => $detail['model'],
            'modelPerson' => $detail['modelPerson'],
            'modelPersonDetail' => $detail['modelPersonDetail'],
            'modelAddress' => $detail['modelAddress'],
            'modelContactAddress' => $detail['modelContactAddress'],
            'modelPersonContact' => $detail['modelPersonContact'],
            'modelPersonCareer' => $detail['modelPersonCareer'],
            'ajax' => Yii::$app->request->isAjax,
            'modelConsider' => new RegisterCustomerConsider()
        ];

        if (Yii::$app->request->isAjax) {
            return $this->renderAjax('view', $data);
        }        
        
        $post = Yii::$app->request->post();
        
        if ($model->load($post)) {
//            print_r($post);
//        exit();
            $model->staff_id = Yii::$app->user->id;
            $model->staff_date = time();
            if ($model->staff_receive == 1) {
                $model->status = 3;
                $model->financial_amount = $post['RegisterCustomer']['financial_amount'];
            } elseif ($model->staff_receive == 2) {
                $model->status = 4;
            } elseif ($model->staff_receive == 0) {
                $model->status = 5;
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
                    Yii::$app->notification->sent($model->statusLabelString, \yii\helpers\Url::to(['/customer/register/view', 'id' => $model->id]), $model->seller);
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
        return $this->render('view', $data);
    }

    public function actionOffer() {

        $searchModel = new \ikhlas\customer\models\RegisterCustomerOffer();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $dataProvider->sort->defaultOrder = ['status' => SORT_DESC];


        return $this->render('offer', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }

    public function actionDraft() {
        $searchModel = new \ikhlas\customer\models\RegisterCustomerDraftSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('draft', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Lists all RegisterCustomer models.
     * @return mixed
     */
    public function actionConsider() {
        $searchModel = new \ikhlas\customer\models\RegisterCustomerConsiderSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('consider', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Lists all RegisterCustomer models.
     * @return mixed
     */
    public function actionResult() {
        $searchModel = new \ikhlas\customer\models\RegisterCustomerResult();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('result', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Creates a new RegisterCustomer model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate($id = null) {
        if ($id === NULL) {
            $model = new RegisterCustomer();
            $model->status = 0;
            $model->created_at = time();
            $model->seller_id = Yii::$app->user->id;
            if ($model->save()) {
                $this->redirect(['create', 'id' => $model->id]);
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
           
            if ($model->load($post)) {
// print_r($post);
// exit();
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
            return $this->render('create', [
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

    public function actionConfirm($id) {
        $model = RegisterCustomer::find()->where(['id' => $id, 'seller_id' => Yii::$app->user->id])->one();
//        print_r($model);
//        exit();
        if (empty($model)) {
            Yii::$app->session->setFlash('warning', 'ไม่สามารถเข้าถึงข้อมูลนี้ได้');
            return $this->redirect(['index']);
        }
        if (!@in_array($model->status,[0,4])) {
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
                    $model->seller_date = time();
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

    #############################################################

    public function actionUploadajax() {
        $this->uploadMultipleFile();
    }

    private function uploadMultipleFile() {
        $files = [];
        $json = '';
        if (Yii::$app->request->isPost) {
            $img = Yii::$app->img;
            $UploadedFiles = \yii\web\UploadedFile::getInstancesByName('RegisterCustomer[doc]');
            $upload_folder = Yii::$app->request->post('upload_folder');
            $id = Yii::$app->request->post('id');
            $model = $this->findModel($id);
            $tempFile = Json::decode($model->doc);

            $pathFile = $img->getUploadPath() . $upload_folder;
//            print_r($tempFile);
//            exit();
            if ($UploadedFiles !== null) {
                $img->CreateDir($upload_folder);
                foreach ($UploadedFiles as $key => $file) {
                    try {


                        $oldFileName = $file->basename . '.' . $file->extension;
                        $newFileName = md5($file->baseName.time()) . '.' . $file->extension;
                        

                        $file->saveAs($pathFile . '/' . $newFileName);
                        $files[$newFileName] = $oldFileName;

                        if (in_array($file->extension, ['png', 'jpg'])) {
                            $image = Yii::$app->image->load($pathFile . '/' . $newFileName);
                            $image->resize(1000);
                            $image->save($pathFile . '/' . $newFileName);

                            $image = Yii::$app->image->load($pathFile . '/' . $newFileName);
                            $image->resize(200);
                            $image->save($pathFile . '/thumbnail/' . $newFileName);
                        }
                    } catch (Exception $e) {
                        
                    }
                }

                //print_r($json);
                $model = $this->findModel($id);
                $model->doc = RegisterCustomer::findFiles($pathFile);
                if ($model->save(false)) {
                    echo json_encode(['success' => 'true', 'file' => $files, 'temp' => $tempFile, 'json' => $json]);
                } else {
                    echo json_encode(['success' => 'false', 'error' => $model->getErrors()]);
                }
            } else {
                echo json_encode(['success' => 'false',]);
            }
        }
    }

    public function actionDeletefileAjax($id, $folder = null, $fileName = null) {
        $file = Yii::$app->img->getUploadPath($folder . '/' . $id) . $fileName;
        $pathFile = Yii::$app->img->getUploadPath($folder . '/' . $id);
        $model = RegisterCustomer::findOne($id);
//        $data = Json::decode($model->images);
//        unset($data[$fileName]);

        if (@unlink($file)) {
            $model->doc = RegisterCustomer::findFiles($pathFile);
            if ($model->save(false)) {
                echo json_encode(['success' => true]);
            } else {
                echo json_encode(['success' => false]);
            }
        } else {
            echo json_encode(['success' => false, 'error' => $model->getErrors()]);
        }
    }

}
