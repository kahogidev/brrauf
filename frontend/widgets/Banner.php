<?php

namespace frontend\widgets;

class Banner extends \yii\base\Widget
{
    public function run()
    {
        return $this->render('banner');
    }
}