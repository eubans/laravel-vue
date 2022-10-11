<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Exception;
use Twilio\Rest\Client;

class SMSController extends Controller
{
    public $twilioSID;
    public $twilioToken;
    public $twilioMSSID;
 
    /**
     * Create a new controller instance.
     *
     * @return void
     */
 
    public function __construct()
    {
        $this->twilioSID    = env('TWILIO_SID');
        $this->twilioToken     = env('TWILIO_TOKEN');
        $this->twilioMSSID   = env('TWILIO_MSSID');
    }
    
    public function index()
    {
        return response()->json([], 403);
    }

    public function sendSMS($to, $message)
    {
        if(env('IS_SMS_DISABLED')){
            return "success";
        }

        try {
            $client = new Client($this->twilioSID, $this->twilioToken);
            $client->messages->create($to, // to 
                array(  
                    "messagingServiceSid" => $this->twilioMSSID,      
                    "body" => $message
                )
            );
  
            \Log::error("SMS Sent Successfully: ". $to);
            return "success";
  
        } catch (Exception $e) {
            \Log::error("Error: ". $e->getMessage());
            return 'failed';
        }
    }
}
