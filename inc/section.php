<?php
Namespace SectionBuilder;
defined( 'ABSPATH' ) or die( 'No script kiddies please!' );

/**
 * SectionBuilder Interface
 */

interface SectionBuilder {
	


    /**
	 * Setting the labels array
	 */
	public function setLabels();

    /**
	 * Getting the labels array
	 */
	public function getLabels();

   /**
    * Set arguments for the section
    * @param array $arrayToMerge Array with parameter to merge / change the defaults
    */
	public function setArguments($arrayToMerge);

    /**
	 * Getting the arguments array
	 */
	public function getArguments();

	/**
	 *  Creating the section
	 */
	public function createSection();

	/**
	 *  Getting the post type
	 */
	public function getPostType();

	/**
	 *  Getting the post type
	 */
	public function getTextDomain();


}