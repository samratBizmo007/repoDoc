<?php
namespace App\Controller\Component;

use Cake\Controller\Component;
use Firebase;
use Firebase\FirebaseLib;
use Cake\Core\Configure;

/**
 * Firebase component
 */
class FirebaseComponent extends Component {

    protected $_defaultConfig = [];
    protected $firebase = null;

    /**
     * Modeled after base64 web-safe chars, but ordered by ASCII.
     *
     * @var string
     */
    const PUSH_CHARS = '-0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ_abcdefghijklmnopqrstuvwxyz';
    
    /**
     * Timestamp of last push, used to prevent local collisions if you push twice in one ms.
     *
     * @var int
     */
    private static $lastPushTime = 0;
    
    /**
     * We generate 72-bits of randomness which get turned into 12 characters and appended to the
     * timestamp to prevent collisions with other clients.  We store the last characters we
     * generated because in the event of a collision, we'll use those same characters except
     * "incremented" by one.
     *
     * @var array
     */
    private static $lastRandChars = [];
    
    public function initialize(array $config) {
        parent::initialize($config);
        
        $defaultToken = Configure::read('defaultToken');
        $defaultUrl   = Configure::read('defaultUrl');
        
        $this->firebase = new FirebaseLib($defaultUrl, $defaultToken);
    }
    
    public function get($path) {
        $data = $this->firebase->get($path);
        if(!empty($data) && $data != 'null' && $data != null) {
            return json_decode($data, true);
        }
        return [];
    }

    public function set($path, $data) {
        $dd = $this->firebase->set($path, $data);
    }
    
    public function push($path, $data) {
        return $this->firebase->push($path, $data);
    }

    public function delete($path) {
        return $this->firebase->delete($path);
    }
    
    public function update($path, $data) {
        return $this->firebase->update($path, $data);
    }
    
    public function sendFCMMessage($registrationIds, $text = '', $name = '', $extraParam = [], $sound = '', $device_type = 1, $chatType = 0) {
    
        $mySound = 'commonMsg.mp3'; 
        
        if($chatType == 1) {
            $mySound = 'silence.mp3';
        }
        
        if($sound == '3') {
            $mySound = 'veryurgentMsg.mp3';
        }elseif($sound == '4') {
            $mySound = 'urgentMsg.mp3';
        }
        
        #prep the bundle
        $msg = [
            'body' 	=> $text,
            'title'	=> $name,
            'icon'	=> 'myicon',/*Default Icon*/
            'sound' => $mySound, /*Default sound*/
        ];
           
        if(!empty($extraParam)) {
            $msg['extra'] = $extraParam;
        }
        
        // IOS
        if($device_type == 1) {
            $fields = [
                'to'		=> $registrationIds,
                'notification'	=> $msg
            ];
        } else { //Android
            $fields = [
                'to'		=> $registrationIds,
                'data'	=> $msg
            ];
        }
    
        $headers = [
            'Authorization: key=' . Configure::read('serverkey'),
            'Content-Type: application/json'
        ];
    
        #Send Reponse To FireBase Server
        $ch = curl_init();
        curl_setopt( $ch,CURLOPT_URL, Configure::read('FCMUrl') );
        curl_setopt( $ch,CURLOPT_POST, true );
        curl_setopt( $ch,CURLOPT_HTTPHEADER, $headers );
        curl_setopt( $ch,CURLOPT_RETURNTRANSFER, true );
        curl_setopt( $ch,CURLOPT_SSL_VERIFYPEER, false );
        curl_setopt( $ch,CURLOPT_POSTFIELDS, json_encode( $fields ) );
        $result = curl_exec($ch );
        curl_close( $ch );
    
        #Echo Result Of FireBase Server
        //echo $result;
    }
    
    /**
     * @return string
     */
    public function generateMessageToken()
    {
        $now = (int) microtime(true) * 1000;
        $isDuplicateTime = ($now === static::$lastPushTime);
        static::$lastPushTime = $now;

        $timeStampChars = new \SplFixedArray(8);
        for ($i = 7; $i >= 0; $i--) {
            $timeStampChars[$i] = substr(self::PUSH_CHARS, $now % 64, 1);
            // NOTE: Can't use << here because javascript will convert to int and lose the upper bits.
            $now = (int) floor($now / 64);
        }

        $this->assert($now === 0, 'We should have converted the entire timestamp.');

        $id = implode('', $timeStampChars->toArray());

        if (!$isDuplicateTime) {
            for ($i = 0; $i < 12; $i++) {
                $lastRandChars[$i] = floor(rand(0, 64));
            }
        } else {
            // If the timestamp hasn't changed since last push, use the same random number, except incremented by 1.
            for ($i = 11; $i >= 0 && static::$lastRandChars[$i] === 63; $i--) {
                static::$lastRandChars[$i] = 0;
            }
            static::$lastRandChars[$i]++;
        }
        for ($i = 0; $i < 12; $i++) {
            $id .= substr(self::PUSH_CHARS, $lastRandChars[$i], 1);
        }

        $this->assert(strlen($id) === 20, 'Length should be 20.');

        return $id;
    }

    /**
     * @param bool   $condition
     * @param string $message
     */
    public function assert($condition, $message = '')
    {
        if ($condition !== true) {
             //throw new \RuntimeException($message);
            return $message;
        }
    }
}
