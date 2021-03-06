<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace yz\gii\generators\module;

use yii\gii\CodeFile;
use Yii;
use yii\helpers\Html;
use yii\helpers\StringHelper;

/**
 * This generator will generate the skeleton code needed by a module.
 *
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class Generator extends \yii\gii\Generator
{
    public $moduleBasePath;
    public $moduleClass;
    public $moduleID;

    public $t9nCategory;
    public $moduleName;
    public $moduleDescription;
    public $moduleIcon;

    /**
     * @inheritdoc
     */
    public function getName()
    {
        return 'Yz Module Generator';
    }

    /**
     * @inheritdoc
     */
    public function getDescription()
    {
        return 'This generator helps you to generate the skeleton code needed by a Yz module.';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return array_merge(parent::rules(), [
            [['moduleID', 'moduleClass', 'moduleName', 'moduleDescription', 'moduleIcon', 'moduleBasePath'], 'filter', 'filter' => 'trim'],
            [['moduleID', 'moduleClass', 't9nCategory', 'moduleName', 'moduleDescription'], 'required'],
            [['moduleID'], 'match', 'pattern' => '/^[\w\\-]+$/', 'message' => 'Only word characters and dashes are allowed.'],
            [['moduleClass'], 'match', 'pattern' => '/^[\w\\\\]*$/', 'message' => 'Only word characters and backslashes are allowed.'],
            [['moduleClass'], 'validateModuleClass'],
        ]);
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'moduleBasePath' => 'Base Path',
            'moduleID' => 'Module ID',
            'moduleClass' => 'Module Class',
            't9nCategory' => 'Translation category',
        ];
    }

    /**
     * @inheritdoc
     */
    public function hints()
    {
        return [
            'moduleBasePath' => 'Base path to the module, e.g., <code>vendor/company/moduleName</code>',
            'moduleID' => 'This refers to the ID of the module, e.g., <code>admin</code>.',
            'moduleClass' => 'This is the fully qualified class name of the module, e.g., <code>yz/admin/Module</code>.',
            't9nCategory' => 'This is the default translation category for this module',
            'moduleName' => 'This is the name of the module that is visible in the administration panel',
            'moduleDescription' => 'This is the description of the module',
            'moduleIcon' => 'This is the icon of the module',
        ];
    }

    /**
     * @inheritdoc
     */
    public function successMessage()
    {
        if (Yii::$app->hasModule($this->moduleID)) {
            $link = Html::a('try it now', Yii::$app->getUrlManager()->createUrl($this->moduleID), ['target' => '_blank']);
            return "The module has been generated successfully. You may $link.";
        }

        $output = <<<EOD
<p>The module has been generated successfully.</p>
<p>To access the module, you need to add this to your application configuration:</p>
EOD;
        $code = <<<EOD
<?php
	......
	'modules' => [
		'{$this->moduleID}' => [
			'class' => '{$this->moduleClass}',
		],
	],
	......
EOD;

        return $output . '<pre>' . highlight_string($code, true) . '</pre>';
    }

    /**
     * @inheritdoc
     */
    public function requiredTemplates()
    {
        return ['module.php', 'controller.php', 'view.php'];
    }

    /**
     * @inheritdoc
     */
    public function generate()
    {
        $files = [];
        $modulePath = $this->getModulePath();
        $files[] = new CodeFile(
            $modulePath . '/' . StringHelper::basename($this->moduleClass) . '.php',
            $this->render("module.php")
        );
        $files[] = new CodeFile(
            $modulePath . '/controllers/frontend/DefaultController.php',
            $this->render("controller.php")
        );
        $files[] = new CodeFile(
            $modulePath . '/views/frontend/default/index.php',
            $this->render("view.php")
        );
        $files[] = new CodeFile(
            $modulePath . '/messages/config.php',
            $this->render("messages.php")
        );

        return $files;
    }

    /**
     * Validates [[moduleClass]] to make sure it is a fully qualified class name.
     */
    public function validateModuleClass()
    {
        if ($this->moduleBasePath == '') {
            if (strpos($this->moduleClass, '\\') === false || Yii::getAlias('@' . str_replace('\\', '/', $this->moduleClass), false) === false) {
                $this->addError('moduleClass', 'Module class must be properly namespaced.');
            }
        } else {
            if (strpos($this->moduleClass, '\\') === false || Yii::getAlias('@' . $this->moduleBasePath . '/' . str_replace('\\', '/', $this->moduleClass), false) === false) {
                $this->addError('moduleClass', 'Module class must be properly namespaced.');
            }
        }
        if (substr($this->moduleClass, -1, 1) == '\\') {
            $this->addError('moduleClass', 'Module class name must not be empty. Please enter a fully qualified class name. e.g. "app\\modules\\admin\\Module".');
        }
    }

    /**
     * @return boolean the directory that contains the module class
     */
    public function getModulePath()
    {
        return Yii::getAlias('@' . $this->moduleBasePath . '/' . str_replace('\\', '/', substr($this->moduleClass, 0, strrpos($this->moduleClass, '\\'))));
    }

    /**
     * @return string the controller namespace of the module.
     */
    public function getControllerNamespace()
    {
        return substr($this->moduleClass, 0, strrpos($this->moduleClass, '\\')) . '\controllers';
    }
}
