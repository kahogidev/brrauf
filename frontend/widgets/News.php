<?php

namespace frontend\widgets;

use common\models\News as NewsModel;
use Yii;

class News extends \yii\bootstrap5\Widget
{
    public function run()
    {
        $models = NewsModel::find()
            ->where(['status' => 1])
            ->orderBy(['published_date' => SORT_DESC, 'id' => SORT_DESC])
            ->limit(3)
            ->all();

        if (empty($models)) {
            return '';
        }

        return $this->render('news', [
            'models' => $models,
        ]);
    }
}