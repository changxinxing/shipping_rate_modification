<?php 

add_action( 'wp_enqueue_scripts', 'my_enqueue_assets' ); 

function my_enqueue_assets() { 

    wp_enqueue_style( 'parent-style', get_template_directory_uri().'/style.css' ); 

}

function rename_project_cpt() {

register_post_type( 'project',
	array(
	'labels' => array(
	'name'          => __( 'Video Resources', 'divi' ), // change the text portfolio to anything you like
	'singular_name' => __( 'Video Resource', 'divi' ), // change the text portfolio to anything you like
	),
	'has_archive'  => true,
	'hierarchical' => false,
    'menu_icon'    => 'dashicons-video-alt3',  // you choose your own dashicon
	'public'       => true,
	
	'rewrite'      => array( 'slug' => 'video-resources', 'with_front' => false ), // change the text portfolio to anything you like
  'supports'     => array( 'page-attributes' ),
         
));
    }
 
add_action( 'init', 'rename_project_cpt' );

// Update WooCommerce Flexslider options

add_filter( 'woocommerce_single_product_carousel_options', 'ud_update_woo_flexslider_options' );

function ud_update_woo_flexslider_options( $options ) {

    $options['directionNav'] = true;

    return $options;
}

add_filter('woocommerce_single_product_image_thumbnail_html','wc_remove_link_on_thumbnails' );
 
function wc_remove_link_on_thumbnails( $html ) {
     return strip_tags( $html,'<div><img>' );
}

add_action('the_content', 'dbvideo_html_without_youtube_related_videos', 100);

if (!function_exists('dbvideo_html_without_youtube_related_videos')) {
	function dbvideo_html_without_youtube_related_videos($old_content) {
		$regex = preg_quote('https://www.youtube.com/embed/', '/').'[a-z0-9_-]+'.preg_quote('?feature=oembed', '/');
		$new_content = preg_replace_callback("/$regex/i", 'dbvideo_url_without_youtube_related_videos', $old_content);
		return apply_filters('dbvideo_html_without_youtube_related_videos', $new_content, $old_content);
	}
}

if (!function_exists('dbvideo_url_without_youtube_related_videos')) {
	function dbvideo_url_without_youtube_related_videos($match) {
		$old_url = isset($match[0])?$match[0]:'';
		$new_url = add_query_arg('rel', '0', $old_url);
		return apply_filters('dbvideo_url_without_youtube_related_videos', $new_url, $match);
	}
}

add_filter( 'woocommerce_continue_shopping_redirect', 'st_change_continue_shopping' );
/**
 * WooCommerce
 * Change continue shopping URL
 */
function st_change_continue_shopping() {
   return wc_get_page_permalink( 'shop' ); // Change link
}

add_filter('woocommerce_billing_fields', 'custom_billing_fields', 1000, 1);
function custom_billing_fields( $fields ) {
    $fields['billing_company']['required'] = false;
	$fields['shipping_company']['required'] = false;
    return $fields;
}

/* COUPON CODE REMOVES FREE SHIPPING */

add_filter( 'woocommerce_package_rates', 'coupons_removes_free_shipping', 10, 2 );
function coupons_removes_free_shipping( $rates, $package ){
    require_once( ABSPATH . 'wp-admin/includes/plugin.php' );
    activate_plugin("/wp-content/plugins/ph-show-hide-woocommerce-shipping-methods/xa-msm-show-hide-shipping-methods.php");
    if ( is_admin() && ! defined( 'DOING_AJAX' ) )
        return $rates;

    $applied_coupons = WC()->cart->get_applied_coupons();
    $coupons_array = 
    ["samsung-3186704",
    "samsung-1637522",
    "samsung-1638427",
    "samsung-3160663",
    "samsung-3184792",
    "samsung-3185587",
    "samsung-3185598",
    "samsung-3186707",
    "samsung-3192060", 
    "samsung-3286118", 
    "samsung-3866645", 
    "samsung-3866646",
    "samsung-4302269", 
    "samsung-4323410", 
    "samsung-6192464", 
    "samsung-6197753", 
    "samsung-7373713", 
    "samsung-8204880", 
    "samsung-bfsc043", 
    "samsung-bfsc160", 
    "samsung-bfsc417",
    "samsung-bfsc428", 
    "samsung-bfsc429", 
    "samsung-bfsc430",
    "samsung-bfsc431",
    "samsung-bfsc432",
    "samsung-bfsc445",
    "samsung-bfsc501",
    "samsung-bfsc555", 
    "samsung-bfsc613", 
    "samsung-bfsc673",
    "samsung-bfsc674",
    "samsung-bfsc747", 
    "samsung-bfsc797", 
    "samsung-bfsca54",
    "samsung-bfscc01",
    "samsung-bfscc02", 
    "samsung-bfscc03", 
    "samsung-bfscc04", 
    "samsung-bfscc05", 
    "samsung-bfscc06",
    "samsung-bfscc13",
    "samsung-bfscc14", 
    "samsung-bfscc15", 
    "samsung-bfscc32",
    "samsung-bfscc33",
    "samsung-bfsct06", 
    "samsung-bfsct09"
];
    $sub_value = WC()->cart->subtotal;

    if( in_array($applied_coupons[0],$coupons_array)){        
        foreach ( $rates as $rate_key => $rate ){
            if( 'free_shipping' === $rate->method_id  ){
                require_once( ABSPATH . 'wp-admin/includes/plugin.php' );
                deactivate_plugins("/wp-content/plugins/ph-show-hide-woocommerce-shipping-methods/xa-msm-show-hide-shipping-methods.php");
                unset($rates[$rate_key]); 
            }
        }
    }
    else{
        if($sub_value<100){
            foreach ( $rates as $rate_key => $rate ){
                if( 'free_shipping' === $rate->method_id  ){
                    require_once( ABSPATH . 'wp-admin/includes/plugin.php' );
                    deactivate_plugins("/wp-content/plugins/ph-show-hide-woocommerce-shipping-methods/xa-msm-show-hide-shipping-methods.php");
                    unset($rates[$rate_key]); 
                }
            }
        }
    }
    return $rates;
}