<?php

define( 'VENDI_LCT_FILE', __FILE__ );
define( 'VENDI_LCT_PATH', dirname( __FILE__ ) );

require_once VENDI_LCT_PATH . '/vendor/autoload.php';

//This is required to get our custom wp-config.php to load. WordPress requires
//that file to live at one of two magic locations
file_put_contents(
                    VENDI_LCT_PATH . '/vendor/johnpbloch/wordpress-core/wp-config.php',
                    "<?php

                    require_once VENDI_LCT_PATH . '/wp-config.php';

                    //DO NOT REMOVE, this code is parsed by regex in wp-cli!!
                    /*
                    require_once( ABSPATH . 'wp-settings.php' );
                    */
                    "
                );

WP_CLI::add_command( 'lct',        \Vendi\LCT\cleaner::class );
