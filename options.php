<div class="wrap">
<h2>SPD Shortcode Slider</h2>
<ul class="subsubsub" style="width:100%;clear:both;">
<li><a href="#1">Shortcode &amp; Embed Tags</a>|</li>
<li><a href="#3">Slide Content</a>|</li>
<li><a href="#4">Slider Display</a>|</li>
<li><a href="#5">Custom Image Sizes</a>|</li>
<li><a href="#6">Slider Effects</a>|</li>
<li><a href="#7">Help Finding Id's</a></li>
</ul>

<p>Each instance of the slider can have a unique content and appearance using the shortcode attributes and values outlined below.</p>


<div class="clear"></div>
<form method="post" >
<h3 style="margin-bottom:5px;"><a name="3"></a>Embed tags:</h3>
<p style="margin-bottom:0;">You can embed the slider directly into your template files with this code:</p>
<input style="font-weight:bold;color:#666;" size="100" type="text" name="" value="<?php echo "<?php do_shortcode('[spd_slider]'); ?>"  ?>" />

<h3 style="margin-bottom:5px;">Complex Examples:</h3>
<p style="margin-bottom:0;">Pages, posts and custom post types by custom taxonomy term:</p>
<textarea style="font-weight:bold;color:#666;" cols="100" rows="2" >
<?php 
echo "<?php do_shortcode('[spd_slider max_slides=\"6\" slider_layout=\"buttons\"  term_slug=\"slideshow\"  tax_slug=\"display\" slider_fx=\"zoom\" ]'); ?> "
?>
</textarea>

<p style="margin-bottom:0;">Posts by tag alternating between zoom and fade effects:</p>
<textarea style="font-weight:bold;color:#666;" cols="100" rows="2" >
<?php 
echo "<?php do_shortcode('[spd_slider slider_layout=\"numbers-top\" post_type=\"post\" tag_id=\"72\"  slider_display_slide_excerpt=\"no\"  slider_fx=\"fade,zoom\"]'); ?> "
?>
</textarea>

<p style="margin-bottom:0;">Page &amp; Post by their ids:</p>
<textarea style="font-weight:bold;color:#666;" cols="100" rows="2" >
<?php 
echo "<?php do_shortcode('[spd_slider slider_layout=\"thumbnails-bottom\"  pageorpost_ids=\"6,12,22,8,9\"  hidearrows=\"yes\"  ]'); ?> "
?>
</textarea>

<hr />
<h3><a name="3"></a>Attributes for Slide Content:</h3>

<p><strong>cat_id</strong> <em>(no default value)</em> <br /> Use id of category to show slides from that category</p>

<p><strong>tag_id</strong> <em>(no default value)</em><br />Use id of tag to show slides from that tag</p>

<p><strong>term_slug</strong> <em>(no default value)</em><br />Use term slug to show slides from that term.
<strong>important: will only work if you also specify the taxonomy as well.</strong></p>

<p><strong>tax_slug</strong> <em>(no default value)</em><br />Define the parent custom taxonomy slug when you want to show slides from term (above).</p>

<p><strong>author_id</strong> <em>(no default value)</em><br />Use author id to show slides written by that author</p>

<p><strong>pageorpost_ids</strong> <em>(no default value)</em><br />Use page or post ids separated by commas to show slides with those pages and posts.</p>

<p><strong>post_type</strong> <em>(default value: &quot;any&quot; other options: page, post, attachment, or custom post type)</em><br />Use post type name to show slides from that post type.</p>

<p><strong>orderby</strong> <em>(default value: &quot;date&quot; other options: none, ID ,author, title, modified, parent, rand, comment_count)<br />Use to control how slides are ordered</em></p>

<p><strong>order</strong> <em>(default value: &quot;DESC&quot; other options: ASC )<br />Use to control in what direction the order goes</em></p>

<p><strong>max_slides</strong> <em>(default value: &quot;5&quot; other options: any other number )<br />Use to control  the max amount of slides.</em></p>

<hr />
<h3><a name="4"></a>Attributes for Slider Layout:</h3>

<p><strong>slider_layout</strong> <em>(default value: &quot;plain&quot; other options: thumbnails-side, thumbnails-bottom, numbers-top, numbers-bottom, buttons )</em><br />Use to specify which layout you want to display</em></p>
<p><strong>hide_arrows </strong> <em>(default value: &quot;no&quot; other options: yes )</em> Use to hide prev/next arrows that appear when you hover over slide edges. </em></p>

<p><strong>slider_display_slide_title </strong><em>(default value: &quot;yes&quot; other options: no )</em> Use to display or hide slides title. </em></p>

