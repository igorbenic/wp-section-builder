<?php
Namespace SectionBuilder;
use SectionBuilder\Builder;
use SectionBuilder\SectionBuilder;
use SectionBuilder\Metabox\DefaultMetaBox;


abstract class Section implements SectionBuilder {
	/**
	 * 
	 * @var String
	 */
	protected $slug;

    /**
	 * Section Name
	 * @var String
	 */
	protected $name;

    /**
	 * Section Name Singular
	 * @var String
	 */
	protected $singular;

    /**
	 * Section Name Plural
	 * @var String
	 */
	protected $plural;
    
    /**
	 * Text domain
	 * @var String
	 */
	protected $textdomain;
    
    /**
	 * Section Labels
	 * @var Array
	 */
	protected $labels;

    /**
	 * Section Arguments
	 * @var Array
	 */
	protected $arguments;

    /**
     * Builder holder
     * @var Object
     */
    public $builder;

    /**
     * Default Meta box Object
     * @var Object
     */
    public $defaultMetaBox;


	/**
	 * Setting the labels array
	 */
	public function setLabels(){
      $this->labels = array(
      		'name'               => _x( $this->name, 'post type general name', $this->textdomain ),
			'singular_name'      => _x( $this->singular, 'post type singular name', $this->textdomain ),
			'menu_name'          => _x( $this->plural, 'admin menu', $this->textdomain ),
			'name_admin_bar'     => _x( $this->singular, 'add new on admin bar', $this->textdomain ),
			'add_new'            => _x( 'Add New', $this->singular, $this->textdomain ),
			'add_new_item'       => __( 'Add New '.$this->singular, $this->textdomain ),
			'new_item'           => __( 'New '.$this->singular, $this->textdomain ),
			'edit_item'          => __( 'Edit '.$this->singular, $this->textdomain ),
			'view_item'          => __( 'View '.$this->singular, $this->textdomain ),
			'all_items'          => __( 'All '.$this->plural, $this->textdomain ),
			'search_items'       => __( 'Search '.$this->plural, $this->textdomain ),
			'parent_item_colon'  => __( 'Parent '.$this->plural, $this->textdomain ),
			'not_found'          => __( 'No '.$this->plural.' found.', $this->textdomain ),
			'not_found_in_trash' => __( 'No '.$this->plural.' found in Trash.', $this->textdomain )
      );
	}
    
    /**
     * Set the slug
     * @param string $newSlug the new slug
     */
    public function setSlug($newSlug){
    	$this->slug = $newSlug;
    }

    /**
     * Get the slug
     */
    public function getSlug(){
    	return $this->slug;
    }

    /**
	 * Getting the labels array
	 */
	public function getLabels(){
		return $this->labels;
	}

	/**
	 *  Getting the post type
	 */
	public function getPostType(){
		return $this->slug;
	}

	/**
	 *  Getting the text domain
	 */
	public function getTextDomain(){
		return $this->textdomain;
	}
    

    
    /**
	 * Setting the arguments array
	 */
	public function setArguments($arrayToMerge){
		$defaultArray = array(
      		'labels'             => $this->getLabels(),
            'description'        => __( 'Description.', $this->textdomain ),
		    'public'             => true,
		    'publicly_queryable' => true,
		    'show_ui'            => true,
		    'show_in_menu'       => true,
		    'query_var'          => true,
		    'rewrite'            => array( 'slug' => $this->getSlug() ),
		    'capability_type'    => 'post',
		    'has_archive'        => true,
		    'hierarchical'       => false,
		    'menu_position'      => null,
		    'supports'           => array( 'title', 'editor', 'author', 'thumbnail', 'excerpt', 'comments' )
        );

        //Merge the default with a new array to change values
        $this->arguments = array_merge($defaultArray, $arrayToMerge);
	}

    /**
	 * Getting the arguments array
	 */
	public function getArguments(){
		
		return $this->arguments;
	}

	/**
	 *  Creating the section. After registering the post type we enqueue the builders` style and also add the builder output to the conten
	 */
	public function createSection(){

		register_post_type( $this->getPostType(), $this->getArguments() );
        
       

		add_action( 'wp_enqueue_scripts', array($this->builder, 'builderStyle') );

		add_filter( 'the_content', array($this->builder, 'constructBuilder') );

		

		
	}
    /**
     * Constructor
     * @param string  $slug                  The slug, used also as post_type
     * @param string  $name                  Name of the section
     * @param string  $singular              Singular name
     * @param string  $plural                Plural name
     * @param Builder $builder               A new Builder
     * @param string  $textdomain            Textdomain for the section
     * @param array   $additional_parameters Additinal parameters that can be set to override the defaults
     */
	public function __construct($slug, $name, $singular, $plural, Builder $builder,  $textdomain = "", $additional_parameters = array()){

		$this->setSlug($slug);

		$this->name = $name;

		$this->singular = $singular;

		$this->plural = $plural;

		$this->builder = $builder;

		$this->createDefaultMetaBox();

		$this->builder->post_type = $slug;

        $this->builder->meta_key = $this->defaultMetaBox->key;

		if( "" != $textdomain ){

	        $this->textdomain = $textdomain;

		} else {

            $this->textdomain = $slug;

		}

		$this->setLabels();

		$this->setArguments($additional_parameters);

		add_action('init', array(&$this, 'createSection'));
		

	}

    /**
     * Creating the default metabox and storing it in a variable
     * TODO: More Flexibility | Setting it at the instantation of Section
     */
	public function createDefaultMetaBox(){

		$this->defaultMetaBox = new DefaultMetaBox( "sb_pageID", "Default MetaBox", $this , "Default Metabox");


	}


}