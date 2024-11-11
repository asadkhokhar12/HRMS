<?php

namespace App\Helpers\CoreApp\Traits;

use GuzzleHttp\Client;

trait SmsHandler
{
    //you need to pass a number here like $number = 01777777777 & need to pass the content text for explain like $text = "Hi there"
    function sendSingleSms($to, $text)
    {
        try {
            $client = new Client();
            $pass = '1@r@b!IDL';
            $body = array(
                "Username" => 'sookh',
                "Password" => $pass,
                "From" => 'SOOKH',
                "To" => '88' . $to,
                "Message" => $text,
            );

            $response = $client->request('POST', env("ROBI_API_URL"), [
                'form_params' => $body,
            ]);
        } catch (\Throwable $th) {
            return true;
        }
        return true;
    }

    //you need to pass an array of number here like $numbers = [01777777777,01999999999] & need to pass the content text for explain like $text = "Hi there"
    function sendMultipleSms($numbers, $text)
    {
        try {
            foreach ($numbers as $number) {
                $client = new Client();
                $pass = '1@r@b!IDL';
                $body = array(
                    "Username" => 'sookh',
                    "Password" => $pass,
                    "From" => 'SOOKH',
                    "To" => '88' . $number,
                    "Message" => $text,
                );
                $response = $client->request('POST', env("ROBI_API_URL"), [
                    'form_params' => $body,
                ]);
            }

        } catch (\Throwable $th) {
            return true;
        }
        return true;
    }


}
