<?php

class WPB_Xirect_API
{

    private $token;
    private $xirect_endpoint;

    public function __construct()
    {
        $this->xirect_endpoint = get_option("wpb_xirect_endpoint");

        $this->token = false;
    }


    function get_token()
    {
        $url = $this->xirect_endpoint . "/api/v2.0/Auth/GetToken";

        $wpb_auth_user = get_option("wpb_auth_user");
        $wpb_auth_pass = get_option("wpb_auth_pass");

        $body = array(
            "userName" => $wpb_auth_user,
            "password" => $wpb_auth_pass,
        );

        $response = wp_remote_post(
            $url,
            array(
                'headers' => array('Content-Type' => 'application/json'),
                'body' => wp_json_encode($body),
                'timeout' => 10000
            )
        );

        return WPB_API::proccess_remote_response($response, array("step" => "get token"));
    }

    function get_all_products()
    {

        $all_products = array();

        $response = $this->get_markets();
        if ($response === false)
            return false;

        $markets = $response["data"];

        $response = $this->get_languages();
        if ($response === false)
            return false;

        $languages = $response["data"];

        foreach ($markets as $market) {
            $id_market = $market["marketId"];
            $market_name = $market["name"];
            $id_warehouse = $market["primaryWarehouse"];
            $cultureInfo = $market["defaultCultureInfo"];

            $id_language = 0;
            foreach ($languages as $language) {
                if ($language["cultureInfo"] == $cultureInfo) {
                    $id_language = $language["languageId"];

                    break;
                }
            }

            $response = $this->get_categories($id_language);
            if ($response === false)
                return false;

            $categories = $response["data"];

            foreach ($categories as $category) {
                $id_category = $category["categoryId"];

                $response = $this->get_products($id_market, $id_language, $id_category, $id_warehouse);
                if ($response === false)
                    continue;

                $products = $response["data"];

                for ($o = 0; $o < count($products); $o++) {
                    $products[$o]["market_id"] = $id_market;
                    $products[$o]["market_name"] = $market_name;

                    array_push($all_products, $products[$o]);                    
                }         
            }
        }

        return $all_products;
    }

    function get_markets()
    {
        if ($this->token === false) {
            $response = $this->get_token();

            if ($response === false)
                return false;
            else $this->token = $response["token"];
        }

        $url = $this->xirect_endpoint . "/api/v2.0/Market";

        $response = wp_remote_get(
            $url,
            array(
                'headers' => array('Content-Type' => 'application/json', "Authorization" => "Bearer " . $this->token),
                //'body' => wp_json_encode($body),
                'timeout' => 20000
            )
        );

        $response = WPB_API::proccess_remote_response($response, array("step" => "get_markets"));

        return $response;
    }

    function get_autoship_frequencies()
    {
        if ($this->token === false) {
            $response = $this->get_token();

            if ($response === false)
                return false;
            else $this->token = $response["token"];
        }

        $url = $this->xirect_endpoint . "/api/v2.0/Autoship/Frequencies";

        $response = wp_remote_get(
            $url,
            array(
                'headers' => array('Content-Type' => 'application/json', "Authorization" => "Bearer " . $this->token),
                //'body' => wp_json_encode($body),
            )
        );

        $response = WPB_API::proccess_remote_response($response, array("step" => "get_autoship_frequencies"));

        return $response;
    }

    function get_languages()
    {
        if ($this->token === false) {
            $response = $this->get_token();

            if ($response === false)
                return false;
            else $this->token = $response["token"];
        }

        $url = $this->xirect_endpoint . "/api/v2.0/Language";

        $response = wp_remote_get(
            $url,
            array(
                'headers' => array('Content-Type' => 'application/json', "Authorization" => "Bearer " . $this->token),
                //'body' => wp_json_encode($body),
            )
        );

        return WPB_API::proccess_remote_response($response, array("step" => "get_languages"));

        // WPB_Useful::log("language response");
        // WPB_Useful::log($response);

        return $response;
    }

    function get_categories($id_language)
    {
        if ($this->token == false)
            return false;

        $url = $this->xirect_endpoint . "/ProductCategory/$id_language";

        $response = wp_remote_get(
            $url,
            array(
                'headers' => array('Content-Type' => 'application/json', "Authorization" => "Bearer " . $this->token),
                //'body' => wp_json_encode($body),
            )
        );

        $response = WPB_API::proccess_remote_response($response);

        return $response;
    }

    function get_products($id_market, $id_language, $id_category, $id_warehouse)
    {
        if ($this->token == false)
            return false;

        $url = $this->xirect_endpoint . "/Product/$id_market/xEnroll/$id_language/All/Customers/$id_category/$id_warehouse/Replicate";

        $response = wp_remote_get(
            $url,
            array(
                'headers' => array('Content-Type' => 'application/json', "Authorization" => "Bearer " . $this->token),
                //'body' => wp_json_encode($body),
            )
        );

        $response = WPB_API::proccess_remote_response($response);

        // WPB_Useful::log("Products response");
        // WPB_Useful::log($response);

        return $response;
    }

    function calculate_data($data)
    {
        if ($this->token === false) {
            $response = $this->get_token();

            if ($response === false)
                return false;
            else $this->token = $response["token"];
        }

        $url = $this->xirect_endpoint . "/api/v2.0/Order/Calculate";

        $response = wp_remote_post(
            $url,
            array(
                'headers' => array('Content-Type' => 'application/json', "Authorization" => "Bearer " . $this->token),
                'body' => json_encode($data),
                // 'timeout' => 10000
            )
        );

        $response = WPB_API::proccess_remote_response($response);

        return $response;
    }

