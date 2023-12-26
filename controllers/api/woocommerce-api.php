<?php

class WPB_Woocommerce_API
{

    private $endpoint;

    public function __construct()
    {
        $endpoint = get_option("wpb_woocommerce_endpoint");
        $this->endpoint = $endpoint;
    }

    function get_product($id)
    {
        $url = $this->endpoint . "/products/$id";

        $wpb_woocommerce_api_key = get_option("wpb_woocommerce_api_key");
        $wpb_woocommerce_api_secret = get_option("wpb_woocommerce_api_secret");

        $response = wp_remote_get(
            $url,
            array(
                'headers' => array('Content-Type' => 'application/json', 'Authorization' => 'Basic ' . base64_encode($wpb_woocommerce_api_key . ':' . $wpb_woocommerce_api_secret)),
            )
        );

        $response = WPB_API::proccess_remote_response($response);

        if ($response === false) {
            WPB_Useful::log("An error occurs - get_product id " . $id);
            return false;
        }

        // WPB_Useful::log("Get product response");
        // WPB_Useful::log($response);

        return $response;
    }

    function get_all_products()
    {
        $url = $this->endpoint . "/products?per_page=20"; //?per_page=20

        $wpb_woocommerce_api_key = get_option("wpb_woocommerce_api_public");
        $wpb_woocommerce_api_secret = get_option("wpb_woocommerce_api_secret");

        WPB_Useful::log("get_all_products_info");
        WPB_Useful::log($url);
        WPB_Useful::log($wpb_woocommerce_api_key);
        WPB_Useful::log($wpb_woocommerce_api_secret);

        $response = wp_remote_request(
            $url,
            array(
                'headers' => array('Content-Type' => 'application/json', 'Authorization' => 'Basic ' . base64_encode($wpb_woocommerce_api_key . ':' . $wpb_woocommerce_api_secret)),
                'method'    => 'GET',
                // 'timeout' => 20000
            )
        );

        return WPB_API::proccess_remote_response($response, array("step" => "get_all_products"));
    }

    function create_product($data)
    {
        $url = $this->endpoint . "/products";

        $wpb_woocommerce_api_key = get_option("wpb_woocommerce_api_key");
        $wpb_woocommerce_api_secret = get_option("wpb_woocommerce_api_secret");

        $response = wp_remote_request(
            $url,
            array(
                'headers' => array('Content-Type' => 'application/json', 'Authorization' => 'Basic ' . base64_encode($wpb_woocommerce_api_key . ':' . $wpb_woocommerce_api_secret)),
                'body' => json_encode($data),
                'method'    => 'POST'
            )
        );

        return WPB_API::proccess_remote_response($response, array("step" => "create_product"));
    }

    function update_product($id, $data)
    {
        $url = $this->endpoint . "/products/$id";

        $wpb_woocommerce_api_key = get_option("wpb_woocommerce_api_key");
        $wpb_woocommerce_api_secret = get_option("wpb_woocommerce_api_secret");       

        $response = wp_remote_request(
            $url,
            array(
                'headers' => array('Content-Type' => 'application/json', 'Authorization' => 'Basic ' . base64_encode($wpb_woocommerce_api_key . ':' . $wpb_woocommerce_api_secret)),
                'body' => json_encode($data),
                'method'    => 'PUT'
            )
        );

        $response = WPB_API::proccess_remote_response($response);

        WPB_Useful::log("Update poduct response");
        WPB_Useful::log($response);

        if ($response === false) {
            WPB_Useful::log("An error occurs - update_product id " . $id);
            return false;
        }

        return $response;
    }

    function delete_product($id)
    {
        $url = $this->endpoint . "/products/$id";

        $wpb_woocommerce_api_key = get_option("wpb_woocommerce_api_key");
        $wpb_woocommerce_api_secret = get_option("wpb_woocommerce_api_secret");

        $response = wp_remote_request(
            $url,
            array(
                'headers' => array('Content-Type' => 'application/json', 'Authorization' => 'Basic ' . base64_encode($wpb_woocommerce_api_key . ':' . $wpb_woocommerce_api_secret)),
                'method'    => 'DELETE'
            )
        );

        $response = WPB_API::proccess_remote_response($response);

        if ($response === false) {
            WPB_Useful::log("An error occurs - delete_product id " . $id);
            return false;
        }

        WPB_Useful::log("Delete product response");
        WPB_Useful::log($response);

        return $response;
    }

    function get_product_categories()
    {
        $url = $this->endpoint . "/products/categories";

        $wpb_woocommerce_api_key = get_option("wpb_woocommerce_api_key");
        $wpb_woocommerce_api_secret = get_option("wpb_woocommerce_api_secret");

        $response = wp_remote_request(
            $url,
            array(
                'headers' => array('Content-Type' => 'application/json', 'Authorization' => 'Basic ' . base64_encode($wpb_woocommerce_api_key . ':' . $wpb_woocommerce_api_secret)),
                'method'    => 'GET'
            )
        );

        $response = WPB_API::proccess_remote_response($response);

        if ($response === false) {
            WPB_Useful::log("An error occurs - get_product_categories ");
            return false;
        }

        WPB_Useful::log("Getting product categories response");
        WPB_Useful::log($response);

        return $response;
    }

    function create_product_categories($data)
    {
        $url = $this->endpoint . "/products/categories";

        $wpb_woocommerce_api_key = get_option("wpb_woocommerce_api_key");
        $wpb_woocommerce_api_secret = get_option("wpb_woocommerce_api_secret");

        $response = wp_remote_request(
            $url,
            array(
                'headers' => array('Content-Type' => 'application/json', 'Authorization' => 'Basic ' . base64_encode($wpb_woocommerce_api_key . ':' . $wpb_woocommerce_api_secret)),
                'body' => json_encode($data),
                'method'    => 'POST'
            ),
        );

        $response = WPB_API::proccess_remote_response($response);

        if ($response === false) {
            WPB_Useful::log("An error occurs - create_product_categories ");
            return false;
        }

        WPB_Useful::log("Creating product categories response");
        WPB_Useful::log($response);

        return $response;
    }


    function aux_get_or_create_product_category_id($category)
    {
        WPB_Useful::log("category");
        WPB_Useful::log($category);

        $all_products_categories = $this->get_product_categories();
        WPB_Useful::log("all_products_categories");
        WPB_Useful::log($all_products_categories);

        if ($all_products_categories === false) {
            WPB_Useful::log("An error occurs get_product_categories");
            return false;
        }



        foreach ($all_products_categories as $element) {
            WPB_Useful::log("element");
            WPB_Useful::log($element["name"]);

            if ($element["name"] == $category) {
                WPB_Useful::log("comparing");

                return $element["id"];
            }
        }

        $new_category = array(
            "name" => $category,
            // "description" => $sku_xirect,
        );

        $response = $this->create_product_categories($new_category);

        if ($response === false) {
            WPB_Useful::log(array("An error occurs creating the category " . $category));
            return false;
        }

        WPB_Useful::log("create_product_categories");
        WPB_Useful::log($response);

        return $response["id"];
    }
}
