<?php

class FPG_Session
{

    static function start_session()
    {
        if (!session_id()) {
            session_start();
        }
    }

    static function get_session_info($session_key)
    {
        $value = null;
        if (isset($_SESSION[$session_key]))
            $value = $_SESSION[$session_key];

        return $value;
    }

    static function save_session_data()
    {
        $session_data = $_POST["session_data"];
        // session_start();
        foreach ($session_data as $key => $value) {
            if ($key != "action")
                $_SESSION[$key] = $value;
        }

        $body = array();
        $body["response_code"] = 200;
        $body["success"] = true;

        FPG_API::ajax_server_response($body);
    }
}
