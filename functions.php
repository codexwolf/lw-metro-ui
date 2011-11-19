<?php
// Unhook default Thematic functions
function unhook_thematic_functions() {
    // Don't forget the position number if the original function has one
	if (of_get_option('hide_menubar','1') == '1') {
		remove_action('thematic_header','thematic_access',9); // removes menu bar
	}
	remove_action('thematic_header','thematic_blogtitle',3); // removes site title text, we're using add_logo()
	if (of_get_option('hide_tagline','0') == '1') {
		remove_action('thematic_header','thematic_blogdescription',5); // removes site tagline text
	}
}
add_action('init','unhook_thematic_functions');

function add_stylescripts() { ?>
	<link rel="stylesheet" type="text/css" href="<?php echo get_stylesheet_directory_uri(); ?>/css/style-<?php echo of_get_option('lwmetroui_style','original'); ?>.css" />
	<?php if (of_get_option('image_header','0') == '1') { ?>
		<style type="text/css">
			#header {
				background: url('<?php echo get_stylesheet_directory_uri(); ?>/images/header-<?php echo of_get_option('lwmetroui_style','original'); ?>.<?php echo of_get_option('type_header','png'); ?>') center top no-repeat;
				overflow: visible;
				padding-bottom: 32px;
			}
			#main {
				padding: 11px 0 22px 0;
			}
		</style>
	<?php } ?>
	<script type="text/javascript" src="<?php echo get_stylesheet_directory_uri(); ?>/js/jquery-1.6.4.min.js"></script>
	<script type="text/javascript" src="<?php echo get_stylesheet_directory_uri(); ?>/js/jquery-ui-1.8.16.custom.min.js"></script>
	<script type="text/javascript" src="<?php echo get_stylesheet_directory_uri(); ?>/js/lw-metro-ui-<?php echo of_get_option('lwmetroui_style','original'); ?>.js"></script>
<?php
}
add_action('wp_head','add_stylescripts');

function add_logo() { ?>
	<?php if (of_get_option('image_logo','0') == '1') { ?>
		<h1 id="blog-title"><a href="<?php echo get_bloginfo('siteurl'); ?>" title="<?php echo get_bloginfo('name'); ?>"><img src="<?php echo get_stylesheet_directory_uri(); ?>/images/logo-<?php echo of_get_option('lwmetroui_style','original'); ?>.png" alt="<?php get_bloginfo('name'); ?>" /></a></h1>
	<?php } else { ?>
		<h1 id="blog-title"><a href="<?php echo get_bloginfo('siteurl'); ?>" title="<?php echo get_bloginfo('name'); ?>"><?php echo get_bloginfo('name'); ?></a></h1>
	<?php } ?>
<?php 
}
add_action('thematic_header','add_logo',3);

// Change some options and redirect on activate
if ( is_admin() && isset($_GET['activated'] ) && $pagenow == 'themes.php' ) {
	//update default avatar
	update_option( 'avatar_default', get_bloginfo('stylesheet_directory') .'/images/avatar.png');
}
function childtheme_avatar($avatar_defaults) {
	$new_default_icon = get_bloginfo('stylesheet_directory') .'/images/avatar.png';
	$avatar_defaults[$new_default_icon] = 'LW Metro UI (custom avatar)';
	return $avatar_defaults;
}
add_filter( 'avatar_defaults' , 'childtheme_avatar' );

function childtheme_avatarsize() {
	return '48';
}
add_filter( 'avatar_size', 'childtheme_avatarsize' );

function childtheme_override_previous_post_link() {
	$args = array ('format'              => '%link',
								 'link'                => '%title',
								 'in_same_cat'         => FALSE,
								 'excluded_categories' => '');
	$args = apply_filters('thematic_previous_post_link_args', $args );
	previous_post_link($args['format'], $args['link'], $args['in_same_cat'], $args['excluded_categories']);
}
function childtheme_override_next_post_link() {
	$args = array ('format'              => '%link',
								 'link'                => '%title',
								 'in_same_cat'         => FALSE,
								 'excluded_categories' => '');
	$args = apply_filters('thematic_next_post_link_args', $args );
	next_post_link($args['format'], $args['link'], $args['in_same_cat'], $args['excluded_categories']);
}

