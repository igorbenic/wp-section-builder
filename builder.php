<?php 

Namespace Builder;

Interface Builder {
    
    /**
     * Render Function
     */
    public function render();
    
    /**
     * Get the main content
     */
    public function getMainContent();
    
    /**
     * Get the complementary content
     */
    public function getComplementaryContent();

}