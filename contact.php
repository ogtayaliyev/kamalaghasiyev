<?php
try {
    if (count($_POST) == 0 || !isset($_POST['name']) || !isset($_POST['email']) || !isset($_POST['message'])) {
        throw new \Exception('Form is empty');
    }

    // an email address that will be in the From field of the email.
    $from = $_POST['email'];
    // The message send in email
    $message = $_POST['message'];
    // subject of the email
    $subject = $_POST['name'];

    // Set the recipient email address
    $sendTo = 'aghasiyevk@gmail.com';

    $headers = 'From: ' . $from . "\r\n" .
               'Reply-To: ' . $sendTo . "\r\n" .
               'X-Mailer: PHP/' . phpversion();

    // Send email
    if (mail($sendTo, $subject, $message, $headers)) {
        $responseArray = array('type' => 'success', 'message' => 'Message has been sent');
    } else {
        throw new \Exception('Message could not be sent');
    }
} catch (\Exception $e) {
    $responseArray = array('type' => 'danger', 'message' => $e->getMessage());
}

// if requested by AJAX request return JSON response
if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
    $encoded = json_encode($responseArray);
    header('Content-Type: application/json');
    echo $encoded;
} else {
    echo $responseArray['message'];
}