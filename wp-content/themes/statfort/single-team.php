<?php

/**

 * The template for displaying all single posts

 */

 	global $cs_node,$post,$cs_theme_option,$cs_counter_node;

	

	$cs_uniq = rand(40, 9999999);

	if ( is_single() ) {

		cs_set_post_views($post->ID);

	}	

	$cs_node = new stdClass();

  	get_header();

 	$cs_layout = '';

	$leftSidebarFlag	= false;

	$rightSidebarFlag	= false;

	?>

<!-- PageSection Start -->



<section class="page-section team-detail" style=" padding: 0; "> 

  <!-- Container -->

  <div class="container"> 

    <!-- Row -->

    <div class="row">

      <?php

	if (have_posts()):

		while (have_posts()) : the_post();	

		$postname = 'team';

		$image_url = cs_get_post_img_src($post->ID, 820, 462);	



		$post_xml = get_post_meta($post->ID, "team", true);	

			if ( $post_xml <> "" ) {

			

				$cs_xmlObject = new SimpleXMLElement($post_xml);

				$cs_layout 			= $cs_xmlObject->sidebar_layout->cs_page_layout;

				$cs_sidebar_left 	= $cs_xmlObject->sidebar_layout->cs_page_sidebar_left;

				$cs_sidebar_right   = $cs_xmlObject->sidebar_layout->cs_page_sidebar_right;

				if(isset($cs_xmlObject->cs_related_post))

					$cs_related_post = $cs_xmlObject->cs_related_post;

				else 

					$cs_related_post = '';

				

				if(isset($cs_xmlObject->cs_post_tags_show))

					$post_tags_show = $cs_xmlObject->cs_post_tags_show;

				else 

					$post_tags_show = '';

				

				if(isset($cs_xmlObject->post_social_sharing))

					$cs_post_social_sharing = $cs_xmlObject->post_social_sharing;

				else 

					$cs_post_social_sharing = '';

				

				if(isset($cs_xmlObject->cs_post_author_info_show))

					 $cs_post_author_info_show = $cs_xmlObject->cs_post_author_info_show;

				else 

					$cs_post_author_info_show = '';

				if(isset($cs_xmlObject->post_pagination_show))

					 $post_pagination_show = $cs_xmlObject->post_pagination_show;

				else 

					$post_pagination_show = '';



				if ( $cs_layout == "left") {

					$cs_layout = "page-content";

					$leftSidebarFlag	= true;

				}

				else if ( $cs_layout == "right" ) {

					$cs_layout = "page-content";

					$rightSidebarFlag	= true;

				}

				else {

					$cs_layout = "col-md-12";

				}

				

				$postname = 'post';

			}else{

				$cs_layout 	=  $cs_theme_option['cs_single_post_layout'];

				if ( isset( $cs_layout ) && $cs_layout == "sidebar_left") {

					$cs_layout = "page-content";

					$cs_sidebar_left	= $cs_theme_option['cs_single_layout_sidebar'];

					$leftSidebarFlag	= true;

				} else if ( isset( $cs_layout ) && $cs_layout == "sidebar_right" ) {

					$cs_layout = "page-content";

					$cs_sidebar_right	= $cs_theme_option['cs_single_layout_sidebar'];

					$rightSidebarFlag	= true;

				} else {

					$cs_layout = "col-md-12";

				}

  				$post_pagination_show = 'on';

				$post_tags_show = '';

				$cs_related_post = '';

				$post_social_sharing = '';

				$post_social_sharing = '';

				$cs_post_author_info_show = '';

				$postname = 'team';

				$cs_post_social_sharing = '';

			}

			if ($post_xml <> "") {

				$cs_xmlObject = new SimpleXMLElement($post_xml);

				

				$postname = 'team';

				$cs_team_phone_num = $cs_xmlObject->cs_team_phone_num;

				$cs_team_fax_num = $cs_xmlObject->cs_team_fax_num;

				$cs_team_email = $cs_xmlObject->cs_team_email;

				$cs_team_subtitle = $cs_xmlObject->cs_team_subtitle;

				$cs_team_admissions_title = $cs_xmlObject->cs_team_admissions_title;

				$cs_team_certifications_title = $cs_xmlObject->cs_team_certifications_title;

				$cs_team_admissions = $cs_xmlObject->cs_team_admissions;

				$cs_team_certifications = $cs_xmlObject->cs_team_certifications;

				$cs_team_eval_form = $cs_xmlObject->cs_team_eval_form;

				$cs_team_eval_form_title = $cs_xmlObject->cs_team_eval_form_title;

				$cs_team_facebook = $cs_xmlObject->cs_team_facebook;

				$cs_team_twitter = $cs_xmlObject->cs_team_twitter;

				$cs_team_google_plus = $cs_xmlObject->cs_team_google_plus;

				$cs_team_linked_in = $cs_xmlObject->cs_team_linked_in;

				$cs_team_vcard = $cs_xmlObject->cs_team_vcard;

				$cs_team_education_title = $cs_xmlObject->cs_team_education_title;

				$cs_team_practices_title = $cs_xmlObject->cs_team_practices_title;

				$cs_team_rich_edit_title = $cs_xmlObject->cs_team_rich_edit_title;

				

			}

			else {

				$cs_xmlObject = new stdClass();

				

				$postname = 'team';

				$cs_team_phone_num = '';

				$cs_team_fax_num = '';

				$cs_team_email = '';

				$cs_team_admissions = '';

				$cs_team_certifications = '';

				$cs_team_subtitle = '';

				$cs_team_admissions_title = '';

				$cs_team_certifications_title = '';

				$cs_team_eval_form = '';

				$cs_team_eval_form_title = '';

				$cs_team_facebook = '';

				$cs_team_twitter = '';

				$cs_team_google_plus = '';

				$cs_team_linked_in = '';

				$cs_team_vcard = '';

				$cs_team_education_title = '';

				$cs_team_practices_title = '';

				$cs_team_rich_edit_title = '';



			}		

		$width = 820;

		$height = 462;

		$image_url = cs_get_post_img_src($post->ID, $width, $height);

		?>

      <!--Left Sidebar Starts-->

      <?php if ($leftSidebarFlag == true){ ?>

      <aside class="page-sidebar">

        <?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar($cs_sidebar_left) ) : ?>

        <?php endif; ?>

      </aside>

      <?php } ?>

      <!--Left Sidebar End--> 

      

      <!-- Team Detail Start -->

      <div class="<?php echo esc_attr($cs_layout); ?>"> 

        <!-- Team Start --> 

        <!-- Row -->

			<div class="col-md-12"> 

            <figure class="detailpost">

                <?php

				if ($image_url <> '') { 

					echo '<img src="'.$image_url.'" alt="" >';

				}

				?>

                <figcaption>

                    <div class="contant-info cs-team">

                    <header>

                    	<?php

						if($cs_team_subtitle <> ''){

						?>

                        <span><?php echo cs_allow_special_char($cs_team_subtitle); ?></span>

                        <?php

						}

						?>

                        <h2 class="cs-post-title"><?php the_title(); ?></h2>

                    </header>

                    <div class="fullwidth-sepratore"><span class="dividerstyle"></span></div>

                    <ul class="post-options">

                      <?php

					  if($cs_team_phone_num <> ''){

					  ?>

                      <li>

                        <span><?php _e('Phone Number', 'Lawyer'); ?></span>

                        <p><?php echo cs_allow_special_char($cs_team_phone_num); ?></p>

                      </li>

                      <?php

					  }

					  if($cs_team_fax_num <> ''){

					  ?>

                      <li>

                        <span><?php _e('Fax Number', 'Lawyer'); ?></span>

                        <p><?php echo cs_allow_special_char($cs_team_fax_num); ?></p>

                      </li>

                      <?php

					  }

					  if($cs_team_email <> ''){

					  ?>

                      <li>

                        <span><?php _e('Email Address', 'Lawyer'); ?></span>

                        <a href="mailto:<?php echo cs_allow_special_char($cs_team_email); ?>"><?php echo cs_allow_special_char($cs_team_email); ?></a>

                      </li>

                      <?php

					  }

					  ?>

                    </ul>

                    <div class="sg-socialmedia">

                        <ul>

                        	<?php

							if($cs_team_facebook <> ''){

							?>

                            <li><a href="<?php echo esc_url($cs_team_facebook); ?>" data-original-title="<?php _e('Facebook', 'Lawyer'); ?>"><i class="icon-facebook2"></i></a></li>

                            <?php

							}

							if($cs_team_twitter <> ''){

							?>

                            <li><a href="<?php echo esc_url($cs_team_twitter); ?>" data-original-title="<?php _e('Twitter', 'Lawyer'); ?>"><i class="icon-twitter6"></i></a></li>

                            <?php

							}

							if($cs_team_google_plus <> ''){

							?>

                            <li><a href="<?php echo esc_url($cs_team_google_plus); ?>" data-original-title="<?php _e('Google Plus', 'Lawyer'); ?>"><i class="icon-googleplus7"></i></a></li>

                            <?php

							}

							if($cs_team_linked_in <> ''){

							?>

                            <li><a href="<?php echo esc_url($cs_team_linked_in); ?>" data-original-title="<?php _e('Linked in', 'Lawyer'); ?>"><i class="icon-linkedin4"></i></a></li>

                            <?php

							}

							?>

                        </ul>

                        <?php

						if($cs_team_email <> ''){

						?>

                        <a class="send-email" href="mailto:<?php echo cs_allow_special_char($cs_team_email); ?>"><i class="icon-envelope-o"></i><?php _e('Send Email', 'Lawyer'); ?></a>

                        <?php

						}

						?>

                    </div>

                    <?php

					if($cs_team_vcard <> ''){

					?>

                    <a href="<?php echo cs_allow_special_char($cs_team_vcard); ?>" class="Profile-btn"><?php _e('Download vCard', 'Lawyer'); ?></a>

                    <?php

					}

					?>

                </div>

                </figcaption>

            </figure>

            </div>

            <div class="col-md-12">

            	<div class="rich_editor_text">

					<?php

                    if($cs_team_rich_edit_title <> ''){

                    ?>

                    <div class="widget-section-title">

                        <h2><?php echo cs_allow_special_char($cs_team_rich_edit_title); ?></h2>

                    </div>

                    <?php

                    }

                    ?>

                    <?php the_content(); ?>

                </div>

            </div>

                

                  

            <?php 

				if(isset($post_pagination_show) &&  $post_pagination_show == 'on'){
  echo "<div class='col-md-12'>";
                	echo cs_next_prev_custom_links('team');
  echo'</div>';
            	}

            ?>

        

           

              <?php

			  if($cs_team_education_title <> ''){
 echo "<div class='col-md-12'>";
			  ?>

              <div class="widget-section-title"><h2><?php echo cs_allow_special_char($cs_team_education_title); ?></h2></div>

              <?php

			  }

			  if ( isset($cs_xmlObject->educations) && is_object($cs_xmlObject) && count($cs_xmlObject->educations)>0) {

				  foreach ( $cs_xmlObject->educations as $educations ){

					   $team_memb_education_title = $educations->education_title;

					   $team_memb_education_date = $educations->education_date;

					   $team_memb_education_description = $educations->education_description;

					   

			  ?>

                      <article class="cs-edu-info">

                          <div class="inner-sec">

                              <header>

                                  <h4><?php echo cs_allow_special_char($team_memb_education_title); ?></h4>

                              </header>

                              <div class="text">

                                  <span><?php echo cs_allow_special_char($team_memb_education_date); ?></span>

                                  <p><?php echo cs_allow_special_char($team_memb_education_description); ?></p>

                              </div>

                          </div>

                      </article>

              <?php

				  }
 echo'</div>';
			  }

			  ?>

          

          

           

			  <?php

			  if($cs_team_education_title <> ''){
 echo "<div class='col-md-12'>";
			  ?>

              <div class="widget-section-title"><h2>Practice Areas</h2></div>

              <?php

			  }

			  ?>

              <div id="accordion-<?php echo intval($post->ID); ?>" class="panel-group box">

              	<?php

				if ( isset($cs_xmlObject->practices) && is_object($cs_xmlObject) && count($cs_xmlObject->practices)>0) {

				  $prac_counter = 1;

				  foreach ( $cs_xmlObject->practices as $practices ){

					   $team_memb_practice_title = $practices->practice_title;

					   $team_memb_practice_description = $practices->practice_description;

				?>

                	<div class="panel panel-default">

                        <div class="panel-heading">

                              <h5 class="panel-title">

                              <a aria-expanded="false" class="collapse collapsed" href="#accordion-<?php echo intval($prac_counter); ?>" data-parent="#accordion-<?php echo intval($post->ID); ?>" data-toggle="collapse">

                                  <?php echo cs_allow_special_char($team_memb_practice_title); ?>

                              </a>

                              </h5>

                          </div>

                          <div class="panel-collapse collapse" id="accordion-<?php echo intval($prac_counter); ?>" style="height: 0px;">

                              <div class="panel-body"><p><?php echo cs_allow_special_char($team_memb_practice_description); ?></p></div>

                          </div>

                    </div>

				  <?php

					$prac_counter++;

                    }

                }
 echo'</div>';
  echo'</div>';
                ?>

           

         
          

         
			  <?php

			  if($cs_team_admissions_title <> ''){
 echo '<div id="cs-check-list" class="col-md-6  cs-check-list">';

			  ?>

              <div class="widget-section-title"><h2><?php echo cs_allow_special_char($cs_team_admissions_title); ?></h2></div>

              <?php

			  }

			  ?>

              

             
                  <?php

				  if($cs_team_admissions <> ''){
 echo '<div class="liststyle">';

				  ?>

                  <ul class="cs-iconlist">

                      <li><i class="icon-checkmark6"></i>

                      <?php

					  $cs_team_admissions = nl2br($cs_team_admissions);

					  $cs_team_admissions = str_replace('<br />', '</li><li><i class="icon-checkmark6"></i>', $cs_team_admissions);

					  echo cs_allow_special_char($cs_team_admissions);

					  ?>

                      </li>

                  </ul>

                  <?php

				  }
     echo '</div>';

        echo   '</div>';
				  ?>

         

          

         

              <?php

			  if($cs_team_certifications_title <> ''){
 echo '<div class="col-md-6 cs-check-list">';
			  ?>

              <div class="widget-section-title"><h2><?php echo cs_allow_special_char($cs_team_certifications_title); ?></h2></div>

              <?php

			  }

			  ?>

              <div class="liststyle">

                  <?php

				  if($cs_team_certifications <> ''){

				  ?>

                  <ul class="cs-iconlist">

                      <li><i class="icon-checkmark6"></i>

                      <?php

					  $cs_team_certifications = nl2br($cs_team_certifications);

					  $cs_team_certifications = str_replace('<br />', '</li><li><i class="icon-checkmark6"></i>', $cs_team_certifications);

					  echo cs_allow_special_char($cs_team_certifications);

					  ?>

                      </li>

                  </ul>

                  <?php

				  }
    echo '</div></div>';
				  ?>

         

          

          <?php

		  if($cs_team_eval_form == 'on'){

		  ?>

          <div class="col-md-12">

			  <?php

			  if($cs_team_eval_form_title <> ''){

			  ?>

              <div class="widget-section-title"><h2><?php echo cs_allow_special_char($cs_team_eval_form_title); ?></h2></div>

              <?php

			  }

			  $msg_form_counter = rand(34, 34589);

			  $contact_succ_msg = __('Message Sent Successfully.', 'Lawyer');

			  $error = __('An error Occured, please try again later.', 'Lawyer');

			  

			  cs_enqueue_validation_script();

			  ?>

              <script type="text/javascript">

				  jQuery(document).ready(function($) {

					  var container = $('');

					  var validator = jQuery("#frm<?php echo absint($msg_form_counter)?>").validate({

						  messages:{

							  contact_name: '',

							  contact_number: '',

							  

							  contact_email:{

								  required: '',

								  email:'',

							  },

							  subject: {

								  required:'',

							  },

							  contact_msg: '',

						  },

						  errorContainer: container,

						  errorLabelContainer: jQuery(container),

						  errorElement:'div',

						  errorClass:'frm_error',

						  meta: "validate"

					  });

				  });

				  function frm_submit<?php echo cs_allow_special_char($msg_form_counter)?>(){

					  var $ = jQuery;

					  $("#submit_btn<?php echo cs_allow_special_char($msg_form_counter) ?>").hide();

					  $("#loading_div<?php echo cs_allow_special_char($msg_form_counter) ?>").html('<img src="<?php echo esc_js(get_template_directory_uri());?>/assets/images/ajax-loader.gif" alt="" />');

					  var datastring =$('#frm<?php echo cs_allow_special_char($msg_form_counter) ?>').serialize() +"&cs_contact_email=<?php echo esc_js($cs_team_email);?>&cs_contact_succ_msg=<?php echo cs_allow_special_char($contact_succ_msg);?>&cs_contact_error_msg=<?php echo cs_allow_special_char($error);?>&action=cs_contact_form_submit";

					  $.ajax({

						  type: 'POST', 

						  url: '<?php echo esc_js(admin_url('admin-ajax.php')); ?>',

						  data: datastring, 

						  dataType: "json",

						  success: function(response) {

							  if (response.type == 'error'){

								  $("#loading_div<?php echo cs_allow_special_char($msg_form_counter);?>").html('');

								  $("#loading_div<?php echo cs_allow_special_char($msg_form_counter);?>").hide();

								  $("#message<?php echo cs_allow_special_char($msg_form_counter); ?>").addClass('error_mess');

								  $("#message<?php echo cs_allow_special_char($msg_form_counter); ?>").show();

								  $("#message<?php echo cs_allow_special_char($msg_form_counter); ?>").html(response.message);

							  } else if (response.type == 'success'){

								  $("#loading_div<?php echo cs_allow_special_char($msg_form_counter); ?>").html('');

								  $("#message<?php echo cs_allow_special_char($msg_form_counter); ?>").addClass('succ_mess');

								  $("#message<?php echo cs_allow_special_char($msg_form_counter); ?>").show();

								  $("#message<?php echo cs_allow_special_char($msg_form_counter); ?>").html(response.message);

							  }

						  }

					  });

				  }

			  </script>

              <div class="cs-classic-form cs_form_styling" id="form_hide<?php echo absint($msg_form_counter);?>">

                <div id="contact_formnLb" class="form-style">

                  <form id="frm<?php echo absint($msg_form_counter);?>" name="frm<?php echo absint($msg_form_counter);?>" method="post" action="javascript:<?php echo "frm_submit".$msg_form_counter. "()"; ?>" novalidate>

                  <p>

                      <input type="text" class="cs-classic nameinput {validate:{required:true}}" placeholder="<?php _e('Name', 'Lawyer'); ?>" name="contact_name">

                  </p>

                  <p>

                      <input type="text" class="cs-classic {validate:{required:true ,email:true}}" placeholder="<?php _e('Email', 'Lawyer'); ?>" name="contact_email">

                  </p>

                  <p>

                      <input type="text" class="cs-classic {validate:{required:false}}" placeholder="<?php _e('Phone', 'Lawyer'); ?>" name="contact_number">

                  </p>

                  <p>

                      <input type="text" class="cs-classic nameinput {validate:{required:true}}" placeholder="<?php _e('Subject', 'Lawyer'); ?>" name="subject_name">

                  </p>

                  

                   <p class="comment-form-comment full-width">

                      <textarea name="contact_msg" placeholder="<?php _e('Tell Us About Your Case', 'Lawyer'); ?>" class="cs-classic {validate:{required:true}}"></textarea>

                   </p>

                   <p class="checkbox-form full-width">

                      <label>

                          <input type="checkbox">

                          <span><?php _e('I Have Read and agree to these terms', 'Lawyer'); ?></span>

                      </label>

                   </p>

                   <p>

                      <input type="hidden" value="<?php echo cs_allow_special_char($contact_succ_msg);?>" name="cs_contact_succ_msg">

                      <input type="hidden" name="bloginfo" value="<?php echo get_bloginfo() ?>" />

                      <input type="hidden" name="counter_node" value="<?php echo absint($msg_form_counter)?>" />

                      <span id="loading_div<?php echo absint($msg_form_counter)?>"><i class="icon-envelope"></i></span>

                      <span id="message<?php echo absint($msg_form_counter);?>" style="display:none;"></span>

                      <input type="submit" class="cs-bgcolor" value="Submit" name="submit" id="submit_btn<?php echo absint($msg_form_counter)?>">

                   </p>

                  </form>

                </div>

              </div>

          </div>                                                                        

          <?php

		  }

		  ?>

          

                                                

          <!-- Col Comments Start -->

		  <?php comments_template('', true); ?>

          <!-- Col Comments End --> 

          

      <?php 

	  endwhile;   

	  endif; 

	  ?>

      </div>

      <?php if ($rightSidebarFlag == true){ ?>

      		<aside class="page-sidebar">

       			<?php if ( !function_exists('dynamic_sidebar') || !dynamic_sidebar($cs_sidebar_right) ) : endif; ?>

      		</aside>

      <?php } ?>

        

    </div>

    

  

  </div>

</section>

<!-- PageSection End --> 

<!-- Footer -->

<?php get_footer(); ?>