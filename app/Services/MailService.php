<?php

namespace App\Services;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use Illuminate\Support\Facades\Log;

class MailService
{
    public function sendEmail($to, $subject, $body)
    {
        return $this->send($to, $subject, $body);
    }

    public function sendEmailWithAttachment($to, $subject, $body, $filePath)
{
    $mail = new PHPMailer(true);

    try {
        // Konfigurasi server
        $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com'; // Ganti dengan host SMTP Anda
            $mail->SMTPAuth = true;
            $mail->Username = 'elvanchua1@gmail.com'; // Ganti dengan email Anda
            $mail->Password = 'cmzp xxak xfog fkmn'; // Ganti dengan password Anda
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port = 587;

        // Pengaturan email
        $mail->setFrom('elvanchua1@gmail.com', 'Elvan'); // Ganti dengan email dan nama Anda
        $mail->addAddress($to);
        $mail->Subject = $subject;
        $mail->Body = $body;

       // Jika ada lampiran
       if ($filePath && file_exists($filePath)) {
        $mail->addAttachment($filePath); // Pastikan path file benar
    } else {
        Log::warning("File not found: " . $filePath);
    }

    $mail->send();
    return true;
} catch (Exception $e) {
    Log::error('Email could not be sent. Mailer Error: ' . $e->getMessage());
    return false;
}
}

    private function send($to, $subject, $body, $filePath = null)
    {
        $mail = new PHPMailer(true);

        try {
            // Konfigurasi server
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com'; // Ganti dengan host SMTP Anda
            $mail->SMTPAuth = true;
            $mail->Username = 'elvanchua1@gmail.com'; // Ganti dengan email Anda
            $mail->Password = 'cmzp xxak xfog fkmn'; // Ganti dengan password Anda
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port = 587;

            // Pengaturan email
            $mail->setFrom('elvanchua1@gmail.com', 'Elvan'); // Ganti dengan email dan nama Anda
            $mail->addAddress($to);
            $mail->Subject = $subject;
            $mail->Body = $body;

            // Jika ada lampiran
            if ($filePath) {
                $mail->addAttachment($filePath);
            }

            $mail->send();
            return true;
        } catch (Exception $e) {
            return false;
        }
    }
}