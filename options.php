<?php
/**
 * A unique identifier is defined to store the options in the database and reference them from the theme.
 * By default it uses the theme name, in lowercase and without spaces, but this can be changed if needed.
 * If the identifier changes, it'll appear as if the options have been reset.
 * 
 */

function optionsframework_option_name() {

	// This gets the theme name from the stylesheet (lowercase and without spaces)
	$themename = get_theme_data(STYLESHEETPATH . '/style.css');
	$themename = $themename['Name'];
	$themename = preg_replace("/\W/", "", strtolower($themename) );
	
	$optionsframework_settings = get_option('optionsframework');
	$optionsframework_settings['id'] = $themename;
	update_option('optionsframework', $optionsframework_settings);
	
	// echo $themename;
}

/**
 * Defines an array of options that will be used to generate the settings page and be saved in the database.
 * When creating the "id" fields, make sure to use all lowercase and no spaces.
 *  
 */

function optionsframework_options() {
	
	$style_array = array("original" => "Original"
						,"blue" => "Blue"
						,"lime" => "Lime"
						,"pink" => "Pink"
						,"purple" => "Purple"
						);
		
	// If using image radio buttons, define a directory path
	$imagepath =  get_bloginfo('stylesheet_directory') . '/images/';
		
	$options = array();
	
	$options[] = array( "name" => "LW Metro UI Settings",
						"type" => "heading");

	$options[] = array( "name" => "Choose your style",
						"desc" => "",
						"id" => "lwmetroui_style",
						"std" => "original",
						"type" => "images",
						"options" => array(
							'original' => $imagepath . 'option-original.jpg',
							'blue' => $imagepath . 'option-blue.jpg',
							'lime' => $imagepath . 'option-lime.jpg',
							'pink' => $imagepath . 'option-pink.jpg',
							'purple' => $imagepath . 'option-purple.jpg')
						);
						
	$options[] = array( "name" => "Path to Theme Images Folder",
						"desc" => "Upload your banner and logo to the following folder:
									<strong><code>".$imagepath."</code></strong>",
						"type" => "info");
						
	$options[] = array( "name" => "Use a background image in the header",
						"desc" => "Use <strong><code>header-&lt;theme style&gt;.".of_get_option('type_header','png')."</code></strong> (e.g. header-".of_get_option('lwmetroui_style','original').".".of_get_option('type_header','png').")",
						"id" => "image_header",
						"std" => "0",
						"type" => "checkbox");
						
	$options[] = array( "name" => "Header background image file extension",
						"desc" => "",
						"id" => "type_header",
						"std" => "png",
						"type" => "radio",
						"class" => "hidden",
						"options" => array(
							'jpg' => '.JPG',
							'png' => '.PNG')
						);
						
	$options[] = array( "name" => "Use a PNG image for the site title",
						"desc" => "Use <strong><code>logo-&lt;theme style&gt;.png</code></strong> (e.g. logo-".of_get_option('lwmetroui_style','original').".png)",
						"id" => "image_logo",
						"std" => "0",
						"type" => "checkbox");
						
	$options[] = array( "name" => "Hide the site tagline",
						"desc" => "Check to hide the Tagline text defined in Settings > General",
						"id" => "hide_tagline",
						"std" => "0",
						"type" => "checkbox");
						
	$options[] = array( "name" => "Hide the menu bar",
						"desc" => "This is checked by default. The theme is designed not to need a menu (for minimalistic reasons) but you still have the option. The included menu design is basic so you may also want to customize the <a title='Cascading Style Sheets'>CSS</a> files if you uncheck this.",
						"id" => "hide_menubar",
						"std" => "1",
						"type" => "checkbox");
						
	$options[] = array( "name" => "Theme credits on footer",
						"desc" => "Here you can customize the credits text if you don't like the default. You may remove this completely but of course it would be appreciated if you could link back to <a href='http://syaoran.net/' target='_blank'>me</a> or the <a href='http://www.syaoran.net/lw-metro-ui' target='_blank'>LW Metro UI page</a>, in some way. Thanks. :-)",
						"id" => "theme_credits",
						"std" => 'Metro-designed by <a href="http://syaoran.net/">Little Wolf</a>.',
						"type" => "textarea");

	return $options;
}