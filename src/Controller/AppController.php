<?php
/**
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link      http://cakephp.org CakePHP(tm) Project
 * @since     0.2.9
 * @license   http://www.opensource.org/licenses/mit-license.php MIT License
 */
namespace App\Controller;

use Cake\Controller\Controller;
use Cake\Event\Event;
use Cake\Core\Configure;

use Cake\Mailer\Email;
use Cake\Network\Exception\SocketException;


/**
 * Application Controller
 *
 * Add your application-wide methods in the class below, your controllers
 * will inherit them.
 *
 * @link http://book.cakephp.org/3.0/en/controllers.html#the-app-controller
 */
class AppController extends Controller
{

    /**
     * Initialization hook method.
     *
     * Use this method to add common initialization code like loading components.
     *
     * e.g. `$this->loadComponent('Security');`
     *
     * @return void
     */
    public function initialize()
    {
        parent::initialize();
        
        $this->loadComponent('CSV');
        $this->loadComponent('RequestHandler');
        $this->loadComponent('Flash');
        $this->loadComponent('Auth', [
            'authenticate' => [
                'Form' => [
                    'fields' => ['username' => 'email']
                ]
            ],
            'loginRedirect' => [
                'controller' => 'Users',
                'action' => 'index'
            ],
            'logoutRedirect' => [
                'controller' => 'Users',
                'action' => 'login'
            ]
        ]);

        /*
         * Enable the following components for recommended CakePHP security settings.
         * see http://book.cakephp.org/3.0/en/controllers/components/security.html
         */
        //$this->loadComponent('Security');
        //$this->loadComponent('Csrf');

        $current_user = $this->Auth->user();
        if(!empty($this->Auth->user('photo'))){
            $current_user['photo_url'] = Configure::read('UPLOAD_THUMB_IMAGE_URL').$this->Auth->user('photo');
        } else {
            $current_user['photo_url'] = Configure::read('DEFAULT_USER_IMAGE_URL');
        }
        $this->current_user = $current_user;
        $this->set('current_user',$this->current_user);
        $this->set('theme',Configure::read('Theme'));
    }
    
    public function beforeFilter(Event $event)
    {
        $this->Auth->allow(['privacyPolicy']);
    }
    
    function date_sort($a, $b) {
        return strtotime($a) - strtotime($b);
    }
    
    /**
     * Before render callback.
     *
     * @param \Cake\Event\Event $event The beforeRender event.
     * @return \Cake\Network\Response|null|void
     */
    public function beforeRender(Event $event)
    {
        if (!array_key_exists('_serialize', $this->viewVars) &&
            in_array($this->response->type(), ['application/json'])
        ) {
            $this->set('_serialize', true);
        }
    }

    public function _getKey() {
        mt_srand((double) microtime() * 10000); //optional for php 4.2.0 and up.
        $charid = strtoupper(md5(uniqid(rand(), true)));
        $uuid = substr($charid, 0, 8)
                . substr($charid, 8, 4)
                . substr($charid, 12, 4)
                . substr($charid, 16, 4)
                . substr($charid, 20, 12)
                . time();

        return strtolower($uuid);
    }

    public function _generateString($limit = 8) {
        $alphabet = "abcdefghijklmnopqrstuwxyzABCDEFGHIJKLMNOPQRSTUWXYZ0123456789";
        $pass = array(); //remember to declare $pass as an array
        $alphaLength = strlen($alphabet) - 1; //put the length -1 in cache
        for ($i = 0; $i < $limit; $i++) {
            $n = rand(0, $alphaLength);
            $pass[] = $alphabet[$n];
        }

        return $randomString = implode($pass);
    }
    
    public function sendEmail($template,$data){
        $email = new Email('default');
        $email->from(Configure::read('ADMIN_EMAIL'), Configure::read('Theme.title'))
        ->transport('default')
        ->to($data['email'])
        ->emailFormat('html')
        ->subject($data['subject'])
        ->template($template)
        ->viewVars(['data' => $data]);
    
        try{
            if($email->send()){
                return true;
            } else {
                return false;
            }
    
        } catch(SocketException $e){
            return false;
        }
    }
    
    public function _generateRandomPassword() {
    
        $alphabet = "abcdefghijklmnopqrstuwxyzABCDEFGHIJKLMNOPQRSTUWXYZ0123456789";
        $pass = array(); //remember to declare $pass as an array
        $alphaLength = strlen($alphabet) - 1; //put the length -1 in cache
        for ($i = 0; $i < 8; $i++) {
            $n = rand(0, $alphaLength);
            $pass[] = $alphabet[$n];
        }
    
        return $randomString = implode($pass);
    }
    
