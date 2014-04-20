<?php
/**
 * This is the template for generating a module class file.
 *
 * @var yii\web\View $this
 * @var yz\gii\generators\module\Generator $generator
 */
$className = $generator->moduleClass;
$pos = strrpos($className, '\\');
$ns = ltrim(substr($className, 0, $pos), '\\');
$className = substr($className, $pos + 1);
$t9nCategory = $generator->t9nCategory;

echo "<?php\n";
?>

namespace <?= $ns ?>;

/**
 * Class Module
 * @package <?= $ns ."\n" ?>
 */
class <?= $className ?> extends \yz\Module
{
	/**
	 * @inheritdoc
	 */
	public function getVersion()
	{
		return '0.1';
	}

	/**
     * @inheritdoc
     */
	public function getName()
	{
		return \Yii::t('<?= $t9nCategory ?>', '<?= $generator->moduleName; ?>');
	}

	/**
     * @inheritdoc
     */
	public function getDescription()
	{
		return \Yii::t('<?= $t9nCategory ?>', '<?= $generator->moduleDescription; ?>');
	}

	/**
     * @inheritdoc
     */
	public function getIcon()
	{
		return <?= $generator->moduleIcon?'\yz\icons\Icons::o(\''.$generator->moduleIcon.'\')':'null'; ?>;
	}

	public function init()
	{
		parent::init();

		// custom initialization code goes here
	}
}
