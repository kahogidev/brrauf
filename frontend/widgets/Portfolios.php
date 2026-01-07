<?php

namespace frontend\widgets;

use common\models\Portfolio;
use Yii;

class Portfolios extends \yii\bootstrap5\Widget
{
    public function run()
    {
        $models = Portfolio::find()
            ->where(['status' => 1])
            ->orderBy(['sort_order' => SORT_ASC, 'id' => SORT_DESC])
            ->all();

        if (empty($models)) {
            return '';
        }

        return $this->render('portfolio', [
            'models' => $models,
        ]);
    }
}