<?php
/*
Plugin Name: WP Section Builder
Description: Section Builder Plugin
Version:     1.0.0.
Author:      Igor Benić
Author URI:  http://www.lakotuts.com
License:     GPL2
License URI: https://www.gnu.org/licenses/gpl-2.0.html

*/



function includeAll($path, $search){
   
   foreach (glob($path.$search) as $file) {
   		
   		include_once $file;
   		$info = pathinfo($file);
   		$fileName = $info["filename"];
   		$filePath = $path.'/'.$fileName;
   		if(is_dir($filePath) && is_readable($filePath)){
   			includeAll($filePath, $search);
   		}
   }


}

$path = plugin_dir_path( __FILE__ ) . 'inc';
$search = "/*.php";

includeAll($path, $search);

$slug = "homesection";
$name = "Home Section";
$singular = "Home Section";
$plural = "Home Sections";
$homeSection = new HomeSection($slug, $name, $singular, $plural);