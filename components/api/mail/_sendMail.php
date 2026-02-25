<?php
require __DIR__ . "/PHPMailer/PHPMailer.php";
require __DIR__ . "/PHPMailer/SMTP.php";
require __DIR__ . "/PHPMailer/Exception.php";
use PHPMailer\PHPMailer\PHPMailer;

function sendMail($data)
{
    $message = writteMail($data);

    $smtpHost = $_ENV["SMTP_HOST"] ?? null;
    $smtpPort = $_ENV["SMTP_PORT"] ?? null;
    $smtpUsername = $_ENV["SMTP_USERNAME"] ?? null;
    $smtpPassword = $_ENV["SMTP_PASSWORD"] ?? null;
    $emailFrom = $_ENV["EMAIL_FROM"] ?? null;
    $emailTo = $_ENV["EMAIL_TO"] ?? null;
    $emailCC = explode(" ", $_ENV["EMAIL_CC"]) ?? null;
    $emailBCC = explode(" ", $_ENV["EMAIL_BCC"]) ?? null;

    try {
        $mail = new PHPMailer(true);
        $mail->IsSMTP();
        $mail->CharSet = "UTF-8";
        $mail->Host = $smtpHost;
        $mail->Port = $smtpPort;
        $mail->SMTPAuth = true;
        $mail->Username = $smtpUsername;
        $mail->Password = $smtpPassword;
        $mail->SMTPSecure = "tls";
        $mail->setFrom($emailFrom);
        $mail->addAddress($emailTo);
        $mail->isHTML(true);
        $mail->Subject = "Demande de Devis en ligne";
        $mail->Body = $message;
        if ($emailCC && $_ENV["ENVIRONMENT"] === "production") {
            foreach ($emailCC as $cc) {
                $mail->addCC($cc);
            }
        }
        if ($emailBCC) {
            foreach ($emailBCC as $bcc) {
                $mail->addBCC($bcc);
            }
        }
        $mail->send();
    } catch (Exception $e) {
    }
}

function sendClientMail($data)
{
    $message = getClientMail($data);

    $smtpHost = $_ENV["SMTP_HOST"] ?? null;
    $smtpPort = $_ENV["SMTP_PORT"] ?? null;
    $smtpUsername = $_ENV["SMTP_USERNAME"] ?? null;
    $smtpPassword = $_ENV["SMTP_PASSWORD"] ?? null;
    $emailFrom = $_ENV["EMAIL_FROM"] ?? null;
    $emailTo = $data["email"] ?? null;
    try {
        $mail = new PHPMailer(true);
        $mail->IsSMTP();
        $mail->CharSet = "UTF-8";
        $mail->Host = $smtpHost;
        $mail->Port = $smtpPort;
        $mail->SMTPAuth = true;
        $mail->Username = $smtpUsername;
        $mail->Password = $smtpPassword;
        $mail->SMTPSecure = "tls";
        $mail->setFrom($emailFrom);
        $mail->addAddress($emailTo);
        $mail->isHTML(true);
        $mail->Subject = "Reçu de votre demande de Devis en ligne";
        $mail->Body = $message;
        // if ($emailBCC) {
        //     $mail->addBCC($emailBCC);
        // }
        $mail->send();
    } catch (Exception $e) {
        // echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
    }

}

?>