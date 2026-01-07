<?php

namespace frontend\widgets;

use common\models\ProductionVolume;
use Yii;

class Productions extends \yii\bootstrap5\Widget
{
    public function run()
    {
        $models = ProductionVolume::find()

            ->limit(10)
            ->all();

        if (empty($models)) {
            return '';
        }

        return $this->render('production', [
            'models' => $models,
        ]);
    }
}