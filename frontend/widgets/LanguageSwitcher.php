<?php
namespace frontend\widgets;

use yii\base\Widget;
use yii\helpers\Html;
use Yii;

class LanguageSwitcher extends Widget
{
    public function run()
    {
        $languages = Yii::$app->params['languages'];
        $current = Yii::$app->language;
        $items = [];

        foreach ($languages as $code => $name) {
            $url = array_merge(
                [Yii::$app->controller->route],
                Yii::$app->request->get(),
                ['language' => $code]
            );

            $linkClass = 'dropdown-item nav-link';
            if ($code === substr($current, 0, 2)) {

            }

            $link = Html::a($name, $url, ['class' => $linkClass, 'style' => 'color:black;']);
            $items[] = Html::tag('li', $link, ['class' => 'nav-item', 'style' => 'color:black;']);
        }

        return implode('', $items);
    }
}