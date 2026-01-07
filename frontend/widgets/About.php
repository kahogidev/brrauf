<?php

namespace frontend\widgets;
use common\models\AboutCompany;
class About extends \yii\bootstrap5\Widget
{
    public function run()
    {
        $model = AboutCompany::find()->where(['status' => 1])->one();
        return $this->render('about', ['model' => $model]);
    }
}