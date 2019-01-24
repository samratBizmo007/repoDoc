<?php
namespace App\Mailer;

use Cake\Mailer\Mailer;
use Cake\Core\Configure;

/**
 * Mail mailer.
 */
class MailMailer extends Mailer
{

    /**
     * Mailer's name.
     *
     * @var string
     */
    static public $name = 'Mail';

    /**
     * Mailer's name.
     *
     * @var string
     */
    public function contactUs($data)
    {    
        return $this
            ->to(Configure::read('ADMIN_EMAIL'))
            ->emailFormat('both')
            ->template('contact_us')
            ->subject('Contact Us - '. $data['name'])
            ->set(['data' => $data]);
    }
}
