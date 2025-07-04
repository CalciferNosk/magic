<?php
defined('BASEPATH') or exit('No direct script access allowed');

class EmailNotifModel extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->library('user_agent');
    }

    public function sendOtp($email, $content, $Subject, $cc = [])
    {

        if(empty($email)) return false;
        // Load PHPMailer library
        $this->load->library('phpmailer_lib');
        // PHPMailer object
        $mail = $this->phpmailer_lib->load();
        // $mail->SMTPDebug = 3;

         $mail->isSMTP();
        $mail->Host     = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'ericksonadriano.h2software@gmail.com';
        $mail->Password = 'rtol vjrx aplq aiwy ';#(eadriano.it@ = 'hudo qrsk uwsd ucsj';) # create here https://myaccount.google.com/apppasswords?pli=1&rapt=AEjHL4N3Ucs5jEph3Jsr49Anyj_GTq2DJCMP_Z5del3rXoqDdl8B0JgtCjiGBRVZGwJQNXae35bVh976JwH5z3Q8kRDZGPfupg
        $mail->SMTPSecure = 'tls';
        // $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
        $mail->Port       = 587;

        // $mail->isSMTP();
        // $mail->Host     = 'smtp.gmail.com';
        // $mail->SMTPAuth = true;
        // $mail->Username = 'hrlegacionjaypee@gmail.com';
        // $mail->Password = 'nftj ekvl tfjc yrsb ';#(eadriano.it@ = 'hudo qrsk uwsd ucsj';) # create here https://myaccount.google.com/apppasswords?pli=1&rapt=AEjHL4N3Ucs5jEph3Jsr49Anyj_GTq2DJCMP_Z5del3rXoqDdl8B0JgtCjiGBRVZGwJQNXae35bVh976JwH5z3Q8kRDZGPfupg
        // $mail->SMTPSecure = 'tls';
        // // $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
        // $mail->Port       = 587;

        $mail->setFrom('no-reply@gmail.com', 'MOTORTRADE | RECRUITMENT');
        $mail->addReplyTo('no-reply@gmail.com', 'MOTORTRADE | RECRUITMENT');

        // Add a recipient
        $mail->addAddress($email);

        // Add cc or bcc 
        if (!empty($cc)) {
            $mail->addCC($cc);
        }
        // $mail->addBCC('bcc@example.com');

        // Email subject
        $mail->Subject = $Subject;

        // Set email format to HTML
        $mail->isHTML(true);

        // Email body content
        $mail->Body = $content;

        // Send email
        if (!$mail->send()) {
            // $result['msg'] =  'Message could not be sent.  | Mailer Error: ' . $mail->ErrorInfo;
            $result['error'] = 0;
        } else {
            // $result['msg'] = 'Message has been sent';
            $result['error'] = 1;
        }
    }

    public function monitorOTP($email, $content, $otp)
    {

        // var_dump($email, $content, $otp);die;
        $logs_otp = [
            "EmailAddress"  => $email,
            "Content"       => $content,
            "OTP"           => $otp
        ];
        $CI =& get_instance();
        $CI->load->database('external', TRUE);
        $result = $CI->db->insert('external_jobapp.tblJobAppOtpLogs', $logs_otp);

        var_dump($result,$CI->db->last_query());

        // if(empty($email)) return false;
        // // Load PHPMailer library
        // $this->load->library('phpmailer_lib');
        // // PHPMailer object
        // $mail = $this->phpmailer_lib->load();
        // if($debug){
        //      $mail->SMTPDebug = 3;
        // }
       


        // $mail->isSMTP();
        // $mail->Host     = 'smtp.gmail.com';
        // $mail->SMTPAuth = true;
        // $mail->Username = 'ericksonadriano.h2software@gmail.com';
        // $mail->Password = 'rtol vjrx aplq aiwy ';#(eadriano.it@ = 'hudo qrsk uwsd ucsj';) # create here https://myaccount.google.com/apppasswords?pli=1&rapt=AEjHL4N3Ucs5jEph3Jsr49Anyj_GTq2DJCMP_Z5del3rXoqDdl8B0JgtCjiGBRVZGwJQNXae35bVh976JwH5z3Q8kRDZGPfupg
        // $mail->SMTPSecure = 'tls';
        // // $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
        // $mail->Port       = 587;

        // $mail->setFrom('no-reply@gmail.com', 'MOTORTRADE | RECRUITMENT');
        // $mail->addReplyTo('no-reply@gmail.com', 'MOTORTRADE | RECRUITMENT');

        // // Add a recipient
        // $mail->addAddress($email);

        // // Add cc or bcc 
        // if (!empty($cc)) {
        //     $mail->addCC($cc);
        // }
        // // $mail->addBCC('bcc@example.com');

        // // Email subject
        // $mail->Subject = $Subject;

        // // Set email format to HTML
        // $mail->isHTML(true);

        // // Email body content
        // $mail->Body = $content;

        // // Send email
        // if (!$mail->send()) {
        //     // $result['msg'] =  'Message could not be sent.  | Mailer Error: ' . $mail->ErrorInfo;
        //     $result['error'] = 0;
        // } else {
        //     // $result['msg'] = 'Message has been sent';
        //     $result['error'] = 1;
        // }
    }
}
