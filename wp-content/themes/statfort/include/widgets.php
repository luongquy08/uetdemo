<?php 
// widget start

// widget_facebook start



 
if ( ! class_exists( 'facebook_module' ) ) { 
    class facebook_module extends WP_Widget {      
        /**
         * Outputs the content of the widget
         *
         * @param array $args
         * @param array $instance
         */
         /**
         * @Facebook Module
         *
         *
         */
		public function __construct() {
		
			parent::__construct(
				'facebook_module', // Base ID
				__( 'CS : Facebook','logistic' ), // Name
				array( 'classname' => 'facebok_widget', 'description' =>esc_html__('Facebook widget like box total customized with theme.', 'logistic'), ) // Args
			);
		}
        /**
         * @Facebook html Form
         *
         *
         */
         function form($instance) {
                $instance = wp_parse_args( (array) $instance, array( 'title' => '' ) );
                $title = $instance['title'];
                $pageurl = isset( $instance['pageurl'] ) ? esc_attr( $instance['pageurl'] ) : '';
                $showfaces = isset( $instance['showfaces'] ) ? esc_attr( $instance['showfaces'] ) : '';
                $showstream = isset( $instance['showstream'] ) ? esc_attr( $instance['showstream'] ) : '';
                $showheader = isset( $instance['showheader'] ) ? esc_attr( $instance['showheader'] ) : '';
                $fb_bg_color = isset( $instance['fb_bg_color'] ) ? esc_attr( $instance['fb_bg_color'] ) : '';
                $likebox_height = isset( $instance['likebox_height'] ) ? esc_attr( $instance['likebox_height'] ) : '';         
				
				
				$width = isset( $instance['width'] ) ? esc_attr( $instance['width'] ) : '';   
				$hide_cover = isset( $instance['hide_cover'] ) ? esc_attr( $instance['hide_cover'] ) : '';   
				$show_posts = isset( $instance['show_posts'] ) ? esc_attr( $instance['show_posts'] ) : '';   
				$hide_cta = isset( $instance['hide_cta'] ) ? esc_attr( $instance['hide_cta'] ) : '';   
				$small_header = isset( $instance['small_header'] ) ? esc_attr( $instance['small_header'] ) : '';   
				$adapt_container_width = isset( $instance['adapt_container_width'] ) ? esc_attr( $instance['adapt_container_width'] ) : '';   
	              
            ?>
            <p>
            	<label for="<?php echo esc_attr($this->get_field_id('title')); ?>"><?php esc_html_e('Title','logistic');?>
                	<input class="upcoming" id="<?php echo esc_attr($this->get_field_id('title')); ?>" size='40' name="<?php echo esc_attr($this->                    get_field_name('title')); ?>" type="text" value="<?php echo esc_attr($title); ?>" />
              </label>
            </p>
            <p>
            	<label for="<?php echo esc_attr($this->get_field_id('pageurl')); ?>"><?php esc_html_e('Page Url','logistic');?> 
                <input class="upcoming" id="<?php echo cs_allow_special_char($this->get_field_id('pageurl')); ?>" size='40' name="<?php echo                 esc_attr($this->get_field_name('pageurl')); ?>" type="text" value="<?php echo esc_attr($pageurl); ?>" />
                <br />
                <small><?php esc_html_e('Please enter your page or User profile url example:L','logistic');?> http://www.facebook.com/profilename OR <br />
                https://www.facebook.com/pages/wxyz/123456789101112 </small><br />
              </label>
            </p>
            
           
            <p>
            	<label for="<?php echo cs_allow_special_char($this->get_field_id('fb_bg_color')); ?>"><?php esc_html_e('Background Color','logistic');?> 
                <input type="text" name="<?php echo cs_allow_special_char($this->get_field_name('fb_bg_color')); ?>" size='4' id="<?php echo cs_allow_special_char($this->get_field_id('fb_bg_color')); ?>"  value="<?php if(!empty($fb_bg_color))
				{ echo cs_allow_special_char($fb_bg_color);} ?>" class="fb_bg_color upcoming"  />
              </label>
            </p>   
            
             <p>
            	<label for="<?php echo cs_allow_special_char($this->get_field_id('width')); ?>"><?php esc_html_e('width','logistic');?> 
                <input class="upcoming" id="<?php echo cs_allow_special_char($this->get_field_id('width')); ?>" size='2' name="<?php echo cs_allow_special_char($this->get_field_name('width')); ?>" type="text" value="<?php echo esc_attr($width); ?>" />
              </label>
            </p>
            
              <p>
            	<label for="<?php echo cs_allow_special_char($this->get_field_id('likebox_height')); ?>"><?php esc_html_e('Like Box Height','logistic');?> 
                <input class="upcoming" id="<?php echo cs_allow_special_char($this->get_field_id('likebox_height')); ?>" size='2' name="<?php echo cs_allow_special_char($this->get_field_name('likebox_height')); ?>" type="text" value="<?php echo esc_attr($likebox_height); ?>" />
              </label>
            </p>
            
              <p>
            	<label for="<?php echo esc_attr($this->get_field_id('hide_cover')); ?>"><?php esc_html_e('Hide Cover','logistic');?> 
                <input class="upcoming" id="<?php echo esc_attr($this->get_field_id('hide_cover')); ?>" name="<?php echo esc_attr($this->get_field_name('hide_cover')); ?>" type="checkbox" <?php if(esc_attr($hide_cover) != '' ){echo 'checked';}?> />
              </label>
            </p>
            
            
              <p>
            	<label for="<?php echo esc_attr($this->get_field_id('showfaces')); ?>"><?php esc_html_e('Show Faces','logistic');?> 
                <input class="upcoming" id="<?php echo esc_attr($this->get_field_id('showfaces')); ?>" name="<?php echo esc_attr($this->get_field_name('showfaces')); ?>" type="checkbox" <?php if(esc_attr($showfaces) != '' ){echo 'checked';}?> />
              </label>
            </p>
            
            
              <p>
            	<label for="<?php echo esc_attr($this->get_field_id('show_posts')); ?>"><?php esc_html_e('Show Posts','logistic');?> 
                <input class="upcoming" id="<?php echo esc_attr($this->get_field_id('show_posts')); ?>" name="<?php echo esc_attr($this->get_field_name('show_posts')); ?>" type="checkbox" <?php if(esc_attr($show_posts) != '' ){echo 'checked';}?> />
              </label>
            </p>
            
            
              <p>
            	<label for="<?php echo esc_attr($this->get_field_id('hide_cta')); ?>"><?php esc_html_e('Hide Cta','logistic');?> 
                <input class="upcoming" id="<?php echo esc_attr($this->get_field_id('hide_cta')); ?>" name="<?php echo esc_attr($this->get_field_name('hide_cta')); ?>" type="checkbox" <?php if(esc_attr($hide_cta) != '' ){echo 'checked';}?> />
              </label>
            </p>
            
              <p>
            	<label for="<?php echo esc_attr($this->get_field_id('small_header')); ?>"><?php esc_html_e('Small Header','logistic');?> 
                <input class="upcoming" id="<?php echo esc_attr($this->get_field_id('small_header')); ?>" name="<?php echo esc_attr($this->get_field_name('small_header')); ?>" type="checkbox" <?php if(esc_attr($small_header) != '' ){echo 'checked';}?> />
              </label>
            </p>
            
                    <p>
            	<label for="<?php echo esc_attr($this->get_field_id('adapt_container_width')); ?>"><?php esc_html_e('Adapt width','logistic');?> 
                <input class="upcoming" id="<?php echo esc_attr($this->get_field_id('adapt_container_width')); ?>" name="<?php echo esc_attr($this->get_field_name('adapt_container_width')); ?>" type="checkbox" <?php if(esc_attr($adapt_container_width) != '' ){echo 'checked';}?> />
              </label>
            </p>
                     
            <?php       
        }        
        /**
         * @Facebook Update Form Data
         *
         *
         */
         function update($new_instance, $old_instance) {    
			$instance = $old_instance;
			$instance['title'] = $new_instance['title'];
			$instance['pageurl'] = $new_instance['pageurl'];
			$instance['showfaces'] = $new_instance['showfaces'];    
			$instance['showstream'] = $new_instance['showstream'];
			$instance['showheader'] = $new_instance['showheader'];
			$instance['fb_bg_color'] = $new_instance['fb_bg_color'];        
			$instance['likebox_height'] = $new_instance['likebox_height'];
			
			$instance['width'] = $new_instance['width'];
			$instance['hide_cover'] = $new_instance['hide_cover'];
			$instance['show_posts'] = $new_instance['show_posts'];
			$instance['hide_cta'] = $new_instance['hide_cta'];
			$instance['small_header'] = $new_instance['small_header'];
			$instance['adapt_container_width'] = $new_instance['adapt_container_width'];
		 
 
			return $instance;
        }
        /**
         * @Facebook Widget Display
         *
         *
         */
         function widget($args, $instance) {    
            extract($args, EXTR_SKIP);
            $title = empty($instance['title']) ? '' : apply_filters('widget_title', $instance['title']);
			$title = htmlspecialchars_decode(stripslashes($title));
            $pageurl = empty($instance['pageurl']) ? ' ' : apply_filters('widget_title', $instance['pageurl']);
            $showfaces = empty($instance['showfaces']) ? ' ' : apply_filters('widget_title', $instance['showfaces']);
            $showstream = empty($instance['showstream']) ? ' ' : apply_filters('widget_title', $instance['showstream']);
            $showheader = empty($instance['showheader']) ? ' ' : apply_filters('widget_title', $instance['showheader']);
            $fb_bg_color = empty($instance['fb_bg_color']) ? ' ' : apply_filters('widget_title', $instance['fb_bg_color']);                        
            $likebox_height = empty($instance['likebox_height']) ? ' ' : apply_filters('widget_title', $instance['likebox_height']);
			
			 $width = empty($instance['width']) ? ' ' : apply_filters('widget_title', $instance['width']);
			 $hide_cover = empty($instance['hide_cover']) ? ' ' : apply_filters('widget_title', $instance['hide_cover']);
			 $show_posts = empty($instance['show_posts']) ? ' ' : apply_filters('widget_title', $instance['show_posts']);
			 $hide_cta = empty($instance['hide_cta']) ? ' ' : apply_filters('widget_title', $instance['hide_cta']);
		     $small_header = empty($instance['small_header']) ? ' ' : apply_filters('widget_title', $instance['small_header']);
			 $adapt_container_width = empty($instance['adapt_container_width']) ? ' ' : apply_filters('widget_title', $instance['adapt_container_width']);
		 
				   
			if(isset($showfaces) AND $showfaces == 'on'){$showfaces ='true';}else{$showfaces = 'false';}
            if(isset($showstream) AND $showstream == 'on'){$showstream ='true';}else{$showstream ='false';}
			
				if(isset($hide_cover) AND $hide_cover == 'on'){$hide_cover ='true';}else{$hide_cover ='false';}
				if(isset($show_posts) AND $show_posts == 'on'){$show_posts ='true';}else{$show_posts ='false';}
				if(isset($hide_cta) AND $hide_cta == 'on'){$hide_cta ='true';}else{$hide_cta ='false';}
				if(isset($small_header) AND $small_header == 'on'){$small_header ='true';}else{$small_header ='false';}
				if(isset($adapt_container_width) AND $adapt_container_width == 'on'){$adapt_container_width ='true';}else{$adapt_container_width ='false';}
		 
				  
           		echo cs_allow_special_char($before_widget);
			?>
            <style scoped>
				.facebookOuter {background-color:<?php echo cs_allow_special_char($fb_bg_color);?>; width:100%;padding:0;float:left;}
				.facebookInner {float: left; width: 100%;}
				.facebook_module, .fb_iframe_widget > span, .fb_iframe_widget > span > iframe { width: 100% !important;}
				.fb_iframe_widget, .fb-like-box div span iframe { width: 100% !important; float: left;}
			</style>
            <?php
            if (!empty($title) && $title <> ' '){
                echo cs_allow_special_char($before_title);
                echo cs_allow_special_char($title);
                echo cs_allow_special_char($after_title);
            }    
        global $wpdb, $post;?>		
        
        	<div id="fb-root"></div>
			<script>(function(d, s, id) {
              var js, fjs = d.getElementsByTagName(s)[0];
              if (d.getElementById(id)) return;
              js = d.createElement(s); js.id = id;
               js.src = "//connect.facebook.net/en_US/sdk.js#xfbml=1&version=v2.3";
              fjs.parentNode.insertBefore(js, fjs);
            }(document, 'script', 'facebook-jssdk'));</script>
			
            <?php
	 
		$output  = '';
$output .= '<div style="background:' . esc_attr( $instance['fb_bg_color'] ) . ';" class="fb-like-box" '; 
$output .= ' data-href="'.esc_url($pageurl).'"';
$output .= ' data-width="'.$width.'" ';
$output .= ' data-height="'.$likebox_height.'" ';
$output .= ' data-hide-cover="'.$hide_cover.'" ';
$output .= ' data-show-facepile="'.$showfaces.'" ';
$output .= ' data-show-posts="'.$show_posts.'">';
$output .= ' </div>';
	  	echo cs_allow_special_char($output);
		
	  echo cs_allow_special_char($after_widget);
		}
	}    
}
add_action( 'widgets_init', create_function('', 'return register_widget("facebook_module");'));

	// widget_facebook end

