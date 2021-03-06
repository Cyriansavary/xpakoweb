<?php

include_once (dirname(dirname(__FILE__)) . '/config.php');

//Initial response is NULL
$response = null;

//Initialize appropriate action and return as HTML response
if (isset($_POST["action"])) {
    $action = $_POST["action"];

    switch ($action) {
        case "SendMessage": {
                if (isset($_POST["email"]) && !empty($_POST["email"])) {

                    $message = $_POST["message"];
                    $message .= "<br/><br/>";                                        

                    $response = (SendEmail($message, $_POST["subject"], $_POST["name"], $_POST["email"], $email)) ? 'Message envoyé' : "Envoi échoué";
                } else {
                    $response = "Envoi échoué";
                }
            }
            break;
        default: {
                $response = "Erreur! Regarde ça : " . $action;
            }
    }
}


if (isset($response) && !empty($response) && !is_null($response)) {
    echo '{"ResponseData":' . json_encode($response) . '}';
}

function SendEmail($message, $subject, $name, $from, $to) {
    $isSent = false;
    // Content-type header
    $headers = 'MIME-Version: 1.0' . "\r\n";
    $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
    // Additional headers    
    $headers .= 'From: ' . $name .'<'.$from .'>';

    mail($to, $subject, $message, $headers);
    if (mail) {
        $isSent = true;
    }
    return $isSent;
}

?>