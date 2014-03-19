<?php

use yii\db\ActiveRecordInterface;
use yii\helpers\StringHelper;

/**
 * This is the template for generating a CRUD controller class file.
 *
 * @var yii\web\View $this
 * @var yz\gii\generators\crud\Generator $generator
 */

$controllerClass = StringHelper::basename($generator->controllerClass);
$modelClass = StringHelper::basename($generator->modelClass);
$searchModelClass = StringHelper::basename($generator->searchModelClass);
if ($modelClass === $searchModelClass) {
    $searchModelAlias = $searchModelClass . 'Search';
}

/** @var ActiveRecordInterface $class */
$class = $generator->modelClass;
$pks = $class::primaryKey();
$urlParams = $generator->generateUrlParams();
$actionParams = $generator->generateActionParams();
$actionParamComments = $generator->generateActionParamComments();

echo "<?php\n";
?>

namespace <?= StringHelper::dirname(ltrim($generator->controllerClass, '\\')) ?>;

use Yii;
use <?= ltrim($generator->modelClass, '\\') ?>;
use <?= ltrim($generator->searchModelClass, '\\') . (isset($searchModelAlias) ? " as $searchModelAlias" : "") ?>;
use <?= ltrim($generator->baseControllerClass, '\\') ?>;
use yii\web\NotFoundHttpException;
use yii\web\VerbFilter;
use yii\helpers\ArrayHelper;
use yii\web\Response;
use yz\admin\widgets\ActiveForm;

/**
 * <?= $controllerClass ?> implements the CRUD actions for <?= $modelClass ?> model.
 */
class <?= $controllerClass ?> extends <?= StringHelper::basename($generator->baseControllerClass) . "\n" ?>
{
	public function behaviors()
	{
        return ArrayHelper::merge(parent::behaviors(), [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['post'],
                ],
            ],
		]);
    }

    /**
     * Lists all <?= $modelClass ?> models.
	 * @param string $export Set export type
     * @return mixed
     */
	public function actionIndex($export = null)
    {
        $searchModel = new <?= isset($searchModelAlias) ? $searchModelAlias : $searchModelClass ?>;
        $dataProvider = $searchModel->search(Yii::$app->request->getQueryParams());

        return $this->render('index', [
            'dataProvider' => $dataProvider,
            'searchModel' => $searchModel,
        ]);
    }

    /**
     * Creates a new <?= $modelClass ?> model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new <?= $modelClass ?>;

		if (\Yii::$app->request->isAjax) {
			\Yii::$app->response->format = Response::FORMAT_JSON;
			$model->load($_POST);
			return ActiveForm::validate($model);
		}

		if ($model->load(\Yii::$app->request->post()) && $model->save()) {
			\Yii::$app->session->setFlash(\yz\Yz::FLASH_SUCCESS, \Yii::t('admin/t', 'Record was successfully created'));
			return $this->getCreateUpdateResponse($model);
		} else {
			return $this->render('create', [
				'model' => $model,
			]);
		}
	}

	/**
	 * Updates an existing <?= $modelClass ?> model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * <?= implode("\n\t * ", $actionParamComments) . "\n" ?>
	 * @return mixed
	 */
	public function actionUpdate(<?= $actionParams ?>)
	{
		$model = $this->findModel(<?= $actionParams ?>);

		if (\Yii::$app->request->isAjax) {
			\Yii::$app->response->format = Response::FORMAT_JSON;
			$model->load(\Yii::$app->request->post());
			return ActiveForm::validate($model);
		}

		if ($model->load(\Yii::$app->request->post()) && $model->save()) {
			\Yii::$app->session->setFlash(\yz\Yz::FLASH_SUCCESS, \Yii::t('admin/t', 'Record was successfully updated'));
			return $this->getCreateUpdateResponse($model);
		} else {
			return $this->render('update', [
				'model' => $model,
			]);
		}
	}


    /**
     * Deletes an existing <?= $modelClass ?> model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * * <?= implode("\n\t * ", $actionParamComments) . "\n" ?>
     * @return mixed
     */
    public function actionDelete(<?= $actionParams ?>)
    {
<?php if (count($pks) == 1): ?>
        if (is_array(<?= $actionParams ?>)) {
            $message = \Yii::t('admin/t', 'Records were successfully deleted');
        } else {
            <?= $actionParams ?> = (array)<?= $actionParams ?>;
            $message = \Yii::t('admin/t', 'Record was successfully deleted');
        }

        foreach (<?= $actionParams ?> as <?= $actionParams ?>_)
            $this->findModel(<?= $actionParams ?>_)->delete();
<?php else: ?>
<?php
    $condition = 'is_array('.implode(') && is_array(',$pks).')';
?>
        if ($condition) {
            $keys = array_map(null, <?= $actionParams ?>);
            $message = \Yii::t('admin/t', 'Records were successfully deleted');
        } else {
            $keys = [[<?= $actionParams ?>]];
            $message = \Yii::t('admin/t', 'Record was successfully deleted');
        }

        foreach ($keys as $key) {
            list(<?= $actionParams ?>) = $key;
            $this->findModel(<?= $actionParams ?>)->delete();
        }
<?php endif; ?>

        \Yii::$app->session->setFlash(\yz\Yz::FLASH_SUCCESS, $message);

        return $this->redirect(['index']);
    }

    /**
     * Finds the <?= $modelClass ?> model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * <?= implode("\n     * ", $actionParamComments) . "\n" ?>
     * @return <?=                   $modelClass ?> the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel(<?= $actionParams ?>)
    {
<?php
if (count($pks) === 1) {
    $condition = '$id';
    // find() would return Query when $id === null
    $nullCheck = '$id !== null && ';
} else {
    $condition = [];
    foreach ($pks as $pk) {
        $condition[] = "'$pk' => \$$pk";
    }
    $condition = '[' . implode(', ', $condition) . ']';
    $nullCheck = '';
}
?>
        if (<?= $nullCheck ?>($model = <?= $modelClass ?>::find(<?= $condition ?>)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
