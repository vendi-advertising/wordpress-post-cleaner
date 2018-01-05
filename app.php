<?php

define( 'VENDI_LCT_FILE', __FILE__ );
define( 'VENDI_LCT_PATH', dirname( __FILE__ ) );

require_once VENDI_LCT_PATH . '/vendor/autoload.php';


WP_CLI::add_command( 'lct',        \Vendi\LCT\cleaner::class );
