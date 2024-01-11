<?php

class FPG_FreeGiftController
 {

    function __construct()
 {
        // add_filter( 'woocommerce_is_purchasable', [ $this, 'woocommerce_is_purchasable' ], 10, 2 );
        add_filter( 'woocommerce_add_to_cart_validation', [ $this, 'woocommerce_add_to_cart_validation' ], 10, 5 );
        // add_filter( 'woocommerce_is_sold_individually', [ $this, 'remove_all_quantity_fields_for_free_gifts' ] );
    }

    function show_free_gifts()
 {
        wp_enqueue_style( 'css_free_gift_product', plugin_dir_url( __FILE__ ) . 'free_gift_product.css' );
        wp_enqueue_script( 'js_free_gift_product', plugin_dir_url( __FILE__ ) . 'free_gift_product.js' );

        // $relation_product_gift = [ 14 => [ 16, 18 ], 2 => [ 3 ] ];

        // global $product;
        // $id_product = $product->get_id();

        // $ids_product_gifts = [];
        // if ( array_key_exists( $id_product, $relation_product_gift ) ) {
        //     $ids_product_gifts = $relation_product_gift[ $id_product ];

        //     $product_gifts = array_map( function( $id_product ) {
        //         return wc_get_product( $id_product );
        //     }
        //, $ids_product_gifts );

        // }

        $free_products = wc_get_products( [
            'category' => 'Free Gifts',
        ] );

        //  FPG_Useful::log( 'product categoryss' );
        //  FPG_Useful::log( $products );
        //  FPG_Useful::log( $products[ 0 ]->get_id() );

        FPG_Useful::view( 'free_gift/free-product-gift', compact( 'free_products' ) );

    }

    function woocommerce_add_to_cart_validation( $passed, $product_id, $quantity, $variation_id = null, $variations = null ) {

        FPG_Useful::log( 'woocommerce_add_to_cart_validation' );
        FPG_Useful::log( $_SESSION );

        $terms = get_the_terms( $product_id, 'product_cat' );

        // FPG_Useful::log( 'terms' );
        // FPG_Useful::log( $terms );

        foreach ( $terms as $term ) {

            $product_cat = $term->name;

            if ( $product_cat == 'Free Gifts' ) {

                if ( isset( $_SESSION[ 'free_product_gift' ] ) && $_SESSION[ 'free_product_gift' ] == true ) {
                    $_SESSION[ 'free_product_gift' ] = false;
                    return true;
                } else {
                    wc_add_notice( 'This is a free gift, is not purchable ', 'error' );
                    $_SESSION[ 'free_product_gift' ] = false;
                    return false;
                }

            }

        }

        return $passed;

    }

    function woocommerce_add_to_cart() {
        if ( !session_id() ) {
            session_start();
        }

        global $woocommerce;

        FPG_Useful::log( 'add_free_gift_to_cart' );
        FPG_Useful::log( $_SESSION );

        // remove_action( 'woocommerce_add_to_cart', __FUNCTION__ );

        if ( isset( $_POST[ 'radio_free_product_gift' ] ) ) {
            $id_free_product_gift = $_POST[ 'radio_free_product_gift' ];

            unset( $_POST[ 'radio_free_product_gift' ] );

            $product = wc_get_product( $id_free_product_gift );

            $_SESSION[ 'free_product_gift' ] = true;
            $result = $woocommerce->cart->add_to_cart( $id_free_product_gift, 1 );
            $_SESSION[ 'free_product_gift' ] = false;

            if ( $result ) {
                wc_add_notice( '"'.$product->get_title().'" has been added as a gift to your cart.', 'success' );
            } else wc_add_notice( 'Error adding "'.$product->get_title().'" to your cart.', 'error' );

            // $_SESSION[ 'free_product_gift' ] = false;

        }

        return false;

        // }
    }

    // function set_free_gifts_products_visibility_none() {

    //     $free_products = wc_get_products( [
    //         'category' => 'Free Gifts',
    //     ] );

    //     FPG_Useful::log( 'products' );
    //     FPG_Useful::log( $free_products );

    //     foreach ( $free_products as $product ) {
    //         FPG_Useful::log( $product->get_id() );
    //         $product->set_catalog_visibility( 'hidden' );
    //         $product->save();
    //     }

    // }

    // function validate_not_a_free_product( $cart ) {

    //     FPG_Useful::log( 'validate_not_a_free_product' );

    //     // $cart->remove_cart_item( $free_in_cart );
    // remove free product

    //     return false;
    // }

    // function remove_all_quantity_fields_for_free_gifts( $return, $product ) {

    //     $id_product = $product->get_id();
    //     $terms = get_the_terms( $id_product, 'product_cat' );

    //     FPG_Useful::log( 'remove_all_quantity_fields_for_free_gifts' );
    //     // FPG_Useful::log( $terms );

    //     foreach ( $terms as $term ) {

    //         $product_cat = $term->name;

    //         if ( $product_cat == 'Free Gifts' ) {
    //                       return false;
    //         }

    //     }

    //     return true;
    //   }

    // function woocommerce_is_purchasable( $is_purchasable, $product ) {
    //     // if ( is_product() ) {
    //     $id_product = $product->get_id();
    //     $relation_product_gift = [ 14 => [ 16, 18 ], 2 => [ 3 ] ];

    //     // if ( array_key_exists( $id_product, $relation_product_gift ) ) {
    //     //     $is_purchasable = false;
    //     // }

    //     if ( $id_product == 16 )
    //     $is_purchasable = false;
    //     // }

    //     return $is_purchasable;

    // }

    //     add_filter( 'woocommerce_add_to_cart_validation', 'filter_wc_add_to_cart_validation', 10, 3 );

    //     function filter_wc_add_to_cart_validation( $passed, $product_id, $quantity ) {
    //         $is_virtual = $is_physical = false;
    //         $product = wc_get_product( $product_id );

    //         if ( $product->is_virtual() ) {
    //             $is_virtual = true;
    //         } else {
    //             $is_physical = true;
    //         }

    //         // Loop though cart items
    //         foreach ( WC()->cart->get_cart() as $cart_item ) {
    //             // Check for specific product categories
    //             if ( ( $cart_item[ 'data' ]->is_virtual() && $is_physical )
    //             || ( ! $cart_item[ 'data' ]->is_virtual() && $is_virtual ) ) {
    //                 wc_add_notice( __( "You can't combine physical and virtual products together.", 'woocommerce' ), 'error' );
    //                 return false;
    //             }
    //         }

    //         return $passed;
    //     }

    //     // For security: check cart items and avoid checkout
    //     add_action( 'woocommerce_check_cart_items', 'filter_wc_check_cart_items' );

    //     function filter_wc_check_cart_items() {
    //         $cart = WC()->cart;
    //         $cart_items = $cart->get_cart();
    //         $has_virtual = $has_physical = false;

    //         // Loop though cart items
    //         foreach ( WC()->cart->get_cart() as $cart_item ) {
    //             // Check for specific product categories
    //             if ( $cart_item[ 'data' ]->is_virtual() ) {
    //                 $has_virtual = true;
    //             } else {
    //                 $has_physical = true;
    //             }
    //         }

    //         if ( $has_virtual && $has_physical ) {
    //             // Display an error notice ( and avoid checkout )
    //             wc_add_notice( __( "You can't combine physical and virtual products together.", 'woocommerce' ), 'error' );
    //         }
    //     }

    //     add_action( 'woocommerce_after_shop_loop_item', 'hide_add_to_cart_for_specific_product', 10 );
    // function hide_add_to_cart_for_specific_product() {
    //     global $product;
    //     if ( 25 == $product->get_id() ) {
    //         remove_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_loop_add_to_cart' );
    //         remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_add_to_cart', 30 );
    //     }
    // }

}
