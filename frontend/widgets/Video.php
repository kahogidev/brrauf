<?php

namespace frontend\widgets;

use yii\base\Widget;

class Video extends Widget
{
    public function run()
    {
        return $this->render('video');
    }
}