<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator, Mail;


class MailerController extends Controller
{
    public function sendEmail(Request $request){
        $name = $request->contactName;
        $email = $request->contactEmail;
        $subject = $request->contactSubject;
        $message = $request->contactMessage;

        $success_message = "Message sent!";
        $error_message = "Something went wrong. Please try again.";

        $subject = "Web form enquiry";
        try {
            Mail::send('email', ["name" => $name, "subject" => $subject, "email" => $email, "comments" => $request->message],
                function ($mail) use ($email, $name, $message, $subject) {
                    $mail->from($email, $name);
                    $mail->to(getenv('MAIL_FROM_ADDRESS'), getenv('MAIL_FROM_NAME'));
                    $mail->bcc($email);
                    $mail->subject($subject);
                });

            return view('index', compact('success_message'));
        } catch (\Exception $e) {
            return view('index', compact('error_message'));
        }
    }
}
