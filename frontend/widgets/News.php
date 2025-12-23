<?php

namespace frontend\widgets;

use yii\base\Widget;

class News extends Widget
{
    public function run()
    {
        return $this->render('news');
    }
}