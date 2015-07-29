<?php 

Namespace SectionBuilder;
use SectionBuilder\SectionBuilder;

/** 
 * Metabox Abstract Class.
 */
abstract class MetaBox {
    
    /**
     * Name of the metabox
     * @var string
     */
    protected $name = "";

    /**
     * Slug of the metabox. Can be used as ID.
     * @var string
     */
    protected $slug = "";

    /**
     * Description of the metabox
     * @var string
     */
    protected $description = "";

    /**
     * Textdomain of the metabox
     * @var string
     */
    protected $textdomain = "";

    /**
     * Post type slug
     * @var string
     */
    protected $post_type = "";

    /**
     * Position of the metabox
     * @var string
     */
    protected $position = "high";

    /**
     * Type of the metabox
     * @var string
     */
    protected $type = "advanced";

    /**
     * Meta Key
     * @var string
     */
    public $key = "";

	/**
	 * Hook into the appropriate actions when the class is constructed.
	 */
	public function __construct( $slug, $name, SectionBuilder $post, $description, $position = "high", $type= "advanced") {

		

			$this->name = $name;

		    $this->slug = $slug;

		    $this->key = "sb_".$slug."_metabox_value";

			$this->post_type = $post->getPostType();

			$this->position = $position;

			$this->type = $type;

			$this->description = $description;

			$this->textdomain = $post->getTextDomain();
        
        if ( is_admin() ) {

		    add_action( 'load-post.php',     array(&$this, 'startMetaBox') );
		    add_action( 'load-post-new.php', array(&$this, 'startMetaBox') );

		    
		}


		

		
	}

    /**
     * Start the metabox. Adds the metabox to the post/page and includes it in the save method which is called on save
     */
	public function startMetaBox(){
		add_action( 'add_meta_boxes', array( $this, 'add_meta_box' ) );
		add_action( 'save_post', array( $this, 'save' ) );
	}

    /**
     * Get the Slug
     * @return String The name of the slug. Used like an ID where needed.
     */
    public function getSlug(){
		return $this->slug;
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