    function fGenerateRandomPassword($length,$useUpperCase = true,$useLowerCase = true,$useNumbers = true,$useSpecialChars = true)
    {
        //define strings for each category
        $upperCase = "ABCDEFGHJKPQRSTUXYZ";
        $lowerCase = "abcdefghjkopqrstuxyz";
        $numbers = "23456789";
        $specialChars = "!@#$%";
    
        //adds characters from category if selected
        $toUse = "";
        $countToUse = 0;
        if($useUpperCase == "true") { $toUse .= $upperCase; $countToUse++; }
        if($useLowerCase == "true") { $toUse .= $lowerCase; $countToUse++; }
        if($useNumbers == "true") { $toUse .= $numbers; $countToUse++; }
        if($useSpecialChars == "true") { $toUse .= $specialChars;  $countToUse++; }
    
        if($length < $countToUse) //if number entered is less that the count of selected character sets.
        {
            return "<i--><b>'number of characters'</b> can not be less than selection of characters to use.";
        }
    
        //no errors, generate the password
        $password = "";
        for ($i = 0; $i < $length;$i++)
        {
            $password .= $toUse[(rand() % strlen($toUse))];
        }
    
        //define the array to return
        $passwordArray[0] = $password;
        $passwordArray[1] = $upperCase;
        $passwordArray[2] = $lowerCase;
        $passwordArray[3] = $numbers;
        $passwordArray[4] = $specialChars;
    
        //check that the password contains at LEAST 1 character from each selected category
        $hasUpper = strpbrk($passwordArray[0],$passwordArray[1]);
        $hasLower = strpbrk($passwordArray[0],$passwordArray[2]);
        $hasNumber = strpbrk($passwordArray[0],$passwordArray[3]);
        $hasSpecChar = strpbrk($passwordArray[0],$passwordArray[4]);
        if(($useUpperCase == "true" && $hasUpper == "") || ($useLowerCase == "true" && $hasLower == "") || ($useNumbers == "true" && $hasNumber == "") || ($useSpecialChars == "true" && $hasSpecChar == ""))
        {
            return $this->fGenerateRandomPassword(8);
        } else {
            return $password = $passwordArray[0];
        }
    }
        
    // Encrypt Function
    function encrypt($encrypt){
        $key = Configure::read('ACCESS_KEY');
        $iv = mcrypt_create_iv(mcrypt_get_iv_size(MCRYPT_RIJNDAEL_128, MCRYPT_MODE_ECB), MCRYPT_RAND);
        $passcrypt = mcrypt_encrypt(MCRYPT_RIJNDAEL_128, $key, $encrypt, MCRYPT_MODE_CBC, $iv);
        $encoded = $this->base64url_encode($passcrypt).'|'.$this->base64url_encode($iv);
        return $encoded;
    }
    
    // Decrypt Function
    function decrypt($decrypt){
        $key = Configure::read('ACCESS_KEY');
        $decrypt = explode('|', $decrypt.'|');
        $decoded = $this->base64url_decode($decrypt[0]);
        $iv = $this->base64url_decode($decrypt[1]);
        if(!empty($decoded) && !empty($iv)){
            $decrypted = trim(mcrypt_decrypt(MCRYPT_RIJNDAEL_128, $key, $decoded, MCRYPT_MODE_CBC, $iv));
            return $decrypted;
        } else {
            return false;
        }
    }
    
    function base64url_encode($s) {
        return str_replace(array('+', '/'), array('-', '_'), base64_encode($s));
    }
    
    function base64url_decode($s) {
        return base64_decode(str_replace(array('-', '_'), array('+', '/'), $s));
    }
    
    function accessAdminUrl() {
        if($this->Auth->user()['role_id'] == 3) {
            return $this->redirect(['controller' => "Dashboard", 'action' => "index"]);
        }elseif($this->Auth->user()['role_id'] == 4) {
            return $this->redirect(['controller' => "Patients", 'action' => "index"]);
        }elseif($this->Auth->user()['role_id'] == 5) {
            return $this->redirect(['controller' => "EmployeesSchedules", 'action' => "index"]);
        }
    }
    
    function accessUrl() {
        if($this->Auth->user()['role_id'] == 4) {
            return $this->redirect(['controller' => "Patients", 'action' => "index"]);
        }
        if($this->Auth->user()['role_id'] == 5) {
            return $this->redirect(['controller' => "EmployeesSchedules", 'action' => "index"]);
        }
    }
    
    function accessUrlSubAdmin() {
        if($this->Auth->user()['role_id'] == 5) {
            $this->redirect("/EmployeesSchedules");
        }
    }
    
    function accessUrlOffice() {
        if($this->Auth->user()['role_id'] == 4) {
                $this->redirect("/patients");
        }
    }
}
