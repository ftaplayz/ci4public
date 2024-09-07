<?php

namespace App\Libraries;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;

class EmailSender{
    private PHPMailer $mail;

    /**
     * @param string $config Config name from PHPMailer config file
     */
    public function __construct(string $config = 'default'){
        $config = config('PHPMailer')->{$config};
        $this->mail = new PHPMailer();
        $this->mail->SMTPDebug = ENVIRONMENT=='development'?$config['SMTPDebug']:SMTP::DEBUG_OFF;
        if($config['isSMTP'])
            $this->mail->isSMTP();
        $this->mail->Host = $config['host'];
        $this->mail->SMTPAuth = $config['SMTPAuth'];
        $this->mail->Username = $config['username'];
        $this->mail->Password = $config['password'];
        $this->mail->SMTPAutoTLS = $config['SMTPAutoTLS'];
        $this->mail->SMTPSecure = $config['SMTPSecure'];
        $this->mail->Port = $config['port'];
        $this->mail->CharSet = $config['charset'];
    }

    /**
     * Send email function
     * @param string $senderName Sender name
     * @param array $addresses List of emails to send email
     * @param string $subject Message subject
     * @param array $message Array that contains the message (msg key) and optional html message (html key)
     * @return bool|string Returns a message if an error ocurred
     */
    public function sendEmail(string $senderName, array $addresses, string $subject, array $message){
        if(empty($message['msg']))
            return "Can't send empty message";
        if(empty($addresses))
            return 'Need email destination';
        try{
            $this->mail->setFrom($this->mail->Username, $senderName);
            foreach($addresses as $address)
                $this->mail->addAddress($address);
            $this->mail->isHTML(true);
            $this->mail->Subject = $subject;
            $this->mail->Body = $message['html'] ?? $message['msg'];
            $this->mail->AltBody = $message['msg'];
            $this->mail->send();
        }catch(\Exception $e){
            return $this->mail->ErrorInfo;
        }
        return true;
    }

    public function getSender():string{
        return $this->mail->Username;
    }
}