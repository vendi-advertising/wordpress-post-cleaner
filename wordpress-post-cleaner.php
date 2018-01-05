<?php
/*
Plugin Name: WordPress Post Cleaner CLI
Description: WP-CLI command for cleaning posts of ugly HTML/CSS.
Plugin URI: https://www.vendiadvertising.com/
Author: Vendi Advertising
Version: 1.1.0
Author URI: https://www.vendiadvertising.com/
*/

define( 'VENDI_WORDPRESS_POST_CLEANER_FILE', __FILE__ );
define( 'VENDI_WORDPRESS_POST_CLEANER_PATH', dirname( __FILE__ ) );

if (! defined('WP_CLI')) {
    //Not in CLI, nothing to do.
    return;
}

require_once VENDI_WORDPRESS_POST_CLEANER_PATH . '/includes/autoload.php';

WP_CLI::add_command( 'vendi-post-cleaner',        \Vendi\WordPressPostCleaner\cleaner::class );
