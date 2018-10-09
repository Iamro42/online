<?php

//require_once '../model/phpmailer/src/Exception.php';
//require_once '../model/phpmailer/src/PHPMailer.php';
//require_once '../model/phpmailer/src/SMTP.php';

//require_once '../model/libphp-phpmailer/PHPMailerAutoload.php';

include ('../model/UserModel.php');

$json = file_get_contents('php://input');
if($json==null){
    echo "ERROR";
    return;
}
//echo "page send link";
$userId = "";
$requestType;
$data = json_decode($json);
$requestType = $data->requestType;
$userModel = new UserModel();
// session_start();
if(isset($_SESSION['userId'])){
    $userId = $_SESSION['userId'];
}

$email =  $data->email;
$fname = $data->fname;
$username = 'roshan.tantransh@gmail.com';
$password = 'iam42groot';

if(!empty($email))
{
  //echo "yes";
  $mail = new PHPMailer(true);                              // Passing `true` enables exceptions
    try {
        //Server settings
        //$mail->SMTPDebug = 2;                                 // Enable verbose debug output
        $mail->isSMTP();                                      // Set mailer to use SMTP
        $mail->Host = 'Smtp.gmail.com';  // Specify main and backup SMTP servers
        $mail->SMTPAuth = true;                               // Enable SMTP authentication
        $mail->Username = $username;                 // SMTP username
        $mail->Password = $password;                          // SMTP password
        $mail->SMTPSecure = 'tls';                            // Enable TLS encryption, `ssl` also accepted
        $mail->Port = 587;                                    // TCP port to connect to

        //Recipients
        $mail->setFrom('roshan.tantransh@gmail.com', 'Tantransh Solutions');
        $mail->addAddress($email, 'Joe User');     // Add a recipient
        //$mail->addAddress('ellen@example.com');               // Name is optional
        $mail->addReplyTo('info@example.com', 'Information');
        $mail->addCC('cc@example.com');
        $mail->addBCC('bcc@example.com');

        //Attachments
        //$mail->addAttachment('/var/tmp/file.tar.gz');         // Add attachments
        //$mail->addAttachment('final_logo.png', 'new.jpg');    // Optional name

        //Content
        $mail->isHTML(true);                                  // Set email format to HTML
        $mail->Subject = 'Online Exam Portal : Thank you ';
        $mail->Body    = '<div class="" style = "background:#00619b"></div>
                            <div class = "well">  Dear '.ucfirst($fname).', <br> <p>Thank you For Registration on Online Exam Portal Now you are able to apeear for Test. <br> Your Test code is <b>QPS/005/2</b></p></div>';
        $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

        // $mail->send();
        // echo 'SUCCESS';

        if(!$mail->send()) {
           echo 'FAILED';
           echo 'Mailer error: ' . $mail->ErrorInfo;
        } 
        else{
           echo 'SUCCESS';
        }
    } 
    catch (Exception $e) {
        echo 'FAILED. Mailer Error: ', $mail->ErrorInfo;
    }
}
?>