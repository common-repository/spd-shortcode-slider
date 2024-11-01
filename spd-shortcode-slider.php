<?php /*
Plugin Name: SPD Shortcode Slider Plugin
Description: Jquery Featured Content Slider controlled completely by shortcodes for easy template integration (Uses featured images and has 5 default layouts). 
Plugin URI: http://wordpress.org/extend/plugins/spd-shortcode-slider/
Author: sheepdogpd.com
Version: 1.06
Author URI: http://www.sheepdogpd.com/
License: GPL2
*/
/* SPD Shortcode Slider (Wordpress Plugin)
Copyright (C) 2011
This program is free software: you can redistribute it and/or modify it under the terms of the GNU General Public License as published by the Free Software Foundation, either version 3 of the License, or (at your option) any later version.
This program is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU General Public License for more details.
You should have received a copy of the GNU General Public License along with this program. If not, see  <http://www.gnu.org/licenses/>.
*/

/* ********************************************** */
/* ************* Add options page ************** */
/* ******************************************** */
function spd_slider_options_pg() {
add_options_page('SPD Shortcode Slider Options', 'SPD Shortcode Slider', 'edit_pages', 'spd-shortcode-slider/options.php');	
}
/* ********************************************** */
/* ** Add excerpt support to Page ************** */
/* ******************************************** */
add_post_type_support('page', 'excerpt');
/* ********************************************** */
/* ************ Add post-thumbnails ************ */
/* ******************************************** */
if (function_exists('add_theme_support')){ 
add_theme_support('post-thumbnails'); 
}
// Add default slider thumb sizes
function spd_slider_add_default_imgsize(){ 
if (function_exists('add_image_size')){ 
add_image_size('default-slide-img', 600, 400 ,true);
add_image_size('default-thumb-img', 50, 50 ,true);
}}

/* ********************************************** */
/* *************** Load Scripts **************** */
/* ******************************************** */
function spd_slider_jquery() {
// unregister default wp jquery 
wp_deregister_script('jquery');
//set our version as the new jquery
// jquery originally used wp_register_script('jquery','http://jqueryjs.googlecode.com/files/jquery-1.3.2.min.js');
wp_register_script( 'jquery', ( "http://ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js" ), false, '1', false);
// then load it
wp_enqueue_script('jquery');
// this is Malsup's 'jQuery Cycle Plugin' http://jquery.malsup.com/cycle/
wp_enqueue_script('cycle', get_bloginfo('url') . '/wp-content/plugins/spd-shortcode-slider/jquery.cycle.all.min.js');
}

/* wp_enqueue_script won't work if called with wp_head action because <script> tags get outputted before wp_head runs
use template_redirect instead so that it doesent remove the jquery needed in the admin pages (pop up image boxes, expanding admin panels, etc...) | to load jquery on all pages use:  init action | on only public pages use: template_redirect action  | only admin pages use: admin_print_scripts  action */ 
/* ********************************************** */
/* *************** Load CSS ******************** */
/* ******************************************** */
function spd_slider_css() { ?>
<link rel="stylesheet" href="<?php echo site_url(); ?>/wp-content/plugins/spd-shortcode-slider/style.css" type="text/css" media="screen" charset="utf-8"/>
<?php
}

/* ********************************************************* */
/* more options http://jquery.malsup.com/cycle/options.html */
/* ******************************************************* */
function spd_slider_footer_scripts() { 
	global $slider_layout;
	global $slider_fx;
	global $slider_timeout; 
	global $slider_effect_speed; 
//buttons and numbers-bottom are built the same only difference is only css styling 
if(($slider_layout == 'buttons') ||($slider_layout == 'numbers-bottom')){ ?>
<script type="text/javascript" charset="utf-8">
$(function() {
            $('#slides')
			.after('<div id="nav_num">') // adds span after cycle
			.cycle({
			pager:  '#nav_num', 
            next:   '#nav_nextslide',
            prev:   '#nav_previousslide',
			fx:      '<?php echo "$slider_fx" ; ?>',
			timeout: '<?php echo "$slider_timeout;" ;?>',
			speed:   '<?php echo "$slider_effect_speed" ;?>' //be sure to remove last comma for i.e 
            });
        });
</script><?php // end numbers-bottom and buttons
} // numbers-top same as numbers-bottom except it is put BEFORE (not after) slides and has different styles
elseif($slider_layout == 'numbers-top'){?>
<script type="text/javascript" charset="utf-8">
      $(function() { 
            $('#slides')
			.before('<div id="nav_num">') // adds span after cycle
			.cycle({
			pager:  '#nav_num',
			next:   '#nav_nextslide',
            prev:   '#nav_previousslide',
			fx:      '<?php echo "$slider_fx" ; ?>',
			timeout: '<?php echo "$slider_timeout;" ;?>',
			speed:   '<?php echo "$slider_effect_speed" ;?>'
            });
        });
</script><?php // end numbers-top
}// thumbnails bottom and thumbnails side are same except for css styling
elseif( $slider_layout == 'thumbnails-bottom' || $slider_layout == 'thumbnails-side'){ ?>
<script type="text/javascript" charset="utf-8">
      $(function() {
			$('#slides')
			.cycle({ 
  			pager:  '#nav_thumb',
			pagerAnchorBuilder: function(idx, slide) { // return selector string for existing anchor 
			return '#nav_thumb li:eq(' + idx + ') a'; },
		 	next:   '#nav_nextslide',
            prev:   '#nav_previousslide',
			fx:      '<?php echo "$slider_fx" ; ?>',
			timeout: '<?php echo "$slider_timeout;" ;?>',
			speed:   '<?php echo "$slider_effect_speed" ;?>'  
	}); 
        });	
</script><?php // end thumbnails
}// plain has no numbers, buttons, or thumbs but does have default next previous arrows
elseif( $slider_layout == 'plain'){ ?>
<script type="text/javascript" charset="utf-8">
      $(function() {
            $('#slides')
			.cycle({
			next:   '#nav_nextslide',
            prev:   '#nav_previousslide'
            });
        });
</script><?php // end plain 
}// end ifelse
}// adds scripts in footer

