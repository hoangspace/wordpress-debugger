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
            'loggers' => array(),
            'themedebug' => false,
            'databasedebug' => false
        );
    }
        
    // admin area
    function wpdebugger_settings(){
        require_once(plugin_dir_path(__FILE__).'wpdebugger-settings.php');
    }
    function wpdebugger_plugin_setup_menu(){
        add_menu_page( 'Wordpress Debugger settings', 'wpdebugger', 'manage_options', 'wpdebugger', 'wpdebugger_settings' );
    }
    if (is_admin()){
        add_action('admin_menu', 'wpdebugger_plugin_setup_menu');
    }
    
    require_once(plugin_dir_path(__FILE__).'class.logger.php');
    
    foreach ($options['loggers'] as $logid){        
        $logger = new Logger($logid);
        $logger->init();
    }
    
    

?>