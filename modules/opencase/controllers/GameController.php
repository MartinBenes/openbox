<?php

namespace app\modules\opencase\controllers;

use app\models\User;
use app\modules\opencase\models\GameConfig;
use app\modules\opencase\models\Items;
use yii\db\Exception;
use yii\web\Controller;
use yii\web\Response;

class GameController extends Controller {

	public $enableCsrfValidation = false;

	/**
	 * @param integer $caseType
	 * @return mixed|string
	 */
	public function actionRun($caseType) {

		\Yii::$app->response->format = Response::FORMAT_JSON;

		$user = User::getCurrentUser();
		if (!$user) {
			return [
				'code' => 400,
				'msg' => 'Пожалуйста авторизируйтесь или зарегистрируйтесь',
			];
		}

		if ($user->money - $caseType <= 0) {
			return [
				'code' => 400,
				'msg' => 'Недостаточно средств, пожалуйста пополните счет',
			];
		}

		try {
			$user->money -= $caseType;
			$idWinItem = $this->getRandItem($caseType);
			$r = [
				'id' => $idWinItem,
				'caseType' => $caseType,
				'code' => 200,
				'balance' => $user->money,
			];

		} catch (\Exception $e) {
			$r = [
				'msg' => $e->getMessage(),
				'code' => 500,
			];
		}

		$user->save();

		return $r;
	}

	/**
	 * @param integer $caseType
	 * @return mixed
	 */
	public function getRandItem($caseType) {

		$user = \Yii::$app->getUser()->getId();
		$itemPersonal = GameConfig::find()
			->where(['user_id' => $user])
			->andWhere(['case_type' => $caseType])
			->all();

		$items = Items::find()->where(['case_type' => $caseType])->all();
		$chancesMap = [];
		/**
		 * @var Items $item
		 */
		foreach ($items as $item) {
			$chancesMap = array_merge($chancesMap, $item->getChance());
		}
		shuffle($chancesMap);
		$count = count($chancesMap);
		$rand = rand(0, $count - 1);
		$randItem = $chancesMap[$rand];

		return $randItem;
	}


}
