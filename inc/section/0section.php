<?php
Namespace SectionBuilder;
use SectionBuilder\SectionBuilder;
use SectionBuilder\Metabox\Metabox;
use SectionBuilder\Metabox\DefaultMetaBox\DefaultMetaBox;

abstract class Section implements SectionBuilder {
	/**
	 * Section slug
	 * @var String
	 */
	private $slug;

    /**
	 * Section Name
	 * @var String
	 */
	private $name;

    /**
	 * Section Name Singular
	 * @var String
	 */
	private $singular;

    /**
	 * Section Name Plural
	 * @var String
	 */
	private $plural;
    
    /**
	 * Text domain
	 * @var String
	 */
	private $textdomain;
    
    /**
	 * Section Labels
	 * @var Array
	 */
	private $labels;

    /**
	 * Section Arguments
	 * @var Array
	 */
	private $arguments;

    

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
		    'rewrite'            => array( 'slug' => $this->slug ),
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
	 *  Creating the section
	 */
	public function createSection(){

		register_post_type( $this->getPostType(), $this->getArguments() );

		$this->createDefaultMetaBox();

		
	}

	public function __construct($slug, $name, $singular, $plural, $textdomain = "", $additional_parameters = array()){

		$this->slug = $slug;

		$this->name = $name;

		$this->singular = $singular;

		$this->plural = $plural;

		if( "" != $textdomain ){

	        $this->textdomain = $textdomain;

		} else {

            $this->textdomain = $slug;

		}

		$this->setLabels();

		$this->setArguments($additional_parameters);

		add_action('init', array(&$this, 'createSection'));
		

	}

	public function createDefaultMetaBox(){

		new DefaultMetaBox( "pageMeta",  "Default MetaBox", $this , "Default Metabox");

	}


}