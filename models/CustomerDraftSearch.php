<?php

namespace ikhlas\customer\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use ikhlas\customer\models\Customer;

/**
 * CustomerSearch represents the model behind the search form about `ikhlas\customer\models\Customer`.
 */
class CustomerDraftSearch extends Customer {

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['id', 'created_at', 'register_customer_id', 'person_id', 'status', 'seller_id', 'staff_id'], 'integer'],
            [['data'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function scenarios() {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params) {
        $query = Customer::find();


        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        if (Yii::$app->user->can('seller')) {
            $query->where([
                'seller_id' => Yii::$app->user->id,
                'status' => ['0', 'null', '']
            ]);
        } elseif (Yii::$app->user->can('staff')) {
            $query->where(['status' => [0]]);
        }



        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'created_at' => $this->created_at,
            'register_customer_id' => $this->register_customer_id,
            'person_id' => $this->person_id,
            'status' => $this->status,
            'seller_id' => $this->seller_id,
            'staff_id' => $this->staff_id,
        ]);

        $query->andFilterWhere(['like', 'data', $this->data]);

        return $dataProvider;
    }

}
