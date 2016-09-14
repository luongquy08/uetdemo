<?php
defined( 'ABSPATH' ) or die( 'Cheatin\' uh?' );

define( 'WP_ROCKET_ADVANCED_CACHE', true );
$rocket_cache_path = 'E:\xampp\htdocs\uet-demo/wp-content/cache/wp-rocket/';
$rocket_config_path = 'E:\xampp\htdocs\uet-demo/wp-content/wp-rocket-config/';

if ( file_exists( 'E:\xampp\htdocs\uet-demo\wp-content\plugins\wp-rocket\inc\front/process.php' ) ) {
	include( 'E:\xampp\htdocs\uet-demo\wp-content\plugins\wp-rocket\inc\front/process.php' );
} else {
	define( 'WP_ROCKET_ADVANCED_CACHE_PROBLEM', true );
}