class cs_social_network_widget extends WP_Widget

{
/*
  function cs_social_network_widget()

  {

		$widget_ops = array('classname' => 'widget_text', 'description' => 'Social Newtork widget.' );
		parent::__construct('cs_social_network_widget', __('CS : Social Newtork', 'Statfort'), $widget_ops);

  }
  */
  /*
public function __construct() {
  
   parent::__construct(
    'cs_social_network_widget', // Base ID
    __( 'CS : Social Newtork','Statfort' ), // Name
    array( 'classname' => 'widget_text', 'description' =>__('Social Newtork widget.', 'Statfort'), ) // Args
   );
  }
  */
  public function __construct() {
  
   parent::__construct(
    'cs_social_network_widget', // Base ID
    __( 'CS : Social Newtork','Statfort' ), // Name
    array( 'classname' => 'widget_text', 'description' =>esc_html__('Social Newtork widget.', 'Statfort'), ) // Args
   );
  }
  
  function form($instance)

  {

		$instance = wp_parse_args( (array) $instance, array( 'title' => '' ) );

		$title = $instance['title'];

	?>

	  <p>

	  <label for="<?php echo $this->get_field_id('title'); ?>">

		  Title: 

		  <input class="upcoming" id="<?php echo $this->get_field_id('title'); ?>" size='40' name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo esc_attr($title); ?>" />

	  </label>

	  </p> 


	<?php

	  }

