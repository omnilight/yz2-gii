<?php

use yii\helpers\Inflector;
use yii\helpers\StringHelper;

/**
 * @var yii\web\View $this
 * @var yz\gii\generators\crud\Generator $generator
 */

echo "<?php\n";
?>

use yii\helpers\Html;
use yz\admin\widgets\ActiveForm;
use yz\admin\widgets\FormBox;

/**
 * @var yii\web\View $this
 * @var <?= ltrim($generator->searchModelClass, '\\') ?> $model
 * @var yz\admin\widgets\ActiveForm $form
 */
?>

<div class="<?= Inflector::camel2id(StringHelper::basename($generator->modelClass)) ?>-search hidden" id="filter-search">
    <?= "<?php" ?> $box = FormBox::begin() ?>
    <?= "<?php" ?> $box->beginBody() ?>
    <?= "<?php" ?> $form = ActiveForm::begin([
        'action' => ['index'],
        'fieldConfig' => [
            'horizontal' => ['label' => 'col-sm-3', 'input' => 'col-sm-5', 'offset' => 'col-sm-offset-3 col-sm-5'],
        ],
        'method' => 'get',
    ]); ?>

<?php
$count = 0;
foreach ($generator->getColumnNames() as $attribute) {
    if (++$count < 6) {
        echo "    <?= " . $generator->generateActiveSearchField($attribute) . " ?>\n";
    } else {
        echo "    <?php // echo " . $generator->generateActiveSearchField($attribute) . " ?>\n";
    }
}
?>
        <?= "<?php " ?> $box->endBody() ?>
        <?= "<?php " ?> $box->beginFooter() ?>
            <?= "<?= " ?>Html::submitButton(\Yii::t('admin/t','Search'), ['class' => 'btn btn-primary']) ?>
        <?= "<?php " ?> $box->endFooter() ?>

    <?= "<?php " ?>ActiveForm::end(); ?>
    <?= "<?php " ?> FormBox::end() ?>
</div>
