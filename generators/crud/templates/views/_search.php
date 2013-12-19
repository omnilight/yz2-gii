<?php

use yii\helpers\Inflector;
use yii\helpers\StringHelper;

/**
 * @var yii\web\View $this
 * @var yii\gii\generators\crud\Generator $generator
 */

echo "<?php\n";
?>

use yii\helpers\Html;
use yz\admin\widgets\ActiveForm;

/**
 * @var yii\web\View $this
 * @var <?= ltrim($generator->searchModelClass, '\\') ?> $model
 * @var yz\admin\widgets\ActiveForm $form
 */
?>

<div class="<?= Inflector::camel2id(StringHelper::basename($generator->modelClass)) ?>-search hidden" id="filter-search">

	<?= "<?php " ?>$form = ActiveForm::begin([
		'action' => ['index'],
		'method' => 'get',
	]); ?>

<?php
$count = 0;
foreach ($generator->getColumnNames() as $attribute) {
	if (++$count < 6) {
		echo "\t\t<?= " . $generator->generateActiveSearchField($attribute) . " ?>\n\n";
	} else {
		echo "\t\t<?php // echo " . $generator->generateActiveSearchField($attribute) . " ?>\n\n";
	}
}
?>
		<div class="form-group">
			<?= "<?= " ?>Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
			<?= "<?= " ?>Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
		</div>

	<?= "<?php " ?>ActiveForm::end(); ?>

</div>
