<?php

namespace app\modules\opencase\models;

use Yii;

/**
 * This is the model class for table "promo".
 *
 * @property integer $id
 * @property string $token
 * @property integer $token_index
 * @property integer $parent_index
 * @property integer $created_at
 * @property integer $updated_at
 */
class Promo extends \yii\db\ActiveRecord
{
	const BONUS_MONEY = 50;
	const BONUS_PERCENT = 50;

	/**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'promo';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['token_index', 'parent_index'], 'integer'],
            [['token'], 'string', 'max' => 255],
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
            'token_index' => 'Token Index',
            'parent_index' => 'Parent Index',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }
}