    function check_referral_code($promo_code)
    {
        if ($this->token === false) {
            $response = $this->get_token();

            if ($response === false)
                return false;
            else $this->token = $response["token"];
        }

        $client_ip = WC_Geolocation::get_ip_address();

        $url = $this->xirect_endpoint . "/api/v2.0/ReferAFriend/username/$promo_code?ClientIP=$client_ip";

        $response = wp_remote_get(
            $url,
            array(
                'headers' => array('Content-Type' => 'application/json', "Authorization" => "Bearer " . $this->token),
            )
        );

        $response = WPB_API::proccess_remote_response($response, array("step" => "check_referral_code"));

        return $response;
    }

    function check_promo_code($promo_code)
    {
        if ($this->token === false) {
            $response = $this->get_token();

            if ($response === false)
                return false;
            else $this->token = $response["token"];
        }

        $client_ip = WC_Geolocation::get_ip_address();

        $url = $this->xirect_endpoint . "/api/v2.0/Promotion/ValidatePromoCode/$promo_code?ClientIP=$client_ip";
        WPB_Useful::log($url);
        $response = wp_remote_get(
            $url,
            array(
                'headers' => array('Content-Type' => 'application/json', "Authorization" => "Bearer " . $this->token),
            )
        );

        $response = WPB_API::proccess_remote_response($response, array("step" => "check_promo_code"));

        return $response;
    }

    function get_states($id_country)
    {
        if ($this->token === false) {
            $response = $this->get_token();

            if ($response === false)
                return false;
            else $this->token = $response["token"];
        }

        $url = $this->xirect_endpoint . "/api/v2.0/Address/Configuration/" . $id_country;
        WPB_Useful::log("get_states: " . $url);

        $response = wp_remote_get(
            $url,
            array(
                'headers' => array('Content-Type' => 'application/json', "Authorization" => "Bearer " . $this->token),
            )
        );

        $response = WPB_API::proccess_remote_response($response, array("step" => "get_states"));

        return $response;
    }

    function check_username($username)
    {
        if ($this->token === false) {
            $response = $this->get_token();

            if ($response === false)
                return false;
            else $this->token = $response["token"];
        }

        $client_ip = WC_Geolocation::get_ip_address();

        $url = $this->xirect_endpoint . "/api/v2.0/Distributor/VerifyUsersame/$username?ClientIP=$client_ip";

        $response = wp_remote_get(
            $url,
            array(
                'headers' => array('Content-Type' => 'application/json', "Authorization" => "Bearer " . $this->token),
                //'body' => wp_json_encode($body),
                // 'timeout' => 20000
            )
        );

        $response = WPB_API::proccess_remote_response($response, array("step" => "check_username"));

        return $response;
    }

    function check_email($email)
    {
        if ($this->token === false) {
            $response = $this->get_token();

            if ($response === false)
                return false;
            else $this->token = $response["token"];
        }

        $client_ip = WC_Geolocation::get_ip_address();

        $url = $this->xirect_endpoint . "/api/v2.0/Distributor/VerifyEmail/$email?ClientIP=$client_ip";

        $response = wp_remote_get(
            $url,
            array(
                'headers' => array('Content-Type' => 'application/json', "Authorization" => "Bearer " . $this->token),
                //'body' => wp_json_encode($body),
                // 'timeout' => 20000
            )
        );

        $response = WPB_API::proccess_remote_response($response, array("step" => "check_email"));

        return $response;
    }

    function get_payment_methods($data)
    {
        if ($this->token === false) {
            $response = $this->get_token();

            if ($response === false)
                return false;
            else $this->token = $response["token"];
        }

        $market_id = $_SESSION["market_id"];
        $account_type = $_SESSION["account_type"];
        $total = $_SESSION["total"];
        $date = date("Y-m-d");
        $date = date('Y-m-d', strtotime($date . "+1 days"));
        $ip_client = WC_Geolocation::get_ip_address();

        $url = $this->xirect_endpoint . "/api/v2.0/Order/PaymentMethods?ModuleId=xReplicate&MarketId=$market_id&AccountType=$account_type&TotalAmount=$total&OrderDate=$date&ClientIP=$ip_client";

        $response = wp_remote_get(
            $url,
            array(
                'headers' => array('Content-Type' => 'application/json', "Authorization" => "Bearer " . $this->token),
                // 'body' => json_encode($data),
                // 'timeout' => 10000
            )
        );

        $response = WPB_API::proccess_remote_response($response, array("step" => "get_payment_methods"));

        return $response;
    }

    function payment_charge($data)
    {
        if ($this->token === false) {
            $response = $this->get_token();

            if ($response === false)
                return false;
            else $this->token = $response["token"];
        }

        $url = $this->xirect_endpoint . "/api/v2.0/Payment/Charge";

        $response = wp_remote_post(
            $url,
            array(
                'headers' => array('Content-Type' => 'application/json', "Authorization" => "Bearer " . $this->token),
                'body' => json_encode($data),
                // 'timeout' => 10000
            )
        );

        $response = WPB_API::proccess_remote_response($response, array("step" => "payment_charge"));

        return $response;
    }

    function save_order($data)
    {
        if ($this->token === false) {
            $response = $this->get_token();

            if ($response === false)
                return false;
            else $this->token = $response["token"];
        }

        // WPB_Useful::log("save_order body");
        // WPB_Useful::log($data);

        $url = $this->xirect_endpoint . "/api/v2.0/Order/Save";

        $response = wp_remote_post(
            $url,
            array(
                'headers' => array('Content-Type' => 'application/json', "Authorization" => "Bearer " . $this->token),
                'body' => json_encode($data),
                // 'timeout' => 10000
            )
        );

        $response = WPB_API::proccess_remote_response($response);

        return $response;
    }
}
