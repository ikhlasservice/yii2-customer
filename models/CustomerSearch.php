<?php

namespace ikhlas\customer\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use ikhlas\customer\models\Customer;

/**
 * CustomerSearch represents the model behind the search form about `ikhlas\customer\models\Customer`.
 */
class CustomerSearch extends Customer
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'created_at', 'register_customer_id', 'person_id', 'status', 'seller_id', 'staff_id','profit_id'], 'integer'],
             [['financial_amount'], 'number'],
            [['data','fullname'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
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
    public function search($params)
    {
        $query = Customer::find();
        
        
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);
        
        if (Yii::$app->user->can('seller')) {
            $query->where(['seller_id' => Yii::$app->user->id]);
        } elseif (Yii::$app->user->can('staff')) {
            $query->where(['status'=>[1,2,3,4]]);    
        }
        
        $dataProvider->setSort([
            'attributes' => [
                'id',
                'status',
                'created_at',
                'seller_id',
                'profit_id',
                'financial_amount',
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

         if ($this->fullname) {
            $query->joinWith(['person' => function ($q) {                $q->where('person.name LIKE "%' . $this->fullname . '%" ' .
                        'OR person.surname LIKE "%' . $this->fullname . '%"');
            }]);

        }
        
        $query->andFilterWhere([
            //'id' => $this->id,
            'created_at' => $this->created_at,
            'register_customer_id' => $this->register_customer_id,
            'person_id' => $this->person_id,
            'status' => $this->status, 
            'seller_id' => $this->seller_id,
            'staff_id' => $this->staff_id,
            'profit_id' => $this->profit_id,
        ]);

        $query->andFilterWhere(['like', 'customer.id', $this->id]);
        $query->andFilterWhere(['like', 'customer.financial_amount', $this->financial_amount]);
        if ($this->fullname) {
            $query->joinWith(['person' => function ($q) {                $q->where('person.name LIKE "%' . $this->fullname . '%" ' .
                        'OR person.surname LIKE "%' . $this->fullname . '%"');
            }]);

        }

        return $dataProvider;
    }
}
