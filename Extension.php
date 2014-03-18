<?php

namespace yz\gii;


/**
 * Class Extension
 */
class Extension extends \yii\base\Extension
{
    public static function bootstrap()
    {
        parent::bootstrap();

        \Yii::$app->i18n->translations['yz/gii'] = [
            'class' => 'yii\i18n\PhpMessageSource',
            'basePath' => '@yz/gii/messages',
            'sourceLanguage' => 'en-US',
        ];
    }

} 