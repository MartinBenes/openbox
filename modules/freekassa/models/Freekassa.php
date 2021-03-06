<?php

namespace app\modules\freekassa\models;


use app\models\User;
use app\modules\opencase\models\PromoLog;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "freekassa".
 *
 * @property integer $id
 * @property string $name
 * @property string $description
 * @property string $message
 * @property integer $currency
 * @property integer $amount
 * @property integer $status
 * @property string $user_id
 * @property integer $created_at
 * @property integer $updated_at
 * 
 * @property PromoLog $promo
 * @property User $user
 */
class Freekassa extends ActiveRecord {

	const STATUS_CREATED = 1;
	const STATUS_SUCCESS = 2;
	const STATUS_FAIL = 3;
	private $merchantId;
	private $secretWord;

	public function initFreekassa() {
		$this->merchantId = \Yii::$app->controller->module->params['merchantId'];
		$this->secretWord = \Yii::$app->controller->module->params['merchantSecret'];
	}

	/**
	 * @inheritdoc
	 */
	public static function tableName()
	{
		return 'freekassa';
	}

	/**
	 * @inheritdoc
	 */
	public function rules()
	{
		return [
			[['currency', 'amount', 'status', 'user_id', 'created_at', 'updated_at'], 'integer'],
			[['name', 'description', 'message'], 'string', 'max' => 255],
		];
	}

	/**
	 * @inheritdoc
	 */
	public function attributeLabels()
	{
		return [
			'id' => 'ID',
			'name' => 'Name',
			'description' => 'Description',
			'message' => 'Message',
			'currency' => 'Currency',
			'amount' => 'Amount',
			'status' => 'Status',
			'user_id' => 'User ID',
			'created_at' => 'Created At',
			'updated_at' => 'Updated At',
		];
	}

	public function behaviors() {
		return [
			TimestampBehavior::className(),
		];
	}

	public static function getCurrencies() {
		return \Yii::$app->controller->module->params['currency'];
	}

	public function getSign($sec = 'merchantSecret') {
		$merchantId = \Yii::$app->controller->module->params['merchantId'];
		$secretWord = \Yii::$app->controller->module->params[$sec];
		$sign = md5($merchantId . ':' . $this->amount . ':' . $secretWord . ':' . $this->id);
		return $sign;
	}

	/**
	 * @return bool
	 */
	public function userAddMoney() {
		/** @var Freekassable $userClass */
		$userClass = \Yii::$app->controller->module->params['userClass'];
		$userClass::addMoney($this->user_id, $this->amount);
		return true;
	}

    public function getPromo() {
        return $this->hasOne(PromoLog::className(), ['token' => 'user_id']);
	}

    public function getUser() {
        return $this->hasOne(User::className(), ['token_index' => 'user_id']);
	}

}