	  function update($new_instance, $old_instance)

	  {

		$instance = $old_instance;

		$instance['title'] = $new_instance['title'];

		return $instance;

	  }

		function widget($args, $instance)

		{

			extract($args, EXTR_SKIP);

			$title = empty($instance['title']) ? ' ' : apply_filters('widget_title', $instance['title']);
			

			echo $before_widget;	

			// WIDGET display CODE Start

			if (!empty($title) && $title <> ' '){

				echo $before_title;

				echo $title;

				echo $after_title;

			}

				global $wpdb, $post;
				echo '<div class="followus">';
					cs_social_network_widget();
				echo '</div>';

				echo $after_widget;

			}

			

		}

	add_action( 'widgets_init', create_function('', 'return register_widget("cs_social_network_widget");') );

	// widget_social network end

	// widget_gallery start

	class cs_gallery extends WP_Widget {

		
		/*
		function cs_gallery() {

			$widget_ops = array('classname' => 'widget_gallery', 'description' => 'Select any gallery to show in widget.');
			parent::__construct('cs_gallery', __('CS : Gallery Widget', 'Statfort'), $widget_ops);

		}
		*/
		public function __construct() {
  
			parent::__construct(
			'cs_gallery', // Base ID
			__( 'CS : Gallery Widget','Statfort' ), // Name
			array( 'classname' => 'widget_gallery', 'description' =>esc_html__('Select any gallery to show in widget.', 'Statfort'), ) // Args
		   );
		}

	

		function form($instance) {

			$instance = wp_parse_args((array) $instance, array('title' => '', 'get_names_gallery' => 'new'));

			$title = $instance['title'];

			$get_names_gallery = isset($instance['get_names_gallery']) ? esc_attr($instance['get_names_gallery']) : '';

			$showcount = isset($instance['showcount']) ? esc_attr($instance['showcount']) : '';

			?>

			<p>

				<label for="<?php echo $this->get_field_id('title'); ?>">

					Title: 

					<input class="upcoming" id="<?php echo $this->get_field_id('title'); ?>" size="40" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo esc_attr($title); ?>" />

				</label>

			</p>

			<p>

				<label for="<?php echo $this->get_field_id('get_names_gallery'); ?>">

					Select Gallery:

					<select id="<?php echo $this->get_field_id('get_names_gallery'); ?>" name="<?php echo $this->get_field_name('get_names_gallery'); ?>" style="width:225px;">

						<?php

						global $wpdb, $post;

						$newpost = 'posts_per_page=-1&post_type=cs_gallery&order=ASC&post_status=publish';

						$newquery = new WP_Query($newpost);

						while ($newquery->have_posts()): $newquery->the_post();

							?>

							<option <?php

							if (esc_attr($get_names_gallery) == $post->post_name) {

								echo 'selected';

							}

							?> value="<?php echo $post->post_name; ?>" >

							<?php echo substr(get_the_title($post->ID), 0, 20);

							if (strlen(get_the_title($post->ID)) > 20)

								echo "...";

							?>

							</option>						

						<?php endwhile; ?>

					</select>

				</label>

			</p>  

			 

			<p>

				<label for="<?php echo $this->get_field_id('showcount'); ?>">

					Number of Images: 

					<input class="upcoming" id="<?php echo $this->get_field_id('showcount'); ?>" size="2" name="<?php echo $this->get_field_name('showcount'); ?>" type="text" value="<?php echo esc_attr($showcount); ?>" />

				</label>

			</p>  

			<?php

		}

	

		function update($new_instance, $old_instance) {



			$instance = $old_instance;

			$instance['title'] = $new_instance['title'];

			$instance['get_names_gallery'] = $new_instance['get_names_gallery'];

			$instance['showcount'] = $new_instance['showcount'];

  			return $instance;

		}

	

		function widget($args, $instance) {

			extract($args, EXTR_SKIP);

			global $wpdb, $post;

			$title = empty($instance['title']) ? ' ' : apply_filters('widget_title', $instance['title']);

			$get_names_gallery = isset($instance['get_names_gallery']) ? esc_attr($instance['get_names_gallery']) : '';

			$showcount = isset($instance['showcount']) ? esc_attr($instance['showcount']) : '';

			if (empty($showcount)) {

				 $showcount = '12';

			}

			

			// WIDGET display CODE Start

			echo $before_widget;

			if (strlen($get_names_gallery) <> 1 || strlen($get_names_gallery) <> 0) {

				echo $before_title . $title . $after_title;

			}

 			if ($get_names_gallery <> '') {

 				// galery slug to id start

				$get_gallery_id = '';

				$args=array(

					'name' => $get_names_gallery,

					'post_type' => 'cs_gallery',

					'post_status' => 'publish',

					'showposts' => 1,

				);

				$get_posts = get_posts($args);

 				if($get_posts){

					$get_gallery_id = $get_posts[0]->ID;

				}

				// galery slug to id end

				if($get_gallery_id <> ''){

				$cs_meta_gallery_options = get_post_meta($get_gallery_id, "cs_meta_gallery_options", true);

				if ($cs_meta_gallery_options <> "") {

					$cs_xmlObject = new SimpleXMLElement($cs_meta_gallery_options);

					if ($showcount > count($cs_xmlObject)) {

						$showcount = count($cs_xmlObject);

					}

				?>

				<ul class="gallery-list lightbox">

					<?php

 
 						for ($i = 0; $i < $showcount; $i++) {

							$path = $cs_xmlObject->gallery[$i]->path;

							$title = $cs_xmlObject->gallery[$i]->title;

							$social_network = $cs_xmlObject->gallery[$i]->social_network;

							$use_image_as = $cs_xmlObject->gallery[$i]->use_image_as;

							$video_code = $cs_xmlObject->gallery[$i]->video_code;

							$link_url = $cs_xmlObject->gallery[$i]->link_url;

							$image_url = cs_attachment_image_src($path, 50, 50);

							$image_url_full = cs_attachment_image_src($path, 0, 0);

						?>

						 <li>

							<a <?php if ( $title <> '' ) { echo 'data-title="'.$title.'"'; }?> href="<?php if ($use_image_as == 1)echo $video_code;  elseif($use_image_as==2) echo $link_url; else echo $image_url_full;?>" target="<?php if($use_image_as==2){ echo '_blank'; }else{ echo '_self'; }; ?>" data-rel="<?php if ($use_image_as == 1) echo "prettyPhoto"; elseif($use_image_as==2) echo ""; else echo "prettyPhoto[gallery1]"?>"><?php echo "<img width='60' height='60' src='" . $image_url . "' data-alt='" . $title . "' alt='' />" ?></a>

						</li>

				<?php } ?>

				</ul>

			 <?php }}else{

					fnc_no_result_found(false);

				 }}     // endif of Category Selection?>

				

			 <?php

 			echo $after_widget; // WIDGET display CODE End

		}

	

	}

	

	add_action('widgets_init', create_function('', 'return register_widget("cs_gallery");'));

	// widget_gallery end

	// widget_recent_post start

	class recentposts extends WP_Widget

	{
		/*
	  function recentposts()

	  {

		$widget_ops = array('classname' => 'widget-recent-blog', 'description' => 'Recent Posts from category.' );
		parent::__construct('recentposts', __('CS : Recent Posts', 'Statfort'), $widget_ops);

	  }

	 */
	 public function __construct() {
  
	   parent::__construct(
		'recentposts', // Base ID
		__( 'CS : Recent Posts','Statfort' ), // Name
		array( 'classname' => 'widget-recent-blog', 'description' =>esc_html__('Recent Posts from category.', 'Statfort'), ) // Args
	   );
	}
	 

	  function form($instance)

	  {

		$instance = wp_parse_args( (array) $instance, array( 'title' => '' ) );

		$title = $instance['title'];

		$select_category = isset( $instance['select_category'] ) ? esc_attr( $instance['select_category'] ) : '';

		$showcount = isset( $instance['showcount'] ) ? esc_attr( $instance['showcount'] ) : '';	

		$thumb = isset( $instance['thumb'] ) ? esc_attr( $instance['thumb'] ) : '';

	?>

		<p>

			<label for="<?php echo $this->get_field_id('title'); ?>">

				Title: 

				<input class="upcoming" id="<?php echo $this->get_field_id('title'); ?>" size="40" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo esc_attr($title); ?>" />

			</label>

		</p> 

		<p>

			<label for="<?php echo $this->get_field_id('select_category'); ?>">

			  Select Category:            

			  <select id="<?php echo $this->get_field_id('select_category'); ?>" name="<?php echo $this->get_field_name('select_category'); ?>" style="width:225px">

				<?php

				$categories = get_categories();

					if($categories <> ""){

						foreach ( $categories as $category ) {?>

							<option <?php if($select_category == $category->slug){echo 'selected';}?> value="<?php echo $category->slug;?>" ><?php echo $category->name;?></option>						

						<?php }?>

					<?php }?>            

			  </select>

			</label>

		</p>  

		<p>

			<label for="<?php echo $this->get_field_id('showcount'); ?>">

				Number of Posts To Display:

				<input class="upcoming" id="<?php echo $this->get_field_id('showcount'); ?>" size='2' name="<?php echo $this->get_field_name('showcount'); ?>" type="text" value="<?php echo esc_attr($showcount); ?>" />

			</label>

		</p>

		<p>

			<label for="<?php echo $this->get_field_id('thumb'); ?>">

				Display Thumbinals:

				<input class="upcoming" id="<?php echo $this->get_field_id('thumb'); ?>" size='2' name="<?php echo $this->get_field_name('thumb'); ?>" value="true" type="checkbox"  <?php if(isset($instance['thumb']) && $instance['thumb']=='true' ) echo 'checked="checked"'; ?> />

			</label>

		</p>

	<?php

	  }

	 

	  function update($new_instance, $old_instance)

	  {

		$instance = $old_instance;

		$instance['title'] = $new_instance['title'];

		$instance['select_category'] = $new_instance['select_category'];

		$instance['showcount'] = $new_instance['showcount'];

		$instance['thumb'] = $new_instance['thumb'];

		return $instance;

	  }

	 

		function widget($args, $instance)

		{

			global $cs_node;

			extract($args, EXTR_SKIP);

			$title = empty($instance['title']) ? ' ' : apply_filters('widget_title', $instance['title']);

			$select_category = empty($instance['select_category']) ? ' ' : apply_filters('widget_title', $instance['select_category']);		

			$showcount = empty($instance['showcount']) ? ' ' : apply_filters('widget_title', $instance['showcount']);	

			$thumb = isset( $instance['thumb'] ) ? esc_attr( $instance['thumb'] ) : '';						

	

			if($instance['showcount'] == ""){$instance['showcount'] = '-1';}

			echo $before_widget;	

			// WIDGET display CODE Start

			if (!empty($title) && $title <> ' '){

				echo $before_title;

				echo $title;

				echo $after_title;

			}

				global $wpdb, $post;?>

				<!-- Recent Posts Start -->

 						<?php

							wp_reset_query();

							$args = array( 'posts_per_page' => "$showcount",'post_type' => 'post','category_name' => "$select_category"); 

							$custom_query = new WP_Query($args);

							if ( $custom_query->have_posts() <> "" ) {

								while ( $custom_query->have_posts()) : $custom_query->the_post();

								$post_xml = get_post_meta($post->ID, "post", true);	

								$cs_xmlObject = new stdClass();

								if ( $post_xml <> "" ) {

									$cs_xmlObject = new SimpleXMLElement($post_xml);
									
 
 									$width 	= 150;

									$height = 150;

 									$image_url = cs_get_post_img_src($post->ID, $width, $height);
									if($image_url == ''){
										$cs_noimage ='cs-noimage';	
									}else{
										$cs_noimage = '';
									}

 								}

								?>

									<!-- Upcoming Widget Start -->

									<article class="<?php echo $cs_noimage; ?>">

										<?php if($thumb == "true"){?>

											

												<?php

												if($image_url <> ''){

 
													echo "<figure><a class='fa fa-hover' href='".get_permalink()."' ><img src='".$image_url."' alt='' width='60'></a></figure>";												 

												}

												?>

                                             

                                            <div class="text">

                                            	<h6><a class="colrhvr" href="<?php the_permalink();?>"><?php echo substr(get_the_title(),0,30); if ( strlen(get_the_title()) > 30) echo "..."; ?></a></h6>	

                                                <time datetime="<?php echo date('Y-m-d',strtotime(get_the_date()));?>"><?php echo get_the_date();?></time>

                                            </div>

											 

										<?php }else{ ?>

											 <div class="text">

                                            	<h6><a class="colrhvr" href="<?php echo get_permalink();?>"><?php echo substr(get_the_title(),0,30);if ( strlen(get_the_title()) > 30) echo "..."; ?></a></h6>	

                                                <time datetime="<?php echo date('Y-m-d',strtotime(get_the_date()));?>"><?php echo get_the_date();?></time>

                                            </div>

										<?php } ?>

									</article>                 

								<?php endwhile; ?>

							<?php

                            }

							else {

								fnc_no_result_found(false);

							}?>

  				<!-- Recent Posts End -->     

				<?php

				echo $after_widget;

			}

		}

		add_action( 'widgets_init', create_function('', 'return register_widget("recentposts");') );

	// widget_recent_post end

	// widget_twitter start

 	class cs_twitter_widget extends WP_Widget {
		/*
		function cs_twitter_widget() {
			$widget_ops = array('classname' => 'widget widget-latestnews widget-twitter', 'description' => 'Twitter Widget');
			parent::__construct('cs_twitter_widget', __('CS : Twitter Widget', 'Statfort'), $widget_ops);
		}
		*/
		public function __construct() {
  
		   parent::__construct(
			'cs_twitter_widget', // Base ID
			__( 'CS : Twitter Widget','Statfort' ), // Name
			array( 'classname' => 'widget widget-latestnews widget-twitter', 'description' =>esc_html__('Twitter Widget.', 'Statfort'), ) // Args
		   );
		}
		function form($instance) {
			$instance = wp_parse_args((array) $instance, array('title' => ''));
			$title = $instance['title'];
			$username = isset($instance['username']) ? esc_attr($instance['username']) : '';
			$numoftweets = isset($instance['numoftweets']) ? esc_attr($instance['numoftweets']) : '';
 		?>
          	<label for="<?php echo $this->get_field_id('title'); ?>">
				<span>Title: </span>
				<input class="upcoming" id="<?php echo $this->get_field_id('title'); ?>" size="40" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo esc_attr($title); ?>" />
			</label>
			<label for="screen_name">User Name<span class="required">(*)</span>: </label>
				<input class="upcoming" id="<?php echo $this->get_field_id('username'); ?>" size="40" name="<?php echo $this->get_field_name('username'); ?>" type="text" value="<?php echo esc_attr($username); ?>" />
            <label for="tweet_count">
			<span>Num of Tweets: </span>
			<input class="upcoming" id="<?php echo $this->get_field_id('numoftweets'); ?>" size="2" name="<?php echo $this->get_field_name('numoftweets'); ?>" type="text" value="<?php echo esc_attr($numoftweets); ?>" />
			<div class="clear"></div>
			</label>
  		<?php
		}
	
		function update($new_instance, $old_instance) {
			$instance = $old_instance;
			$instance['title'] = $new_instance['title'];
			$instance['username'] = $new_instance['username'];
			$instance['numoftweets'] = $new_instance['numoftweets'];
			
 			return $instance;
		}
  	 
		
		function widget($args, $instance) {
            global $cs_theme_option, $cs_twitter_arg;

           
			$cs_twitter_arg['consumerkey'] = isset($cs_theme_option['consumer_key']) ? $cs_theme_option['consumer_key'] : '';
			$cs_twitter_arg['consumersecret'] = isset($cs_theme_option['consumer_secret']) ? $cs_theme_option['consumer_secret'] : '';
			$cs_twitter_arg['accesstoken'] = isset($cs_theme_option['access_token']) ? $cs_theme_option['access_token'] : '';
			$cs_twitter_arg['accesstokensecret'] = isset($cs_theme_option['access_token_secret']) ? $cs_theme_option['access_token_secret'] : '';
            $cache_limit_time = isset($cs_theme_option['cache_limit_time']) ? $cs_theme_option['cache_limit_time'] : '';
            $tweet_num_from_twitter = isset($cs_theme_option['tweet_num_post']) ? $cs_theme_option['tweet_num_post'] : '';
            $twitter_datetime_formate = isset($cs_theme_option['twitter_datetime_formate']) ? $cs_theme_option['twitter_datetime_formate'] : '';
            
            if ($cache_limit_time == '') {
                $cache_limit_time = 60;
            }
            if ($twitter_datetime_formate == '') {
                $twitter_datetime_formate = 'time_since';
            }
            if ($tweet_num_from_twitter == '') {
                $tweet_num_from_twitter = 5;
            }

            extract($args, EXTR_SKIP);
            $title = empty($instance['title']) ? '' : apply_filters('widget_title', $instance['title']);
            $title = htmlspecialchars_decode(stripslashes($title));
            $username = $instance['username'];
            $numoftweets = $instance['numoftweets'];
            if ($numoftweets == '') {
                $numoftweets = 2;
            }
		
            echo cs_allow_special_char($before_widget);
            // WIDGET display CODE Start
            if (!empty($title) && $title <> ' ') {
                echo cs_allow_special_char($before_title . $title . $after_title);
            }
            if (strlen($username) > 1) {
				if($cs_twitter_arg['consumerkey'] <> '' && $cs_twitter_arg['consumersecret'] <> '' &&  $cs_twitter_arg['accesstoken'] <> '' && $cs_twitter_arg['accesstokensecret'] <> '')
				{
                require_once get_template_directory() . '/include/twitteroauth/display-tweets.php';
                display_tweets($username,$twitter_datetime_formate , $tweet_num_from_twitter, $numoftweets, $cache_limit_time);
				}
				else{
					echo '<p>Please Set Twitter API</p>';
				}
            }
			 echo cs_allow_special_char($after_widget);
        }
 	}
 	add_action('widgets_init', create_function('', 'return register_widget("cs_twitter_widget");'));
	
	

	// widget_twitter end



