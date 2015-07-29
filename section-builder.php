<?php 
/*
* Plugin Name:        Section Builder
 * Plugin URI:        http://example.com/plugin-name-uri/
 * Description:       Section builder PHP.
 * Version:           1.0.0
 * Author:            Igor Benić
 * Author URI:        http://www.lakotuts.com/
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       section-builder

 */


defined( 'ABSPATH' ) or die( 'No script kiddies please!' );


class SectionBuilderStarter {

    /**
     * Plugin Version
     * @var string
     */
	private $version = "1.0.0";
    
    /**
     * Plugin Name
     * @var string
     */
    private $name = "Section Builder";


	/**
	 * Include folder
	 * @var string
	 */
    private $incFolder = "inc";

    /**
     * Magic Constructor
     */
    public function __construct(){

        $dir = plugin_dir_path( __FILE__ );

    	$this->includeAll($dir.$this->incFolder.'/','*.php');
    }

    /**
     * Include all files in the include folder
     * @param  string $path Path to search
     */
    private function includeAll( $path, $search ){

    	foreach ( glob( $path . $search ) as $file ) {
		        
		    	include_once $file;

		    	$fileParts = pathinfo($file);

		    	$fileFolder = $fileParts["filename"];

		    	if(is_dir($path . $fileFolder) && is_readable($path . $fileFolder)){

		    		foreach ( glob( $path . $fileFolder . "/" . $search ) as $otherFile ) { 

		    				include_once $otherFile;
		    		}

		    	}

		    
		}
    }
}

$newSectionBuilder = new SectionBuilderStarter();

$homeSection = new HomeSection("homesection", "Home Section", "Home Section", "Home Sections", new HomeBootstrap());


//$homeMetaBox = new HomeMetaBox("home_meta_box", $homeSection, "SideBar Content", "high", "advanced" );
//



/*function add_to_footer_of_content($content) {

	global $post;

	
	$builder = new HomeBootstrap($post->ID);

    $content .= $builder->appendSections($content);

    return $content;
}

add_filter( 'the_content', 'add_to_footer_of_content' );*/


