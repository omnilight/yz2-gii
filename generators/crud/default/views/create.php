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
use yz\admin\widgets\Box;
use yz\admin\widgets\ActionButtons;

/**
 * @var yii\web\View $this
 * @var <?= ltrim($generator->modelClass, '\\') ?> $model
 */
<?php if ($generator->enableI18N): ?>
$this->title = \Yii::t('admin/t', 'Create {item}', ['item' => <?= $generator->modelClass ?>::modelTitle()]);
<?php else: ?>
$this->title = 'Create ' . <?= $generator->modelClass ?>::modelTitle();
<?php endif ?>
$this->params['breadcrumbs'][] = ['label' => <?= $generator->modelClass ?>::modelTitlePlural(), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
$this->params['header'] = $this->title;
?>
<div class="<?= Inflector::camel2id(StringHelper::basename($generator->modelClass)) ?>-create">

    <div class="text-right">
        <?= "<?php " ?> Box::begin() ?>
        <?= "<?= " ?> ActionButtons::widget([
            'order' => [['index', 'create', 'return']],
            'addReturnUrl' => false,
        ]) ?>
        <?= "<?php " ?> Box::end() ?>
    </div>

    <?= "<?php " ?>echo $this->render('_form', [
        'model' => $model,
    ]); ?>

</div>
