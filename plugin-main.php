<?php
/*
Plugin Name: WP Expand tabs Free
Plugin URI: http://wpexpand.com/wp-expand-tabs
Description: This plugin will enable tabs features in your wordpress site. 
Author: Rasel Ahmed
Author URI: http://wpexpand.com
Version: 1.0
*/


function tr_easy_tabs_pro_jquery() {
	wp_enqueue_script('jquery');
}
add_action('init', 'tr_easy_tabs_pro_jquery');

define('TR_EASY_TABS_PRO', WP_PLUGIN_URL . '/' . plugin_basename( dirname(__FILE__) ) . '/' );


function tr_easy_tabs_files() {
wp_enqueue_script('tr-easy-tabs-pro-main-js', TR_EASY_TABS_PRO.'js/jquery.pwstabs-1.1.3.min.js', array('jquery'), 1.0, true);
wp_enqueue_style('tr-easy-tabs-pro-main-css', TR_EASY_TABS_PRO.'css/jquery.pwstabs.css');
}
add_action( 'wp_enqueue_scripts', 'tr_easy_tabs_files' );

function tr_easy_tabs_pro_wrapper( $atts, $content = null  ) {

	extract( shortcode_atts( array(
		'id' => '',
		'background' => '#46B3E6',
		'color' => '#fff',
		'border' => '#f1f1f1',
		'effect' => 'scale',
		'open' => 1,
		'width' => '100%',
		'position' => 'horizontal',
		'hposition' => 'top',
		'vposition' => 'left',
		'rtl' => 'false',
	), $atts ) );

	return '
        <script>
            jQuery(document).ready(function($){
                $("#tr-easy-tabs-wrapper'.$id.' .tr-easy-tabs-activate").pwstabs({
                    effect: "'.$effect.'", 
                    defaultTab: '.$open.',    
                    containerWidth: "'.$width.'",
                    tabsPosition: "'.$position.'",   
                    horizontalPosition: "'.$hposition.'",
                    verticalPosition: "'.$vposition.'",     
                    rtl: '.$rtl.' 
                });
            });
        </script>
        <style>
            #tr-easy-tabs-wrapper'.$id.' div.pws_tabs_container ul.pws_tabs_controll li a:before, #tr-easy-tabs-wrapper'.$id.' div.pws_tabs_container ul.pws_tabs_controll li a {background-color:'.$background.'}
            #tr-easy-tabs-wrapper'.$id.' div.pws_tabs_container ul.pws_tabs_controll li a.pws_tab_active:before, #tr-easy-tabs-wrapper'.$id.' div.pws_tabs_container ul.pws_tabs_controll li a.pws_tab_active {background-color:#fff;color:#333}
            #tr-easy-tabs-wrapper'.$id.' div.pws_tabs_container ul.pws_tabs_controll li a {color:'.$color.'}
            #tr-easy-tabs-wrapper'.$id.' div.pws_tabs_container ul.pws_tabs_controll li a.pws_tab_active, #tr-easy-tabs-wrapper'.$id.' div.pws_tabs_list {border-color:'.$border.'}
        </style>
        <div id="tr-easy-tabs-wrapper'.$id.'" class="tr-easy-tabs-wrapper">
        <div class="tr-easy-tabs-activate">
            '.do_shortcode($content).'
        </div>
        </div>
    ';
}	
add_shortcode('tr_tabs', 'tr_easy_tabs_pro_wrapper');


function tr_easy_tabs_pro_items( $atts, $content = null  ) {

	extract( shortcode_atts( array(
		'id' => '',
		'title' => ''
	), $atts ) );

	return '
  <div data-pws-tab="tab'.$id.'" data-pws-tab-name="'.$title.'">
    '.do_shortcode($content).'
  </div>    
    ';
}	
add_shortcode('ir_item', 'tr_easy_tabs_pro_items');



