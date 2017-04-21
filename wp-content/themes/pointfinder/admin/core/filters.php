<?php
/**********************************************************************************************************************************
*
* Filters
* 
* Author: Webbu Design
*
***********************************************************************************************************************************/



// Custom Comments Callback
function pointfindert2dcomments($comment, $args, $depth){
	$GLOBALS['comment'] = $comment;
	extract($args, EXTR_SKIP);
	
	if ( 'div' == $args['style'] ) {
		$tag = 'div';
		$add_below = 'comment';
	} else {
		$tag = 'li';
		$add_below = 'div-comment';
	}
?>
	<?php echo '<'; echo $tag ?> <?php comment_class(empty( $args['has_children'] ) ? '' : 'parent') ?> id="comment-<?php comment_ID() ?>">
	<?php if ( 'div' != $args['style'] ){ ?>
	<div id="div-comment-<?php comment_ID() ?>" class="comment-body">
	<?php }; ?>

	<div class="comment-author-image">
	   <?php if ($args['avatar_size'] != 0){echo get_avatar( $comment,128 );} ?>
	</div>
    
    <div class="comments-detail-container">
       
        <div class="comment-author-vcard">
            <?php printf(esc_html__('%s says:', 'pointfindert2d'), get_comment_author_link()) ?>
        </div>
    
        <?php if ($comment->comment_approved == '0') { ?>
        	<em class="comment-awaiting-moderation"><?php esc_html_e('Su comentario esta pendiente para ser aprobado.', 'pointfindert2d') ?></em>
        	<br />
        <?php }; ?>

    	<div class="comment-meta commentmetadata">
            <a href="<?php echo htmlspecialchars( get_comment_link( $comment->comment_ID ) ) ?>">
    		<?php
//print_r($comment);
                echo kmimos_get_valuations_of_petsitter($comment->comment_ID, $comment->comment_post_ID);
    			printf( esc_html__('%1$s at %2$s', 'pointfindert2d'), get_comment_date(),  get_comment_time()) ?></a>
                <?php edit_comment_link(esc_html__('Edit', 'pointfindert2d'),'  ','' );
    		?>
    	</div>
        
        <div class="comment-textarea">
	    <?php comment_text() ?>
        </div>

	    <div class="reply"> <i class="pfadmicon-glyph-362"></i>
	       <?php comment_reply_link(array_merge( $args, array('add_below' => $add_below, 'depth' => $depth, 'max_depth' => $args['max_depth']))) ?>
	    </div>
    </div>

	<?php if ( 'div' != $args['style'] ){ ?>
	</div>
	<?php }; ?>
<?php }


function my_wp_nav_menu_args($args = '')
{
    $args['container'] = false;
    return $args;
}

function my_css_attributes_filter($var)
{
    return is_array($var) ? array() : '';
}

function remove_category_rel_from_category_list($thelist)
{
    return str_replace('rel="category tag"', 'rel="tag"', $thelist);
}

function add_slug_to_body_class($classes)
{
    global $post;
    if (is_home()) {
        $key = array_search('blog', $classes);
        if ($key > -1) {
            unset($classes[$key]);
        }
    } elseif (is_page()) {
        $classes[] = sanitize_html_class($post->post_name);
    } elseif (is_singular()) {
        $classes[] = sanitize_html_class($post->post_name);
    }

    return $classes;
}


// Remove wp_head() injected Recent Comment styles
function pointfinder_remove_recent_comments_style()
{
    global $wp_widget_factory;
    remove_action('wp_head', array(
        $wp_widget_factory->widgets['WP_Widget_Recent_Comments'],
        'recent_comments_style'
    ));
}

add_filter( 'the_content_more_link', 'pointfinder_modify_read_more_link' );
function pointfinder_modify_read_more_link() {
return '...';
}




function pointfinderwp_excerpt($length_callback = '', $more_callback = '')
{
    global $post;

    $output = do_shortcode(get_the_content('' . esc_html__('Read more', 'pointfindert2d') . ''));
    $output = apply_filters('convert_chars', $output);
    if (strpos($output, '<!--more-->')){$output = apply_filters('the_content_more_link', $output);}
    $output = apply_filters('the_content', $output);
    echo $output;
	
}



function pointfinderwp_excerpt_single($length_callback = '', $more_callback = '')
{   
    
    global $post;
    global $more;
    $more = 0;

    remove_shortcode('gallery');
    $output = do_shortcode(get_the_content('' . esc_html__('Read more', 'pointfindert2d') . ''));
    $output = preg_replace('/\[gallery(.*?)\]/', '', $output);
    $output = apply_filters('convert_chars', $output);
    $output = apply_filters('the_content', $output);
    
    echo $output;
    
}

function pointfinderh_blank_view_article($more)
{
    global $post;
    $output = '... <a class="view-article" href="' . get_permalink($post->ID) . '">' . esc_html__('View Article', 'pointfindert2d') . '</a>';
	return $output;
}
add_filter('excerpt_more', 'pointfinderh_blank_view_article');


