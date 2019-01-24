<?php
// Create the file src/Mailer/Preview/UserMailPreview.php
namespace App\Mailer\Preview;

use DebugKit\Mailer\MailPreview;

class MailMailPreview extends MailPreview
{
    public function contactUs()
    {
        $this->loadModel("Users");
        $user = $this->Users->find()->first();
                
        return $this->getMailer("Mail")
            ->contactUs($user);
    }
}

