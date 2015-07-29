<?php

use SectionBuilder\Builder;
use SectionBuilder\Metabox\DefaultMetaBox;
/**
 * Section builder with Bootstrap 3
 */
Class HomeBootstrap implements Builder {
    
    /**
     * Row Class - .row
     * @var string
     */
    public $rowClass = "";
    
    /**
     * Main Content Class
     * @var string
     */
    public $mainClass = "";
    
   /**
    * The WP Query Loop for all the section for a page
    * @var Object
    */
    public $WPLOOP;

    
    /**
     * Complementary Content Class
     * @var string
     */
    public $complementaryClass = "";
    
    
    /**
     * The Post Type
     * @var string
     */
    public $post_type = "";

    /**
     * Meta Key for search
     * @var string
     */
    public $meta_key = "";

    /**
     * Id of the Page on which we are using the builder
     * @var integer
     */
    public $contentID = 0;

    
    /**
     * Constructor
     */
    public function __construct($thePostID = 0){
      
      if(!is_admin()){
      	  
	      $this->contentID = $thePostID;
	      /**
	       * Applying Filters so that the class can be changed outside the class by a theme developer
	       */
	      $this->rowClass = apply_filters( get_class($this) . "_row_class", "row" );

	      $this->mainClass = apply_filters( get_class($this) . "_main_content_class", "col-xs-12 col-sm-7 col-md-8" );

	      $this->complementaryClass = apply_filters( get_class($this) . "_complementary_content_class", "col-xs-12 col-sm-5 col-md-4" );
      }
      

    }

    
    
    public function constructBuilder($content){
		  global $post;

	      if($this->contentID == 0){

	      		
	      	    $this->contentID = $post->ID;

	      }
	      
	      
	      $this->getLoop();


	      return $this->appendSections($content);
    }
    
    public function builderStyle(){

    	wp_enqueue_style( "homeBootstrapBuilder-css", "https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css" );

    }
    /**
     * Getting the Loop
     */
    private function getLoop(){

    	$args = array(

    			'post_type' => $this->post_type,

    			'posts_per_page' => 50,

    			'meta_query' => array(

					array(
						'key'     => $this->meta_key,
						'value'   => $this->contentID,
						'compare' => '=',

					),
				),
    		);

       $this->WPLOOP =  new WP_Query($args);

    }
    
   

	/**
     * Render Function
     */
    public function renderSections(){

    	if($this->WPLOOP->have_posts()):

    		while($this->WPLOOP->have_posts()):

    			$this->WPLOOP->the_post();
        
		        echo "<div class='" . $this->rowClass . "'>";
		         
		            echo "<div class='" . $this->mainClass . "'>";

		            	echo $this->getMainContent();

		            echo "</div>";

		            echo "<div class='"  . $this->complementaryClass . "'>";

		                echo $this->getComplementaryContent();

		            echo "</div>";

		        echo "</div>";

	        endwhile;
            wp_reset_postdata();
        endif;

        
       
    }

    /**
     * Appending the sections to content
     */
    public function appendSections($content){

    	if($this->WPLOOP->have_posts()):

    		while($this->WPLOOP->have_posts()):

    			$this->WPLOOP->the_post();
        
		        $content .= "<div class='" . $this->rowClass . "'>";
		         
		            $content .= "<div class='" . $this->mainClass . "'>";

		            	$content .= $this->getMainContent();

		            $content .= "</div>";

		            $content .= "<div class='"  . $this->complementaryClass . "'>";

		                $content .= $this->getComplementaryContent();

		            $content .= "</div>";

		        $content .= "</div>";

	        endwhile;
            wp_reset_postdata();
        endif;

        
       return $content;
    }
    
    /**
     * Get the main content
     */
    public function getMainContent(){
      return "Bla";
    }
    
    /**
     * Get the complementary content
     */
    public function getComplementaryContent(){

    }
}