<p><strong>slider_display_slide_excerpt </strong><em>(default value: &quot;yes&quot; other options: no )</em> Use to display or hide slides title. </em></p>

<p><strong>slider_display_thumb_title </strong><em>(default value: &quot;yes&quot; other options: no )</em> Use to display or hide thumbnails title.</p>

<hr />
<h3><a name="5"></a>Attributes for Custom Image Sizes:</h3>

<p><strong>slide_img_size</strong> <em>(default value: &quot;default-slide-img&quot; other options: large, medium, full, thumbnail or custom size )</em> Use to set slide image size.</p>

<p><strong>thumb_img_size</strong> <em>(default value: &quot;default-thumb-img&quot; other options: large, medium, full,  thumbnail  or custom size )</em> Use to set thumbnail image size.</p>

<p>The Default slide_img_size is set in the plugin as 600 px wide and 400 high, and thumb_img_size as 50px by 50px. You can replace the Custom thumbnail name with standard wordpress image sizes (large, medium, full,  thumbnail) which you can change the sizes in settings&gt; media.</p>

<p>You can also create your own Custom thumbnail sizes by pasting the following code in your functions file. remember to update the image sizes to what you want. Also be careful when working with your themes function file - always have access to via ftp in case something goes wrong. </p>

<textarea style="font-weight:bold;color:#666;" cols="100" rows="9" >
<?php 
echo "if (function_exists('add_theme_support')){ \n";
echo "	add_theme_support('post-thumbnails');  \n";
echo "} \n";
echo "function add_slider_imgsize(){ \n";
echo "	if (function_exists('add_image_size')){ \n";
echo "		add_image_size('new-slide-img', 600, 400, true); \n";
echo "		add_image_size('new-thumb-img', 50, 50, true); \n";
echo "	} \n";
echo "} \n";
echo "add_action('admin_init', 'add_slider_imgsize'); \n"; 
?>
</textarea>

<p> Also remember that any changes to image sizes will not be applied to your current images, and you will have to Regenerate your existing thumbnails to see changes on your images that were uploaded before you changed the image size. Use <a href="http://wordpress.org/extend/plugins/regenerate-thumbnails/">Regenerate Thumbnails</a> plugin to do so easily. </p>

<p>This Plugin uses featured post images, for the slide and thumb images. If you do not have featured images set for your posts and pages - <a href="http://wordpress.org/extend/plugins/auto-post-thumbnail/">Auto Post Thumbnail</a> will search for the first image in every post and set it as the featured image. </p>

<hr />
<h3><a name="6"></a>Slider Effects:</h3>

<p><strong>slider_fx</strong> <em>(default value: &quot;fade&quot; other options:     blindY, blindZ, cover, curtainX, curtainY, fade, fadeZoom, growX, growY, none, scrollUp, scrollDown, scrollLeft, scrollRight, scrollHorz, scrollVert, shuffle, slideX, slideY, toss, turnUp, turnDown, turnLeft, turnRight, uncover, wipe, zoom
 
)</em> Use to set slider transition effect. Test out all effects at <a href="http://jquery.malsup.com/cycle/browser.html" >malsup.com</a>.</p>

<p><strong>slider_timeout</strong> <em>(default value: &quot;5000&quot; other options: any integer )</em> Use to set how many milliseconds will elapse between the start of each transition.</p>

<p><strong>slider_effect_speed</strong> <em>(default value: &quot;300&quot; other options: any integer )</em> Use to set the number of milliseconds it will take to transition from one slide to the next.</p>

<hr />
<h3><a name="7"></a>Help Finding ID's:</h3>
<ul>
<li><strong>Category and Tag ID:</strong> find your tag/cat id right after <strong>tag_ID=</strong> in the browser's address bar when editing the Individual Category or Tag</li>

<li><strong>Term slug:</strong> find your term slug in the <strong>slug field</strong> while editing the term.</li>

<li><strong>Term's Taxonomy slug:</strong> find your custom tax slug right after <strong>taxonomy=</strong> in the browser's address bar while editing the term</li>

<li><strong>Post or Page ID:</strong>  find your Post/Page id right after <strong>post=</strong> in the browser's address bar when editing the actual Post or Page</li>

<li><strong>Author ID:</strong>  find the Author's id right after <strong>user_id=</strong> in browsers address bar when editing the user profile</li>

<li><strong> You can also install a plugin such as <a href="http://wordpress.org/extend/plugins/showid-for-postpagecategorytagcomment/">ShowID</a> that makes finding the id's easier. </strong></li>
</ul>

</form>
</div><!-- end wrap-->