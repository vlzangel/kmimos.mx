<?php
/*
 * Plugin Name: Pretty Block Testimonials
 * Description: This plugin helps you to adds a testimonial section with an elegant block on your website
 * Version: 1.0.5
 * Author: Elgali Amine
 * Author Email: elgaliamine@gmail.com
 *
 * @package WordPress
 * @subpackage pretty-block-testimonials
 * @author Amine
 * @since 2.0
 *
 */

// don't load directly
if ( ! function_exists( 'is_admin' ) ) 
{
	header( 'Status: 403 Forbidden' );
	header( 'HTTP/1.1 403 Forbidden' );
	exit();
}

if ( ! class_exists( 'Pretty_Testimonials' ) )
{
	class Pretty_Testimonials {

		/*--------------------------------------------*
		 * Constructor
		 *--------------------------------------------*/
		public function __construct( $file )
		{
			$this->file = $file;
			add_action( 'init', array( &$this, 'load_localisation' ), 0 );
			add_action( 'init', array( &$this, 'pt_reg_testimonials' ) );
			add_action( 'admin_menu', array( &$this, 'pt_add_admin_menu' ) );
			add_action( 'admin_init', array( &$this, 'pt_settings_init' ) );
			add_action( 'wp_enqueue_scripts', array( &$this, 'pt_enqueue_scripts' ) );
			add_shortcode( 'pt_pretty_testimonial', array( &$this, 'pt_shortcode' ) );
			add_action('add_meta_boxes',array( &$this, 'pt_init_metabox' ));
			add_action('save_post',array( &$this, 'pt_save_metabox' ));
		}

		/*--------------------------------------------*
		 * Load Localisation
		 *--------------------------------------------*/
		public function load_localisation()
		{
			load_plugin_textdomain( 'ptlg', false, dirname( plugin_basename( $this->file ) ) . '/languages/' );
		}

		/*--------------------------------------------*
		 * Settings & Settings Page
		 *--------------------------------------------*/
		function pt_add_admin_menu()
		{ 
			$page_title = __('Pretty Block Testimonials', 'ptlg');
			$menu_title = __('Pretty Block Testimonials', 'ptlg');
			$capability = 'manage_options';
			$menu_slug = 'pretty-testimonials';
			$function =  array( &$this, 'pt_options_page');
			add_options_page($page_title, $menu_title, $capability, $menu_slug, $function);
		}

		/*--------------------------------------------*
		 * Enqueue Scripts
		 *--------------------------------------------*/
		function pt_enqueue_scripts()
		{
			wp_enqueue_style( 'css-slick-prettytest', plugins_url( '/assets/css/slick.css', __FILE__ ) );
			wp_enqueue_style( 'css-prettytest', plugins_url( '/assets/css/style.css', __FILE__ ) );
			wp_register_script('js-prettytest',  plugins_url( '/assets/js/slick.js', __FILE__ ), 'jquery', '1.1.0', false);

			wp_enqueue_script( 'jquery' );
			wp_enqueue_script( 'js-prettytest' );
		}

		/*--------------------------------------------*
		 * Settings Field Page
		 *--------------------------------------------*/
		function pt_settings_init()
		{ 
			register_setting( 'ptblock', 'pt_settings' );
			add_settings_section(
				'pt_ptblock_section', 
				__( 'Description', 'ptlg' ), 
				array( &$this, 'pt_settings_section_callback' ), 
				'ptblock'
			);

			add_settings_field( 
				'pt_checkbox_field_autoplay', 
				__( 'Auto play', 'ptlg' ), 
				array( &$this, 'pt_checkbox_autoplay_render' ), 
				'ptblock', 
				'pt_ptblock_section' 
			);

			add_settings_field( 
				'pt_text_field_speed', 
				__( 'AutoplaySpeed', 'ptlg' ),
				array( &$this, 'pt_text_speed_render' ),
				'ptblock', 
				'pt_ptblock_section' 
			);

			add_settings_field( 
				'pt_text_field_color', 
				__( 'Color', 'ptlg' ),
				array( &$this, 'pt_text_color_render' ),
				'ptblock', 
				'pt_ptblock_section' 
			);

			add_settings_field( 
				'pt_checkbox_field_pause', 
				__( 'Pause on Hover', 'ptlg' ), 
				array( &$this, 'pt_checkbox_pause_render' ), 
				'ptblock', 
				'pt_ptblock_section' 
			);

			add_settings_field( 
				'pt_select_field_model', 
				__( 'Model', 'ptlg' ),
				array( &$this, 'pt_select_model_render' ),
				'ptblock', 
				'pt_ptblock_section' 
			);

			add_settings_field( 'instructions', 
				__( 'Shortcode and Template Tag', 'dot' ), 
				array(&$this, 'pt_setting_instructions'), 
				'ptblock', 
				'pt_ptblock_section' );
		}

		/*--------------------------------------------*
		 * Field Checkbox AutoPlay
		 *--------------------------------------------*/
		function pt_checkbox_autoplay_render()
		{ 
			$options = get_option( 'pt_settings' );
			?>
			<input type='checkbox' name='pt_settings[pt_checkbox_field_autoplay]'  value="1" <?php checked( @$options['pt_checkbox_field_autoplay'], 1 ); ?>>
			<?php
		}

		/*--------------------------------------------*
		 * Field Checkbox Pause On Hover
		 *--------------------------------------------*/
		function pt_checkbox_pause_render()
		{ 
			$options = get_option( 'pt_settings' );
			?>
			<input type='checkbox' name='pt_settings[pt_checkbox_field_pause]'  value="1" <?php checked( @$options['pt_checkbox_field_pause'], 1 ); ?>>
			<?php
		}

		/*--------------------------------------------*
		 * Field Textbox Speed
		 *--------------------------------------------*/
		function pt_text_speed_render()
		{ 
			$options = get_option( 'pt_settings' );
			?>
			<input type='text' name='pt_settings[pt_text_field_speed]' value='<?php if( @$options['pt_text_field_speed'] > 0) echo $options['pt_text_field_speed']; else echo 5000;?>'> ms
			<?php
		}

		/*--------------------------------------------*
		 * Field Textbox Color
		 *--------------------------------------------*/
		function pt_text_color_render()
		{ 
			$options = get_option( 'pt_settings' );
			?>
			<input type='text' name='pt_settings[pt_text_field_color]' value='<?php if( @$options['pt_text_field_color'] != '') echo $options['pt_text_field_color']; else echo '#ffffff';?>'> (Hex color code, ex white: "#ffffff")
			<?php
		}

		/*--------------------------------------------*
		 * Field Select Model
		 *--------------------------------------------*/
		function pt_select_model_render()
		{ 
			$options = get_option( 'pt_settings' ); 
			?>
			<select name='pt_settings[pt_select_field_model]' id="model_testi">
				<option value='1' <?php selected( $options['pt_select_field_model'], 1 ); ?>>Demo 1</option>
				<option value='2' <?php selected( $options['pt_select_field_model'], 2 ); ?>>Demo 2</option>
				<option value='3' <?php selected( $options['pt_select_field_model'], 3 ); ?>>Demo 3</option>
				<option value='4' <?php selected( $options['pt_select_field_model'], 4 ); ?>>Demo 4</option>
			</select>
			<div class="panel" style="text-align:center">
				<img id="t1" class="img-thumbnail model-t" style="display:none" src="<?php print  plugins_url();?>/pretty-testimonials/assets/img/ex1.jpg">
				<img id="t2" class="img-thumbnail model-t" style="display:none" src="<?php print  plugins_url();?>/pretty-testimonials/assets/img/ex2.jpg">
				<img id="t3" class="img-thumbnail model-t" style="display:none" src="<?php print  plugins_url();?>/pretty-testimonials/assets/img/ex3.jpg">
				<img id="t4" class="img-thumbnail model-t" style="display:none" src="<?php print  plugins_url();?>/pretty-testimonials/assets/img/ex4.jpg">
			</div>
			<script language="javascript">
				jQuery(document).ready(function($) {
					jQuery('#t'+jQuery('#model_testi').val()).show();
				});
				jQuery('#model_testi').change(function(event) {
					jQuery('.model-t').hide();
					jQuery('#t'+jQuery(this).val()).show();
				});
			</script>
			<?php
		}
		/*--------------------------------------------*
		 * Register Post Type Testimonial
		 *--------------------------------------------*/
		function pt_reg_testimonials(){
			$labels = array(
				'name'               => __( 'Testimonials', 'ptlg' ),
				'singular_name'      => __( 'Testimonial', 'ptlg' ),
				'add_new'            => __( 'Add New', 'ptlg' ),
				'add_new_item'       => __( 'Add New Testimonial', 'ptlg' ),
				'edit_item'          => __( 'Edit Testimonial', 'ptlg' ),
				'new_item'           => __( 'New Testimonial', 'ptlg' ),
				'all_items'          => __( 'All Testimonial', 'ptlg' ),
				'view_item'          => __( 'View Testimonial', 'ptlg' ),
				'search_items'       => __( 'Search Testimonial', 'ptlg' ),
				'not_found'          => __( 'No Testimonial Found', 'ptlg' ),
				'not_found_in_trash' => __( 'No Testimonial Found in the Trash', 'ptlg' ), 
				'menu_name'          => __( 'Pretty Testimonial' )
			);
			
			$args = array(
				'labels'        => $labels,
				'description'   => __( 'Pretty Testimonials', 'ptlg' ),
				'public'        => true,
				'supports'      => array( 'title', 'thumbnail', 'editor'),
				'has_archive'   => true,
				'rewrite' => array('slug' => 'testimonials', 'with_front' => true),
				'query_var' => true
			);
			
			register_post_type( 'testimonials', $args );
			flush_rewrite_rules( false );	
		}

		/*--------------------------------------------*
		 * Register Custom Field For Post Type Testimonial
		 *--------------------------------------------*/
		function pt_init_metabox(){
		  add_meta_box('job', 'Byline', array(&$this,'pt_field_job'), 'testimonials', 'side');
		}
		function pt_field_job($post){
		  $job = get_post_meta($post->ID,'_job',true);
		  echo '<label for="job_meta">Job :</label>';
		  echo '<input id="job_meta" type="text" name="job_f" value="'.$job.'" />';
		}
		function pt_save_metabox($post_id){
			if(isset($_POST['job_f']))
			  update_post_meta($post_id, '_job', $_POST['job_f']);
		}

		/*--------------------------------------------*
		 * Show Bloc In Front
		 *--------------------------------------------*/
		function pt_show_blc_front()
		{
			$options = get_option( 'pt_settings' );
			$args = array(
				'post_type' => 'testimonials',
				'posts_per_page' => -1,
				'post_status' => 'publish',
				'orderby' => 'date',
				'order' => 'DESC'
			);
			$the_query = new WP_Query( $args );

			$autoplay = ( (int) $options['pt_checkbox_field_autoplay'] == 1 ) ? 'true' : 'false';
			$speed = $options['pt_text_field_speed'];
			$color = $options['pt_text_field_color'];
			$pausesl = ( (int) $options['pt_checkbox_field_pause'] == 1 ) ? 'true' : 'false';
			$model = $options['pt_select_field_model'];

			if( $model == 1 )
			{
				$data = '<style type="text/css">
							.tem-helper-right{
								background-color: '.$color.';
							}
							#model1 .arrow_box{
								background: '.$color.';
						    	border: 4px solid '.$color.';
							}
							#model1 .arrow_box:after,#model1 .arrow_box:before{
								border-right-color: '.$color.';
							}
						</style>
						<div class="tem-bloc-testimonial" id="model1">
							<div class="tem-items">
								<div class="tem-helper-right">
									<p class="tem-txt">“</p>
								</div>
								<div class="arrow_box"></div>
								<div class="tem-slick">
						';
				while ( $the_query->have_posts() ) {
					$the_query->the_post();
					$data.= '<div class="tem-single-item">
									<div class="tem-col-6 tem-img">
										<h2 class="tem-tit">'.__( "Testimonials", "ptlg" ).'</h2>
										<div>
											'.get_the_post_thumbnail( get_the_ID(), array('class'=>'img-responsive')).'
											<div>
												<h4>'.get_the_title().'</h4>
												<p>'.get_post_meta( get_the_ID(), '_job', true ).'</p>
											</div>
										</div>
									</div>
									<div class="tem-col-6 tem-infos">
										<p class="tem-desc">'.get_the_content().'</p>
									</div>
							</div>';
				}
				$data.= '</div></div></div>
							<script>
								var $play = '.$autoplay.';
								var $pause = '.$pausesl.';
								jQuery("#model1 .tem-slick").slick({
							      dots: true,
							      infinite: true,
							      fade: true,
							      speed: 500,
							      cssEase: "linear",
							      adaptiveHeight: true,
							      autoplay: '.$autoplay.',
							      pauseOnHover : '.$pausesl.',
							      autoplaySpeed: '.$speed.'
							    });
							</script>
						';
			}
			else if( $model == 2 )
			{
				$data .= '<style type="text/css">
							#model2 .tem-infos  .poste{
								color: '.$color.'
							}
							#model2 .tem-tit:after{
								background-color: '.$color.'
							}
						</style>
						<div class="tem-bloc-testimonial" id="model2">
						<div class="tem-items">
							<h2 class="tem-tit">'.__( "They say about us", "ptlg" ).'</h2>
							<div class="tem-slick">
						';
				while ( $the_query->have_posts() ) {
					$the_query->the_post();
					$data.= '<div class="tem-single-item">
								<div class="tem-img">
									'.get_the_post_thumbnail( get_the_ID(), array('class'=>'img-responsive')).'
								</div>
								<div class="tem-infos">
									<p>'.strip_tags(get_the_content()).'</p>
									<h4>'.get_the_title().'</h4>
									<p class="poste">'.get_post_meta( get_the_ID(), '_job', true ).'</p>
								</div>
							</div>';
				}
				$data.= '</div></div></div>';
			}
			else if( $model == 3 )
			{
				$data .= '<style type="text/css">
							#model3 .tem-single-item, #model3 .tem-tit:after{
								background-color: '.$color.'
							}
						</style>
						<div class="tem-bloc-testimonial" id="model3">
						<div class="tem-items">
							<h2 class="tem-tit">'.__( "Comments from our clients", "ptlg" ).'</h2>
							<div class="tem-slick">
						';
				while ( $the_query->have_posts() ) {
					$the_query->the_post();
					$data.= '<div class="tem-single-item">
								<div class="tem-img">
									'.get_the_post_thumbnail( get_the_ID(), array('class'=>'img-responsive')).'
									<h4>'.get_the_title().'</h4>
									<p class="poste">'.get_post_meta( get_the_ID(), '_job', true ).'</p>
									<p>'.strip_tags(get_the_content()).'</p>
								</div>
							</div>';
				}
				$data.= '</div></div></div>
						<script>
							var $play = '.$autoplay.';
							var $pause = '.$pausesl.';
							jQuery("#model3 .tem-slick").slick({
						      dots: false,
						      infinite: true,
						      speed: 500,
						      cssEase: "linear",
						      adaptiveHeight: true,
						      autoplay: $play,
						      pauseOnHover : $pause,
						      autoplaySpeed: '.$speed.',
						      slidesToShow: 3,
						  	  slidesToScroll: 1,
						      responsive: [
							    {
							      breakpoint: 1024,
							      settings: {
							        slidesToShow: 3,
							        slidesToScroll: 1,
							        infinite: true,
							        dots: true
							      }
							    },
							    {
							      breakpoint: 600,
							      settings: {
							        slidesToShow: 2,
							        slidesToScroll: 1
							      }
							    },
							    {
							      breakpoint: 420,
							      settings: {
							        slidesToShow: 1,
							        slidesToScroll: 1
							      }
							    }
							  ]
						    });
						</script>
				';
			}
			else if( $model == 4 )
			{
				$data .= '<style type="text/css">
							#model4 .tem-img h4,#model4 .slick-prev::before,#model4 .slick-next::before,#model4 .slick-dots li.slick-active button::before,#model4 .slick-dots li button::before,#model4 .tem-tit{
								color: '.$color.'
							}
							#model4 .tem-tit:after{
								background-color: '.$color.'
							}
						</style>
						<div class="tem-bloc-testimonial" id="model4">
						<div class="tem-items">
							<!--<h2 class="tem-tit">'.__( "What they say?", "ptlg" ).'</h2>-->
							<div class="tem-slick">
						';
				while ( $the_query->have_posts() ) {
					$the_query->the_post();
					$data.= '<div class="tem-single-item">
								<div class="tem-img">
									<div class="tem-bl-img">
										'.get_the_post_thumbnail( get_the_ID(), array('class'=>'img-responsive')).'
									</div>
									<div class="tem-infos">	
										<h4>'.get_the_title().'</h4>
										<p class="poste">'.get_post_meta( get_the_ID(), '_job', true ).'</p>
										<p>'.strip_tags(get_the_content()).'</p>
									</div>
								</div>
							</div>';
				}
				$data.= '</div></div></div>
						<script>
							var $play = '.$autoplay.';
							var $pause = '.$pausesl.';
							jQuery("#model4 .tem-slick").slick({
							      dots: true,
							      infinite: true,
							      speed: 500,
							      cssEase: "linear",
							      adaptiveHeight: true,
							      autoplay: $play,
							      fade : true,
							      pauseOnHover : '.$pausesl.',
							      autoplaySpeed: '.$speed.'
							    });
						</script>
				';
			}
			return $data;
		}

		/*--------------------------------------------*
		 * Show Bloc In Front
		 *--------------------------------------------*/
		function pt_shortcode( $atts )
		{
			return $this->pt_show_blc_front();
		}	

		/*--------------------------------------------*
		 * Field Section
		 *--------------------------------------------*/
		function pt_settings_section_callback()
		{ 
			echo __( 'Pretty Testimonials module helps you to adds a testimonial section with an elegant block on your website.', 'ptlg' );
		}

		/*--------------------------------------------*
		 * Setting Instruction
		 *--------------------------------------------*/
		function pt_setting_instructions()
		{
			echo '<p>'. __('To use Pretty Block testimonials in your posts and pages you can use the shortcode:', 'ptlg') .'</p>
			<p><code>[pt_pretty_testimonial]</code></p>
			<p>'. __('To use Pretty Block testimonials manually in your theme template use the following PHP code:', 'ptlg') .'</p>
			<p><code>&lt;?php if( function_exists(\'pt_pretty_testimonial\') ) pt_pretty_testimonial(); ?&gt;</code></p>';
		}

		/*--------------------------------------------*
		 * Random String
		 *--------------------------------------------*/
		public function pt_generateRandomString($length = 10) 
		{
		    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
		    $charactersLength = strlen($characters);
		    $randomString = '';
		    for ($i = 0; $i < $length; $i++) {
		        $randomString .= $characters[rand(0, $charactersLength - 1)];
		    }
		    return $randomString;
		}

		/*--------------------------------------------*
		 * Setting Option Page
		 *--------------------------------------------*/
		function pt_options_page()
		{ 
			?>
			<form action='options.php' method='post'>
				<h2>Pretty block Testimonials</h2>
				<?php
				settings_fields( 'ptblock' );
				do_settings_sections( 'ptblock' );
				submit_button();
				?>
			</form>
			<?php
		}
	}
	global $cpn;
	$cpn = new Pretty_Testimonials(__FILE__);
}

/*--------------------------------------------*
 * Template Tag
 *--------------------------------------------*/
function pt_pretty_testimonial()
{
	global $cpn;
	echo $cpn->pt_show_blc_front();
}
?>

