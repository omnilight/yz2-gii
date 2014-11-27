<?php

/**
 * @var yii\web\View $this
 * @var yz\gii\generators\crud\Generator $generator
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
use yz\admin\helpers\AdminHtml;
use yz\admin\widgets\Box;
use yz\admin\widgets\FormBox;
use yz\admin\widgets\ActiveForm;

/**
 * @var yii\web\View $this
 * @var <?= ltrim($generator->modelClass, '\\') ?> $model
 * @var yz\admin\widgets\ActiveForm $form
 */
$index = $model->isNewRecord ? '[_'.time().']' : '['.$model->getPrimaryKey().']';
?>

<?= "<?php " ?>ob_start(); $form = ActiveForm::begin(); ob_end_clean(); ?>

<?php foreach ($safeAttributes as $attribute) {
    echo "  <?= " . $generator->generateActiveField($attribute) . " ?>\n";
} ?>

<?= "<?php " ?>ob_start(); ActiveForm::end(); ob_end_clean(); ?>