// Remove 'text/css' from our enqueued stylesheet
function pointfinderh_style_remove($tag)
{
    return preg_replace('~\s+type=["\'][^"\']++["\']~', '', $tag);
}

// Remove thumbnail width and height dimensions that prevent fluid images in the_thumbnail
function remove_thumbnail_dimensions( $html )
{
    $html = preg_replace('/(width|height)=\"\d*\"\s/', "", $html);
    return $html;
}

// Custom Gravatar in Settings > Discussion
function pointfindert2dgravatar ($avatar_defaults)
{
    $myavatar = get_home_url()."/wp-content/themes/pointfinder" . '/img/gravatar.jpg';
    $avatar_defaults[$myavatar] = "Custom Gravatar";
    return $avatar_defaults;
}

// Threaded Comments
function enable_threaded_comments()
{
    if (!is_admin()) {
        if (is_singular() AND comments_open() AND (get_option('thread_comments') == 1)) {
            wp_enqueue_script('comment-reply');
        }
    }
}



/**
 * Filters wp_title to print a neat <title> tag based on what is being viewed.
 *
 * @param string $title Default title text for current view.
 * @param string $sep Optional separator.
 * @return string The filtered title.
 */
function pointfinder_wp_title( $title, $sep ) {
    if ( is_feed() ) {
        return $title;
    }
    
    global $page, $paged;

    // Add the blog name
    $title .= get_bloginfo( 'name', 'display' );

    // Add the blog description for the home/front page.
    $site_description = get_bloginfo( 'description', 'display' );
    if ( $site_description && ( is_home() || is_front_page() ) ) {
        $title .= " $sep $site_description";
    }

    // Add a page number if necessary:
    if ( ( $paged >= 2 || $page >= 2 ) && ! is_404() ) {
        $title .= " $sep " . sprintf( esc_html__( 'Page %s', 'pointfindert2d' ), max( $paged, $page ) );
    }

    return $title;
}
add_filter( 'wp_title', 'pointfinder_wp_title', 10, 2 );


/*
* Redirects after login
* Added with v1.6
*/
$as_redirect_logins = PFASSIssetControl('as_redirect_logins','','0');
if ($as_redirect_logins) {

    function pointfinder_possibly_redirect(){
      global $pagenow;
      if( 'wp-login.php' == $pagenow ) {

        $setup4_membersettings_dashboard = PFSAIssetControl('setup4_membersettings_dashboard','',site_url());
        $setup4_membersettings_dashboard_link = get_permalink($setup4_membersettings_dashboard);
        
        $pfmenu_perout = PFPermalinkCheck();

        $special_linkurl = $setup4_membersettings_dashboard_link.$pfmenu_perout.'ua=myitems';

        if (isset($_GET['action']) == 'rp') {
            
        } else {
            if ( isset( $_POST['wp-submit'] ) ||   // in case of LOGIN
              ( isset($_GET['action']) && $_GET['action']=='logout') ||   // in case of LOGOUT
              ( isset($_GET['checkemail']) && $_GET['checkemail']=='confirm') ||   // in case of LOST PASSWORD
              ( isset($_GET['checkemail']) && $_GET['checkemail']=='registered') ) return;    // in case of REGISTER
            else wp_redirect( $special_linkurl ); // or wp_redirect(home_url('/login'));
            exit();
        }
        
        
      }
    }
    add_action('init','pointfinder_possibly_redirect');
}

/**
 * Manage WooCommerce styles and scripts.
 * Added with v1.6
 */
function pf_grd_woocommerce_script_cleaner() {
    if (function_exists('is_woocommerce')) {
       if ( !is_woocommerce() && !is_page('store') && !is_shop() && !is_product_category() && !is_product() && !is_cart() && !is_checkout() && !is_product_tag() && !is_product_taxonomy() && !is_view_order_page() ) {
            wp_dequeue_style( 'select2' );
            wp_dequeue_script( 'select2' );
        }
    }
}
add_action( 'wp_enqueue_scripts', 'pf_grd_woocommerce_script_cleaner', 99 );


/**
 * Agent and user link filter for posts
 * Added with v1.6
 * Updated with 1.6.3
 */
function pf_agentltp_filter( $where, &$wp_query ){
    global $wpdb;
    $setup3_pointposttype_pt1 = PFSAIssetControl('setup3_pointposttype_pt1','','pfitemfinder');

    if ( $search_term = $wp_query->get( 'search_prod_agent' ) ) {
        if($search_term != ''){
            $search_term = $wpdb->esc_like( $search_term );
            $where .= ' OR (' . $wpdb->posts . '.post_author IN (' . esc_sql(  $search_term ) . ') AND ' . $wpdb->posts . '.post_type = "'.$setup3_pointposttype_pt1.'" )';
        }
    }
    return $where;
}
add_filter( 'posts_where', 'pf_agentltp_filter', 10, 2 );

?>