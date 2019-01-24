<?php
namespace App\Shell\Task;

use Cake\Console\Shell;
use Cake\Controller\ComponentRegistry;
use App\Controller\Component\FirebaseComponent;

class ScheduleMessageTask extends Shell
{
    public function initialize()
    {
        parent::initialize();
        $this->loadModel('ScheduleMessages');
        $this->loadModel('Patients');
        $this->loadModel('HospitalsEmployees');
        $this->Firebase = new FirebaseComponent(new ComponentRegistry());
    }
    
    public function sendMessageNotification()
    {
        $messageLists = $this->ScheduleMessages->sendScheduleMessage();
        
        if(!empty($messageLists)) {
            foreach ($messageLists as $key => $val) {
                date_default_timezone_set($val->timezone);
                $message = [
                    'actualChatId' => $val->chat_id,
                    'chatType' => "1",
                    'mediaDuration' => 0,
                    'mediaHeight' => 0,
                    'mediaSize' => 0,
                    'mediaThumbSize' => 0,
                    'mediaWidth' => 0,
                    'message' => base64_encode($val->message),
                    'messageReceipt' => "1",
                    'messageId' => $val->message_id,
                    'messageType' => "8",
                    'receiverId' => (string)$val->receiver_id,
                    'senderId' => (string)$val->sender_id,
                    'timestamp' => round(microtime(true) * 1000),
                    'type'  => "1",
                ];
                
                if($val->chat_type == 1) {
                    $patientDetail = $this->Patients->getPatientDetails($val->patient_id, 1);
                    $employeeList = $this->HospitalsEmployees->getServiceTeamLists($patientDetail['hospital_id'], $patientDetail['patient_service_teams'], $val->patient_id);
                    //$membersList = [];//$this->array_remove_empty($this->Firebase->get('groups/'.$val->chat_id.'/membersList'));
                    
                    if(!empty($employeeList)) {
                        $message['chatId'] = (string)$val->chat_id;
                        $rensponse = $this->Firebase->set('OneToOne/'.$val->chat_id.'/'.$val->message_id.'/', $message);
                        foreach ($employeeList as $m_key => $m_val)
                        {
                            if($m_val['id'] != $val->sender_id) {
                                $recentChat = $this->Firebase->get('RecentChats/'.$m_val['id'].'/'.$val->chat_id.'/');
                                $message['badgeCounter'] = !empty($recentChat['badgeCounter']) ? $recentChat['badgeCounter'] + 1 : 1;
                                $this->Firebase->update('RecentChats/'.$m_val['id'].'/'.$val->chat_id.'/', $message);
                            }
                        }
                    }
                    
                    $this->ScheduleMessages->delete($val);
                } elseif($val->chat_type == 0 && empty($val->patient_id)) {
                    $message['chatId'] = (string)$val->receiver_id;
                    $message['chatType'] = "0";
                    $rensponse = $this->Firebase->set('OneToOne/'.$val->chat_id.'/'.$val->message_id.'/', $message);
                    $message['senderName'] = !empty($val->sender_employee) ? $val->sender_employee->full_name : '';
                    $this->Firebase->set('push/tasks/'.$val->receiver_id.'/', $message);
                    $this->Firebase->update('RecentChats/'.$val->sender_id.'/'.$val->receiver_id.'/', $message);
                    $message['chatId'] = (string)$val->sender_id;
                    $recentChat = $this->Firebase->get('RecentChats/'.$val->receiver_id.'/'.$val->sender_id.'/');
                    $message['badgeCounter'] = !empty($recentChat['badgeCounter']) ? $recentChat['badgeCounter'] + 1 : 1;
                    $this->Firebase->update('RecentChats/'.$val->receiver_id.'/'.$val->sender_id.'/', $message);
                    $statusMessage = [
                      'messageId' => $val->message_id,
                      'messageReceipt' => "1",
                      'timestamp' => $message['timestamp'] 
                    ];
                    $this->Firebase->set('Status/'.$val->sender_id.'/'.$val->receiver_id.'/'.$val->message_id.'/', $statusMessage);
                    $this->ScheduleMessages->delete($val);
                } elseif(!empty($val->patient_id)) {
                    $message['chatId'] = (string)$val->receiver_id;
                    $message['patientId'] = (string)$val->patient_id;
                    $message['chatType'] = "0";
                    /* Care team  one to one*/
                    $rensponse = $this->Firebase->set('CareTeam/OneToOne/'.$val->patient_id.'/'.$val->chat_id.'/'.$val->message_id.'/', $message);
                    /* Care team  push*/
                    $message['senderName'] = !empty($val->sender_employee) ? $val->sender_employee->full_name : '';
                    $this->Firebase->set('CareTeam/push/tasks/'.$val->receiver_id.'/', $message);
                    /* Care team recent chat sender*/
                    $this->Firebase->update('CareTeam/RecentChats/'.$val->sender_id.'/'.$val->patient_id.'/'.$val->receiver_id.'/', $message);
                    $message['chatId'] = (string)$val->sender_id;
                    
                    /* Care team  recant chat reciever*/
                    $recentChat = $this->Firebase->get('CareTeam/RecentChats/'.$val->receiver_id.'/'.$val->patient_id.'/'.$val->sender_id.'/');
                    $message['badgeCounter'] = !empty($recentChat['badgeCounter']) ? $recentChat['badgeCounter'] + 1 : 1;
                    $this->Firebase->update('CareTeam/RecentChats/'.$val->receiver_id.'/'.$val->patient_id.'/'.$val->sender_id.'/', $message);
                    
                    $statusMessage = [
                        'messageId' => $val->message_id,
                        'messageReceipt' => "1",
                        'timestamp' => $message['timestamp']
                    ];
                    $this->Firebase->set('CareTeam/Status/'.$val->sender_id.'/'.$val->patient_id.'/'.$val->receiver_id.'/'.$val->message_id.'/', $statusMessage);
                    
                    $this->ScheduleMessages->delete($val);
                }
            }
        }
        
        return true;
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