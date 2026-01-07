<?php
namespace frontend\widgets;

use common\models\Contact;
use yii\base\Widget;

class Footer extends Widget
{
    public function run()
    {
        $contact = Contact::getSettings();

        return $this->render('footer', [
            'contact' => $contact,
        ]);
    }
}