// widget end


// Event Widget



class upcoming_events extends WP_Widget

{
/*
  function upcoming_events()

  {

    $widget_ops = array('classname' => 'widget-latest-event fullwidth', 'description' => 'Select Event to show its countdown.' );
	parent::__construct('upcoming_events', __('CS : Upcoming Events', 'Statfort'), $widget_ops);

  }
*/
	public function __construct() {
	  
			   parent::__construct(
				'upcoming_events', // Base ID
				__( 'CS : Upcoming Events','Statfort' ), // Name
				array( 'classname' => 'widget-latest-event fullwidth', 'description' =>esc_html__('Select Event to show its countdown.', 'Statfort'), ) // Args
			   );
	}
 

  function form($instance)

  {

    $instance = wp_parse_args( (array) $instance, array( 'title' => '' ,'widget_names_events' =>'new') );

    $title = $instance['title'];

	$get_post_slug = isset( $instance['get_post_slug'] ) ? esc_attr( $instance['get_post_slug'] ) : '';

	$showcount = isset( $instance['showcount'] ) ? esc_attr( $instance['showcount'] ) : '';	

?>

  <p>

  <label for="<?php echo $this->get_field_id('title'); ?>">

	  Title: 

	  <input class="upcoming" id="<?php echo $this->get_field_id('title'); ?>" size="40" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo esc_attr($title); ?>" />

  </label>

  </p>

  <p>

  <label for="<?php echo $this->get_field_id('get_post_slug'); ?>">

	  Select Event:

	  <select id="<?php echo $this->get_field_id('get_post_slug'); ?>" name="<?php echo $this->get_field_name('get_post_slug'); ?>" style="width:225px">

      	<option value=""> Select Category</option>

		<?php

        global $wpdb,$post;

		$categories = get_categories('taxonomy=event-category&child_of=0&hide_empty=0'); 

			if($categories != ''){}

				foreach ( $categories as $category){ ?>

                    <option <?php if(esc_attr($get_post_slug) == $category->slug){echo 'selected';}?> value="<?php echo $category->slug;?>" >

	                    <?php echo substr($category->name, 0, 20);	if ( strlen($category->name) > 20 ) echo "...";?>

                    </option>						

			<?php }?>

      </select>

  </label>

  </p>

  <p>

  <label for="<?php echo $this->get_field_id('showcount'); ?>">

	  Number of Events: 

	  <input class="upcoming" id="<?php echo $this->get_field_id('showcount'); ?>" size="2" name="<?php echo $this->get_field_name('showcount'); ?>" type="text" value="<?php echo esc_attr($showcount); ?>" />

  </label>

  </p>  

<?php

  }

 

