<?php

namespace frontend\widgets;

use common\models\Partner;
use Yii;

class Sponsors extends \yii\bootstrap5\Widget
{
    public function run()
    {
        $models = Partner::find()
            ->where(['status' => 1])
            ->orderBy(['sort_order' => SORT_ASC, 'id' => SORT_ASC])
            ->all();

        if (empty($models)) {
            return '';
        }

        return $this->render('sponsors', [
            'models' => $models,
        ]);
    }
}