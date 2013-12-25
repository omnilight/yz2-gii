<?php
/**
 * This is the template for generating the model class of a specified table.
 *
 * @var yii\web\View $this
 * @var yz\gii\generators\model\Generator $generator
 * @var string $tableName full table name
 * @var string $tableAlias alias of the table
 * @var string $className class name
 * @var string $t9nCategory translation category
 * @var boolean $prepareForBackend is prepare to backend
 * @var yii\db\TableSchema $tableSchema
 * @var string[] $labels list of attribute labels (name=>label)
 * @var string[] $rules list of validation rules
 * @var array $relations list of relations (name=>relation declaration)
 */

use yii\helpers\Inflector;

$implement = $generator->getImplementInterfaces()?
	' implements '.implode(', ', $generator->getImplementInterfaces()):'';

echo "<?php\n";
?>

namespace <?= $generator->ns ?>;

<?php foreach ($generator->getUsedClasses() as $useClass): ?>
use <?= ltrim($useClass, '\\') . ";\n"; ?>
<?php endforeach; ?>

/**
 * This is the model class for table "<?= $tableName ?>".
 *
<?php foreach ($tableSchema->columns as $column): ?>
 * @property <?= "{$column->phpType} \${$column->name}\n" ?>
<?php endforeach; ?>
<?php if (!empty($relations)): ?>
 *
<?php foreach ($relations as $name => $relation): ?>
 * @property <?= $relation[1] . ($relation[2] ? '[]' : '') . ' $' . lcfirst($name) . "\n" ?>
<?php endforeach; ?>
<?php endif; ?>
 */
class <?= $className ?> extends <?= '\\' . ltrim($generator->baseClass, '\\') . $implement . "\n" ?>
{
	/**
	 * @inheritdoc
	 */
	public static function tableName()
	{
		return '<?= $tableAlias ?>';
	}

<?php if($generator->prepareForBackend): ?>
	/**
     * Returns model title, ex.: 'Person', 'Book'
     * @return string
     */
    public static function modelTitle()
    {
        return \Yii::t('<?= $t9nCategory; ?>', '<?= Inflector::camel2words($className) ?>');
    }

    /**
     * Returns plural form of the model title, ex.: 'Persons', 'Books'
     * @return string
     */
    public static function modelTitlePlural()
    {
        return \Yii::t('<?= $t9nCategory; ?>', '<?= Inflector::camel2words(Inflector::pluralize($className)) ?>');
    }
<?php endif; ?>

	/**
	 * @inheritdoc
	 */
	public function rules()
	{
		return [<?= "\n\t\t\t" . implode(",\n\t\t\t", $rules) . "\n\t\t" ?>];
	}

	/**
	 * @inheritdoc
	 */
	public function attributeLabels()
	{
		return [
<?php foreach ($labels as $name => $label): ?>
			<?= "'$name' => \Yii::t('".$t9nCategory."','" . addslashes($label) . "'),\n" ?>
<?php endforeach; ?>
<?php foreach ($relations as $name => $relation): ?>
			<?= "'".lcfirst($name)."' => \Yii::t('".$t9nCategory."','" . addslashes(Inflector::camel2words($name)) . "'),\n" ?>
<?php endforeach; ?>
		];
	}
<?php foreach ($relations as $name => $relation): ?>

	/**
	 * @return \yii\db\ActiveRelation
	 */
	public function get<?= $name ?>()
	{
		<?= $relation[0] . "\n" ?>
	}
<?php endforeach; ?>
}
