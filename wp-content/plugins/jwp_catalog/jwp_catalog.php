<?php

/*
Plugin Name: JWP Catalog
Description: Каталог материалов JWP Catalog
Author: Eugene Jokerov
Version: 1.0 beta
Author URI: http://jokerov.com/
*/

if(!defined('JWP_CATALOG_PATH')) define('JWP_CATALOG_PATH', plugin_dir_path(__FILE__)); // путь к папке с плагином
if(!defined('JWP_CATALOG_URL')) define('JWP_CATALOG_URL', plugin_dir_url(__FILE__)); // URL папки плагина

require_once(ABSPATH . 'wp-includes/pluggable.php');
add_theme_support('post-thumbnails', array('post'));

if(isset($_GET['jwp_parser'])){
	include_once(JWP_CATALOG_PATH.'pq.php');
	include_once(JWP_CATALOG_PATH.'parser.php');
}


?>
