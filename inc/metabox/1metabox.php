<?php
Namespace SectionBuilder\Metabox;
use SectionBuilder\Metabox;

Class DefaultMetaBox extends Metabox {
     
    
	/**
	 * Save the meta when the post is saved.
	 *
	 * @param int $post_id The ID of the post being saved.
	 */
	public function save( $post_id ) {
	     
	     if ( ! isset( $_POST['section_builder_'.$this->getSlug().'_metabox_nonce'] ) ) {
			return;
		 }

		 if(
		 	!wp_verify_nonce( 
		 		$_REQUEST['section_builder_'.$this->getSlug().'_metabox_nonce' ],  
		 		'section_builder_'.$this->getSlug().'_metabox'
		 		)
		 	){

                 die("Cheating");
		     }
		 
		

		$fileData =  sanitize_text_field($_POST[$this->getSlug()]);

		update_post_meta ( $post_id,  $this->key, $fileData);
	}

	


	/**
	 * Render Meta Box content.
	 *
	 * @param WP_Post $post The post object.
	 */
	public function render_meta_box_content( $post ) {


	    
	    // Add a nonce field so we can check for it later.
		wp_nonce_field( 'section_builder_'.$this->getSlug().'_metabox', 'section_builder_'.$this->getSlug().'_metabox_nonce' );

		/*
		 * Use get_post_meta() to retrieve an existing value
		 * from the database and use the value for the form.
		 */
		$value = get_post_meta( $post->ID,  $this->key, true );

		echo '<label for="'.$this->getSlug().'">';

			_e( 'On which page it shows', $this->textdomain );

		echo '</label> ';

		echo '<select id="'.$this->getSlug().'" name="'.$this->getSlug().'"> 

			 <option value="">'

			 .esc_attr( __( 'Select page' ) ).'</option> ';
			 
			  $pages = get_pages(); 

			  foreach ( $pages as $page ) {

			  	$option = '<option value="' . $page->ID  . '"';

			  	$option .= selected(  $value, $page->ID, false );

			  	$option .= '>';

				$option .= $page->post_title;

				$option .= '</option>';

				echo $option;

			  }

	    echo '</select>';
	   
		
	}
	
}