function childtheme_override_nav_above() {
	if (is_single()) { ?>

			<div id="nav-above" class="navigation">
				<div class="nav-previous"><?php thematic_previous_post_link() ?></div>
				<div class="nav-next"><?php thematic_next_post_link() ?></div>
			</div>

<?php
	} else { ?>

			<div id="nav-above" class="navigation">
				<?php if(function_exists('wp_pagenavi')) { ?>
				<?php wp_pagenavi(); ?>
				<?php } else { ?>  
				<div class="nav-previous"><?php next_posts_link(__('Older articles', 'thematic')) ?></div>
				<div class="nav-next"><?php previous_posts_link(__('More recent articles', 'thematic')) ?></div>
				<?php } ?>
				
			</div>	

<?php
	}
}
function childtheme_override_nav_below() {
	if (is_single()) { ?>

		<div id="nav-below" class="navigation">
			<div class="nav-previous"><?php thematic_previous_post_link() ?></div>
			<div class="nav-next"><?php thematic_next_post_link() ?></div>
		</div>

<?php
	} else { ?>

		<div id="nav-below" class="navigation">
			<?php if(function_exists('wp_pagenavi')) { ?>
			<?php wp_pagenavi(); ?>
			<?php } else { ?>  
			<div class="nav-previous"><?php next_posts_link(__('Older articles', 'thematic')) ?></div>
			<div class="nav-next"><?php previous_posts_link(__('More recent articles', 'thematic')) ?></div>
			<?php } ?>
		</div>	

<?php
	}
}

function childtheme_override_postheader() {
	global $post;

	if ( is_404() || $post->post_type == 'page') {
	   $postheader = thematic_postheader_posttitle();        
	} else {
	   $postheader = thematic_postheader_posttitle() . childtheme_override_postheader_postmeta();    
	}

	echo apply_filters( 'thematic_postheader', $postheader ); // Filter to override default post header
}
function childtheme_override_postheader_postmeta() {
	$postmeta = '<div class="entry-meta">';
	$postmeta .= thematic_postmeta_entrydate();
	$postmeta .= "</div><!-- .entry-meta -->\n";
	return apply_filters('thematic_postheader_postmeta',$postmeta); 
}
function childtheme_override_postmeta_entrydate() {
	$entrydate = '<span class="entry-date"><abbr class="published" title="';
	$entrydate .= get_the_time(thematic_time_title()) . '">';
	$entrydate .= get_the_time(thematic_time_display());
	$entrydate .= '</abbr></span>';
	return apply_filters('thematic_post_meta_entrydate', $entrydate);
}
function childtheme_override_postfooter() {
	global $id, $post;
	$postfooter = '';
	return apply_filters( 'thematic_postfooter', $postfooter ); // Filter to override default post footer
}
function childtheme_override_commentmeta($print = TRUE) {
	$content = '<div class="comment-meta">' . 
				sprintf( __('<a href="%3$s" title="Permalink to this comment">%1$s at %2$s</a>', 'thematic' ),
				get_comment_date(),
				get_comment_time(),
				'#comment-' . get_comment_ID() );
						
	if ( get_edit_comment_link() ) {
		$content .=	sprintf(' <span class="meta-sep">|</span><span class="edit-link"> <a class="comment-edit-link" href="%1$s" title="%2$s">%3$s</a></span>',
					get_edit_comment_link(),
					__( 'Edit comment' ),
					__( 'Edit', 'thematic' ) );
		}
	
	$content .= '</div>' . "\n";
		
	return $print ? print(apply_filters('thematic_commentmeta', $content)) : apply_filters('thematic_commentmeta', $content);
}

function childtheme_override_init_presetwidgets() {
	update_option( 'widget_ctc', array( 2 => array( 'title' => 'Tags', 'smallest' => 10, 'largest' => 22, 'unit' => 'pt', 'number' => '15', 'format' => 'list', 'orderby' => 'rand', 'showcount' => 'no', 'showtags' => 'no', 'showcats' => 'yes', 'empty' => 'no', 'widget' => 'yes' ), '_multiwidget' => 1 ) );
	update_option( 'widget_search', array( 2 => array( 'title' => '' ), '_multiwidget' => 1 ) );
	update_option( 'widget_pages', array( 2 => array( 'title' => ''), '_multiwidget' => 1 ) );
	update_option( 'widget_categories', array( 2 => array( 'title' => '', 'count' => 0, 'hierarchical' => 0, 'dropdown' => 0 ), '_multiwidget' => 1 ) );
	update_option( 'widget_archives', array( 2 => array( 'title' => '', 'count' => 0, 'dropdown' => 0 ), '_multiwidget' => 1 ) );
	update_option( 'widget_links', array( 2 => array( 'title' => ''), '_multiwidget' => 1 ) );
	update_option( 'widget_rss-links', array( 2 => array( 'title' => ''), '_multiwidget' => 1 ) );
	update_option( 'widget_meta', array( 2 => array( 'title' => ''), '_multiwidget' => 1 ) );
}
function childtheme_preset_widgets() {
	$preset_widgets = array (
		'primary-aside'  => array(  ),
		'secondary-aside'  => array(  ),
		'1st-subsidiary-aside'  => array( 'CTC' ),
		'2nd-subsidiary-aside'  => array( 'search-2', 'rss-links-2' ),
		'3rd-subsidiary-aside'  => array(  )
		);
	return $preset_widgets;
}
add_filter('thematic_preset_widgets','childtheme_preset_widgets' );