// Registering Custom post
add_action( 'init', 'tr_easy_tabs_pro_create_custom_post' );
function tr_easy_tabs_pro_create_custom_post() {
	register_post_type( 'tr-tabs-pro',
		array(
			'labels' => array(
				'name' => __( 'Tabs' ),
				'singular_name' => __( 'Tab' ),
				'add_new_item' => __( 'Add New Tab' )
			),
            'public' => true,
            'menu_icon' => 'dashicons-exerpt-view',
			'supports' => array('title', 'editor', 'page-attributes'),
		)
	);
	
}

function tr_easy_tabs_pro_custom_post_taxonomy() {
	register_taxonomy(
		'tab_pro_cat',  
		'tr-tabs-pro',                  
		array(
			'hierarchical'          => true,
			'label'                 => 'Tabs Category',  
			'query_var'             => true,
			'show_admin_column'     => true,
			'rewrite'               => array(
				'slug'              => 'tabs-category', 
				'with_front'    => true 
				)
			)
	);
}
add_action( 'init', 'tr_easy_tabs_pro_custom_post_taxonomy');   


function tr_easy_tabs_pro_items_shortcode($atts){
	extract( shortcode_atts( array(
		'id' => '01',		
		'items' => '5',		
		'category' => '',
		'background' => '#46B3E6',
		'color' => '#fff',
		'border' => '#f1f1f1',
		'effect' => 'scale',
		'open' => 1,
		'width' => '100%',
		'position' => 'horizontal',
		'hposition' => 'top',
		'vposition' => 'left',
		'rtl' => 'false',        
	), $atts) );
	
    $q = new WP_Query(
        array('posts_per_page' => $items, 'post_type' => 'tr-tabs-pro', 'tab_pro_cat' => $category, 'orderby' => 'menu_order', 'order' => 'ASC')
        );	

			
	$list = '
        <script>
            jQuery(document).ready(function($){
                $("#tr-easy-tabs-wrapper'.$id.' .tr-easy-tabs-activate").pwstabs({
                    effect: "'.$effect.'", 
                    defaultTab: '.$open.',    
                    containerWidth: "'.$width.'",
                    tabsPosition: "'.$position.'",   
                    horizontalPosition: "'.$hposition.'",
                    verticalPosition: "'.$vposition.'",     
                    rtl: '.$rtl.' 
                });
            });
        </script>  
        <style>
            #tr-easy-tabs-wrapper'.$id.' div.pws_tabs_container ul.pws_tabs_controll li a:before, #tr-easy-tabs-wrapper'.$id.' div.pws_tabs_container ul.pws_tabs_controll li a {background-color:'.$background.'}
            #tr-easy-tabs-wrapper'.$id.' div.pws_tabs_container ul.pws_tabs_controll li a.pws_tab_active:before, #tr-easy-tabs-wrapper'.$id.' div.pws_tabs_container ul.pws_tabs_controll li a.pws_tab_active {background-color:#fff;color:#333}
            #tr-easy-tabs-wrapper'.$id.' div.pws_tabs_container ul.pws_tabs_controll li a {color:'.$color.'}
            #tr-easy-tabs-wrapper'.$id.' div.pws_tabs_container ul.pws_tabs_controll li a.pws_tab_active, #tr-easy-tabs-wrapper'.$id.' div.pws_tabs_list {border-color:'.$border.'}
        </style>        
	
		<div id="tr-easy-tabs-wrapper'.$id.'" class="tr-easy-tabs-wrapper">
        <div class="tr-easy-tabs-activate">
	';
	while($q->have_posts()) : $q->the_post();
		$idd = get_the_ID();
		$content_main = do_shortcode(get_the_content());
		$content_autop = wpautop(trim($content_main));
		

		
		$list .= '
          <div data-pws-tab="tab'.$idd.'" data-pws-tab-name="' .do_shortcode( get_the_title() ). '">
            ' .do_shortcode( $content_autop ). '
          </div>  
		'; 		

 		
	endwhile;
	$list.= '</div></div>';
	
	
	wp_reset_query();
	return $list;
}
add_shortcode('tabs', 'tr_easy_tabs_pro_items_shortcode');	



