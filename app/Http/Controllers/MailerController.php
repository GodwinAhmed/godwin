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


        $subject = "Web form enquiry";
        try {
            Mail::send('email', ["name" => $name, "subject" => $subject, "email" => $email, "comments" => $request->message],
                function ($mail) use ($email, $name, $message, $subject) {
                    $mail->from($email, $name);
                    $mail->to(getenv('MAIL_FROM_ADDRESS'), getenv('MAIL_FROM_NAME'));
                    $mail->cc($email);
                    $mail->subject($subject);
                });

            return view('index', ['success' => 'Message sent!']);
        } catch (\Exception $e) {
            return view('index', ['error' => 'Something went wrong. Please try again.']);
        }
    }
}
