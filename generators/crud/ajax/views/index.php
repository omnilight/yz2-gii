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
use yz\icons\Icons;

/**
 * @var yii\web\View $this
 * @var yii\data\ActiveDataProvider $dataProvider
<?= !empty($generator->searchModelClass) ? " * @var " . ltrim($generator->searchModelClass, '\\') . " \$searchModel\n" : '' ?>
 * @var array $columns
 */
?>
<div class="text-right">
    <?= "<?php" ?> echo ActionButtons::widget([
        'order' => [['create-ajax']],
        'gridId' => '<?= Inflector::camel2id(StringHelper::basename($generator->modelClass)) ?>-grid',
        'searchModel' => $searchModel,
        'modelClass' => '<?= $generator->modelClass ?>',
    ]) ?>
</div>

<?php if ($generator->indexWidgetType === 'grid'): ?>
    <?= "<?= " ?>GridView::widget([
        'id' => '<?= Inflector::camel2id(StringHelper::basename($generator->modelClass)) ?>-grid',
        'dataProvider' => $dataProvider,
        'columns' => array_merge([
            ['class' => 'yii\grid\CheckboxColumn', 'name' => $searchModel->formName().'-selection', 'header' => Icons::i('trash')],
        ], $columns, [
            [
                'class' => 'yz\admin\widgets\ActionColumn',
                'template' => '{update-ajax}',
                'buttons' => [
                    'update-ajax' => function ($url, $model, $key) {
                        return Html::a(Icons::i('pencil-square-o fa-lg'), ['update', 'id' => $key], [
                            'title' => Yii::t('admin/t', 'Update'),
                            'class' => 'btn btn-success btn-sm js-btn-ajax-crud-update'
                        ]);
                    }
                ]
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
