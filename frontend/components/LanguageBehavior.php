<?php

namespace frontend\components;

use yii\base\Behavior;
use yii\web\Controller;
use Yii;

class LanguageBehavior extends Behavior
{
    public function events()
    {
        return [
            Controller::EVENT_BEFORE_ACTION => 'beforeAction',
        ];
    }

    public function beforeAction($event)
    {
        $language = Yii::$app->request->get('language');
        $supportedLanguages = ['uz', 'ru'];

        if ($language && in_array($language, $supportedLanguages)) {
            Yii::$app->language = $language;
            Yii::$app->session->set('language', $language);
        } elseif (Yii::$app->session->has('language')) {
            Yii::$app->language = Yii::$app->session->get('language');
        }

        return true;
    }
}
