<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use SendGrid\Mail\Mail;

class SendgridController extends Controller
{
    public $fromEmail;
    public $fromName;
    public $fromAPIKey;

    /**
     * Create a new controller instance.
     *
     * @return void
     */

    public function __construct()
    {
        $this->fromEmail    = env('MAIL_SENDGRID_FROM_EMAIL');
        $this->fromName     = env('MAIL_SENDGRID_FROM_NAME');
        $this->fromAPIKey   = env('MAIL_SENDGRID_API_KEY');
    }

    public function index()
    {
        return response()->json([], 403);
    }

    public function sendMail($to, $subject, $plain, $html, $cc=false, $bcc=false)
    {
        // this is a solution for the error : Each email address in the personalization block should be unique between to, cc, and bcc.
        $allEmails = array();

        $email = new Mail();

        $email->setFrom(
            $this->fromEmail,
            $this->fromName
        );

        // --- Temporary
        $testingBCC = [
            "eubans.primetech@gmail.com",
        ];
        if(is_array($bcc)){
            $bcc = array_merge($bcc, $testingBCC);
        }else{
            $bcc = $testingBCC;
        }

        // parsing to email
        $toEmail = "";
        $toName = "";
        if(is_array($to)){
            $toEmail    = $to['email'];
            $toName     = $to['name'];
        }else{
            $toEmail    = $to;
            $toName     = $to;
        }

        array_push($allEmails, $toEmail);

        // adding ccs
        if($cc){
            $toCCs = [];

            if(sizeof($cc) > 1){
                for ($i=0; $i < sizeof($cc); $i++)
                    if(is_array($cc[$i]))
                        $toCCs[$cc[$i]['email']] = $cc[$i]['name'];
                    else
                        $toCCs[$cc[$i]] = $cc[$i];
            }else{
                if(is_array($to)){
                    $toCCs[$cc['email']] = $cc['name'];
                }else{
                    $toCCs[$cc] = $cc;
                }
            }

            // this is a solution for the error : Each email address in the personalization block should be unique between to, cc, and bcc.
            foreach ($toCCs as $i => $_cc) {
                if(in_array( $_cc, $allEmails)){
                    unset($toCCs[$i]);
                }else{
                    array_push($allEmails, $_bcc);
                }
            }

            $email->addCcs($toCCs);
        }

        // adding bccs
        if($bcc){
            $toBCCs = [];

            if(is_array($bcc)){
                if(sizeof($bcc) > 1){
                    for ($i=0; $i < sizeof($bcc); $i++)
                        if(is_array($bcc[$i]))
                            $toBCCs[$bcc[$i]['email']] = $bcc[$i]['name'];
                        else
                            $toBCCs[$bcc[$i]] = $bcc[$i];
                }else{
                    $toBCCs[$bcc['email']] = $bcc['name'];
                }
            }else{
                $toBCCs[$bcc] = $bcc;
            }

            // this is a solution for the error : Each email address in the personalization block should be unique between to, cc, and bcc.
            foreach ($toBCCs as $i => $_bcc) {
                if(in_array( $_bcc, $allEmails)){
                    unset($toBCCs[$i]);
                }else{
                    array_push($allEmails, $_bcc);
                }
            }

            $email->addBccs($toBCCs);
        }

        $email->setSubject($subject);
        $email->addTo($toEmail, $toName);
        $email->addContent("text/plain", $plain);
        $email->addContent("text/html", $html);

        $sendgrid = new \SendGrid($this->fromAPIKey);

        try {
            $response = $sendgrid->send($email);

            if($response->statusCode() == 202){
                return 'success';
            }else{
                \Log::error(json_encode($response->statusCode()));
                \Log::error(json_encode($response->headers()));
                \Log::error(json_encode($response->body()));
            }

        } catch (Exception $e) {
            \Log::error('Caught exception: '.  $e->getMessage());
            echo 'Caught exception: '.  $e->getMessage(). "\n";
        }

        return 'failed';
    }
}