  function update($new_instance, $old_instance)

  {

    $instance = $old_instance;

    $instance['title'] = $new_instance['title'];

	$instance['get_post_slug'] = $new_instance['get_post_slug'];	

	$instance['showcount'] = $new_instance['showcount'];		

	

	

    return $instance;

  }

 

	function widget($args, $instance)

	{

		extract($args, EXTR_SKIP);

		$title = empty($instance['title']) ? ' ' : apply_filters('widget_title', $instance['title']);

		$get_post_slug = isset( $instance['get_post_slug'] ) ? esc_attr( $instance['get_post_slug'] ) : '';

		$showcount = isset( $instance['showcount'] ) ? esc_attr( $instance['showcount'] ) : '';		

		if(empty($showcount)){$showcount = '4';}

		// WIDGET display CODE Start

		echo $before_widget;	

		wp_reset_query();	

		if (!empty($title) && $title <> ' '){

				echo $before_title . $title . $after_title;

			}

			global $wpdb, $post;

 			//$term = get_term( $get_names_events, 'event-category' );
			date_default_timezone_set('UTC');
			$current_time = current_time('Y-m-d H:i', $gmt = 0 ); 

 			if($get_post_slug <> ''){

				$newterm = get_term_by('slug', $get_post_slug, 'event-category'); 

					$args = array(

						'posts_per_page'			=> $showcount,

						'post_type'					=> 'events',

						'event-category'			=> "$get_post_slug",

                        'post_status'				=> 'publish',

                        'meta_key'					=> 'cs_event_from_date_time',

                        'meta_value'				=> $current_time,

                        'meta_compare'				=> ">",

                        'orderby'					=> 'meta_value',

                        'order'						=> 'ASC'

 					);

                    $custom_query = new WP_Query($args);

					if ( $custom_query->have_posts() <> "" ) {

						

 						$cs_counter_events = 0;

                        while ( $custom_query->have_posts() ): $custom_query->the_post();

							$cs_counter_events++;

							$cs_event_from_date = get_post_meta($post->ID, "cs_event_from_date", true); 

							$year_event = date("Y", strtotime($cs_event_from_date));

							$month_event = date("M", strtotime($cs_event_from_date));

							$day_event = date("d", strtotime($cs_event_from_date));

							$cs_event_meta = get_post_meta($post->ID, "cs_event_meta", true);

							if ( $cs_event_meta <> "" ) {

								$cs_event_meta = new SimpleXMLElement($cs_event_meta);

								$event_start_time = $cs_event_meta->event_start_time;

								$event_end_time = $cs_event_meta->event_end_time;

							}

							$cs_event_loc = get_post_meta($cs_event_meta->event_address, "cs_event_loc_meta", true);

 						?>

                         <!-- Events Widget Start -->
						
                        <article>
                            <div class="text">
                            <h6><a href="<?php echo get_permalink(); ?>" class="colrhvr"><?php

									echo substr(get_the_title(), 0, 39);

									if (strlen(get_the_title()) > 39)

										echo "...";

									?></a></h6>
                            <time datetime="2011-01-12"><?php echo date(get_option('date_format'),strtotime($cs_event_from_date));?></time>
                            </div>
                            <div class="post-options">
                                <ul>
                                    <li><em class="fa fa-clock-o"></em>
                                    <?php 
										if ( $cs_event_meta->event_all_day != "on" ) {
											
											echo $event_start_time; if($cs_event_meta->event_end_time <> ''){ echo "-";  echo $cs_event_meta->event_end_time; }
											
										} else {
                                               echo '<time>';
                                                    _e("All",'Statford') . printf( __("%s day",'Statford'), ' ');
                                               echo '</time>';
										}
									
									?>
                                    </li>
                                    <li><em class="fa fa-map-marker"></em><?php echo get_the_title((int) $cs_event_meta->event_address); ?>.</li>
                                </ul>
                            </div>
                        </article>

                        <!-- Events Widget End -->		

 						<?php endwhile;?>

                        						

 					<?php }else{

							fnc_no_result_found(false);

						}

			}	// endif of Category Selection

			echo $after_widget;	// WIDGET display CODE End

		}

	}

