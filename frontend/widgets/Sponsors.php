<?php

namespace frontend\widgets;

use yii\base\Widget;

class Sponsors extends Widget
{
    public function run()
    {
        return $this->render('sponsors');
    }
}