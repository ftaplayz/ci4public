<?php

namespace Config;
use CodeIgniter\Config\BaseConfig;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\PHPMailer as PHPMailerClass;


/**
 * PHPMailer configuration
 */
class PHPMailer extends BaseConfig{
    /**
     * Default PHPMailer settings
     */
    public array $default = [
        'SMTPDebug' => SMTP::DEBUG_OFF,
        'isSMTP' => true,
        'SMTPAuth' => true,
        'SMTPAutoTLS' => false,
        'SMTPSecure' => 'tls',
        'host' => 'smtp.gmail.com', // host, email?
        'username' => '', // email or username
        'password' => '', // password for username
        'port' => 587,
        'charset' => PHPMailerClass::CHARSET_UTF8
    ];

    /**
     * If you want more just add them with the same format as the $default
     * Example:
     *
     * public array $example = [
     * 'SMTPDebug' => SMTP::DEBUG_OFF,
     * 'isSMTP' => true,
     * 'SMTPAuth' => true,
     * 'SMTPAutoTLS' => false,
     * 'SMTPSecure' => 'tls',
     * 'host' => 'smtp.gmail.com',
     * 'senderName' => '',
     * 'username' => '',
     * 'password' => '',
     * 'port' => 587
     * ];
     */

}