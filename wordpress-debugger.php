<?php 
    /*
    Plugin Name: Wordpress Debugger
    Plugin URI: https://hoang.onthewifi.com/wplugins/wordpress-debugger
    Description: Plugin for Debugging in Wordpress
    Author: Hoang Bui
    Version: 1.0
    Author URI: https://hoang.onthewifi.com
    */
        
    $options = get_option('wpdebugger_config', null);
    
    if (!$options){
        $options = array(
            'enablelogger' => false,
            'loggers' => array(),
            'themedebug' => false,
            'databasedebug' => false
        );
    }
    
    if ($options['databasedebug']){
        define( 'SAVEQUERIES', true );
        
        function print_save_queries(){
            if ( current_user_can( 'administrator' ) ) {
                global $wpdb;
                echo "<pre>";
                print_r( $wpdb->queries );
                echo "</pre>";
            }
        }
        add_action( 'wp_footer', 'print_save_queries' );
    }
    
    // admin area
    if (is_admin()){
        function wpdebugger_settings(){
            require_once(plugin_dir_path(__FILE__).'wpdebugger-settings.php');
        }
        function wpdebugger_plugin_setup_menu(){
            add_menu_page( 'Wordpress Debugger settings', 'WP Debugger', 'manage_options', 'wpdebugger', 'wpdebugger_settings' );
        }
        add_action('admin_menu', 'wpdebugger_plugin_setup_menu');
    }
    
    if ($options['enablelogger']){
        require_once(plugin_dir_path(__FILE__).'class.logger.php');
    
        foreach ($options['loggers'] as $logid){        
            $logger = new Logger($logid);
            $logger->init();
        }
    }
    

?>