/* ********************************************************* */
/* [spd_slider] shortcode function with default attributes  */
/* ******************************************************* */
function spd_slider_handler($atts, $content=null){
// if sharing values of attributes with other functions
//declare them global in each case that they are used so values can be passed
    global $tax_slug;
	global $term_slug;
	global $cat_id;
	global $tag_id;
	global $pageorpost_ids; 
	global $post_type; 
	global $order;
	global $orderby;
	global $max_slides;	
	global $hide_arrows;
	global $slider_display_slide_title;
	global $slider_display_slide_excerpt;
	global $slider_display_thumb_title;
	global $slide_img_size;
	global $thumb_img_size;
	global $slider_fx;
	global $slider_timeout;
	global $slider_effect_speed;
	global $slider_layout;
//shortcodes: syntax:'attribute' => 'default' | default value will get overwitten if defined in shortcode 
extract(shortcode_atts(array(
// shortcode items used for load_spd_slider query

'cat_id'  => '', // cat id
'tag_id'  => '', //tag id
'tax_slug'  => '', //  custom tax id
'term_slug' => '', // term id
'author_id' => '', // author ids
'pageorpost_ids' => '', // page or post ids seperated by comma	
'post_type' => 'any', // default any, other options: page, post, attachment, orcustom post type
'order' => 'DESC', // or ASC
'orderby' => 'date', // default date, none, ID ,author, title, modified, parent, rand, comment_count
'max_slides' => '5', // amt of slides 
'hide_arrows' => 'no', // defaults to no other option 'yes'
'slider_display_slide_title'  => 'yes', // other option 'no'
'slider_display_slide_excerpt'  => 'yes', // other option 'no'
'slider_display_thumb_title'  => 'yes', // other option 'no'
//image size name used in load_spd_slider slide & thumb image source and size
'slide_img_size' => 'default-slide-img' ,// can be large, meduim, small or custom size
'thumb_img_size'  => 'default-thumb-img', // can be, thumbnail, or custom size
// slideshow options used by spd_slider_footer_scripts
'slider_fx'  => 'fade', // slider-transitioneffect	
'slider_timeout'  => '5000', // how many milliseconds will elapse between the start of each transition
'slider_effect_speed'  => '300', // the number of milliseconds it will take to transition from one slide to the next
// layout used by load_spd_slider query AND spd_slider_footer_scripts specifies which footer script is loaded and what class added to div#spd-shortcode-slider for styling control
'slider_layout' => 'plain', // show plain (default),  thumbnails-side , thumbnails-bottom , numbers
), $atts));  
// print_r($atts); use print line to print out attributes when testing plugin

// in case someone enters an undefined layout - defaults to plain
if( ($slider_layout !== 'thumbnails-side') && ($slider_layout !=='thumbnails-bottom') && ($slider_layout!== 'numbers-bottom') && ($slider_layout!== 'numbers-top')&& ($slider_layout!== 'buttons')){ 
$slider_layout = "plain"; 
}
// this loads the actual slider
load_spd_slider();
}// end shortcode 


