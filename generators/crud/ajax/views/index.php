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
use yz\admin\widgets\Box;
use <?= $generator->indexWidgetType === 'grid' ? "yz\\admin\\widgets\\GridView" : "yii\\widgets\\ListView" ?>;
use yz\admin\widgets\ActionButtons;
use yz\icons\Icons;

/**
 * @var yii\web\View $this
 * @var yii\data\ActiveDataProvider $dataProvider
<?= !empty($generator->searchModelClass) ? " * @var " . ltrim($generator->searchModelClass, '\\') . " \$searchModel\n" : '' ?>
 * @var array $columns
 */
?>
<?= "<?php" ?> $box = Box::begin(['cssClass' => '<?= Inflector::camel2id(StringHelper::basename($generator->modelClass)) ?>-index box-primary']) ?>
    <div class="text-right">
        <?= "<?php" ?> echo ActionButtons::widget([
            'order' => [['create', 'delete']],
            'gridId' => '<?= Inflector::camel2id(StringHelper::basename($generator->modelClass)) ?>-grid',
            'searchModel' => $searchModel,
            'modelClass' => '<?= $generator->modelClass ?>',
            'buttons' => [
                'create' => Html::a(Icons::p('plus').'Добавить', ['create'], ['class' => 'btn btn-success js-btn-ajax-crud-create']),
            ],
        ]) ?>
    </div>

<?php if ($generator->indexWidgetType === 'grid'): ?>
    <?= "<?= " ?>GridView::widget([
        'id' => '<?= Inflector::camel2id(StringHelper::basename($generator->modelClass)) ?>-grid',
        'dataProvider' => $dataProvider,
        'columns' => array_merge([
            ['class' => 'yii\grid\CheckboxColumn'],
        ], $columns, [
            [
                'class' => 'yz\admin\widgets\ActionColumn',
                'template' => '{update} {delete}',
            ],
        ]),
    ]); ?>
<?php else: ?>
    <?= "<?= " ?>ListView::widget([
        'dataProvider' => $dataProvider,
        'itemOptions' => ['class' => 'item'],
        'itemView' => function ($model, $key, $index, $widget) {
            return Html::a(Html::encode($model-><?= $nameAttribute ?>), ['view', <?= $urlParams ?>]);
        },
    ]); ?>
<?php endif; ?>
<?= "<?php" ?> Box::end() ?>
