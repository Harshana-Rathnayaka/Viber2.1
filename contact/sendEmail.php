<?php
session_start();

require_once "PHPMailer/PHPMailer.php";
require_once "PHPMailer/SMTP.php";
require_once "PHPMailer/Exception.php";

use PHPMailer\PHPMailer\PHPMailer;

$response = array();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    if (isset($_POST['name']) && isset($_POST['email']) && isset($_POST['contact'])
        && isset($_POST['subject']) && isset($_POST['requirement'])) {

        $name = $_POST['name'];
        $email = $_POST['email'];
        $contact = $_POST['contact'];
        $subject = $_POST['subject'];
        $requirement = $_POST['requirement'];

        $our_sending_email = ''; // enter an email to use for sending emails
        $our_sending_email_password = ''; // password of that email
        $our_receiving_email = 'v21advertising@gmail.com';

        $message_body = '
            <h3>Name : <strong>' . $name . '</strong></h3>
            <h3>Email : <strong>' . $email . '</strong></h3>
            <h3>Contact Number : <strong>' . $contact . '</strong></h3>
            <h3>Subject : <strong>' . $subject . '</strong></h3>
            <h3>Requirement : <strong>' . $requirement . '</strong></h3>
                    ';

        $mail = new PHPMailer(true);

        $mail->IsSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = $our_sending_email;
        $mail->Password = $our_sending_email_password;
        $mail->Port = 587;

        // email settings
        $mail->IsHTML(true);
        $mail->SetFrom($our_sending_email, 'Viber 2.1 Administrator');
        $mail->AddAddress($our_receiving_email);
        $mail->Subject = ('[no-reply] Viber 2.1 Contact Inquiry');
        $mail->Body = $message_body;

        // email sent
        if ($mail->Send()) {

            $_SESSION['result'] = 'Message Sent Successfully';
            $response['error'] = false;
            $response['message'] = "Email sent!";
            header("location:../contact.php");

            // email not sent
        } else {

            $_SESSION['result'] = 'Could not send the message.';
            $response['error'] = true;
            $response['message'] = "Email was not sent!";
            header("location:../contact.php");

        }
    } else {
        $_SESSION['result'] = 'Some values are empty.';
        $response['error'] = true;
        $response['message'] = "Some values are empty.";
        header("location:../contact.php");

    }
} else {
    $_SESSION['result'] = 'Wrong method.';
    $response['error'] = true;
    $response['message'] = "Wrong method.";
    header("location:../contact.php");

}

// echo json_encode($response);
