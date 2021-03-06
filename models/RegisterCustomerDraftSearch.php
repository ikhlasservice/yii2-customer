<?php

namespace ikhlas\customer\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use ikhlas\customer\models\RegisterCustomer;

/**
 * RegisterCustomerSearch represents the model behind the search form about `ikhlas\customer\models\RegisterCustomer`.
 */
class RegisterCustomerDraftSearch extends RegisterCustomer {

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['id', 'created_at', 'person_id', 'seller_id', 'staff_id'], 'integer'],
            [['status', 'data', 'doc', 'doc_fully', 'doc_because', 'score', 'seller_receive', 'seller_receive_because', 'seller_date', 'staff_receive', 'staff_date', 'staff_receive_because'], 'safe'],
            [['financial_amount'], 'number'],
            [['fullname'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function scenarios() {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    public $fullname;

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params) {
        $query = RegisterCustomer::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);
        //$query->joinWith('person');

        $query->where([
            'seller_id' => Yii::$app->user->id,
            'status' => [0, '', NULL]
        ]);


        $dataProvider->setSort([
            'attributes' => [

                'id',
                'created_at',
                'fullname' => [
                    'asc' => ['person.name' => SORT_ASC, 'person.surname' => SORT_ASC],
                    'desc' => ['person.name' => SORT_DESC, 'person.surname' => SORT_DESC],
                    'label' => 'Full Name',
                ],
            ]
        ]);


        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');

            return $dataProvider;
        }

        $query->andFilterWhere([
            //'id' => $this->id,
            'created_at' => $this->created_at,
            'person_id' => $this->person_id,
            'seller_id' => $this->seller_id,
            'seller_date' => $this->seller_date,
            'staff_id' => $this->staff_id,
            'staff_date' => $this->staff_date,
            'financial_amount' => $this->financial_amount,
        ]);

        $query->andFilterWhere(['like', 'status', $this->status])
                ->andFilterWhere(['like', 'id', $this->id])
                ->andFilterWhere(['like', 'doc', $this->doc])
                ->andFilterWhere(['like', 'doc_fully', $this->doc_fully])
                ->andFilterWhere(['like', 'doc_because', $this->doc_because])
                ->andFilterWhere(['like', 'score', $this->score])
                ->andFilterWhere(['like', 'seller_receive', $this->seller_receive])
                ->andFilterWhere(['like', 'seller_receive_because', $this->seller_receive_because])
                ->andFilterWhere(['like', 'staff_receive', $this->staff_receive])
                ->andFilterWhere(['like', 'staff_receive_because', $this->staff_receive_because]);

        if ($this->fullname) {
            $query->joinWith(['person' => function ($q) {                $q->where('person.name LIKE "%' . $this->fullname . '%" ' .
                        'OR person.surname LIKE "%' . $this->fullname . '%"');
            }]);

        }

        //print_r($dataProvider);
        return $dataProvider;
    }

}
