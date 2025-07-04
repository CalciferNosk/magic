<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class PhpMailController extends CI_Controller{
    
    function  __construct(){
        parent::__construct();
    }
    
    function send(){
        // Load PHPMailer library
        $this->load->library('phpmailer_lib');
        // PHPMailer object
        $mail = $this->phpmailer_lib->load();
        $mail->SMTPDebug = 3;                               

        // SMTP configuration
        $mail->isSMTP();
        $mail->Host     = 'godaddy.motortrade.com.ph';   
        $mail->SMTPAuth = true;
        $mail->Username = 'noreply@motortrade.com.ph';#GMAIL
        $mail->Password = 'PH?pK=a_@qWa'; # create here https://myaccount.google.com/apppasswords?pli=1&rapt=AEjHL4N3Ucs5jEph3Jsr49Anyj_GTq2DJCMP_Z5del3rXoqDdl8B0JgtCjiGBRVZGwJQNXae35bVh976JwH5z3Q8kRDZGPfupg
        $mail->SMTPSecure = 'ssl';
        // $mail->SMTPSecure = 1;
        // $mail->SMTPAutoTLS = 0; 
        $mail->Port       = 465;   

        // $mail->isSMTP();
        // $mail->Host     = 'smtp.gmail.com';   
        // $mail->SMTPAuth = true;
        // $mail->Username = 'benjaminbritanico@gmail.com';
        // $mail->Password = 'uved pzks mylf hhom'; # create here https://myaccount.google.com/apppasswords?pli=1&rapt=AEjHL4N3Ucs5jEph3Jsr49Anyj_GTq2DJCMP_Z5del3rXoqDdl8B0JgtCjiGBRVZGwJQNXae35bVh976JwH5z3Q8kRDZGPfupg
        // $mail->SMTPSecure = 'tls';
        // $mail->Port       = 587;   
        
       
         $mail->setFrom('noreply@motortrade.com.ph', 'Motortrade | Recruitment');
        //  $mail->setTo('noreply@motortrade.com.ph');
        $mail->addReplyTo('noreply@motortrade.com.ph', 'LNHS');
        // Add a recipient
        $mail->addAddress('ericksonadriano.h2software@gmail.com');
        
        // Add cc or bcc 
        // $mail->addCC('cc@example.com');
        // $mail->addBCC('bcc@example.com');
        
        // Email subject
        $mail->Subject = 'ONLINE ASSESSMENT';
        
        // Set email format to HTML
        $mail->isHTML(true);
        
        // Email body content
        $html = 'This is the HTML email sent from localhost.';
        $mailContent =  $html ;
        $mail->Body = $mailContent;
        
        // Send email
        if(!$mail->send()){
            echo 'Message could not be sent.';
            echo 'Mailer Error: ' . $mail->ErrorInfo;
        }else{
            echo 'Message has been sent';
        }
    }


    public function send_invite($email,$applicant_id,$name,$cc=[]){
         // Load PHPMailer library
         $this->load->library('phpmailer_lib');
         // PHPMailer object
         $mail = $this->phpmailer_lib->load();
         $mail->SMTPDebug = 3;                               
 
         // SMTP configuration
         $mail->isSMTP();
         $mail->Host     = 'godaddy.motortrade.com.ph';   
         $mail->SMTPAuth = true;
         $mail->Username = 'noreply@motortrade.com.ph';#GMAIL
         $mail->Password = 'PH?pK=a_@qWa'; # create here https://myaccount.google.com/apppasswords?pli=1&rapt=AEjHL4N3Ucs5jEph3Jsr49Anyj_GTq2DJCMP_Z5del3rXoqDdl8B0JgtCjiGBRVZGwJQNXae35bVh976JwH5z3Q8kRDZGPfupg
         $mail->SMTPSecure = 'ssl';
         // $mail->SMTPSecure = 1;
         // $mail->SMTPAutoTLS = 0; 
         $mail->Port       = 465;   

        $mail->setFrom('noreply@motortrade.com.ph', 'Motortrade | Recruitment');
         $mail->addReplyTo('noreply@motortrade.com.ph', 'LNHS');
         // Add a recipient
         $mail->addAddress($email);
         
         // Add cc or bcc 
         // $mail->addCC('cc@example.com');
         // $mail->addBCC('bcc@example.com');
         
         // Email subject
         $mail->Subject = 'ONLINE ASSESSMENT';
         
         // Set email format to HTML
         $mail->isHTML(true);
         
         // Email body content
         $html = 'This is the HTML email sent from localhost.';
         $mailContent =  $html ;
         $mail->Body = $mailContent;
         
         // Send email
         if(!$mail->send()){
             echo 'Message could not be sent.';
             echo 'Mailer Error: ' . $mail->ErrorInfo;
         }else{
             echo 'Message has been sent';
         }
    }
    
    
}