<?php 


// Add all the custom post type functions to the page inialisation so that they are all available for use.

add_action( 'init', 'create_goal_post_type' );

add_action( 'init', 'create_reviews_post_type' );

add_action( 'init', 'create_assessment_post_type' );

add_action( 'init', 'create_profile_post_type' );

add_action('init', 'create_sparkle_post_type');

add_action('init', 'create_tp_post_type');

add_action('init', 'create_dm_post_type');

add_action('init', 'create_communicator_type');

add_action('init', 'create_thinker_type');

add_action('init', 'create_support_type');

add_action('init', 'create_literacy_type');

add_action('init', 'create_maths_type');

add_action('init', 'create_general_type');

add_action('init', 'create_images_type');



// Staff specific


add_action('init', 'create_teacher_type');

add_action('init', 'create_team_type');

add_action('init', 'create_knowing_type');

add_action('init', 'create_learners_type');

add_action('init', 'create_creating_type');

add_action('init', 'create_expectations_type');

add_action('init', 'create_people_type');

add_action('init', 'create_teaching_type');


function create_team_type() {
	register_post_type( 'team',
		array(
			'labels' => array(
				'name' => __( 'Being a team' ),
				'singular_name' => __( 'team' )
			),
			'capability_type' => 'post',
		'public' => true,
		'has_archive' => true,
		'taxonomies' => array( 'person_id') 
		)
	);	

}


function create_knowing_type() {
	register_post_type( 'knowing',
		array(
			'labels' => array(
				'name' => __( 'Knowing the Children' ),
				'singular_name' => __( 'knowing' )
			),
			'capability_type' => 'post',
		'public' => true,
		'has_archive' => true,
		'taxonomies' => array( 'person_id') 
		)
	);	

}

function create_learners_type() {
	register_post_type( 'learners',
		array(
			'labels' => array(
				'name' => __( 'Adults as learners' ),
				'singular_name' => __( 'learners' )
			),
			'capability_type' => 'post',
		'public' => true,
		'has_archive' => true,
		'taxonomies' => array( 'person_id') 
		)
	);	

}

function create_creating_type() {
	register_post_type( 'creating',
		array(
			'labels' => array(
				'name' => __( 'Creating great learning' ),
				'singular_name' => __( 'creating' )
			),
			'capability_type' => 'post',
		'public' => true,
		'has_archive' => true,
		'taxonomies' => array( 'person_id') 
		)
	);	

}


function create_expectations_type() {
	register_post_type( 'expectations',
		array(
			'labels' => array(
				'name' => __( 'Upholding high expectations' ),
				'singular_name' => __( 'expectations' )
			),
			'capability_type' => 'post',
		'public' => true,
		'has_archive' => true,
		'taxonomies' => array( 'person_id') 
		)
	);	

}

function create_people_type() {
	register_post_type( 'people',
		array(
			'labels' => array(
				'name' => __( 'Valuing our people and place' ),
				'singular_name' => __( 'people' )
			),
			'capability_type' => 'post',
		'public' => true,
		'has_archive' => true,
		'taxonomies' => array( 'person_id') 
		)
	);	

}

function create_teacher_type() {
	register_post_type( 'teacher',
		array(
			'labels' => array(
				'name' => __( 'Teacher conversations' ),
				'singular_name' => __( 'teacher' )
			),
			'capability_type' => 'post',
		'public' => true,
		'has_archive' => true,
		'taxonomies' => array( 'person_id') 
		)
	);	

}






// Functions to creat each of the post types that we need.

// Goal post type do be used in the setting of teacher goals.

function create_goal_post_type() {
	register_post_type( 'goal',
		array(
			'labels' => array(
				'name' => __( 'Goal' ),
				'singular_name' => __( 'Goal' )
			),
			'capability_type' => 'post',
		'public' => true,
		'has_archive' => true,
		'taxonomies' => array('action_id', 'goal_id', 'person_id') 
		)
	);
	
	

}
function create_general_type() {
	register_post_type( 'general',
		array(
			'labels' => array(
				'name' => __( 'General' ),
				'singular_name' => __( 'General' )
			),
			'capability_type' => 'post',
		'public' => true,
		'has_archive' => true,
		'taxonomies' => array('category', 'person_id') 
		)
	);
	
	

}


function create_literacy_type() {
	register_post_type( 'literacy',
		array(
			'labels' => array(
				'name' => __( 'Literacy' ),
				'singular_name' => __( 'Literacy' )
			),
			'capability_type' => 'post',
		'public' => true,
		'has_archive' => true,
		'taxonomies' => array('category', 'person_id') 
		)
	);
	
	

}

function create_maths_type() {
	register_post_type( 'maths',
		array(
			'labels' => array(
				'name' => __( 'Maths' ),
				'singular_name' => __( 'Maths' )
			),
			'capability_type' => 'post',
		'public' => true,
		'has_archive' => true,
		'taxonomies' => array('category', 'person_id') 
		)
	);
	
	

}

// Review post type for writing subject reviews and action plans.

