<?php 

Namespace SectionBuilder;

/**
 * Interface for Builder
 */
Interface Builder {
    
   
    /**
     * Render Function
     */
    public function renderSections();
    
    /**
     * Get the main content
     */
    public function getMainContent();
    
    /**
     * Get the complementary content
     */
    public function getComplementaryContent();

}