function childtheme_list_comments_arg() {
	$content = 'type=comment&callback=childtheme_comments';
	return $content;
}
add_filter('list_comments_arg', 'childtheme_list_comments_arg');

function childtheme_comments($comment, $args, $depth) {
    $GLOBALS['comment'] = $comment;
	$GLOBALS['comment_depth'] = $depth;
    ?>
    	<li id="comment-<?php comment_ID() ?>" class="<?php thematic_comment_class() ?>">
			<div class="comment_wrapper">
    		<?php thematic_abovecomment() ?>
    		<div class="comment-author vcard"><?php thematic_commenter_link() ?></div>
    		<?php thematic_commentmeta(TRUE); ?>
    <?php if ($comment->comment_approved == '0') _e("\t\t\t\t\t<span class='unapproved'>Your comment is awaiting moderation.</span>\n", 'thematic') ?>
            <div class="comment-content">
        		<?php comment_text() ?>
    		</div>
			<?php // echo the comment reply link with help from Justin Tadlock http://justintadlock.com/ and Will Norris http://willnorris.com/
				if($args['type'] == 'all' || get_comment_type() == 'comment') :
					comment_reply_link(array_merge($args, array(
						'reply_text' => __('Reply','thematic'), 
						'login_text' => __('Log in to reply.','thematic'),
						'depth' => $depth,
						'before' => '<div class="comment-reply-link">', 
						'after' => '</div>'
					)));
				endif;
			?>
			<?php thematic_belowcomment() ?>
			</div>
<?php }
add_filter('thematic_comments','childtheme_comments' );

function child_meta_keywords($description) {
	$keywords = "\t" . '<meta name="generator" content="WordPress" />' . "\n\n";
	$keywords .= "\t" . '<meta name="template" content="'.get_current_theme().'" />' . "\n\n";
	$child_meta = $description . $keywords;
	return $child_meta;
}
add_filter ('thematic_create_description','child_meta_keywords');

function add_themeinfo() { ?>
	<div id="themeinfo"><?php echo of_get_option('theme_credits','Metro-designed by <a href="http://syaoran.net/">Little Wolf</a>.'); ?></div>
<?php
}
add_action('thematic_belowfooter','add_themeinfo');


if ( !function_exists( 'optionsframework_init' ) ) {
	/* Set the file path based on whether the Options Framework Theme is a parent theme or child theme */
	if ( STYLESHEETPATH == TEMPLATEPATH ) {
		define('OPTIONS_FRAMEWORK_URL', TEMPLATEPATH . '/admin/');
		define('OPTIONS_FRAMEWORK_DIRECTORY', get_bloginfo('template_directory') . '/admin/');
	} else {
		define('OPTIONS_FRAMEWORK_URL', STYLESHEETPATH . '/admin/');
		define('OPTIONS_FRAMEWORK_DIRECTORY', get_bloginfo('stylesheet_directory') . '/admin/');
	}
	require_once (OPTIONS_FRAMEWORK_URL . 'options-framework.php');
}
function optionsframework_custom_scripts() { ?>
	<script type="text/javascript">
	jQuery(document).ready(function() {

		jQuery('#image_header').click(function() {
			jQuery('#section-type_header').fadeToggle(400);
		});
		
		if (jQuery('#image_header:checked').val() !== undefined) {
			jQuery('#section-type_header').show();
		}
		
	});
	</script>
<?php
}
add_action('optionsframework_custom_scripts', 'optionsframework_custom_scripts');

function remove_twentyeleven_options() {
	remove_action( 'admin_menu', 'twentyeleven_theme_options_add_page' );
}
add_action('after_setup_theme','remove_twentyeleven_options', 100);
?>