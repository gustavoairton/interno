<?php

namespace App\Http\Services;

use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\PHPMailer;

class MailService
{

    protected $mail;

    public function __construct()
    {
        $this->mail = new PHPMailer(true);

        $this->mail->isSMTP();                                            //Send using SMTP
        $this->mail->Host       = env('MAIL_HOST');                     //Set the SMTP server to send through
        $this->mail->SMTPAuth   = true;
        $this->mail->Username   = env('MAIL_USERNAME');                     //SMTP username
        $this->mail->Password   = env('MAIL_PASSWORD');                               //SMTP password
        $this->mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;            //Enable implicit TLS encryption
        $this->mail->Port       = 587;
        $this->mail->CharSet = 'UTF-8';
        $this->mail->setFrom(env('MAIL_FROM_ADDRESS'), env('MAIL_FROM_NAME'));
    }

    public function sendView($subject, $to, $name, $view, $args, $alt)
    {
        $this->mail->addAddress($to, $name);
        $this->mail->isHTML(true);
        $this->mail->Subject = $subject;
        $this->mail->Body    = view($view, $args);
        $this->mail->AltBody = $alt;

        $this->mail->send();
    }
}
