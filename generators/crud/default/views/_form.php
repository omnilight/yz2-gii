<?php
/**
 * This is the template for generating CRUD search class of the specified model.
 */
use yii\helpers\Inflector;
use yii\helpers\StringHelper;

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
?>

<?= "<?php " ?> $box = FormBox::begin(['cssClass' => '<?= Inflector::camel2id(StringHelper::basename($generator->modelClass)) ?>-form box-primary', 'title' => '']) ?>
    <?= "<?php " ?>$form = ActiveForm::begin(); ?>

    <?= "<?php " ?>$box->beginBody() ?>
<?php foreach ($generator->getColumnNames() as $attribute) {
    if (in_array($attribute, $safeAttributes)) {
        echo "    <?= " . $generator->generateActiveField($attribute) . " ?>\n\n";
    }
} ?>
    <?= "<?php " ?>$box->endBody() ?>

    <?= "<?php" ?> $box->actions([
        AdminHtml::actionButton(AdminHtml::ACTION_SAVE_AND_STAY, $model->isNewRecord),
        AdminHtml::actionButton(AdminHtml::ACTION_SAVE_AND_LEAVE, $model->isNewRecord),
        AdminHtml::actionButton(AdminHtml::ACTION_SAVE_AND_CREATE, $model->isNewRecord),
    ]) ?>
    <?= "<?php " ?>ActiveForm::end(); ?>

<?= "<?php " ?> FormBox::end() ?>
