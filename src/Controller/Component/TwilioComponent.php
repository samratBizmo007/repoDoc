<?php
namespace App\Controller\Component;

use Cake\Controller\Component;
use Cake\Core\Configure;
use Twilio\Rest\Client;
/**
 * Twilio component
 */
class TwilioComponent extends Component {

    protected $client = null;

    public function initialize(array $config) {
        parent::initialize($config);
        
        $sid = Configure::read('Twilio.sid');
        $token = Configure::read('Twilio.token');
        
        $this->client = new Client($sid, $token);
    }
    
    /**
     * Send sms
     *
     * @param string $to
     * @param string $body
     * @param string $from
     * @return mixed
     */
    public function sendSms($to, $body) 
    {
        // Use the client to do fun stuff like send text messages!
        return $this->client->messages->create($to,[ 
            "from"  => Configure::read('Twilio.from'), // A Twilio phone number you purchased at twilio.com/console
            "body"  => $body, // the body of the text message you'd like to send
        ]);
        return true;
    }
    
}