/* ********************************************** */
/* *********** This is actual slider **********  */
/* ******************************************** */
function load_spd_slider(){ 
//must re-define global terms here or they wont get transfered from the earlier shortcode function
	global $tax_slug;       
	global $term_slug; 	
	global $cat_id;        
	global $tag_id; 
	global $author_id; 		
	global $pageorpost_ids;
	global $post_type; 
	global $order;
	global $orderby; 	
	global $max_slides;	
	global $slider_layout; 	
	global $hide_arrows;
	global $slider_display_slide_title; 
	global $slider_display_slide_excerpt; 	
	global $slider_display_thumb_title; 	
	global $slide_img_size; 
	global $thumb_img_size;
//here we set up the cat query 
if($cat_id!=null && $cat_id!=''){	
	$spd_query = array (
	'post_type' => $post_type,
	'posts_per_page' => $max_slides,
	'cat' => $cat_id,
	'order' => $order,
	'orderby' => $orderby,
);}
//here we set up the tag query 
elseif($tag_id!=null && $tag_id!=''){	
	$spd_query = array (
	'post_type' => $post_type,
	'posts_per_page' => $max_slides,
	'tag_id' => $tag_id,
);}
//here we set up the custom tax query 
elseif($tax_slug!=null && $tax_slug!='' && $term_slug!=null && $term_slug!=''){	
	$spd_query = array (
	'post_type' => $post_type,
	'posts_per_page' => $max_slides,
	$tax_slug => $term_slug,
);}
//here do post or page ids
elseif($pageorpost_ids!=null && $pageorpost_ids!=''){	
	$spd_query = array (
	'post_type' => $post_type,
	'posts_per_page' => $max_slides,
	'post__in' =>  explode(",", $pageorpost_ids)
);}
//here do post or page ids
elseif($author_id!=null && $author_id!=''){	
	$spd_query = array (
	'post_type' => $post_type,
	'posts_per_page' => $max_slides,
	'author' =>  $author_id
);}
//here we set up the custom tax query 
else{
	$spd_query = array (
	'post_type' => $post_type,
	'posts_per_page' => $max_slides
);} // end query if else

// open slider container here we give it the slider_layout value as a class for extra styling control
?><div id="spd-shortcode-slider" class="<?php echo $slider_layout; ?>"><?php 
?><div id="slides" ><?php // slider container used by jquery cycle plugin
$postcount = 0;
$featured_query = new WP_Query($spd_query);
while ($featured_query->have_posts()) : $featured_query->the_post();
$do_not_duplicate[] = get_the_ID();
$postcount++;
// open actual slide
?><div class="slide" id="slide-<?php echo $postcount; ?>" ><?php

// these are the hover arrows - default is not hidden
if( $hide_arrows !== 'yes'){ 
	?><a href="#" id="nav_previousslide"></a><a href="#" id="nav_nextslide"></a><?php
}

// get the image filename
$thumbnail_id = get_post_thumbnail_id($post->ID);
$thumbnail_object = get_post($thumbail_id); //$thumbnail_src
$thumbnail_src = wp_get_attachment_image_src($thumbnail_id, $slide_img_size);


//outputs array use print_r($thumbnail_src) to see object 0 is the img src
// also we use $slide_img_size to determine size
?><a href="<?php the_permalink(); ?>"><img src="<?php echo $thumbnail_src[0] ?>" 
 width="<?php echo $thumbnail_src[1]; ?>" height="<?php echo $thumbnail_src[2]; ?>"/></a><?php

// if either title or excerpt is displayed show info
if(($slider_display_slide_title == 'yes') || ($slider_display_slide_excerpt =='yes')){ 
	?><span class="info"><?php  

	// if display title is yes display title
	if($slider_display_slide_title =='yes'){
		?><h3><a href="<?php the_permalink();?>" title=""><?php the_title();?></a></h3><?php 
	} 
	// if display excerpt is yes display excerpt
	if($slider_display_slide_excerpt == 'yes'){
	?><?php the_excerpt();?><?php 
	} 
	?></span><?php // close info
} // end info if 

?></div><?php // close slide
endwhile;  // end individual loop
?></div><?php // close slides div before thumbs because it needs to be in seperate thumbs for 
	
	
// if thumbnails-bottom run thumbnails loop
if($slider_layout =='thumbnails-bottom'|| $slider_layout =='thumbnails-side'){
	?><ul id="nav_thumb" class="clearfix"><?php
	$postcount = 0;
	$featured_query = new WP_Query($spd_query);
	while ($featured_query->have_posts()) : $featured_query->the_post();
	$do_not_duplicate[] = get_the_ID();
	$postcount++;
	?><li class="thumb" id="fragment-<?php echo $postcount; ?>" ><?php
	$thumbnail_id = get_post_thumbnail_id($post->ID);
	$thumbnail_object= get_post($thumbail_id);
	$thumbnail_src = wp_get_attachment_image_src($thumbnail_id, $thumb_img_size);
	?><a href="#"><img src="<?php echo $thumbnail_src[0] ?>" 
	width="<?php echo $thumbnail_src[1]; ?>" height="<?php echo $thumbnail_src[2]; ?>"/><?php  
	// if display  thumb title is yes display thumb title
	if($slider_display_thumb_title == 'yes'){
	?><h6><?php the_title();?></h6><?php 
	} 
	?></a></li><?php 
	endwhile; 
	?>
	<li class="clear"></li>
	</ul> 
	<div class="clear"></div>
	</div><?php // close nav_thumb
}// end thumbnails-bottom
?></div><?php //close #spd-shortcode-slider
}//  end load_spd_slider function

//all actions
add_action('admin_menu', 'spd_slider_options_pg');
add_action('admin_init', 'spd_slider_add_default_imgsize');
add_action('template_redirect', 'spd_slider_jquery');
add_action('wp_head', 'spd_slider_css');
add_action('wp_footer', 'spd_slider_footer_scripts' );
add_shortcode('spd_slider', 'spd_slider_handler');

?>