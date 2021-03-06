<?php

namespace app\modules\opencase\models;

use Yii;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "free_case".
 *
 * @property integer $id
 * @property integer $token
 * @property integer $last_open
 * @property integer $created_at
 * @property integer $updated_at
 */
class FreeCase extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'free_case';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['token', 'last_open', 'created_at', 'updated_at'], 'integer'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'token' => 'Token',
            'last_open' => 'Last Open',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    public function behaviors() {
        return [
            TimestampBehavior::className(),
        ];
    }
}