function create_reviews_post_type() {
	register_post_type( 'reviews',
		array(
			'labels' => array(
				'name' => __( 'Reviews' ),
				'singular_name' => __( 'Review' )
			),
			'capability_type' => 'post',
		'public' => true,
		'has_archive' => true,
		'taxonomies' => array() 
		)
	);
	
	

}

// Assessment post type use tbc

function create_assessment_post_type() {
	register_post_type( 'assessments',
		array(
			'labels' => array(
				'name' => __( 'Assessments' ),
				'singular_name' => __( 'Assessment' )
			),
			'capability_type' => 'post',
		'public' => true,
		'has_archive' => true,
		'taxonomies' => array('category', 'person_id') 
		)
	);
	
	

}


// Create sparkle post type use to make sparkle commenst about children 

function create_sparkle_post_type() {
	register_post_type( 'sparkle',
		array(
			'labels' => array(
				'name' => __( 'Sparkle' ),
				'singular_name' => __( 'Sparkle' )
			),
			'capability_type' => 'post',
		'public' => true,
		'has_archive' => true,
		'taxonomies' => array('category', 'person_id') 
		)
	);
	
	

}


// Create tesm player post type use to make team player commenst about children 

function create_tp_post_type() {
	register_post_type( 'team_player',
		array(
			'labels' => array(
				'name' => __( 'Team' ),
				'singular_name' => __( 'Team Player' )
			),
			'capability_type' => 'post',
		'public' => true,
		'has_archive' => true,
		'taxonomies' => array('category', 'person_id') 
		)
	);
	
}


// Create  dream maker post type use to make dream maker comments about children 

function create_dm_post_type() {
	register_post_type( 'dream_maker',
		array(
			'labels' => array(
				'name' => __( 'Dream' ),
				'singular_name' => __( 'Dream Maker' )
			),
			'capability_type' => 'post',
		'public' => true,
		'has_archive' => true,
		'taxonomies' => array('category', 'person_id') 
		)
	);
	
}

// Create communicator post type use to make communicator commenst about children 

function create_communicator_type() {
	register_post_type( 'communicator',
		array(
			'labels' => array(
				'name' => __( 'Communicator' ),
				'singular_name' => __( 'Communicator' )
			),
			'capability_type' => 'post',
		'public' => true,
		'has_archive' => true,
		'taxonomies' => array('category', 'person_id') 
		)
	);
	
}

// Create thinker post type use to make thinker comments about children 

function create_thinker_type() {
	register_post_type( 'thinker',
		array(
			'labels' => array(
				'name' => __( 'Thinker' ),
				'singular_name' => __( 'Thinker' )
			),
			'capability_type' => 'post',
		'public' => true,
		'has_archive' => true,
		'taxonomies' => array('category', 'person_id') 
		)
	);
	
}


function create_support_type() {
	register_post_type( 'support',
		array(
			'labels' => array(
				'name' => __( 'Support' ),
				'singular_name' => __( 'Support' )
			),
			'capability_type' => 'post',
		'public' => true,
		'has_archive' => true,
		'taxonomies' => array('category', 'person_id') 
		)
	);
	
}

// Profile post type is for use with teachers as their own description.

function create_profile_post_type() {
	register_post_type( 'profile_post',
		array(
			'labels' => array(
				'name' => __( 'Profile' ),
				'singular_name' => __( 'Profile' )
			),
			'capability_type' => 'post',
		'public' => true,
		'has_archive' => true,
		'taxonomies' => array('person_id') 
		)
	);
	
	

}

function create_images_type() {
	register_post_type( 'images',
		array(
			'labels' => array(
				'name' => __( 'Image' ),
				'singular_name' => __( 'Image' )
			),
			'capability_type' => 'post',
		'public' => true,
		'has_archive' => true,
		'taxonomies' => array('person_id') 
		)
	);
	
	

}

function create_teaching_type() {
	register_post_type( 'teaching',
		array(
			'labels' => array(
				'name' => __( 'Teaching' ),
				'singular_name' => __( 'Teaching' )
			),
			'capability_type' => 'post',
		'public' => true,
		'has_archive' => true,
		'taxonomies' => array('category', 'indicator') 
		)
	);
	
	

}




// build new taxonimoies for people, goals etc..


add_action( 'init', 'build_taxonomies', 0 );  
  
function build_taxonomies() {  
    register_taxonomy( 'registered_teacher_criteria', 'assessments', array( 'hierarchical' => true, 'label' => 'Registered Teacher Criteria', 'query_var' => true, 'rewrite' => true ) );  
	 register_taxonomy( 'person_id', array('post', 'general', 'assessments', 'goals', 'support', 'sparkle', 'dream_maker', 'team_player', 'communicator', 'thinker', 'literacy', 'maths', 'reading', 'images', 'teacher'), array( 'hierarchical' => false, 'public' => false, 'label' => 'Person', 'query_var' => true, 'rewrite' => true ) ); 
	  register_taxonomy( 'indicator', array('post', 'teaching'), array( 'hierarchical' => false, 'label' => 'Indicator', 'query_var' => true, 'rewrite' => true ) ); 
	 
	    
}  ;




