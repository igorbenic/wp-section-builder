<?php 

Namespace Metabox;
use SectionBuilder\SectionBuilder;
/** 
 * Metabox Class.
 */
abstract class MetaBox {
    
    private $name = "";

    private $description = "";

    private $textdomain = "";

    private $post_type = "";

    private $position = "high";

    private $type = "advanced";

	/**
	 * Hook into the appropriate actions when the class is constructed.
	 */
	public function __construct($name, SectionBuilder $post, $description, $position = "high", $type= "advanced") {

		if ( is_admin() ) {
		    add_action( 'load-post.php',     array(&$this, 'startMetaBox') );
		    add_action( 'load-post-new.php', array(&$this, 'startMetaBox') );

		    $this->name = $name;

			$this->post_type = $post->getPostType();

			$this->position = $position;

			$this->type = $type;

			$this->description = $description;

			$this->textdomain = $post->getTextDomain();
		}


		

		
	}

	public function startMetaBox(){
		add_action( 'add_meta_boxes', array( $this, 'add_meta_box' ) );
		add_action( 'save_post', array( $this, 'save' ) );
	}



	/**
	 * Adds the meta box container.
	 */
	public function add_meta_box( ) {
           
		        add_meta_box(
			        $this->name
			        ,__( $this->description, $this->textdomain )
			        ,array( $this, 'render_meta_box_content' )
			        ,$this->post_type
			        ,$this->type
			        ,$this->position
		        );
            
	}

	/**
	 * Save the meta when the post is saved.
	 *
	 * @param int $post_id The ID of the post being saved.
	 */
	public function save( $post_id ) {
	
		 
	}


	/**
	 * Render Meta Box content.
	 *
	 * @param WP_Post $post The post object.
	 */
	public function render_meta_box_content( $post ) {
	
		
		
	}
}