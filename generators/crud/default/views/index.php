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
use <?= $generator->indexWidgetType === 'grid' ? "yz\\admin\\grid\\GridView" : "yii\\widgets\\ListView" ?>;
use yz\admin\widgets\ActionButtons;

/**
 * @var yii\web\View $this
 * @var yii\data\ActiveDataProvider $dataProvider
<?= !empty($generator->searchModelClass) ? " * @var " . ltrim($generator->searchModelClass, '\\') . " \$searchModel\n" : '' ?>
 * @var array $columns
 */

$this->title = <?= $generator->modelClass ?>::modelTitlePlural();
$this->params['breadcrumbs'][] = $this->title;
$this->params['header'] = $this->title;
?>
<?= "<?php" ?> $box = Box::begin(['cssClass' => '<?= Inflector::camel2id(StringHelper::basename($generator->modelClass)) ?>-index box-primary']) ?>
    <div class="text-right">
        <?= "<?php" ?> echo ActionButtons::widget([
            'order' => [/*['search'],*/ ['export', 'create', 'delete', 'return']],
            'gridId' => '<?= Inflector::camel2id(StringHelper::basename($generator->modelClass)) ?>-grid',
            'searchModel' => $searchModel,
            'modelClass' => '<?= $generator->modelClass ?>',
        ]) ?>
    </div>

<?php if(!empty($generator->searchModelClass)): ?>
<?= "    <?php " ?>//echo $this->render('_search', ['model' => $searchModel]); ?>
<?php endif; ?>

<?php if ($generator->indexWidgetType === 'grid'): ?>
    <?= "<?= " ?>GridView::widget([
        'id' => '<?= Inflector::camel2id(StringHelper::basename($generator->modelClass)) ?>-grid',
        'dataProvider' => $dataProvider,
        //'filterModel' => $searchModel,
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
