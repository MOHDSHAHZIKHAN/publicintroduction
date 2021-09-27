<?php
/**
 * Purea Fashion: Dynamic CSS stylesheet
 * 
 */

function purea_fashion_dynamic_css_stylesheet() {
    
    $css = '
    	
    	.top-menu .navigation > li > a:hover {
    		color: #000;
    	}

    	.top-menu .navigation > li > a:before {
    		background: #000;
    	}

    	.pagination .nav-links .current {
		    background: #000 !important;
		}

		.trending-news {
			padding-top: 0;
			padding-bottom: 0;
		}

		.no-sidebar .container {
		    width: 90%;
		    margin: 0 auto ;
		}

	';
	
	return apply_filters( 'purea_fashion_dynamic_css_stylesheet', purea_fashion_minimize_css($css));
}