add_action( 'widgets_init', create_function('', 'return register_widget("upcoming_events");') );

// MailChimp Widget

class chimp_MailChimp_Widget extends WP_Widget {

	private $default_failure_message;

	public $default_loader_graphic;

	private $default_signup_text;

	private $default_success_message;

	private $default_title;

	private $successful_signup = false;

	private $subscribe_errors;

	private $ns_mc_plugin;

	

	

	

	/**

	 * @author James Lafferty

	 * @since 0.1

	 */
/*
	public function chimp_MailChimp_Widget () {

		$this->default_failure_message = __('There was a problem processing your submission.', 'Statfort');

		$this->default_signup_text = __('Join now!', 'Statfort');

		$this->default_success_message = __('Thank you for joining our mailing list. Please check your email for a confirmation link.', 'Statfort');

		$this->default_title = __('Sign up for our mailing list.', 'Statfort');

		$widget_options = array('classname' => 'widget_newsletter', 'description' => __( "Displays a sign-up form for a MailChimp mailing list.", 'Statfort'));
		parent::__construct('chimp_MailChimp_Widget', __('Chimp: MailChimp List Signup', 'Statfort'), $widget_options);

		$this->ns_mc_plugin = CHIMP_MC_Plugin::get_instance();

		$default_loader_graphic = get_template_directory_uri()."/images/ajax-loader.gif";

		$this->default_loader_graphic = get_template_directory_uri()."/images/ajax-loader.gif";

		add_action('parse_request', array(&$this, 'process_submission'));

	}
	
	*/
	public function __construct() {
			$this->default_failure_message = __('There was a problem processing your submission.', 'Statfort');

			$this->default_signup_text = __('Join now!', 'Statfort');

			$this->default_success_message = __('Thank you for joining our mailing list. Please check your email for a confirmation link.', 'Statfort');

			$this->default_title = __('Sign up for our mailing list.', 'Statfort');
	  
			   parent::__construct(
				'chimp_MailChimp_Widget', // Base ID
				__( 'Chimp: MailChimp List Signup','Statfort' ), // Name
				array( 'classname' => 'widget_newsletter', 'description' =>esc_html__('Displays a sign-up form for a MailChimp mailing list.', 'Statfort'), ) // Args
			   );
			   $this->ns_mc_plugin = CHIMP_MC_Plugin::get_instance();

				$default_loader_graphic = get_template_directory_uri()."/images/ajax-loader.gif";

				$this->default_loader_graphic = get_template_directory_uri()."/images/ajax-loader.gif";

				add_action('parse_request', array(&$this, 'process_submission'));

	}

