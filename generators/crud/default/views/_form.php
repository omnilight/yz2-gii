<?php

use yii\helpers\Inflector;
use yii\helpers\StringHelper;

/**
 * @var yii\web\View $this
 * @var yii\gii\generators\crud\Generator $generator
 */

/** @var \yii\db\ActiveRecord $model */
$model = new $generator->modelClass;
$safeAttributes = $model->safeAttributes();
if (empty($safeAttributes)) {
    $safeAttributes = $model->attributes();
}

echo "<?php\n";
?>

use yii\helpers\Html;
use yz\admin\widgets\ActiveForm;

/**
 * @var yii\web\View $this
 * @var <?= ltrim($generator->modelClass, '\\') ?> $model
 * @var yz\admin\widgets\ActiveForm $form
 */
?>

<div class="<?= Inflector::camel2id(StringHelper::basename($generator->modelClass)) ?>-form crud-form">

    <?= "<?php " ?>$form = ActiveForm::begin([
        'enableAjaxValidation' => true,
    ]); ?>

<?php foreach ($safeAttributes as $attribute) {
    echo "\t\t<?= " . $generator->generateActiveField($attribute) . " ?>\n\n";
} ?>
        <div class="form-group form-actions">
            <div class="col-sm-offset-2 col-sm-10">
                <?= "<?= " ?>Html::submitButton($model->isNewRecord ? \Yii::t('admin/t','Create') : \Yii::t('admin/t','Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary', 'name' => 'save_and_stay']) ?>
                <?= "<?= " ?>Html::submitButton($model->isNewRecord ? \Yii::t('admin/t','Create & Exit') : \Yii::t('admin/t','Update & Exit'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
                <?= "<?php " ?>if ($model->isNewRecord): ?>
                    <?= "<?= " ?>Html::submitButton(\Yii::t('admin/t','Create & Then Create Another One'), ['class' => 'btn btn-success', 'name' => 'save_and_create']) ?>
                <?= "<?php " ?>endif ?>
            </div>
        </div>

    <?= "<?php " ?>ActiveForm::end(); ?>

</div>
