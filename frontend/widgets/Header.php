<?php
namespace frontend\widgets;

use common\models\Contact;
use yii\base\Widget;

class Header extends Widget
{
    public function run()
    {
        // Settings ni olish (faqat 1 ta yozuv)
        $contact = Contact::getSettings();

        return $this->render('header', [
            'contact' => $contact,
        ]);
    }
}