	/**

	 * @author James Lafferty

	 * @since 0.1

	 */

	public function form ($instance) {

		$mcapi = $this->ns_mc_plugin->get_mcapi();

		if (false == $mcapi) {

			echo $this->ns_mc_plugin->get_admin_notices();

		} else {

			$this->lists = $mcapi->lists();

			$defaults = array(

				'failure_message' => $this->default_failure_message,

				'title' => $this->default_title,
				
				'description' => '',

				'signup_text' => $this->default_signup_text,

				'success_message' => $this->default_success_message,

				'collect_first' => false,

				'collect_last' => false,

				'old_markup' => false

			);

			$vars = wp_parse_args($instance, $defaults);

			extract($vars);

			?>

					<h3><?php echo  __('General Settings', 'Statfort'); ?></h3>

					<p>

						<label for="<?php echo $this->get_field_id('title'); ?>"><?php echo  __('Title :', 'Statfort'); ?></label>

						<input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>" />

					</p>

					<p>

						<label for="<?php echo $this->get_field_id('current_mailing_list'); ?>"><?php echo __('Select a Mailing List :', 'Statfort'); ?></label>

						<select class="widefat" id="<?php echo $this->get_field_id('current_mailing_list');?>" name="<?php echo $this->get_field_name('current_mailing_list'); ?>">

			<?php	

			foreach ($this->lists['data'] as $key => $value) {

				$selected = (isset($current_mailing_list) && $current_mailing_list == $value['id']) ? ' selected="selected" ' : '';

				?>	

						<option <?php echo $selected; ?>value="<?php echo $value['id']; ?>"><?php echo $value['name']; ?></option>

				<?php

			}

			?>

						</select>

					</p>

                    <p>

						<label ><?php echo  __('Description :', 'Statfort'); ?></label>

                        <textarea  class="widefat" name="<?php echo $this->get_field_name('description'); ?>"  rows="4" cols="8"><?php echo $description; ?></textarea>

					</p>

					

					<p>

						<label for="<?php echo $this->get_field_id('signup_text'); ?>"><?php echo __('Sign Up Button Text :', 'Statfort'); ?></label>

						<input class="widefat" id="<?php echo $this->get_field_id('signup_text'); ?>" name="<?php echo $this->get_field_name('signup_text'); ?>" value="<?php echo $signup_text; ?>" />

					</p>

					<p>

						<input type="checkbox" class="checkbox" id="<?php echo $this->get_field_id('collect_first'); ?>" name="<?php echo $this->get_field_name('collect_first'); ?>" <?php echo  checked($collect_first, true, false); ?> />

						<label for="<?php echo $this->get_field_id('collect_first'); ?>"><?php echo  __('Collect first name.', 'Statfort'); ?></label>

						<br />

						<input type="checkbox" class="checkbox" id="<?php echo  $this->get_field_id('collect_last'); ?>" name="<?php echo $this->get_field_name('collect_last'); ?>" <?php echo checked($collect_last, true, false); ?> />

						<label><?php echo __('Collect last name.', 'Statfort'); ?></label>

					</p>

					<h3><?php echo __('Notifications', 'Statfort'); ?></h3>

					<p><?php echo  __('Use these fields to customize what your visitors see after they submit the form', 'Statfort'); ?></p>

					<p>

						<label for="<?php echo $this->get_field_id('success_message'); ?>"><?php echo __('Success :', 'Statfort'); ?></label>

						<textarea class="widefat" id="<?php echo $this->get_field_id('success_message'); ?>" name="<?php echo $this->get_field_name('success_message'); ?>"><?php echo $success_message; ?></textarea>

					</p>

					<p>

						<label for="<?php echo $this->get_field_id('failure_message'); ?>"><?php echo __('Failure :', 'Statfort'); ?></label>

						<textarea class="widefat" id="<?php echo $this->get_field_id('failure_message'); ?>" name="<?php echo $this->get_field_name('failure_message'); ?>"><?php echo $failure_message; ?></textarea>

					</p>

			<?php

			

		}

	}

	

	/**

	 * @author James Lafferty

	 * @since 0.1

	 */

	

