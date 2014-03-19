<?php

use yii\helpers\Inflector;
use yii\helpers\StringHelper;

/**
 * @var yii\web\View $this
 * @var yz\gii\generators\crud\Generator $generator
 */

$urlParams = $generator->generateUrlParams();
$nameAttribute = $generator->getNameAttribute();

echo "<?php\n";
?>

use yii\helpers\Html;
use <?= $generator->indexWidgetType === 'grid' ? "yz\\admin\\widgets\\GridView" : "yii\\widgets\\ListView" ?>;
use yz\admin\widgets\ActionButtons;

/**
 * @var yii\web\View $this
 * @var yii\data\ActiveDataProvider $dataProvider
 * @var <?= ltrim($generator->searchModelClass, '\\') ?> $searchModel
 */

$this->title = <?= $generator->modelClass ?>::modelTitlePlural();
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="<?= Inflector::camel2id(StringHelper::basename($generator->modelClass)) ?>-index">

    <div class="btn-toolbar pull-right">
        <?= "<?= " ?> ActionButtons::widget([
            'order' => [['search'], ['export', 'create', 'delete', 'return']],
            'gridId' => '<?= Inflector::camel2id(StringHelper::basename($generator->modelClass)) ?>-grid',
            'searchModel' => $searchModel,
            'modelClass' => '<?= $generator->modelClass ?>',
        ]) ?>
    </div>

    <h1><?= "<?= " ?>Html::encode($this->title) ?></h1>

    <?= "<?php " ?>echo $this->render('_search', ['model' => $searchModel]); ?>

<?php if ($generator->indexWidgetType === 'grid'): ?>
    <?= "<?php " ?>echo GridView::widget([
        'id' => '<?= Inflector::camel2id(StringHelper::basename($generator->modelClass)) ?>-grid',
        'dataProvider' => $dataProvider,
        //'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\CheckboxColumn'],

<?php
$count = 0;
if (($tableSchema = $generator->getTableSchema()) === false) {
    foreach ($generator->getColumnNames() as $name) {
        if (++$count < 6) {
            echo "\t\t\t'" . $name . "',\n";
        } else {
            echo "\t\t\t// '" . $name . "',\n";
        }
    }
} else {
    foreach ($tableSchema->columns as $column) {
        $format = $generator->generateColumnFormat($column);
        if (++$count < 6) {
            echo "\t\t\t'" . $column->name . ($format === 'text' ? "" : ":" . $format) . "',\n";
        } else {
            echo "\t\t\t// '" . $column->name . ($format === 'text' ? "" : ":" . $format) . "',\n";
        }
    }
}
?>

            [
                'class' => 'yz\admin\widgets\ActionColumn',
                'template' => '{update} {delete}',
            ],
        ],
    ]); ?>
<?php else: ?>
    <?= "<?php " ?>echo ListView::widget([
        'dataProvider' => $dataProvider,
        'itemOptions' => ['class' => 'item'],
        'itemView' => function ($model, $key, $index, $widget) {
            return Html::a(Html::encode($model-><?= $nameAttribute ?>), ['view', <?= $urlParams ?>]);
        },
    ]); ?>
<?php endif; ?>

</div>
