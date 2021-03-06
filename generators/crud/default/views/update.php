<?php

use yii\helpers\Inflector;
use yii\helpers\StringHelper;

/**
 * @var yii\web\View $this
 * @var yii\gii\generators\crud\Generator $generator
 */

$urlParams = $generator->generateUrlParams();

echo "<?php\n";
?>

use yii\helpers\Html;
use yz\admin\widgets\Box;
use yz\admin\widgets\ActionButtons;

/**
 * @var yii\web\View $this
 * @var <?= ltrim($generator->modelClass, '\\') ?> $model
 */
$this->title = \Yii::t('admin/t', 'Update {item}', ['item' => <?= $generator->modelClass ?>::modelTitle()]);
$this->params['breadcrumbs'][] = ['label' => <?= $generator->modelClass ?>::modelTitlePlural(), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
$this->params['header'] = $this->title;
?>
<div class="<?= Inflector::camel2id(StringHelper::basename($generator->modelClass)) ?>-update">

    <div class="text-right">
        <?= "<?php " ?> Box::begin() ?>
        <?= "<?= " ?> ActionButtons::widget([
            'order' => [['index', 'return']],
            'addReturnUrl' => false,
        ]) ?>
        <?= "<?php " ?> Box::end() ?>
    </div>

    <?= "<?php " ?>echo $this->render('_form', [
        'model' => $model,
    ]); ?>

</div>
