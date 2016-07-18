<?php
/**
 * Plugin Name: TEI Careers Sync
 * Plugin URI: https://theexpertinstitute.com
 * Description: This plugin integrates jazz.co job postings with TEI careers page
 * Version: 1.0.0
 * Author: Kyle Rose 
 * Author URI: http://krose.me
 * License: GPL2
 */


/*  INCLUDE WRAPPER  */
require_once(dirname(__FILE__) . '/class.postcontroller.php');

$api_key = parse_ini_file(dirname(__FILE__) . '/key.ini');
$api_key=$api_key['jazzKey'];


function add_job_postings(){
    global $api_key;
    /*  JAZZ API CALL  */
    $json = file_get_contents("https://api.resumatorapi.com/v1/jobs/status/open?apikey=$api_key");
    $job_listings = json_decode($json);

    foreach ($job_listings as $job_listing) {

        echo $job_listing->title . ' <br/>';
        // create_job_posting($job_listing);
    }
}

function create_job_posting($listing){
    
    $Poster = new PostController;

    $Poster->set_title( $listing->title);
    // $Poster->add_category(array(1,2,8));
    $Poster->set_type( "jobs" );
    $Poster->set_content($listing->description );
    $Poster->set_author_id( 33 );
    $Poster->set_post_slug( $listing->title );
    //$Poster->set_page_template( "login-infusion-page.php" );
    // $Poster->set_post_state( "publish" );

    // $Poster->search('title', $listing->title);
    // $Poster->update();

    $Poster->create();

    // //$Poster->PrettyPrintAll();

    // $Poster->get_var('slug');
}
add_action('init','add_job_postings');

?>