<?php

namespace common\modules\banner\searchModels;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\modules\banner\models\Banner as BannerModel;

/**
 * Banner represents the model behind the search form about `common\modules\banner\models\Banner`.
 */
class Banner extends BannerModel
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'active', 'type', 'sort_order', 'create_time', 'update_time', 'image_id', 'creator_id', 'updater_id'], 'integer'],
            [['name', 'link', 'caption'], 'safe'],
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

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = BannerModel::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'active' => $this->active,
            'type' => $this->type,
            'sort_order' => $this->sort_order,
            'create_time' => $this->create_time,
            'update_time' => $this->update_time,
            'image_id' => $this->image_id,
            'creator_id' => $this->creator_id,
            'updater_id' => $this->updater_id,
        ]);

        $query->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'link', $this->link])
            ->andFilterWhere(['like', 'caption', $this->caption]);

        return $dataProvider;
    }
}
