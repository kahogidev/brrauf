<?php

namespace frontend\widgets;

use common\models\Manager;
use Yii;

class Managers extends \yii\bootstrap5\Widget
{
    public function run()
    {
        $models = Manager::find()
            ->where(['status' => 1])
            ->orderBy(['sort_order' => SORT_ASC, 'id' => SORT_ASC])
            ->limit(10)
            ->all();

        if (empty($models)) {
            return '';
        }

        return $this->render('managers', [
            'models' => $models,
        ]);
    }
}