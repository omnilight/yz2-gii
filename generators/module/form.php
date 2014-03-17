<?php
/**
 * @var yii\web\View $this
 * @var yii\widgets\ActiveForm $form
 * @var yii\gii\generators\module\Generator $generator
 */
?>
<div class="module-form">
    <?php
    echo $form->field($generator, 'moduleBasePath');
    echo $form->field($generator, 'moduleClass');
    echo $form->field($generator, 'moduleID');
    echo $form->field($generator, 't9nCategory');
    echo $form->field($generator, 'moduleName');
    echo $form->field($generator, 'moduleDescription');
    echo $form->field($generator, 'moduleIcon');
    ?>
</div>
