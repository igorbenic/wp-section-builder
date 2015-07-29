<?php

use Builder\Builder;

/**
 * Section builder with Bootstrap 3
 */
Class HomeBootstrap implements Builder {
    
    /**
     * Row Class - .row
     * @var string
     */
    private $rowClass = "";
    
    /**
     * Main Content Class
     * @var string
     */
    private $mainClass = "";
    
   /**
    * The WP Query Loop for all the section for a page
    * @var Object
    */
    private $WPLOOP;

    
    /**
     * Complementary Content Class
     * @var string
     */
    private $complementaryClass = "";

    /**
     * Constructor
     */
    public function __construct(){

      global $post;

      $contentID = $post->ID;
      

      /**
       * Applying Filters so that the class can be changed outside the class by a theme developer
       */
      $this->rowClass = apply_filters( get_class($this) . "_row_class", "row" );

      $this->mainClass = apply_filters( get_class($this) . "_main_content_class", "col-xs-12 col-sm-7 col-md-8" );

      $this->complementaryClass = apply_filters( get_class($this) . "_complementary_content_class", "col-xs-12 col-sm-5 col-md-4" );

    }

	/**
     * Render Function
     */
    public function render(){

        echo "<div class='" . $this->rowClass . "'>";
         
            echo "<div class='" . $this->mainClass . "'>";

            	echo $this->getMainContent();

            echo "</div>";

            echo "<div class='"  . $this->complementaryClass . "'>";

                echo $this->getComplementaryContent();

            echo "</div>";

        echo "</div>";
       
    }
    
    /**
     * Get the main content
     */
    public function getMainContent(){

    }
    
    /**
     * Get the complementary content
     */
    public function getComplementaryContent(){

    }
}