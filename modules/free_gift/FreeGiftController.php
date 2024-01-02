<?php

class FPG_FreeGiftController
 {

    function __construct()
 {
    }

    function show_free_gifts()
 {

        wp_enqueue_style( 'css_free_gift_product', plugin_dir_url( __FILE__ ) . 'free_gift_product.css' );
        wp_enqueue_script( 'js_free_gift_product', plugin_dir_url( __FILE__ ) . 'free_gift_product.js' );

        $relation_product_gift = [ 14 => [ 16, 18 ], 2 => [ 3 ] ];

        global $product;
        $id_product = $product->get_id();

        $ids_product_gifts = [];
        if ( array_key_exists( $id_product, $relation_product_gift ) ) {
            $ids_product_gifts = $relation_product_gift[ $id_product ];

            $product_gifts = array_map( function( $id_product ) {
                return wc_get_product( $id_product );
            }
            , $ids_product_gifts );

        }

        FPG_Useful::view( 'free_gift/free-product-gift', compact( 'product_gifts' ) );

    }

    function add_free_gift_to_cart() {
        global $woocommerce;

        FPG_Useful::log( 'add_free_gift_to_cart' );
        FPG_Useful::log( $_POST );

        // remove_action( 'woocommerce_add_to_cart', __FUNCTION__ );

        if ( isset( $_POST[ 'radio_free_product_gift' ] ) ) {
            $id_free_product_gift = $_POST[ 'radio_free_product_gift' ];
            unset( $_POST[ 'radio_free_product_gift' ] );

            $product = wc_get_product( $id_free_product_gift );

            $result = $woocommerce->cart->add_to_cart( $id_free_product_gift, 1 );
            if ( $result ) {
                wc_add_notice( '"'.$product->get_title().'" has been added as a gift to your cart.', 'success' );
            } else wc_add_notice( 'Error adding "'.$product->get_title().'" to your cart.', 'error' );
                     
        }     

    }
}
