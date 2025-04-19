<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;

class OrganizationSearch extends Model
{
    public $id;
    public $name;
    public $status;

    public function rules()
    {
        return [
            [['id'], 'integer'],
            [['name', 'status'], 'safe'],
        ];
    }

    public function search($params)
    {
        $query = Organization::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 10,
            ],
            'sort' => [
                'defaultOrder' => [
                    'id' => SORT_DESC,
                ]
            ],
        ]);

        $this->load($params);

        if (!$this->validate()) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
        ]);

        $query->andFilterWhere(['like', 'name', $this->name])
              ->andFilterWhere(['like', 'status', $this->status]);

        return $dataProvider;
    }
} 