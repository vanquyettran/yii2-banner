<?php

/**
 * Created by PhpStorm.
 * User: Quyet
 * Date: 8/9/2017
 * Time: 10:56 AM
 */

namespace common\modules\banner\models;

use common\models\Image;
use yii\behaviors\BlameableBehavior;
use yii\behaviors\TimestampBehavior;

class Banner extends \common\modules\banner\baseModels\Banner
{
    const TYPE_TOP_BANNER = 'top_banner';
    const TYPE_SLIDER_ITEM = 'slider_item';

    public static function getTypes()
    {
        return [
            self::TYPE_TOP_BANNER => 'Top banner',
            self::TYPE_SLIDER_ITEM => 'Slider item',
        ];
    }

    /**
     * @param $type
     * @return self|null
     */
    public static function findOneByType($type)
    {
        return self::find()->where(['type' => $type])->oneActive();
    }

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            [
                'class' => BlameableBehavior::className(),
                'createdByAttribute' => 'creator_id',
                'updatedByAttribute' => 'updater_id',
            ],
            [
                'class' => TimestampBehavior::className(),
                'createdAtAttribute' => 'create_time',
                'updatedAtAttribute' => 'update_time',
                'value' => time(),
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['active', 'type', 'sort_order', 'image_id'], 'integer'],
            [['name', 'link', 'caption'], 'string', 'max' => 255],
            [['image_id'], 'exist', 'skipOnError' => true, 'targetClass' => Image::className(), 'targetAttribute' => ['image_id' => 'id'], 'except' => 'test'],
        ];
    }
}