<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use AWS;
use Log;
use Aws\Exception\AwsException;

class SnsBaseController extends Controller
{
    protected $topicName = "";

    function store(Request $request){

        $message = $request->getContent();

        if(!$this->validation($message)){

            Log::warning('Invalid message: '.$message);
            return response()->json("Error 422: Invalid data", 422);

        }

        if ($this->sendTo($this->getTopicName(), $message)) {

            return response()->json("ok", 200);

        };

    }

    function sendTo($topicName, $message){

        $aws = AWS::createClient('sns');

        $result = $aws->publish([
            'Message'   => $message,
            'TargetArn' => $topicName
        ]);

        return $result['MessageId'];
    }

    function getTopicName(){

        $userID = auth('api')->user()->id;

        return "arn:aws:sns:".env('AWS_REGION').":".env('AWS_USER_CODE').":snsTopic_".$this->topicName."_User".$userID;
    }

    function create(Request $request) {

        $topic = $request->getContent();

        $userID = auth('api')->user()->id;

        Log::debug($userID);

        $snsClient = AWS::createClient('sns');

        try {

            $snsClient->createTopic([
                'Name' => "snsTopic_".$topic."_User".$userID,
            ]);

        } catch (AwsException $e) {

            Log::alert("AWS error: ".$e);
            return response()->json("AWS error: ".$e);

        }
        return response()->json("Successfully created topic '".$topic."' for user ".$userID, 200);
    }

    function validation($message){
        return true;
    }
}