	public function process_submission () {

		

		if (isset($_GET[$this->id_base . '_email'])) {

			

			header("Content-Type: application/json");

			

			//Assume the worst.

			$response = '';

			$result = array('success' => false, 'error' => $this->get_failure_message($_GET['ns_mc_number']));

			

			$merge_vars = array();

			

			if (! is_email($_GET[$this->id_base . '_email'])) { //Use WordPress's built-in is_email function to validate input.

				

				$response = json_encode($result); //If it's not a valid email address, just encode the defaults.

				

			} else {

				

				$mcapi = $this->ns_mc_plugin->get_mcapi();

				

				if (false == $this->ns_mc_plugin) {

					

					$response = json_encode($result);

					

				} else {

					

					if (isset($_GET[$this->id_base . '_first_name']) && is_string($_GET[$this->id_base . '_first_name'])) {

						

						$merge_vars['FNAME'] = $_GET[$this->id_base . '_first_name'];

						

					}

					

					if (isset($_GET[$this->id_base . '_last_name']) && is_string($_GET[$this->id_base . '_last_name'])) {

						

						$merge_vars['LNAME'] = $_GET[$this->id_base . '_last_name'];

						

					}

					

					$subscribed = $mcapi->listSubscribe($this->get_current_mailing_list_id($_GET['ns_mc_number']), $_GET[$this->id_base . '_email'], $merge_vars);

				

					if (false == $subscribed) {

						

						$response = json_encode($result);

						

					} else {

					

						$result['success'] = true;

						$result['error'] = '';

						$result['success_message'] =  $this->get_success_message($_GET['ns_mc_number']);

						$response = json_encode($result);

						

					}

					

				}

				

			}

			

			exit($response);

			

		} elseif (isset($_POST[$this->id_base . '_email'])) {

			

			$this->subscribe_errors = '<div class="error">'  . $this->get_failure_message($_POST['ns_mc_number']) .  '</div>';

			

			if (! is_email($_POST[$this->id_base . '_email'])) {

				

				return false;

				

			}

			

			$mcapi = $this->ns_mc_plugin->get_mcapi();

			

			if (false == $mcapi) {

				

				return false;

				

			}

			

			if (is_string($_POST[$this->id_base . '_first_name'])  && '' != $_POST[$this->id_base . '_first_name']) {

				

				$merge_vars['FNAME'] = strip_tags($_POST[$this->id_base . '_first_name']);

				

			}

			

			if (is_string($_POST[$this->id_base . '_last_name']) && '' != $_POST[$this->id_base . '_last_name']) {

				

				$merge_vars['LNAME'] = strip_tags($_POST[$this->id_base . '_last_name']);

				

			}

			

			$subscribed = $mcapi->listSubscribe($this->get_current_mailing_list_id($_POST['ns_mc_number']), $_POST[$this->id_base . '_email'], $merge_vars);

			

			if (false == $subscribed) {



				return false;

				

			} else {

				

				$this->subscribe_errors = '';

				

				setcookie($this->id_base . '-' . $this->number, $this->hash_mailing_list_id(), time() + 31556926);

				

				$this->successful_signup = true;

				

				$this->signup_success_message = '<p>' . $this->get_success_message($_POST['ns_mc_number']) . '</p>';

				

				return true;

				

			}	

			

		}

		

	}

	

	/**

	 * @author James Lafferty

	 * @since 0.1

	 */

	

	public function update ($new_instance, $old_instance) {

		

		$instance = $old_instance;

		

		$instance['collect_first'] = ! empty($new_instance['collect_first']);

		

		$instance['collect_last'] = ! empty($new_instance['collect_last']);

		

		$instance['current_mailing_list'] = esc_attr($new_instance['current_mailing_list']);

		

		$instance['failure_message'] = esc_attr($new_instance['failure_message']);

		

		$instance['signup_text'] = esc_attr($new_instance['signup_text']);

		

		$instance['success_message'] = esc_attr($new_instance['success_message']);

		

		$instance['title'] = esc_attr($new_instance['title']);

		$instance['description'] = esc_attr($new_instance['description']);

		

		return $instance;

		

	}

	

	/**

	 * @author James Lafferty

	 * @since 0.1

	 */

	

	public function widget ($args, $instance) {

		

		extract($args);

		

		if ((isset($_COOKIE[$this->id_base . '-' . $this->number]) && $this->hash_mailing_list_id($this->number) == $_COOKIE[$this->id_base . '-' . $this->number]) || false == $this->ns_mc_plugin->get_mcapi()) {

			

			return 0;

			

		} else {

			

			echo $before_widget . $before_title . $instance['title'] . $after_title;

			

			if ($this->successful_signup) {

				echo $this->signup_success_message;

			} else {

				//cs_mailchimp_add_scripts ();

				global $cs_theme_option;

				?>	

                <p><?php echo $instance['description'];?></p>

               

                <?php echo $this->subscribe_errors; ?>

				

                <form action="<?php echo $_SERVER['REQUEST_URI']; ?>" id="<?php echo $this->id_base . '_form-' . $this->number; ?>" method="post">

					

					<?php	

						if ($instance['collect_first']) {

					?>	

					<input type="text" name="<?php echo $this->id_base . '_first_name'; ?>" value="<?php if($cs_theme_option['trans_switcher'] == "on"){ _e('First Name :','Statfort');}else{ echo $cs_theme_option['res_first_name']; }?>" />

					<br />

					<?php

						}

						if ($instance['collect_last']) {

					?>	

					<input type="text" name="<?php echo $this->id_base . '_last_name'; ?>" value="<?php if($cs_theme_option['trans_switcher'] == "on"){ _e('Last Name :','Statfort');}else{ echo $cs_theme_option['res_last_name']; }?>" />

					<br />

					<?php	

						}

					?>

						<input type="hidden" name="ns_mc_number" value="<?php echo $this->number; ?>" />

						<input id="<?php echo $this->id_base; ?>-email-<?php echo $this->number; ?>" type="text" name="<?php echo $this->id_base; ?>_email" pvalue="<?php _e('email','Statfort'); ?>" />

						

                        <button class="bgcolr" name="<?php echo $instance['signup_text']; ?>"><?php echo $instance['signup_text']; ?></button>

					</form>

                    <h6><em class="fa fa-envelope-o"></em>Dont't worry, we won't spam you. </h6>

						<script type="text/javascript">

							jQuery(document).ready(function(){

								cs_mailchimp_add_scripts ();

								jQuery('#<?php echo $this->id_base; ?>_form-<?php echo $this->number; ?>').ns_mc_widget({"url" : "<?php echo $_SERVER['PHP_SELF']; ?>", "cookie_id" : "<?php echo $this->id_base; ?>-<?php echo $this->number; ?>", "cookie_value" : "<?php echo $this->hash_mailing_list_id(); ?>", "loader_graphic" : "<?php echo $this->default_loader_graphic; ?>"});

							});

						 </script>

				<?php

			}

			echo $after_widget;

		}

		

	}

	

	/**

	 * @author James Lafferty

	 * @since 0.1

	 */

	

	private function hash_mailing_list_id () {

		

		$options = get_option($this->option_name);

		

		$hash = md5($options[$this->number]['current_mailing_list']);

		

		return $hash;

		

	}

	

	/**

	 * @author James Lafferty

	 * @since 0.1

	 */

	

	private function get_current_mailing_list_id ($number = null) {

		

		$options = get_option($this->option_name);

		

		return $options[$number]['current_mailing_list'];

		

	}

	

	/**

	 * @author James Lafferty

	 * @since 0.5

	 */

	

	private function get_failure_message ($number = null) {

		

		$options = get_option($this->option_name);

		

		return $options[$number]['failure_message'];

		

	}

	

	/**

	 * @author James Lafferty

	 * @since 0.5

	 */

	

	private function get_success_message ($number = null) {

		

		$options = get_option($this->option_name);

		

		return $options[$number]['success_message'];

		

	}

	

}



add_action( 'widgets_init', create_function('', 'return register_widget("chimp_MailChimp_Widget");') );



?>