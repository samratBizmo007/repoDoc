<?php
namespace App\Shell\Task;

use Cake\Console\Shell;
use Cake\Controller\ComponentRegistry;
use App\Controller\Component\FirebaseComponent;
use Cake\Utility\Hash;
use App\Controller\Component\TwilioComponent;

class UrgentMessageTask extends Shell
{
    public function initialize()
    {
        parent::initialize();
        $this->loadModel('Messages');
        $this->Firebase = new FirebaseComponent(new ComponentRegistry());
        $this->Twilio = new TwilioComponent(new ComponentRegistry());
    }
    
    public function sendMessageNotification()
    {
        $messageLists = $this->Messages->sendMessageForEmergency(4);
        
        if(!empty($messageLists)) {
            foreach ($messageLists as $key => $val) {
                if(empty($val->employee->device_token) && empty($val->employee->pager_number)) {
                    $val->message_count = 4;
                    $result = $this->Messages->save($val);
                    continue;
                }elseif(!empty($val->employee->device_token) || !empty($val->employee->pager_number)) {
                    if($val->chat_type == 0 && empty($val->patient_id)) {
                        $firebaseMessage = $this->Firebase->get('Status/'.$val->sender_id.'/'.$val->receiver_id.'/'.$val->message_id);
                        
                        if(empty($firebaseMessage)) {
                            $val->message_count = 4;
                            $result = $this->Messages->save($val);
                            if(!empty($val->employee->pager_number)) {
                                $response = $this->Twilio->sendSms($val->employee->pager_number, $val->message);
                                if(!empty($response)) {
                                    $this->Messages->delete($val);
                                }
                            }
                            //continue;
                        }
                        if(!empty($firebaseMessage) && $firebaseMessage['messageReceipt'] < 3) {
                        if($val->message_count <= 1) {
                            if(!empty($val->employee->device_token)) {
                                $this->Firebase->sendFCMMessage($val->employee->device_token, $val->message, $val->doctor_name, [], '', $val->employee->device_type);
                                $val->message_count = $val->message_count + 1;
                                $val->next_message_time = time() + 30;
                                $this->Messages->save($val);
                            } else {
                            	if(!empty($val->employee->pager_number)) {
                                    $response = $this->Twilio->sendSms($val->employee->pager_number, $val->message);
                                    if(!empty($response)) {
                                        $this->Messages->delete($val);
                                    }
                                }
                            }
                        } elseif($val->message_count <= 2 && time() == $val->next_message_time) {
                            if(!empty($val->employee->device_token)) {
                                $this->Firebase->sendFCMMessage($val->employee->device_token, $val->message, $val->doctor_name, [], '', $val->employee->device_type);
                                $val->message_count = $val->message_count + 1;
                                $val->next_message_time = time() + 30;
                                $this->Messages->save($val);
                            } else {
                                if(!empty($val->employee->pager_number)) {
                                    $response = $this->Twilio->sendSms($val->employee->pager_number, $val->message);
                                    if(!empty($response)) {
                                        $this->Messages->delete($val);
                                    }
                                }
                            }
                        }elseif($val->message_count <= 3 && time() == $val->next_message_time){
                            if(!empty($val->employee->device_token)) {
                                $this->Firebase->sendFCMMessage($val->employee->device_token, $val->message, $val->doctor_name, [], '', $val->employee->device_type);
                                $val->message_count = $val->message_count + 1;
                                //$val->next_message_time = date("Y-m-d H:i:s", time() + 30);
                                $this->Messages->save($val);
                            } else {
                                if(!empty($val->employee->pager_number)) {
                                    $response = $this->Twilio->sendSms($val->employee->pager_number, $val->message);
                                    if(!empty($response)) {
                                        $this->Messages->delete($val);
                                    }
                                }
                            }
                        }
                      }elseif(!empty($firebaseMessage) && $firebaseMessage['messageReceipt'] >= 3) {
                        $val->message_count = 4;
                        $result = $this->Messages->save($val);
                      }
                    } elseif(!empty($val->patient_id)) {
                        $firebaseMessage = $this->Firebase->get('CareTeam/Status/'.$val->patient_id.'/'.$val->sender_id.'/'.$val->receiver_id.'/'.$val->message_id);
                        
                        if(empty($firebaseMessage)) {
                            $val->message_count = 4;
                            $result = $this->Messages->save($val);
                            if(!empty($val->employee->pager_number)) {
                                $response = $this->Twilio->sendSms($val->employee->pager_number, $val->message);
                                if(!empty($response)) {
                                    $this->Messages->delete($val);
                                }
                            }
                            //continue;
                        }
                        
                        if(!empty($firebaseMessage) && $firebaseMessage['messageReceipt'] < 3) {
                            if($val->message_count <= 1){
                                if(!empty($val->employee->device_token)) {
                                    //file_put_contents(TMP."device_tokens_chat_type_none.txt", print_r($val,true),FILE_APPEND);
                                    $this->Firebase->sendFCMMessage($val->employee->device_token, $val->message, $val->doctor_name, [], '', $val->employee->device_type);
                                    $val->message_count = $val->message_count + 1;
                                    $val->next_message_time = time() + 30;
                                    $result = $this->Messages->save($val);
                                } else {
                                    if(!empty($val->employee->pager_number)) {
                                        //file_put_contents(TMP."device_tokens_chat_type_none_sms.txt", print_r($val,true),FILE_APPEND);
                                        $response = $this->Twilio->sendSms($val->employee->pager_number, $val->message);
                                        if(!empty($response)) {
                                            $this->Messages->delete($val);
                                        }
                                    }
                                }
                            } elseif($val->message_count <= 2 && time() == $val->next_message_time){
                                if(!empty($val->employee->device_token)) {
                                    //file_put_contents(TMP."device_tokens_chat_type_none.txt", print_r($val,true),FILE_APPEND);
                                    $this->Firebase->sendFCMMessage($val->employee->device_token, $val->message, $val->doctor_name, [], '', $val->employee->device_type);
                                    $val->message_count = $val->message_count + 1;
                                    $val->next_message_time = time() + 30;
                                    $result = $this->Messages->save($val);
                                } else {
                                    if(!empty($val->employee->pager_number)) {
                                        //file_put_contents(TMP."device_tokens_chat_type_none_sms.txt", print_r($val,true),FILE_APPEND);
                                        $response = $this->Twilio->sendSms($val->employee->pager_number, $val->message);
                                        if(!empty($response)) {
                                            $this->Messages->delete($val);
                                        }
                                    }
                                }
                            }elseif($val->message_count <= 3 && time() == $val->next_message_time){
                                if(!empty($val->employee->device_token)) {
                                    //file_put_contents(TMP."device_tokens_chat_type_none.txt", print_r($val,true),FILE_APPEND);
                                    $this->Firebase->sendFCMMessage($val->employee->device_token, $val->message, $val->doctor_name, [], '', $val->employee->device_type);
                                    $val->message_count = $val->message_count + 1;
                                    $result = $this->Messages->save($val);
                                } else {
                                    if(!empty($val->employee->pager_number)) {
                                        //file_put_contents(TMP."device_tokens_chat_type_none_sms.txt", print_r($val,true),FILE_APPEND);
                                        $response = $this->Twilio->sendSms($val->employee->pager_number, $val->message);
                                        if(!empty($response)) {
                                            $this->Messages->delete($val);
                                        }
                                    }
                                }
                            }
                        }elseif(!empty($firebaseMessage) && $firebaseMessage['messageReceipt'] >= 3) {
                            $val->message_count = 4;
                            $result = $this->Messages->save($val);
                        }
                    }
                }
            }
            return true;
            
        } else {
            return false;
        }
    }
    
    public function sendSecondMessageNotification()
    {
        return true;
    }
    
    public function sendThirdMessageNotification()
    {
        return true;
    }
    
    public function sendPagerMessage()
    {
        $messageLists = $this->Messages->sendPagerMessage();
        
        if(!empty($messageLists)) {
            foreach ($messageLists as $key => $val) {
                if(!empty($val->employee->pager_number)) {
                    $response = $this->Twilio->sendSms($val->employee->pager_number, $val->message);
                    if(!empty($response)) {
                        $this->Messages->delete($val);
                    }
                }
            }
        }
    }
    
    public function array_remove_empty($haystack)
    {
        foreach ($haystack as $key => $value) {
            if (is_array($value)) {
                $haystack[$key] = $this->array_remove_empty($haystack[$key]);
            }
    
            if (empty($haystack[$key])) {
                unset($haystack[$key]);
            }
        }
    
        return $haystack;
    }
}
?>