function tretf_add_mce_button() {
	if ( !current_user_can( 'edit_posts' ) && !current_user_can( 'edit_pages' ) ) {
		return;
	}
	if ( 'true' == get_user_option( 'rich_editing' ) ) {
		add_filter( 'mce_external_plugins', 'tretf_add_tinymce_plugin' );
		add_filter( 'mce_buttons', 'tretf_register_mce_button' );
	}
}
add_action('admin_head', 'tretf_add_mce_button');

function tretf_add_tinymce_plugin( $plugin_array ) {
	$plugin_array['tretf_mce_button'] = plugin_dir_url( __FILE__ ) .'/js/tretf-mce-button.js';
	return $plugin_array;
}

function tretf_register_mce_button( $buttons ) {
	array_push( $buttons, 'tretf_mce_button' );
	return $buttons;
}


function add_expandtfree_options_framwrork()  
{  
	add_options_page('Expand tabs pro', '', 'manage_options', 'expandt-settings','expandt_options_framwrork');  
}  
add_action('admin_menu', 'add_expandtfree_options_framwrork');


if ( is_admin() ) : // Load only if we are viewing an admin page



// Function to generate options page
function expandt_options_framwrork() {
?>


	
<div class="wrap">
	<style type="text/css">
		.welcome-panel-column p{padding-right:20px}
		.installing_message h2{background: none repeat scroll 0 0 green;
color: #fff;
line-height: 30px;
padding: 20px;
text-align: center;}
	</style>
	<div class="installing_message">
		<h2>Thank you for installing our free plugin</h2>
	</div>
	

	<div class="welcome-panel" id="welcome-panel">
		
		<div class="welcome-panel-content">
			<h3>Want some cool features of this plugin?</h3>
			<p class="about-description">We've added more extra features in our premium version of this plugin. Let see some amazing features.</p>
	<div class="welcome-panel-column-container">
		<div class="welcome-panel-column">
			<h4>Tab Category Support</h4>
			<p>Using premium version, you can work with tab categories. You can add multiple category & you can embed that easily. </p>
			<a href="http://demos.wpexpand.com/?theme=Expand%20Tabs%20Pro" target="_blank" class="button button-primary">See demo here</a>
		</div>
		
		<div class="welcome-panel-column">
			<h4>Tabs form other custom post</h4>
			<p>Do you have exiting custom post type & you want to embed tab form that? Yes, you can do that via premium version</p>
			<a href="http://demos.wpexpand.com/?theme=Expand%20Tabs%20Pro" target="_blank" class="button button-primary">See demo here</a>
		</div>
		
		<div class="welcome-panel-column welcome-panel-last">
			<h4>Multiple tabs in a page</h4>
			<p>Using premium version, you can embed multiple tab in one page as your needs, You just have to use multiple shortcode in one page.</p>
			<a href="http://demos.wpexpand.com/?theme=Expand%20Tabs%20Pro" target="_blank" class="button button-primary">See demo here</a>
		</div>
	</div>
	

	<br/><br/>
		<h3>Cool! you are ready to enable those features in only $5. </h3>
		<p class="about-description">Watch demo before purchase. I know you like the demos. Thanks for reading features. Good luck with creating tabs in your wordpress site.</p>

		<a href="http://www.wpexpand.com/item/expand-tabs-pro/" class="button button-primary button-hero">Purchase premium plugin now. Only $5</a><br/><br/>
	
	
		</div>
	</div>


</div>
	


	<?php
}



endif;  // EndIf is_admin()


register_activation_hook(__FILE__, 'my_plugin_activate');
add_action('admin_init', 'my_plugin_redirect');

function my_plugin_activate() {
    add_option('my_plugin_do_activation_redirect', true);
}

function my_plugin_redirect() {
    if (get_option('my_plugin_do_activation_redirect', false)) {
        delete_option('my_plugin_do_activation_redirect');
        if(!isset($_GET['activate-multi']))
        {
            wp_redirect("options-general.php?page=expandt-settings");
        }
    }
}


?>