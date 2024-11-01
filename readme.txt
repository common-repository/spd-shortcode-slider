=== SPD Shortcode Slider ===
Contributors: mkjar
Tags: featured content slider, slideshow, gallery, featured image, shortcodes, tag, term, taxonomy, category, pages, posts, jquery, multiple instances, page excerpts
Requires at least: 3.0
Tested up to: 3.5
Stable tag: 1.06

Jquery Featured Content Slider controlled completely by shortcodes for easy template integration (Uses featured images and has 5 default layouts).

== Description ==
Slider uses featured image for slides and thumbs. Multiple instances supported (although not on same page). Since content, slider layouts, image sizes and animations are controlled by attributes with multiple possible values you can create unlimited unique configurations with every instance. 

Specify layouts (plain, thumbnail-top, thumbnail-bottom, numbers-top, numbers-bottom and buttons) along with slide content by custom taxonomy term, post type, category id, tag id, or just their post and page ids. You can also define the amount of slides, order, effect, speed between transitions, speed of transition and whether the slide title, slide excerpt, thumb title, or navigation arrows are visible by their corresponding shortcodes.

Supports custom taxonomy terms, Post AND Page excerpts*, and has 5 default layout choices. (*for custom post types you will have to add excerpt support in your theme functions file)

You can override plugin default CSS styles by adding #shortcodeslider to any css styles in your theme stylesheet.

To clear up any confusion about the shortcode usage: The [spd_slider] shortcode is NOT for embedding a image slider within a post or page content editor (i.e within the loop). If you need a shortcode image gallery plugin (that pulls all images attached to the post/page while on that post or page) there are many other plugins that do this (I recommend Raygun's Portfolio Slideshow Pro).  The SPD Shortcode Slider is for creating featured content slideshows that display the featured image, title and excerpt of selected posts/pages. It uses the [spd_slider] shortcode to facilitate adding custom variables to the slider query within the do_shortcode template tag. 

== Installation ==
1. Upload `spd-shortcode-slider` folder to the `/wp-content/plugins/` directory
2. Activate the plugin through the 'Plugins' menu in WordPress
3. Place this code in template to show slider`<?php do_shortcode('[spd_slider]'); ?>`
3. For a list of all shortcodes and supported values Go on your Dashboard > Settings > SPD Shortcode Slider

== Screenshots ==
1. numbers-bottom layout
2. numbers-top layout
3. thumbnails-bottom layout
4. thumbnails-side layout
5. buttons layout

== Changelog ==
= 1.06 =
* linked to newer version of Jquery

= 1.05 =
* Added line of css for slide divs to correct if Jquery styles take awhile to load

= 1.04 =
* Fixed JavaScript 'expected string or identifier' syntax error  - extra comma after last value in cycle function was thowing error

= 1.03 =
* Updated Version Number

= 1.02 =
* fixed issue where styles were being output in rss header. please upgrade to fix this issue

= 1.0 =
* removed testing 20px margin in style.css
* added missing closing div tag
* fixed extra semicolon options embed examples.

Please [contact](http://sheepdogpd.com/contact/ "contact me") me if you notice any other bugs or errors and I will try and fix them.


== Upgrade Notice ==

= 1.04 =
fixed JS typo

= 1.03 =
Updated Version Number

= 1.02 =
fixed RSS issue 

= 1.0 =
if you downloaded the plugin before 12:40 1/31/2012


