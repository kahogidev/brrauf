<?php

namespace frontend\widgets;

use common\models\Contact as ContactModel;
use Yii;

class Contacts extends \yii\bootstrap5\Widget
{
    public function run()
    {
        // Birinchi yozuvni olish yoki oxirgi qo'shilgan
        $model = ContactModel::find()
            ->orderBy(['id' => SORT_DESC])
            ->one();

        if (empty($model)) {
            return '';
        }

        return $this->render('contacts', [
            'model' => $model,
        ]);
    }
}