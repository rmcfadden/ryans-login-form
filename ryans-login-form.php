<?php
/*
* Plugin Name: Ryan's Login Form
* Plugin URI: https://github.com/rmcfadden/ryans-login-form
* Description: Add a popup login form to your wordpress site.
* Version: 1.0
* Author: Ryan McFadden
* Author URI: https://github.com/rmcfadden
* License: GPLv2
*/

add_action('plugins_loaded', array( 'ryansLoginForm', 'load' ));
register_activation_hook(__FILE__, array('ryansLoginForm',  'activation' ));

// TODO: shortcodes with parameters
class ryansLoginForm {

    private $options;
    private static $page_name = 'ryans_login_form';
    private static $options_name = 'ryans_login_form_options';

    public static function load() {
        $class = __CLASS__;
        new $class;
    }

    public static function activation() {
        $new_options = array(
            'paypal_id' => -1,
            'amount_description' => __('Please enter payment amount and click the button below:')
        );

        if ( get_option(ryansLoginForm::$options_name ) !== false ) {
            update_option(ryansLoginForm::$options_name, $new_options );
        } 
        else{
            add_option(ryansLoginForm::$options_name, $new_options );
        }
    }


    public function __construct() { 
        add_shortcode( 'ryans_login_form', array( $this, 'shortcode' )); 
        add_action('admin_menu', array( $this, 'admin_option_init'));
        add_action('admin_init', array( $this, 'admin_init' ));
        add_action('init', array( $this, 'init' ));        
    }


    public function read_login_form_code(){
        ob_start();

        require(plugin_dir_url(__FILE__) . 'login-form.js');

        $output_text = ob_get_contents();

        ob_end_clean();

        return $output_text;
    }


    public function shortcode() {
        $options = get_option( ryansLoginForm::$options_name );

        $contents = read_login_form_code();       

        return $contents;
    }


    public function init() {
        wp_enqueue_script('ryans-login-form', plugin_dir_url(__FILE__) . 'ryans-login-form.js', array('jquery')); 
        wp_enqueue_style( 'ryans-login-form', plugin_dir_url(__FILE__) . 'ryans-login-form.css' );

        wp_localize_script('ryans-login-form', 'login_object', array( 
            'url' => admin_url( 'admin-ajax.php' ),
            'redirecturl' => 'members',
            'loadingmessage' => __('Signing in...')
        ));
    }


    public function admin_option_init() {
        add_options_page('Ryan\'s Login Form','Ryan\'s Login Form', 'manage_options', ryansLoginForm::$page_name, array( $this, 'admin_options_page' ));
    }


    public function admin_options_page() {
        $this->options = get_option( ryansLoginForm::$options_name );

        ?>
        <div class="wrap">
            <h2>Ryan's Login Form</h2>           
            <form method="post" action="options.php">
            <?php
                settings_fields(ryansLoginForm::$options_name );   
                do_settings_sections( ryansLoginForm::$page_name );
                submit_button(); 
            ?>
            </form>
        </div>
        <?php
    }


    public function admin_init() {

        //wp_enqueue_script('ryans-login-form-admin.js', plugin_dir_url(__FILE__) . 'ryans-login-form-admin.js', array('jquery'));
        wp_enqueue_script('ryans-login-form.js', plugin_dir_url(__FILE__) . 'ryans-login-form.js', array('jquery')); 

        register_setting(
            ryansLoginForm::$options_name,
            ryansLoginForm::$options_name,
            array( $this, 'sanitize' )
        );

        $section_name = ryansLoginForm::$options_name + '_section';

        /*
        add_settings_section(
            $section_name,
            __('Change your settings below.  Don\'t forget to hit \'Save Changes!\' to apply!'),
            array($this, 'options_callback'),
            ryansLoginForm::$page_name
        );

        add_settings_field(
            'paypal_id', 
            __('PayPal id/Email:'), 
            array($this,'paypal_id_callback'), 
            ryansLoginForm::$page_name, 
            $section_name,
            array( 'label_for' => 'paypal_id' )
        );*/
    }


    /*
    function paypal_id_callback() {
        $options = get_option(ryansLoginForm::$options_name);
        $current_options_name = ryansLoginForm::$options_name;

	    echo "<input class='regular-text ltr' name='{$current_options_name}[paypal_id]' id='paypal_id'  value='{$options['paypal_id']}'/>";
    }*/

    function options_callback() {
    }


    public function sanitize( $input ){
        return $input;
    }
}
?>