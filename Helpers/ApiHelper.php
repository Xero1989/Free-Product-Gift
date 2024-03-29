<?php

class FPG_API
{

    static function ajax_server_response($server_response = array())
    {
        // if (!isset($server_response["status"])) {
        //     $server_response["status"] = "success";
        // }
        // if (!isset($server_response["message"])) {
        //     $server_response["message"] = "The operation has been successful";
        // }

        if (is_array($server_response)) {
            echo json_encode($server_response);
        } else echo $server_response;
        die();
    }

    static function proccess_remote_response($response, $extra_data = array())
    {
        $response_code = wp_remote_retrieve_response_code($response);
        $body = wp_remote_retrieve_body($response);

        if ($response_code == 200) {
            $body = wp_remote_retrieve_body($response);

            $body = json_decode($body, true);

            FPG_Useful::log("Response SUCCESS Code -> 200");
            FPG_Useful::log("Response Body");
            FPG_Useful::log($body);

            $body["response_code"] = $response_code;

            return $body;
        } else {
            $body = json_decode($body, true);

            if ($response_code == "") {
                $body["response_code"] = $response_code;
            } else {
                $body["response_code"] = $response_code;
            }


            if (isset($extra_data["step"])) {
                FPG_Useful::log("Step -> " . $extra_data["step"] . "\n\r");
            }

            FPG_Useful::log("Response ERROR CODE -> " . $response_code);
            FPG_Useful::log("Response");
            FPG_Useful::log($response);
            FPG_Useful::log("Response Body");
            FPG_Useful::log($body);

            foreach ($extra_data as $message) {
                FPG_Useful::log($message);
            }

            return $body;
        }
    }
}
